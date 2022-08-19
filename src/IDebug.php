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

use Gzhegow\Support\Domain\Debug\DebugMessage;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;

interface IDebug
{
    /**
     * @param string|array $message
     * @param array        ...$placeholders
     *
     * @return DebugMessage
     */
    public function newDebugMessage($message, ...$placeholders): DebugMessage;

    /**
     * @param string|array|mixed $message
     * @param mixed              ...$placeholders
     *
     * @return null|DebugMessage
     */
    public function messageVal($message, ...$placeholders): ?DebugMessage;

    /**
     * @param string|array|mixed $message
     * @param mixed              ...$placeholders
     *
     * @return DebugMessage
     */
    public function theMessageVal($message, ...$placeholders): DebugMessage;

    /**
     * @param null|array|\Throwable|mixed $trace
     * @param null|int                    $limit
     * @param null|int                    $options
     *
     * @return null|array
     */
    public function traceVal($trace = null, int $limit = null, int $options = null): ?array;

    /**
     * @param null|array|\Throwable|mixed $trace
     * @param null|int                    $limit
     * @param null|int                    $options
     *
     * @return array
     */
    public function theTraceVal($trace = null, int $limit = null, int $options = null): array;

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
     * Рекурсивно собирает из дерева исключений сообщения в список
     *
     * @param null|\Throwable $e
     * @param null|int        $limit
     *
     * @return array
     */
    public function extractThrowableMessages(\Throwable $e, int $limit = -1);

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
    public function buildTraceReport(
        $trace,
        $columns = null,
        string $implode = null,
        int $limit = null,
        int $options = null
    ): array;

    /**
     * Возвращает результат var_dump, заменяет все пробелы на один
     *
     * @param           $arg
     * @param null|bool $return
     *
     * @return string
     */
    public function varDump($arg, bool $return = null): ?string;

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
}
