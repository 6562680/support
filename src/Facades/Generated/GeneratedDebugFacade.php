<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support\Facades\Generated;

use Gzhegow\Support\Debug;

abstract class GeneratedDebugFacade
{
    /**
     * Выводит любой тип для дебага и отчета в исключениях
     *
     * @param mixed $arg
     *
     * @return string
     */
    public static function arg($arg): string
    {
        return static::getInstance()->arg($arg);
    }

    /**
     * @param array $args
     *
     * @return string[]
     */
    public static function args(array $args): array
    {
        return static::getInstance()->args($args);
    }

    /**
     * Заменяет любое число пробелов в тексте на один
     *
     * @param string $content
     *
     * @return string
     */
    public static function dom(string $content): string
    {
        return static::getInstance()->dom($content);
    }

    /**
     * Извлекает определенные колонки из debug_backtrace()/$throwable->getTrace()
     * может соединить их через разделитель в строку
     *
     * @param array       $trace
     * @param array       $columns
     * @param null|string $implode
     *
     * @return array
     */
    public static function trace(array $trace, array $columns = [], string $implode = null): array
    {
        return static::getInstance()->trace($trace, $columns, $implode);
    }

    /**
     * Возвращает результат var_dump, заменяет все пробелы на один
     *
     * @param array $arguments
     *
     * @return string
     */
    public static function varDump(...$arguments): string
    {
        return static::getInstance()->varDump(...$arguments);
    }

    /**
     * Запускает print_r, заменяет все пробелы на один
     *
     * @param mixed     $arg
     * @param bool|null $return
     *
     * @return string
     */
    public static function printR($arg, bool $return = null): ?string
    {
        return static::getInstance()->printR($arg, $return);
    }

    /**
     * Запускает var_export, заменяет все пробелы на один
     *
     * @param mixed     $arg
     * @param bool|null $return
     *
     * @return string
     */
    public static function varExport($arg, bool $return = null): ?string
    {
        return static::getInstance()->varExport($arg, $return);
    }

    /**
     * @return Debug
     */
    abstract public static function getInstance(): Debug;
}
