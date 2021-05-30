<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support\Facades\Generated;

use Gzhegow\Support\Arr;
use Gzhegow\Support\Domain\Arr\ArrExpandVO;
use Gzhegow\Support\Domain\Arr\CrawlIterator;
use Gzhegow\Support\Domain\Arr\WalkIterator;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Exceptions\Logic\OutOfRangeException;
use Gzhegow\Support\Exceptions\Runtime\UnderflowException;

abstract class GeneratedArrFacade
{
    /**
     * @param string|array $path
     * @param array        $src
     * @param null|mixed   $default
     *
     * @return mixed
     */
    public static function get($path, array &$src, $default = null)
    {
        return static::getInstance()->get($path, $src, $default);
    }

    /**
     * @param string|array $path
     * @param array        $src
     * @param null|mixed   $default
     *
     * @return mixed
     */
    public static function getRef($path, array &$src, $default = null)
    {
        return static::getInstance()->getRef($path, $src, $default);
    }

    /**
     * @param string|array $path
     * @param array        $src
     *
     * @return bool
     */
    public static function has($path, array &$src): bool
    {
        return static::getInstance()->has($path, $src);
    }

    /**
     * @param array        $dst
     * @param string|array $path
     * @param mixed        $value
     *
     * @return Arr
     */
    public static function set(array &$dst, $path, $value)
    {
        return static::getInstance()->set($dst, $path, $value);
    }

    /**
     * @param array        $src
     * @param string|array $path
     *
     * @return array
     */
    public static function del(array $src, ...$path): ?array
    {
        return static::getInstance()->del($src, ...$path);
    }

    /**
     * @param array        $src
     * @param string|array $path
     *
     * @return bool
     */
    public static function delete(array &$src, ...$path): bool
    {
        return static::getInstance()->delete($src, ...$path);
    }

    /**
     * @param array        $dst
     * @param string|array $path
     * @param mixed        $value
     *
     * @return mixed
     */
    public static function put(array &$dst, $path, $value)
    {
        return static::getInstance()->put($dst, $path, $value);
    }

    /**
     * @param string|string[]|array $keys
     * @param string|string[]|array $separators
     *
     * @return array
     */
    public static function path($keys, $separators = '.'): array
    {
        return static::getInstance()->path($keys, $separators);
    }

    /**
     * @param string|string[]|array $keys
     * @param string|string[]|array $separators
     *
     * @return string
     */
    public static function key($keys, $separators = '.'): string
    {
        return static::getInstance()->key($keys, $separators);
    }

    /**
     * @param string|string[]|array $separators
     * @param string|string[]|array ...$keys
     *
     * @return string
     */
    public static function indexkey($separators = '.', ...$keys): string
    {
        return static::getInstance()->indexkey($separators, ...$keys);
    }

    /**
     * @param mixed $value
     *
     * @return string
     */
    public static function indexval($value): string
    {
        return static::getInstance()->indexval($value);
    }

    /**
     * в функцию array_intersect_key требуются ключи. можно делать array_flip(), а так будет производительнее
     *
     * @param array $array
     *
     * @return array
     */
    public static function clear(array $array): array
    {
        return static::getInstance()->clear($array);
    }

    /**
     * @param array                 $array
     * @param string|string[]|array ...$keys
     *
     * @return array
     */
    public static function only(array $array, ...$keys): array
    {
        return static::getInstance()->only($array, ...$keys);
    }

    /**
     * @param array                 $array
     * @param string|string[]|array ...$keys
     *
     * @return array
     */
    public static function except(array $array, ...$keys): array
    {
        return static::getInstance()->except($array, ...$keys);
    }

    /**
     * @param array                 $array
     * @param string|string[]|array ...$keys
     *
     * @return array
     */
    public static function drop(array $array, ...$keys)
    {
        return static::getInstance()->drop($array, ...$keys);
    }

    /**
     * array_combine позволяющий передать разное число ключей и значений
     *
     * @param string|string[]    $keys
     * @param null|mixed|mixed[] $values
     * @param bool               $drop
     *
     * @return array
     */
    public static function combine(array $keys, $values = null, bool $drop = null): array
    {
        return static::getInstance()->combine($keys, $values, $drop);
    }

