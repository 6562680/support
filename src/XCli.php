<?php
/**
 * @noinspection RedundantSuppression
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support;

use Gzhegow\Support\Traits\Load\FsLoadTrait;
use Gzhegow\Support\Traits\Load\StrLoadTrait;
use Gzhegow\Support\Traits\Load\EnvLoadTrait;
use Gzhegow\Support\Traits\Load\PhpLoadTrait;
use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Exceptions\Logic\BadFunctionCallException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * XCli
 */
class XCli implements ICli
{
    use EnvLoadTrait;
    use FsLoadTrait;
    use PhpLoadTrait;
    use StrLoadTrait;


    /**
     * @return bool
     */
    public function isWindows() : bool
    {
        return strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
    }


    /**
     * @param mixed ...$arguments
     */
    public function stop(...$arguments) : void
    {
        if (PHP_SAPI !== 'cli') {
            throw new BadFunctionCallException('Method should be called in CLI mode: ' . __METHOD__);
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
            throw new BadFunctionCallException('Method should be called in CLI mode: ' . __METHOD__);
        }

        if ($arguments) var_dump(...$arguments);

        echo '> Press ENTER to continue...' . PHP_EOL;
        $h = fopen('php://stdin', 'r');
        fgets($h);
        fclose($h);

        return $arguments;
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
        $theEnv = $this->getEnv();
        $thePhp = $this->getPhp();

        $cwd = $cwd ?? getcwd();
        $env = $env ?? $theEnv->getenv();

        if ('' === $cwd) {
            throw new InvalidArgumentException('Cwd should be not empty');
        }
        if (! is_dir($cwd)) {
            throw new InvalidArgumentException('Cwd directory not exists');
        }

        [ $env ] = $thePhp->kwargs($env);
        [ $other_options ] = $thePhp->kwargs($other_options);

        $env[ 'PATH' ] = $theEnv->getenv('PATH');

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
     * @return string
     */
    public function readln() : string
    {
        if (PHP_SAPI !== 'cli') {
            throw new BadFunctionCallException('Method should be called in CLI mode: ' . __METHOD__);
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
            throw new BadFunctionCallException('Method should be called in CLI mode: ' . __METHOD__);
        }

        $theStr = $this->getStr();

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

            $expected_pos = $theStr->mb('strlen')($line) - $theStr->mb('strlen')($search);
            $pos = $theStr->mb('strrpos')($line, $search);

            // end found
            if ($expected_pos === $pos) {
                $line = $theStr->mb('substr')($line, 0, $pos);

                if ($line) {
                    $lines[] = $line;
                }

                break;

            } else {
                // end is not found
                $lines[] = $line;
            }
        }
        fclose($h);

        // results
        return implode(PHP_EOL, $lines);
    }


    /**
     * сохраняет файл в указанное место, но выводит предупреждение в консоли, что файл уже есть
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
        $theFs = $this->getFs();

        $backup = $backup ?? true;
        $yesOverwrite = $yesOverwrite ?? 'n';

        $realpath = null;
        $backupPath = null;
        if (! file_exists($outputPath)) {
            $theFs->mkdir(dirname($outputPath));

            $realpath = $theFs->filePut($outputPath, $content);

            echo 'Created file: ' . $theFs->secure($realpath) . PHP_EOL;

        } else {
            $realpath = realpath($outputPath);

            $message = 'File exists: ' . basename($realpath) . PHP_EOL
                . $theFs->secure($realpath) . PHP_EOL
                . 'Overwrite?';

            $yes = $this->yes($message, $yesOverwrite);

            if (! $yes) {
                echo 'File exists: ' . $theFs->secure($realpath) . PHP_EOL;

            } else {
                $backupPath = $theFs->filePut($realpath, $content, $backup);

                echo 'Replaced ' . $theFs->secure($realpath) . PHP_EOL;

                if ($backup) {
                    echo 'Backup stored at ' . $theFs->secure($backupPath) . PHP_EOL;
                }
            }
        }

        return $backupPath ?? $realpath;
    }


    /**
     * Создает директорию средствами командной строки
     *
     * @param string    $directory
     * @param null|int  $permissions
     * @param null|bool $recursive
     *
     * @return int
     */
    public function mkdir(string $directory, int $permissions = null, bool $recursive = null) : int
    {
        if ('' === $directory) return 1;
        if (is_dir($directory)) return 1;

        $recursive = $recursive ?? false;

        $cmd = 'mkdir ';

        if ($recursive && ! $this->isWindows()) {
            $cmd .= '-p ';
        }

        $cmd .= '"' . $directory . '"';

        [ $resultMkdir ] = $t = $this->run($cmd);

        $resultPermissions = 0;
        if ($permissions && ! $this->isWindows()) {
            [ $resultPermissions ] = $this->run('chmod ' . $permissions . ' "' . $directory . '"');
        }

        return intval($resultMkdir || $resultPermissions);
    }

    /**
     * Удаляет директорию средствами командой строки
     *
     * @param string    $directory
     * @param null|bool $recursive
     *
     * @return int
     */
    public function rmdir(string $directory, bool $recursive = null) : int
    {
        if ('' === $directory) return 1;
        if (! is_dir($directory)) return 1;

        $recursive = $recursive ?? false;

        $cmd = $this->isWindows()
            ? 'rmdir /q '
            : 'rm -f ';

        if ($recursive) {
            $cmd .= $this->isWindows()
                ? '/s '
                : '-r ';
        }

        $cmd .= '"' . $directory . '"';

        [ $result ] = $this->run($cmd);

        return $result;
    }


    /**
     * Создает ZIP-архив из папки средствами командной строки
     *
     * @param string $outputPath
     * @param string ...$pathes
     *
     * @return int
     */
    public function zip(string $outputPath, ...$pathes) : int
    {
        if ('' === $outputPath) return 1;
        if (! $pathes) return 1;

        $cmd = 'zip "' . $outputPath . '" ';

        $list = [];
        $queue = $pathes;
        while ( null !== ( $k = key($queue) ) ) {
            if (is_array($queue[ $k ])) {
                $queue = array_merge($queue, $queue[ $k ]);

            } elseif (false
                || ( false === settype($queue[ $k ], 'string') )
                || ( '' === $queue[ $k ] )
                || ! file_exists($queue[ $k ])
            ) {
                continue;

            } else {
                $list[] = '"' . $queue[ $k ] . '"';
            }

            unset($queue[ $k ]);
        }

        if (! $list) return 1;

        $cmd .= implode(' ', $list);

        [ $result ] = $this->run($cmd);

        return $result;
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
     * @return ICli
     */
    public static function getInstance() : ICli
    {
        return SupportFactory::getInstance()->getCli();
    }
}