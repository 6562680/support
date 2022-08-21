<?php
/**
 * @noinspection RedundantSuppression
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support;

use Monolog\Logger;
use Gzhegow\Support\Traits\Load\FsLoadTrait;
use Gzhegow\Support\Traits\Load\StrLoadTrait;
use Gzhegow\Support\Traits\Load\EnvLoadTrait;
use Gzhegow\Support\Traits\Load\PhpLoadTrait;
use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Traits\Load\LoggerLoadTrait;
use Gzhegow\Support\Exceptions\Runtime\FilesystemException;
use Gzhegow\Support\Exceptions\Logic\BadFunctionCallException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * XCli
 */
class XCli implements ICli
{
    const MONOLOG_HANDLER_STREAM_HANDLER = 'Monolog\Handler\StreamHandler';


    use EnvLoadTrait;
    use FsLoadTrait;
    use LoggerLoadTrait;
    use PhpLoadTrait;
    use StrLoadTrait;


    /**
     * @return ILogger
     */
    protected function loadLogger() : ILogger
    {
        $commands = [
            'composer require monolog/monolog',
        ];

        if (! class_exists($class = static::MONOLOG_HANDLER_STREAM_HANDLER)) {
            throw new RuntimeException([
                'Please, run following: %s',
                $commands,
            ]);
        }

        $logger = SupportFactory::getInstance()->newLogger();
        $logger->addChannel($channelName = 'stdout', new Logger($channelName, [ new $class('php://stdout') ]));
        $logger->addChannel($channelName = 'stderr', new Logger($channelName, [ new $class('php://stderr') ]));

        $root = SupportFactory::getInstance()->getLogger();
        $root->addChannel(strtolower(str_replace('\\', '.', __CLASS__)), $logger);

        return $logger;
    }


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
            throw new BadFunctionCallException(
                'Method should be called in CLI mode: ' . __METHOD__
            );
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
            throw new BadFunctionCallException(
                'Method should be called in CLI mode: ' . __METHOD__
            );
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

        $theLogger = $this->getLogger();
        $theLoggerStdout = $theLogger->getChannel('stdout');
        $theLoggerStderr = $theLogger->getChannel('stderr');

        $cwd = $cwd ?? getcwd();
        $env = $env ?? $theEnv->getenv();

        if ('' === $cwd) {
            throw new InvalidArgumentException('Cwd should be not empty');
        }
        if (! is_dir($cwd)) {
            throw new InvalidArgumentException([
                'Directory `cwd` not exists',
            ]);
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
        $stdout = trim(stream_get_contents($ps[ 1 ]));
        fclose($ps[ 1 ]);

        // stderr
        $stderr = trim(stream_get_contents($ps[ 2 ]));
        fclose($ps[ 2 ]);

        // return code
        $code = proc_close($h);

        // write to output streams
        ( null !== $cwd )
            ? $theLoggerStdout->notice('>>> [ cwd: "' . $cwd . '" ] ' . $cmd)
            : $theLoggerStdout->notice('>>> ' . $cmd);

        if ($stderr || $stdout) {
            if ('' !== $stderr) {
                foreach ( explode("\n", $stderr) as $line ) {
                    $line = trim($line);

                    if ('' !== $line) {
                        $theLoggerStderr->error($line);
                    }
                }
            }

            if ('' !== $stdout) {
                foreach ( explode("\n", $stdout) as $line ) {
                    $line = trim($line);

                    if ('' !== $line) {
                        $theLoggerStdout->notice($line);
                    }
                }
            }
        }

        ( null !== $cwd )
            ? $theLoggerStdout->notice('<<< [ cwd: "' . $cwd . '" ] ' . $cmd)
            : $theLoggerStdout->notice('<<< ' . $cmd);

        return [ $code, $stderr, $stdout ];
    }


