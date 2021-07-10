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

use Gzhegow\Support\Domain\Debug\Message;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\IDebug;
use Gzhegow\Support\SupportFactory;
use Gzhegow\Support\ZDebug;

class Debug
{
    /**
     * @param string|array|mixed $message
     * @param mixed              ...$arguments
     *
     * @return null|Message
     */
    public static function messageVal($message, ...$arguments): ?Message
    {
        return static::getInstance()->messageVal($message, ...$arguments);
    }

    /**
     * @param string|array|mixed $message
     * @param mixed              ...$arguments
     *
     * @return Message
     */
    public static function theMessageVal($message, ...$arguments): Message
    {
        return static::getInstance()->theMessageVal($message, ...$arguments);
    }

    /**
     * @param null|array|\Throwable|mixed $trace
     * @param null|int                    $limit
     * @param null|int                    $options
     *
     * @return null|array
     */
    public static function traceVal($trace = null, int $limit = null, int $options = null): ?array
    {
        return static::getInstance()->traceVal($trace, $limit, $options);
    }

    /**
     * @param null|array|\Throwable|mixed $trace
     * @param null|int                    $limit
     * @param null|int                    $options
     *
     * @return array
     */
    public static function theTraceVal($trace = null, int $limit = null, int $options = null): array
    {
        return static::getInstance()->theTraceVal($trace, $limit, $options);
    }

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
     * Извлекает определенные колонки из debug_backtrace()/$throwable->getTrace()
     * может соединить их через разделитель в строку
     *
     * @param null|array|\Throwable $trace
     * @param null|string|array     $columns
     * @param null|string           $implode
     * @param null|int              $limit
     * @param null|int              $options
     *
     * @return array
     */
    public static function traceReport(
        $trace,
        $columns = null,
        string $implode = null,
        int $limit = null,
        int $options = null
    ): array {
        return static::getInstance()->traceReport($trace, $columns, $implode, $limit, $options);
    }

    /**
     * Рекурсивно собирает из дерева исключений сообщения в список
     *
     * @param null|\Throwable $e
     * @param null|int        $limit
     *
     * @return array
     */
    public static function throwableMessages(\Throwable $e, int $limit = -1)
    {
        return static::getInstance()->throwableMessages($e, $limit);
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
     * @return IDebug
     */
    public static function getInstance(): IDebug
    {
        return SupportFactory::getInstance()->getDebug();
    }
}
