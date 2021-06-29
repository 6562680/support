<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support\Interfaces;

use Gzhegow\Support\Cli;
use Gzhegow\Support\Exceptions\Logic\BadFunctionCallException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Exceptions\RuntimeException;

interface CliInterface
{
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
    public function filePut(string $outputPath, string $content, bool $backup = null, string &$overwrite = null): string;

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
}