    /**
     * @return string
     */
    public function readln() : string
    {
        if (PHP_SAPI !== 'cli') {
            throw new BadFunctionCallException(
                'Method should be called in CLI mode: ' . __METHOD__
            );
        }

        $h = fopen('php://stdin', 'r');
        $line = trim(fgets($h));
        fclose($h);

        return $line;
    }

    /**
     * @param string $delimiter
     *
     * @return string
     */
    public function cin(string $delimiter = '```') : string
    {
        if (PHP_SAPI !== 'cli') {
            throw new BadFunctionCallException('Method should be called in CLI mode: ' . __METHOD__);
        }

        $theStr = $this->getStr();

        echo '> Enter text separating lines by pressing ENTER' . PHP_EOL;
        echo '> Write ' . $delimiter . ' when you\'re done...' . PHP_EOL;

        $lines = [];
        $h = fopen('php://stdin', 'r');
        while ( false !== ( $line = fgets($h) ) ) {
            $line = trim($line);

            if (! $line) {
                echo '> Write `' . $delimiter . '` when done...' . PHP_EOL;
                continue;
            }

            $expected_pos = $theStr->mb('strlen')($line) - $theStr->mb('strlen')($delimiter);
            $pos = $theStr->mb('strrpos')($line, $delimiter);

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

        $theLogger = $this->getLogger();
        $theLoggerStdout = $theLogger->getChannel('stdout');

        $backup = $backup ?? true;
        $yesOverwrite = $yesOverwrite ?? 'n';

        $realpath = null;
        $backupPath = null;
        if (! file_exists($outputPath)) {
            $theFs->mkdir(dirname($outputPath));

            $realpath = $theFs->filePut($outputPath, $content);

            $theLoggerStdout->notice('Created file: ' . $theFs->secure($realpath));

        } else {
            $realpath = realpath($outputPath);

            $message = 'File exists: ' . basename($realpath) . PHP_EOL
                . $theFs->secure($realpath) . PHP_EOL
                . 'Overwrite?';

            $yes = $this->yes($message, $yesOverwrite);

            if (! $yes) {
                $theLoggerStdout->notice('File exists: ' . $theFs->secure($realpath));

            } else {
                $backupPath = $theFs->filePut($realpath, $content, $backup);

                $theLoggerStdout->notice('Replaced ' . $theFs->secure($realpath));

                if ($backup) {
                    $theLoggerStdout->notice('Backup stored at ' . $theFs->secure($backupPath));
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

        [ $resultMkdir ] = $this->run($cmd);

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
     * На Windows требует установки 7zip. ZIP-архиваторы чаще установлены у пользователей
     *
     * @param string      $zipFilepath
     * @param null|string $baseDirpath
     * @param string      ...$pathes
     *
     * @return int
     */
    public function zip(string $zipFilepath, string $baseDirpath = null, ...$pathes) : int
    {
        if ('' === $zipFilepath) {
            throw new InvalidArgumentException([
                'Invalid `zipFilepathOutput`: %s',
                $zipFilepath,
            ]);
        }

        if (! $pathes) {
            throw new InvalidArgumentException([
                'The `pathes` should be not empty: %s',
                $pathes,
            ]);
        }

        if (file_exists($zipFilepath)) {
            throw new FilesystemException([
                'File `zipFilepathOutput` already exists: %s',
                $zipFilepath,
            ]);
        }

        $isWindows = $this->isWindows();

        $cwd = null;
        if (null !== $baseDirpath) {
            if (! is_dir($baseDirpath)) {
                throw new FilesystemException([
                    'Directory `baseDirpath` not exists: %s',
                    $baseDirpath,
                ]);
            }

            $cwd = realpath($baseDirpath);

        } elseif (! $isWindows) {
            $cwd = '/';
        }

        if ($isWindows) {
            $cmd = "7z a -mm=Deflate -mfb=258 -mpass=15 \"$zipFilepath\" ";

            if (null === $cwd) {
                $cmd .= "-spf2 ";
            }

        } else {
            $cmd = "zip -9 \"$zipFilepath\" ";
        }

        $list = [];
        $drives = [];
        $queue = $pathes;
        while ( null !== ( $k = key($queue) ) ) {
            if (is_array($queue[ $k ])) {
                $queue = array_merge($queue, $queue[ $k ]);

                unset($queue[ $k ]);

                continue;
            }

            if (false
                || ( false === settype($queue[ $k ], 'string') )
                || ( '' === $queue[ $k ] )
                || ! file_exists($queue[ $k ])
            ) {
                throw new FilesystemException([
                    'File not found: %s',
                    $queue[ $k ],
                ]);
            }

            $path = $realpath = realpath($queue[ $k ]);

            if (null !== $cwd) {
                $relative = str_replace($cwd, '', $realpath);

                if ($realpath === $relative) {
                    throw new FilesystemException([
                        'File is located outside `baseDirpath`: %s',
                        $realpath,
                    ]);
                }

                $path = ltrim($relative, DIRECTORY_SEPARATOR);

            } elseif ($this->isWindows()) {
                $theFs = $theFs ?? $this->getFs();

                [ $drive ] = $theFs->drive($realpath);

                if (false
                    || ( false !== strpos($drive, ':/') )
                    || ( false !== strpos($drive, ':\\') )
                ) {
                    $drives[ $drive ] = true;

                    if (count($drives) > 1) {
                        throw new FilesystemException([
                            'Unable to compress files from different drives: %s',
                            $drives,
                        ]);
                    }
                }
            }

            $list[] = '"' . $path . '"';

            unset($queue[ $k ]);
        }

        if (! $list) return 1;

        $cmd .= implode(' ', $list);

        [ $result ] = $this->run($cmd, null, $cwd);

        return $result;
    }

    /**
     * Распаковывает ZIP-архив средствами командной строки
     * На Windows требует установки 7zip. ZIP-архиваторы чаще установлены у пользователей
     *
     * @param string      $zipFilepath
     * @param null|string $destDirpath
     *
     * @return int
     */
    public function unzip(string $zipFilepath, string $destDirpath = null) : int
    {
        if ('' === $zipFilepath) {
            throw new InvalidArgumentException([
                'Invalid `zipFilepath`: %s',
                $zipFilepath,
            ]);
        }

        if (isset($destDirpath)) {
            if ('' === $destDirpath) {
                throw new InvalidArgumentException([
                    'Invalid `destinationDir`: %s',
                    $zipFilepath,
                ]);
            }

            if (! is_dir($destDirpath)) {
                $this->mkdir($destDirpath, null, true);
            }

            if (( new \FilesystemIterator($destDirpath) )->valid()) {
                throw new FilesystemException([
                    'Directory `dirpathDestination` is not empty: %s',
                    $destDirpath,
                ]);
            }

            $destDirpath = realpath($destDirpath);
        }

        $cmd = $this->isWindows()
            ? "7z x \"$zipFilepath\" "
            : "unzip \"$zipFilepath\" ";

        if ('' !== $destDirpath) {
            $cmd .= $this->isWindows()
                ? "-o\"$destDirpath\" "
                : "-d \"$destDirpath\" ";
        }

        [ $result ] = $this->run($cmd);

        return $result;
    }


    /**
     * Создает GZIP-архив из папки средствами командной строки
     * Tar поставляется в штатной версии Windows 10, чаще установлена у администраторов
     *
     * @param string      $tarFilepath
     * @param null|string $baseDirpath
     * @param string      ...$pathes
     *
     * @return int
     */
    public function tar(string $tarFilepath, string $baseDirpath = null, ...$pathes) : int
    {
        $theEnv = $this->getEnv();

        if ('' === $tarFilepath) {
            throw new InvalidArgumentException([
                'Invalid `tarFilepathOutput`: %s',
                $tarFilepath,
            ]);
        }

        if (! $pathes) {
            throw new InvalidArgumentException([
                'The `pathes` should be not empty: %s',
                $pathes,
            ]);
        }

        if (file_exists($tarFilepath)) {
            throw new FilesystemException([
                'File `tarFilepathOutput` already exists: %s',
                $tarFilepath,
            ]);
        }

        $cwd = null;
        if (null !== $baseDirpath) {
            if (! is_dir($baseDirpath)) {
                throw new FilesystemException([
                    'Directory `baseDirpath` not exists: %s',
                    $baseDirpath,
                ]);
            }

            $cwd = realpath($baseDirpath);
        }

        $cmd = "tar -czf \"$tarFilepath\" ";

        if (null !== $cwd) {
            $cmd .= " -C \"$cwd\" ";
        }

        $list = [];
        $queue = $pathes;
        while ( null !== ( $k = key($queue) ) ) {
            if (is_array($queue[ $k ])) {
                $queue = array_merge($queue, $queue[ $k ]);

                unset($queue[ $k ]);

                continue;
            }

            if (false
                || ( false === settype($queue[ $k ], 'string') )
                || ( '' === $queue[ $k ] )
                || ! file_exists($queue[ $k ])
            ) {
                throw new FilesystemException([
                    'File not found: %s',
                    $queue[ $k ],
                ]);
            }

            $path = $realpath = realpath($queue[ $k ]);

            if (null !== $cwd) {
                $relative = str_replace($cwd, '', $realpath);

                if ($realpath === $relative) {
                    throw new FilesystemException([
                        'File is located outside `baseDirpath`: %s',
                        $realpath,
                    ]);
                }

                $path = ltrim($relative, DIRECTORY_SEPARATOR);

            } elseif ($this->isWindows()) {
                $theFs = $theFs ?? $this->getFs();

                [ $drive ] = $theFs->drive($realpath);

                if (false
                    || ( false !== strpos($drive, ':/') )
                    || ( false !== strpos($drive, ':\\') )
                ) {
                    $drives[ $drive ] = true;

                    if (count($drives) > 1) {
                        throw new FilesystemException([
                            'Unable to compress files from different drives: %s',
                            $drives,
                        ]);
                    }
                }
            }

            $list[] = '"' . $path . '"';

            unset($queue[ $k ]);
        }

        if (! $list) return 1;

        $cmd .= implode(' ', $list);

        $env = $this->getEnv()->getenv();
        $env[ 'GZIP' ] = -9;

        [ $result ] = $this->run($cmd, null, $cwd, $env);

        return $result;
    }

    /**
     * Распаковывает GZIP-архив средствами командной строки
     * Tar поставляется в штатной версии Windows 10, чаще установлена у администраторов
     *
     * @param string      $zipFilepath
     * @param null|string $destDirpath
     *
     * @return int
     */
    public function untar(string $zipFilepath, string $destDirpath = null) : int
    {
        if ('' === $zipFilepath) {
            throw new InvalidArgumentException([
                'Invalid `zipFilepath`: %s',
                $zipFilepath,
            ]);
        }

        if (isset($destDirpath)) {
            if ('' === $destDirpath) {
                throw new InvalidArgumentException([
                    'Invalid `destinationDir`: %s',
                    $zipFilepath,
                ]);
            }

            if (! is_dir($destDirpath)) {
                $this->mkdir($destDirpath, null, true);
            }

            if (( new \FilesystemIterator($destDirpath) )->valid()) {
                throw new FilesystemException([
                    'Directory `dirpathDestination` is not empty: %s',
                    $destDirpath,
                ]);
            }

            $destDirpath = realpath($destDirpath);
        }

        $cmd = "tar -xzf \"$zipFilepath\" ";

        if ('' !== $destDirpath) {
            $cmd .= "-C \"$destDirpath\" ";
        }

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