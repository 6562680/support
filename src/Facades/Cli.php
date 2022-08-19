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
use Gzhegow\Support\ICli;
use Gzhegow\Support\SupportFactory;
use Gzhegow\Support\Traits\Load\EnvLoadTrait;
use Gzhegow\Support\Traits\Load\FsLoadTrait;
use Gzhegow\Support\Traits\Load\PhpLoadTrait;
use Gzhegow\Support\Traits\Load\StrLoadTrait;
use Gzhegow\Support\XCli;

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
     * @param string $search
     *
     * @return string
     */
    public static function cin(string $search = '```'): string
    {
        return static::getInstance()->cin($search);
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
     * Создает ZIP-архив из папки средствами командной строки
     *
     * @param string $outputPath
     * @param string ...$pathes
     *
     * @return int
     */
    public static function zip(string $outputPath, ...$pathes): int
    {
        return static::getInstance()->zip($outputPath, ...$pathes);
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
     * @return ICli
     */
    public static function getInstance(): ICli
    {
        return SupportFactory::getInstance()->getCli();
    }
}
