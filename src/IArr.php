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

use Gzhegow\Support\Domain\Arr\ValueObject\ExpandValue;
use Gzhegow\Support\Exceptions\Error;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Exceptions\Logic\OutOfRangeException;
use Gzhegow\Support\Exceptions\Runtime\UnderflowException;

interface IArr
{
    /**
     * @return ZArr
     */
    public function reset();

    /**
     * @param $indexer
     *
     * @return ZArr
     */
    public function clone(?callable $indexer);

    /**
     * @param null|callable $indexer
     *
     * @return ZArr
     */
    public function with(?callable $indexer);

    /**
     * @param callable $indexer
     *
     * @return ZArr
     */
    public function withIndexer(callable $indexer);

    /**
     * @param string|array $path
     * @param array        $src
     * @param null|mixed   $default
     *
     * @return mixed
     */
    public function &getRef($path, array &$src, $default = "\x00");

    /**
     * @param mixed $value
     *
     * @return null|array
     */
    public function arrval($value): ?array;

    /**
     * @param mixed $value
     *
     * @return array
     */
    public function theArrval($value): array;

    /**
     * @param mixed $value
     *
     * @return null|int|float
     */
    public function keyval($value);

    /**
     * @param mixed $value
     *
     * @return null|int|float
     */
    public function theKeyval($value);

    /**
     * @param int|string|array $keys
     * @param null|bool        $uniq
     * @param null|bool        $recursive
     *
     * @return string[]
     */
    public function keyvals($keys, bool $uniq = null, bool $recursive = null): array;

    /**
     * @param int|string|array $keys
     * @param null|bool        $uniq
     * @param null|bool        $recursive
     *
     * @return string[]
     */
    public function theKeyvals($keys, bool $uniq = null, bool $recursive = null): array;

    /**
     * @param string|array $path
     * @param array        $src
     * @param null|mixed   $default
     *
     * @return mixed
     */
    public function get($path, array &$src, $default = "\x00");

    /**
     * @param string|array $path
     * @param array        $src
     *
     * @return bool
     */
    public function has($path, array &$src): bool;

    /**
     * @param null|array   $dst
     * @param string|array $path
     * @param mixed        $value
     *
     * @return ZArr
     */
    public function set(?array &$dst, $path, $value);

    /**
     * @param array        $src
     * @param string|array $path
     *
     * @return array
     */
    public function del(array $src, ...$path): ?array;

    /**
     * @param array        $src
     * @param string|array $path
     *
     * @return bool
     */
    public function delete(array &$src, ...$path): bool;

    /**
     * @param null|array   $dst
     * @param string|array $path
     * @param mixed        $value
     *
     * @return mixed
     */
    public function &put(?array &$dst, $path, $value);

    /**
     * @param string|string[]|array $path
     * @param string|string[]|array $separators
     *
     * @return array
     */
    public function path($path, $separators = '.'): array;

    /**
     * @param string|string[]|array $path
     * @param string|string[]|array $separators
     *
     * @return string
     */
    public function pathkey($path, $separators = '.'): string;

    /**
     * @param string|string[]|array $separators
     * @param string|string[]|array ...$keys
     *
     * @return string
     */
    public function index($separators = '.', ...$keys): string;

    /**
     * возвращает индекс любого числа аргументов для создания поиска по массивам
     *
     * @param mixed ...$values
     *
     * @return string
     */
    public function indexed(...$values): string;

    /**
     * в функцию array_intersect_key требуются ключи. можно делать array_flip(), а так будет производительнее
     *
     * @param array $array
     *
     * @return array
     */
    public function clear(array $array): array;

    /**
     * @param array                 $array
     * @param string|string[]|array ...$keys
     *
     * @return array
     */
    public function only(array $array, ...$keys): array;

    /**
     * @param array                 $array
     * @param string|string[]|array ...$keys
     *
     * @return array
     */
    public function except(array $array, ...$keys): array;

    /**
     * @param array                 $array
     * @param string|string[]|array ...$keys
     *
     * @return array
     */
    public function drop(array $array, ...$keys);

    /**
     * array_combine позволяющий передать разное число ключей и значений
     *
     * @param string|array     $keys
     * @param null|mixed|array $values
     * @param null|bool        $drop
     *
     * @return array
     */
    public function combine(array $keys, $values = null, bool $drop = null): array;

    /**
     * array_combine + array_map
     *
     * @param string|array $keys
     * @param iterable     $collection
     * @param null|bool    $drop
     *
     * @return array
     */
    public function combineMap(array $keys, iterable $collection, bool $drop = null): array;

    /**
     * @param array $arr
     *
     * @return void
     */
    public function reverse(array &$arr): void;

    /**
     * обменивает местами номер элемента массива и номер ключа в массиве
     * [ [$a1, $a2], [$b1, $b2]... ] => [ [$a1, $b1], [$a2, $b2]... ]
     *
     * @param array $array
     * @param array ...$arrays
     *
     * @return array
     */
    public function zip(array $array, ...$arrays): array;

    /**
     * разбивает массив на два по указанному булеву критерию
     *
     * @param array         $array
     * @param callable|null $func
     *
     * @return array
     */
    public function partition(array $array, callable $func = null): array;

    /**
     * разбивает массив на группированный список и остаток, замыкание должно возвращать имя группы
     *
     * @param array         $array
     * @param \Closure|null $func
     *
     * @return array
     */
    public function group(array $array, \Closure $func = null): array;

    /**
     * рекурсивно собирает массив в одноуровневый соединяя ключи через разделитель
     * пустые массивы пропускаются
     *
     * @param iterable              $iterable
     * @param string|string[]|array $separators
     *
     * @return array
     */
    public function dot(iterable $iterable, $separators = '.'): array;

    /**
     * рекурсивно собирает массив в одноуровневый соединяя ключи через разделитель
     * пустые массивы и цифровые ключи на последнем уровне остаются массивами
     *
     * @param iterable              $iterable
     * @param string|string[]|array $separators
     *
     * @return array
     */
    public function dotarr(iterable $iterable, $separators = '.'): array;

    /**
     * @param array                 $data
     * @param string|string[]|array $separators
     *
     * @return array
     */
    public function undot(array $data, $separators = '.'): array;

    /**
     * @param array    $array
     * @param null|int $mode
     *
     * @return \Generator
     */
    public function walk(array $array, int $mode = null): \Generator;

    /**
     * @param iterable $iterable
     * @param null|int $mode
     * @param null|int $flags
     *
     * @return \Generator
     */
    public function crawl(iterable $iterable, int $mode = null, int $flags = null): \Generator;

    /**
     * @param array    $array
     * @param callable $callback
     * @param mixed    ...$args
     *
     * @return ZArr
     */
    public function walk_recursive(array &$array, $callback, ...$args);

    /**
     * @param array    $iterable
     * @param callable $callback
     * @param mixed    ...$args
     *
     * @return ZArr
     */
    public function crawl_recursive(iterable $iterable, $callback, ...$args);

    /**
     * @param array $dst
     * @param int   $expandIdx
     * @param mixed $expandValue
     *
     * @return array
     */
    public function expand(array $dst, int $expandIdx, $expandValue): array;

    /**
     * Вставляет элементы в указанные позиции по индексам, изменяя числовые индексы существующих элементов
     *
     * Механизм применяется в dran-n-drop элементов списка при пользовательской сортировке
     * и в инжекторе зависимостей, чтобы между переданными параметрами воткнуть свой
     *
     * @param array   $dst
     * @param array[] ...$expands
     *
     * @return array
     */
    public function expandMany(array $dst, array ...$expands): array;
}
