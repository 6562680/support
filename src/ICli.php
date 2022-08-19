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
use Gzhegow\Support\Traits\Load\EnvLoadTrait;
use Gzhegow\Support\Traits\Load\FsLoadTrait;
use Gzhegow\Support\Traits\Load\PhpLoadTrait;
use Gzhegow\Support\Traits\Load\StrLoadTrait;

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
     * @param string $search
     *
     * @return string
     */
    public function cin(string $search = '```'): string;

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
     * Создает ZIP-архив из папки средствами командной строки
     *
     * @param string $outputPath
     * @param string ...$pathes
     *
     * @return int
     */
    public function zip(string $outputPath, ...$pathes): int;

    /**
     * @param string      $message
     * @param null|string $yesQuestion
     *
     * @return bool
     */
    public function yes(string $message, string &$yesQuestion = null): bool;
}
