<?php
/**
 * @noinspection RedundantSuppression
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Exceptions\Logic\BadFunctionCallException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * ZCli
 */
class ZCli implements ICli
{
    /**
     * @var IEnv
     */
    protected $env;
    /**
     * @var IFs
     */
    protected $fs;
    /**
     * @var IPhp
     */
    protected $php;


    /**
     * Constructor
     *
     * @param IEnv $env
     * @param IFs  $fs
     * @param IPhp $php
     */
    public function __construct(
        IEnv $env,
        IFs $fs,
        IPhp $php
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
     * @param null|string $yesOverwrite
     *
     * @return string
     */
    public function filePut(string $outputPath, string $content, bool $backup = null, string &$yesOverwrite = null) : string
    {
        $backup = $backup ?? true;
        $yesOverwrite = $yesOverwrite ?? 'n';

        $realpath = null;
        $backupPath = null;
        if (! file_exists($outputPath)) {
            $this->fs->mkdir(dirname($outputPath));

            $realpath = $this->fs->filePut($outputPath, $content);

            echo 'Created file: ' . $this->fs->secure($realpath) . PHP_EOL;

        } else {
            $realpath = realpath($outputPath);

            $message = 'File exists: ' . basename($realpath) . PHP_EOL
                . $this->fs->secure($realpath) . PHP_EOL
                . 'Overwrite?';

            $yes = $this->yes($message, $yesOverwrite);

            if (! $yes) {
                echo 'File exists: ' . $this->fs->secure($realpath) . PHP_EOL;

            } else {
                $backupPath = $this->fs->filePut($realpath, $content, $backup);

                echo 'Replaced ' . $this->fs->secure($realpath) . PHP_EOL;

                if ($backup) {
                    echo 'Backup stored at ' . $this->fs->secure($backupPath) . PHP_EOL;
                }
            }
        }

        return $backupPath ?? $realpath;
    }

    /**
     * @param string|\SplFileInfo $dir
     * @param null|bool|\Closure  $keep
     * @param null|bool           $recursive
     * @param null|string         $yesRemove
     *
     * @return array
     */
    public function rmdir($dir, $keep = null, bool $recursive = null, string &$yesRemove = null) : array
    {
        $keep = $keep ?? false;
        $yesRemove = $yesRemove ?? 'n';

        $report = $this->fs->rmdir($dir, function (\SplFileInfo $spl) use ($keep, &$yesRemove) {
            $isKeep = null
                ?? ( $keep instanceof \Closure ? $keep($spl) : null )
                ?? (bool) $keep;

            if (! $isKeep) {
                $message = $spl->isDir()
                    ? "Deleting directory: %s\n%s\nAre you sure?"
                    : "Deleting file: %s\n%s\nAre you sure?";

                $realpath = $spl->getRealPath();
                $message = sprintf($message, basename($realpath), $this->fs->secure($realpath));

                $isKeep = ! $this->yes($message, $yesRemove);
            }

            return $isKeep;
        });

        return $report;
    }


    /**
     * @param string      $message
     * @param null|string $yesQuestion
     *
     * @return bool
     */
    public function yes(string $message, string &$yesQuestion = null) : bool
    {
        $yesQuestion = $yesQuestion ?? 'n';

        $yes = ( 'y' === $yesQuestion ) || ( 'yy' === $yesQuestion );
        $all = ( 'nn' === $yesQuestion ) || ( 'yy' === $yesQuestion );

        if (! $all) {
            if (! $yes) {
                $accepted = [ 'yy', 'y', 'n', 'nn' ];

                echo $message . ' [' . implode('/', $accepted) . ']' . PHP_EOL;

                while ( ! in_array($passed = $this->readln(), $accepted) ) {
                    echo 'Please enter one of: [' . implode('/', $accepted) . ']';
                }

                $yesQuestion = $passed;

                $yes = ( 'y' === $yesQuestion ) || ( 'yy' === $yesQuestion );
                $all = ( 'nn' === $yesQuestion ) || ( 'yy' === $yesQuestion );
            }

            if (! $all) {
                $yesQuestion = null;
            }
        }

        return $yes;
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


    /**
     * @return ICli
     */
    public static function getInstance() : ICli
    {
        return SupportFactory::getInstance()->getCli();
    }
}
