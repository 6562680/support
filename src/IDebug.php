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

use Gzhegow\Support\Domain\Debug\Message;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;

interface IDebug
{
    /**
     * @param string|array|mixed $message
     * @param mixed              ...$arguments
     *
     * @return null|Message
     */
    public function messageVal($message, ...$arguments): ?Message;

    /**
     * @param string|array|mixed $message
     * @param mixed              ...$arguments
     *
     * @return Message
     */
    public function theMessageVal($message, ...$arguments): Message;

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
