<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 * @noinspection RedundantSuppression
 */

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\Logic\BadFunctionCallException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Exceptions\Runtime\FilesystemException;
use Gzhegow\Support\Traits\Load\EnvLoadTrait;
use Gzhegow\Support\Traits\Load\FsLoadTrait;
use Gzhegow\Support\Traits\Load\LoggerLoadTrait;
use Gzhegow\Support\Traits\Load\PhpLoadTrait;
use Gzhegow\Support\Traits\Load\StrLoadTrait;
use Monolog\Logger;

interface ICli
{
    /**
     * @return bool
     */
    public function isWindows(): bool;

    /**
     * @param mixed ...$arguments
     */
    public function stop(...$arguments): void;

    /**
     * @param mixed ...$arguments
     *
     * @return array
     */
    public function pause(...$arguments): array;

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
    public function run(
        string $cmd,
        string $stdin = null,
        string $cwd = null,
        array $env = null,
        array $other_options = null
    ): array;

    /**
     * @return string
     */
    public function readln(): string;

    /**
     * @param string $delimiter
     *
     * @return string
     */
    public function cin(string $delimiter = '```'): string;

    /**
     * @param string      $message
     * @param null|string $yesQuestion
     *
     * @return bool
     */
    public function yes(string $message, string &$yesQuestion = null): bool;

    /**
     * Создает директорию средствами командной строки
     *
     * @param string    $directory
     * @param null|int  $permissions
     * @param null|bool $recursive
     *
     * @return int
     */
    public function mkdir(string $directory, int $permissions = null, bool $recursive = null): int;

    /**
     * Удаляет директорию средствами командой строки
     *
     * @param string    $directory
     * @param null|bool $recursive
     *
     * @return int
     */
    public function rmdir(string $directory, bool $recursive = null): int;

    /**
     * Создает соединение на директорию средствами командой строки
     *
     * @param string $target
     * @param string $link
     *
     * @return int
     */
    public function junction(string $target, string $link): int;

    /**
     * Создает символическую ссылку на директорию средствами командой строки
     * К сожалению, на Windows для создания такой ссылки требуются права администратора или пользователь должен иметь разрешение через групповые политики
     *
     * @param string $target
     * @param string $link
     *
     * @return int
     */
    public function symlink(string $target, string $link): int;

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
    public function filePut(
        string $outputPath,
        string $content,
        bool $backup = null,
        string &$yesOverwrite = null
    ): string;

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
    public function zip(string $zipFilepath, string $baseDirpath = null, ...$pathes): int;

    /**
     * Распаковывает ZIP-архив средствами командной строки
     * На Windows требует установки 7zip. ZIP-архиваторы чаще установлены у пользователей
     *
     * @param string      $zipFilepath
     * @param null|string $destDirpath
     *
     * @return int
     */
    public function unzip(string $zipFilepath, string $destDirpath = null): int;

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
    public function tar(string $tarFilepath, string $baseDirpath = null, ...$pathes): int;

    /**
     * Распаковывает GZIP-архив средствами командной строки
     * Tar поставляется в штатной версии Windows 10, чаще установлена у администраторов
     *
     * @param string      $zipFilepath
     * @param null|string $destDirpath
     *
     * @return int
     */
    public function untar(string $zipFilepath, string $destDirpath = null): int;
}
