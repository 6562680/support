<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 * @noinspection RedundantSuppression
 */

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Exceptions\Logic\BadFunctionCallException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Exceptions\Runtime\FilesystemException;
use Gzhegow\Support\ICli;
use Gzhegow\Support\SupportFactory;
use Gzhegow\Support\Traits\Load\EnvLoadTrait;
use Gzhegow\Support\Traits\Load\FsLoadTrait;
use Gzhegow\Support\Traits\Load\LoggerLoadTrait;
use Gzhegow\Support\Traits\Load\PhpLoadTrait;
use Gzhegow\Support\Traits\Load\StrLoadTrait;
use Gzhegow\Support\XCli;
use Monolog\Logger;

class Cli
{
    /**
     * @return bool
     */
    public static function isWindows(): bool
    {
        return static::getInstance()->isWindows();
    }

    /**
     * @param mixed ...$arguments
     */
    public static function stop(...$arguments): void
    {
        static::getInstance()->stop(...$arguments);
    }

    /**
     * @param mixed ...$arguments
     *
     * @return array
     */
    public static function pause(...$arguments): array
    {
        return static::getInstance()->pause(...$arguments);
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
    public static function run(
        string $cmd,
        string $stdin = null,
        string $cwd = null,
        array $env = null,
        array $other_options = null
    ): array {
        return static::getInstance()->run($cmd, $stdin, $cwd, $env, $other_options);
    }

    /**
     * @return string
     */
    public static function readln(): string
    {
        return static::getInstance()->readln();
    }

    /**
     * @param string $delimiter
     *
     * @return string
     */
    public static function cin(string $delimiter = '```'): string
    {
        return static::getInstance()->cin($delimiter);
    }

    /**
     * @param string      $message
     * @param null|string $yesQuestion
     *
     * @return bool
     */
    public static function yes(string $message, string &$yesQuestion = null): bool
    {
        return static::getInstance()->yes($message, $yesQuestion);
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
    public static function mkdir(string $directory, int $permissions = null, bool $recursive = null): int
    {
        return static::getInstance()->mkdir($directory, $permissions, $recursive);
    }

    /**
     * Удаляет директорию средствами командой строки
     *
     * @param string    $directory
     * @param null|bool $recursive
     *
     * @return int
     */
    public static function rmdir(string $directory, bool $recursive = null): int
    {
        return static::getInstance()->rmdir($directory, $recursive);
    }

    /**
     * Создает соединение на директорию средствами командой строки
     *
     * @param string $target
     * @param string $link
     *
     * @return int
     */
    public static function junction(string $target, string $link): int
    {
        return static::getInstance()->junction($target, $link);
    }

    /**
     * Создает символическую ссылку на директорию средствами командой строки
     * К сожалению, на Windows для создания такой ссылки требуются права администратора или пользователь должен иметь разрешение через групповые политики
     *
     * @param string $target
     * @param string $link
     *
     * @return int
     */
    public static function symlink(string $target, string $link): int
    {
        return static::getInstance()->symlink($target, $link);
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
    public static function filePut(
        string $outputPath,
        string $content,
        bool $backup = null,
        string &$yesOverwrite = null
    ): string {
        return static::getInstance()->filePut($outputPath, $content, $backup, $yesOverwrite);
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
    public static function zip(string $zipFilepath, string $baseDirpath = null, ...$pathes): int
    {
        return static::getInstance()->zip($zipFilepath, $baseDirpath, ...$pathes);
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
    public static function unzip(string $zipFilepath, string $destDirpath = null): int
    {
        return static::getInstance()->unzip($zipFilepath, $destDirpath);
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
    public static function tar(string $tarFilepath, string $baseDirpath = null, ...$pathes): int
    {
        return static::getInstance()->tar($tarFilepath, $baseDirpath, ...$pathes);
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
    public static function untar(string $zipFilepath, string $destDirpath = null): int
    {
        return static::getInstance()->untar($zipFilepath, $destDirpath);
    }

    /**
     * @return ICli
     */
    public static function getInstance(): ICli
    {
        return SupportFactory::getInstance()->getCli();
    }
}