    /**
     * обменивает местами номер элемента массива и номер ключа в массиве
     * [ [$a1, $a2], [$b1, $b2]... ] => [ [$a1, $b1], [$a2, $b2]... ]
     *
     * @param array $array
     * @param array ...$arrays
     *
     * @return array
     */
    public static function zip(array $array, ...$arrays): array
    {
        return static::getInstance()->zip($array, ...$arrays);
    }

    /**
     * разбивает массив на два по указанному критерию
     *
     * @param array         $array
     * @param callable|null $func
     *
     * @return array
     */
    public static function partition(array $array, callable $func = null): array
    {
        return static::getInstance()->partition($array, $func);
    }

    /**
     * разбивает массив на группированный список и остаток, замыкание должно возвращать имя группы
     *
     * @param array         $array
     * @param \Closure|null $func
     *
     * @return array
     */
    public static function group(array $array, \Closure $func = null): array
    {
        return static::getInstance()->group($array, $func);
    }

    /**
     * рекурсивно собирает массив в одноуровневый соединяя ключи через разделитель
     * пустые массивы пропускаются
     *
     * @param iterable              $iterable
     * @param string|string[]|array $separators
     *
     * @return array
     */
    public static function dot(iterable $iterable, $separators = '.'): array
    {
        return static::getInstance()->dot($iterable, $separators);
    }

    /**
     * рекурсивно собирает массив в одноуровневый соединяя ключи через разделитель
     * пустые массивы и цифровые ключи на последнем уровне остаются массивами
     *
     * @param iterable              $iterable
     * @param string|string[]|array $separators
     *
     * @return array
     */
    public static function dotarr(iterable $iterable, $separators = '.'): array
    {
        return static::getInstance()->dotarr($iterable, $separators);
    }

    /**
     * @param array                 $data
     * @param string|string[]|array $separators
     *
     * @return array
     */
    public static function undot(array $data, $separators = '.'): array
    {
        return static::getInstance()->undot($data, $separators);
    }

    /**
     * @param array $array
     * @param int   $flags
     *
     * @return \Generator
     */
    public static function walk(array $array, int $flags = 0): \Generator
    {
        yield from static::getInstance()->walk($array, $flags);
    }

    /**
     * @param iterable $iterable
     * @param int      $flags
     *
     * @return \Generator
     */
    public static function crawl(iterable $iterable, int $flags = 0): \Generator
    {
        yield from static::getInstance()->crawl($iterable, $flags);
    }

    /**
     * @param array $dst
     * @param int   $expandIdx
     * @param mixed $expandValue
     *
     * @return array
     */
    public static function expand(array $dst, int $expandIdx, $expandValue): array
    {
        return static::getInstance()->expand($dst, $expandIdx, $expandValue);
    }

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
    public static function expandMany(array $dst, array ...$expands): array
    {
        return static::getInstance()->expandMany($dst, ...$expands);
    }

    /**
     * @param mixed $value
     *
     * @return null|array
     */
    public static function arrval($value): ?array
    {
        return static::getInstance()->arrval($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|int|float
     */
    public static function keyval($value)
    {
        return static::getInstance()->keyval($value);
    }

    /**
     * @param int|string|array  $keys
     * @param null|bool         $uniq
     * @param null|string|array $message
     * @param mixed             ...$arguments
     *
     * @return string[]
     */
    public static function keyvals($keys, $uniq = null, $message = null, ...$arguments): array
    {
        return static::getInstance()->keyvals($keys, $uniq, $message, ...$arguments);
    }

    /**
     * @param int|string|array  $keys
     * @param null|bool         $uniq
     * @param null|string|array $message
     * @param mixed             ...$arguments
     *
     * @return string[]
     */
    public static function theKeyvals($keys, $uniq = null, $message = null, ...$arguments): array
    {
        return static::getInstance()->theKeyvals($keys, $uniq, $message, ...$arguments);
    }

    /**
     * @param int|string|array $keys
     * @param null|bool        $uniq
     *
     * @return array
     */
    public static function keyvalsSkip($keys, $uniq = null): array
    {
        return static::getInstance()->keyvalsSkip($keys, $uniq);
    }

    /**
     * @param int|string|array $keys
     * @param null|bool        $uniq
     *
     * @return array
     */
    public static function theKeyvalsSkip($keys, $uniq = null): array
    {
        return static::getInstance()->theKeyvalsSkip($keys, $uniq);
    }

    /**
     * @return Arr
     */
    abstract public static function getInstance(): Arr;
}