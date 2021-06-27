<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support\Interfaces;

use Gzhegow\Support\Debug;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;

interface DebugInterface
{
    /**
     * @param string|array|mixed $message
     * @param mixed              ...$arguments
     *
     * @return null|array
     */
    public function messageVal($message, ...$arguments): ?array;

    /**
     * @param string|array|mixed $message
     * @param mixed              ...$arguments
     *
     * @return array
     */
    public function theMessageVal($message, ...$arguments): array;

    /**
     * @param null|array|\Throwable|mixed $trace
     * @param int                         $limit
     * @param int                         $options
     *
     * @return null|array
     */
    public function traceVal(
        $trace = null,
        int $limit = 0,
        int $options = Gzhegow\Support\DEBUG_BACKTRACE_PROVIDE_OBJECT
    ): ?array;

    /**
     * @param null|array|\Throwable|mixed $trace
     * @param int                         $limit
     * @param int                         $options
     *
     * @return array
     */
    public function theTraceVal(
        $trace = null,
        int $limit = 0,
        int $options = Gzhegow\Support\DEBUG_BACKTRACE_PROVIDE_OBJECT
    ): array;

    /**
     * Выводит любой тип для дебага и отчета в исключениях
     *
     * @param mixed $arg
     *
     * @return string
     */
    public function arg($arg): string;

    /**
     * @param array $args
     *
     * @return string[]
     */
    public function args(array $args): array;

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
    public function traceReport(
        $trace,
        $columns = null,
        string $implode = null,
        int $limit = null,
        int $options = null
    ): array;

    /**
     * Рекурсивно собирает из дерева исключений сообщения в список
     *
     * @param null|\Throwable $e
     * @param null|int        $limit
     *
     * @return array
     */
    public function throwableMessages(\Throwable $e, int $limit = -1);

    /**
     * Возвращает результат var_dump, заменяет все пробелы на один
     *
     * @param array $arguments
     *
     * @return string
     */
    public function varDump(...$arguments): string;

    /**
     * Запускает print_r, заменяет все пробелы на один
     *
     * @param mixed     $arg
     * @param bool|null $return
     *
     * @return string
     */
    public function printR($arg, bool $return = null): ?string;

    /**
     * Запускает var_export, заменяет все пробелы на один
     *
     * @param mixed     $arg
     * @param bool|null $return
     *
     * @return string
     */
    public function varExport($arg, bool $return = null): ?string;

    /**
     * Заменяет любое число пробелов в тексте на один
     *
     * @param string $content
     *
     * @return string
     */
    public function dom(string $content): string;
}
