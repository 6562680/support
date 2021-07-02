<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Interfaces\CliInterface;
use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Exceptions\Logic\BadFunctionCallException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * CliF
 */
class Cli implements CliInterface
{
    /**
     * @var Env
     */
    protected $env;
    /**
     * @var Fs
     */
    protected $fs;
    /**
     * @var Php
     */
    protected $php;


    /**
     * Constructor
     *
     * @param Env $env
     * @param Fs  $fs
     * @param Php $php
     */
    public function __construct(
        Env $env,
        Fs $fs,
        Php $php
    )
    {
        $this->env = $env;
        $this->php = $php;
        $this->fs = $fs;
    }


    /**
     * @param mixed ...$arguments
     */
    public function stop(...$arguments) : void
    {
        if (PHP_SAPI !== 'cli') {
            throw new BadFunctionCallException('Should be called in CLI mode');
        }

        $this->pause(...$arguments);

        exit(1);
    }

    /**
     * @param mixed ...$arguments
     *
     * @return array
     */
    public function pause(...$arguments) : array
    {
        if (PHP_SAPI !== 'cli') {
            throw new BadFunctionCallException('Should be called in CLI mode');
        }

        if ($arguments) var_dump(...$arguments);

        echo '> Press ENTER to continue...' . PHP_EOL;
        $h = fopen('php://stdin', 'r');
        fgets($h);
        fclose($h);

        return $arguments;
    }


    /**
     * @return string
     */
    public function readln() : string
    {
        if (PHP_SAPI !== 'cli') {
            throw new BadFunctionCallException('Should be called in CLI mode');
        }

        $h = fopen('php://stdin', 'r');
        $line = trim(fgets($h));
        fclose($h);

        return $line;
    }

    /**
     * @param string $search
     *
     * @return string
     */
    public function cin(string $search = '```') : string
    {
        if (PHP_SAPI !== 'cli') {
            throw new BadFunctionCallException('Should be called in CLI mode');
        }

        echo '> Enter text separating lines by pressing ENTER' . PHP_EOL;
        echo '> TypeService ' . $search . ' when you\'re done...' . PHP_EOL;

        $lines = [];
        $h = fopen('php://stdin', 'r');
        while ( false !== ( $line = fgets($h) ) ) {
            $line = trim($line);

            if (! $line) {
                echo '> Write `' . $search . '` when done...' . PHP_EOL;
                continue;
            }

            $expected_pos = mb_strlen($line) - mb_strlen($search);
            $pos = mb_strrpos($line, $search);

            // end found
            if ($expected_pos === $pos) {
                $line = substr($line, 0, $pos);
                if ($line) $lines[] = $line;
                break;

                // end is not found
            } else $lines[] = $line;
        }
        fclose($h);

        // results
        return implode(PHP_EOL, $lines);
    }


    /**
     * сохраняет файл в указанное место, но выводит предупреждение что файл уже есть
     * предлагает его переписать, сохранив копию
     *
     * @param string      $outputPath
     * @param string      $content
     * @param null|bool   $backup
     * @param null|string $overwrite
     *
     * @return string
     */
    public function filePut(string $outputPath, string $content, bool $backup = null, string &$overwrite = null) : string
    {
        $backup = $backup ?? true;

        $overwrite = $overwrite ?? 'n';

        $willOverwrite = ( 'y' === $overwrite ) || ( 'yy' === $overwrite );
        $all = ( 'nn' === $overwrite ) || ( 'yy' === $overwrite );

        if (! file_exists($outputPath)) {
            $this->fs->mkdir(dirname($outputPath));

            $this->fs->filePut($outputPath, $content);

            echo 'Created file: ' . $outputPath . PHP_EOL;

        } else {
            $outputPath = realpath($outputPath);

            if (! $all) {
                $accepted = [ 'yy', 'y', 'n', 'nn' ];
                $message = 'File exists: ' . basename($outputPath) . PHP_EOL
                    . $this->fs->secure($outputPath) . PHP_EOL
                    . 'Overwrite? [' . implode('/', $accepted) . ']';

                echo $message . PHP_EOL;

                while ( ! in_array($var = $this->readln(), $accepted) ) {
                    echo 'Please enter one of: [' . implode('/', $accepted) . ']';
                }

                $overwrite = $var;

                $willOverwrite = ( 'y' === $overwrite ) || ( 'yy' === $overwrite );
            }

            if (! $willOverwrite) {
                echo 'File exists: ' . $this->fs->secure($outputPath) . PHP_EOL;

            } else {
                if ($backup) {
                    copy($outputPath, $backupPath = $outputPath . '.backup' . date('Ymd_His'));

                    echo 'Backup stored at ' . $this->fs->secure($backupPath) . PHP_EOL;
                }

                $this->fs->filePut($outputPath, $content, false);

                echo 'Replaced ' . $this->fs->secure($outputPath) . PHP_EOL;
            }
        }

        $result = realpath($outputPath);

        return $result;
    }


    /**
     * выполняет консольную команду через proc_open и возвращает данные или код ошибки
     *
     * @param string      $cmd
     * @param string|null $stdin
     * @param string|null $cwd
     * @param array|null  $env
     * @param array|null  $other_options
     *
     * @return array
     */
    public function run(string $cmd,
        string $stdin = null,
        string $cwd = null,
        array $env = null,
        array $other_options = null
    ) : array
    {
        $cwd = $cwd ?? getcwd();
        $env = $env ?? $this->env->getenv();

        if ('' === $cwd) {
            throw new InvalidArgumentException('Cwd should be not empty');
        }
        if (! is_dir($cwd)) {
            throw new InvalidArgumentException('Cwd directory not exists');
        }

        [ $env ] = $this->php->kwargs($env);
        [ $other_options ] = $this->php->kwargs($other_options);

        $env[ 'PATH' ] = $this->env->getenv('PATH');

        $h = proc_open($cmd, [
            0 => [ 'pipe', 'r' ],
            1 => [ 'pipe', 'w' ],
            2 => [ 'pipe', 'w' ],
        ], $ps, $cwd, $env, $other_options);

        if (! is_resource($h)) {
            throw new RuntimeException('Unable to start process for cmd: ' . $cmd);
        }

        if ($stdin) fwrite($ps[ 0 ], $stdin);
        fclose($ps[ 0 ]);

        // stdout
        $stdout = stream_get_contents($ps[ 1 ]);
        fclose($ps[ 1 ]);

        // stderr
        $stderr = stream_get_contents($ps[ 2 ]);
        fclose($ps[ 2 ]);

        // return code
        $code = proc_close($h);

        return [ $code, $stderr, $stdout ];
    }
}
