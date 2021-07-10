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
use Gzhegow\Support\ZCli;

class Cli
{
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
    public static function filePut(
        string $outputPath,
        string $content,
        bool $backup = null,
        string &$overwrite = null
    ): string {
        return static::getInstance()->filePut($outputPath, $content, $backup, $overwrite);
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
     * @return ICli
     */
    public static function getInstance(): ICli
    {
        return SupportFactory::getInstance()->getCli();
    }
}
