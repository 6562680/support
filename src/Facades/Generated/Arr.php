<?php

/**
 * This file is auto-generated.
 *
 * * @noinspection PhpUnhandledExceptionInspection
 * * @noinspection PhpDocMissingThrowsInspection
 */

namespace Gzhegow\Support\Facades\Generated;

use Gzhegow\Support\Arr as _Arr;

abstract class Arr
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
    public static function &getRef($path, array &$src, $default = null)
    {
        return static::getInstance()->getRef($path, $src, $default);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isIndexable($value) : bool
    {
        return static::getInstance()->isIndexable($value);
    }

    /**
     * @param string|array $path
     * @param array        $src
     *
     * @return bool
     */
    public static function has($path, array &$src) : bool
    {
        return static::getInstance()->has($path, $src);
    }

    /**
     * @param array        $dst
     * @param string|array $path
     * @param mixed        $value
     *
     * @return _Arr
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
    public static function del(array $src, ...$path) : ?array
    {
        return static::getInstance()->del($src, ...$path);
    }

    /**
     * @param array        $src
     * @param string|array $path
     *
     * @return bool
     */
    public static function delete(array &$src, ...$path) : bool
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
    public static function &put(array &$dst, $path, $value)
    {
        return static::getInstance()->put($dst, $path, $value);
    }

    /**
     * выполняет array_push, но возвращает весь массив, а не количество элементов. Для работы с тернарными операторами
     *
     * @param array $array
     * @param mixed ...$items
     *
     * @return array
     */
    public static function push(array $array, ...$items) : array
    {
        return static::getInstance()->push($array, ...$items);
    }

    /**
     * выполняет array_push, но возвращает ссылку на исходный массив, а не количество элементов. Для работы с тернарными операторами
     *
     * @param array $array
     * @param mixed ...$items
     *
     * @return array
     */
    public static function &rpush(array &$array, ...$items) : array
    {
        return static::getInstance()->rpush($array, ...$items);
    }

    /**
     * в функцию array_intersect_key требуются ключи. можно делать array_flip(), а так будет производительнее
     *
     * @param array $array
     *
     * @return array
     */
    public static function clear(array $array) : array
    {
        return static::getInstance()->clear($array);
    }

    /**
     * @param array $array
     * @param mixed ...$keys
     *
     * @return array
     */
    public static function only(array $array, ...$keys) : array
    {
        return static::getInstance()->only($array, ...$keys);
    }

    /**
     * @param array $array
     * @param mixed ...$keys
     *
     * @return array
     */
    public static function except(array $array, ...$keys) : array
    {
        return static::getInstance()->except($array, ...$keys);
    }

    /**
     * @param array $array
     * @param mixed ...$keys
     *
     * @return array
     */
    public static function drop(array $array, ...$keys)
    {
        return static::getInstance()->drop($array, ...$keys);
    }

    /**
     * array_combine позволяющий передать отличный от keys массив значений
     *
     * @param string|string[]    $keys
     * @param null|mixed|mixed[] $values
     * @param bool               $drop
     *
     * @return array
     */
    public static function combine(array $keys, $values = null, bool $drop = null) : array
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
    public static function zip(array $array, ...$arrays) : array
    {
        return static::getInstance()->zip($array, ...$arrays);
    }

    /**
     * partition
     * разбивает массив на два по указанному критерию
     *
     * @param array         $array
     * @param callable|null $func
     *
     * @return array
     */
    public static function partition(array $array, callable $func = null) : array
    {
        return static::getInstance()->partition($array, $func);
    }

    /**
     * group
     * разбивает массив на группированный список и остаток, колбэк возвращает имя группы
     *
     * @param array         $array
     * @param \Closure|null $func
     *
     * @return array
     */
    public static function group(array $array, \Closure $func = null) : array
    {
        return static::getInstance()->group($array, $func);
    }

    /**
     * @param string|string[] $separators
     * @param mixed|mixed[]   ...$parts
     *
     * @return array
     */
    public static function path($separators, ...$parts) : array
    {
        return static::getInstance()->path($separators, ...$parts);
    }

    /**
     * @param string|string[] $delimiters
     * @param mixed|mixed[]   ...$parts
     *
     * @return string
     */
    public static function key($delimiters, ...$parts) : string
    {
        return static::getInstance()->key($delimiters, ...$parts);
    }

    /**
     * @param mixed|mixed[]   $parts
     * @param string|string[] $delimiters
     *
     * @return string
     */
    public static function indexKey($parts, $delimiters = "\x00") : string
    {
        return static::getInstance()->indexKey($parts, $delimiters);
    }

    /**
     * @param mixed $value
     *
     * @return string
     */
    public static function indexVal($value) : string
    {
        return static::getInstance()->indexVal($value);
    }

    /**
     * @param iterable        $iterable
     * @param string|string[] $separators
     *
     * @return array
     */
    public static function dot(iterable $iterable, $separators = '.') : array
    {
        return static::getInstance()->dot($iterable, $separators);
    }

    /**
     * @param array           $data
     * @param string|string[] $separators
     *
     * @return array
     */
    public static function undot(array $data, $separators = '.') : array
    {
        return static::getInstance()->undot($data, $separators);
    }

    /**
     * @param array $array
     * @param int   $flags
     *
     * @return \Generator
     */
    public static function walk(array $array, int $flags = 0) : \Generator
    {
        yield static::getInstance()->walk($array, $flags);
    }

    /**
     * @param iterable $iterable
     * @param int      $flags
     *
     * @return \Generator
     */
    public static function crawl(iterable $iterable, int $flags = 0) : \Generator
    {
        yield static::getInstance()->crawl($iterable, $flags);
    }

    /**
     * Вставляет элементы в указанные позиции по индексам, изменяя числовые индексы существующих элементов
     *
     * Механизм применяется в dran-n-drop элементов списка при пользовательской сортировке
     * и в инжекторе зависимостей, чтобы между переданными параметрами воткнуть свой
     *
     * @param array   $dst
     * @param mixed[] ...$expands
     *
     * @return array
     */
    public static function expandMany(array $dst, array ...$expands) : array
    {
        return static::getInstance()->expandMany($dst, ...$expands);
    }

    /**
     * @param array $dst
     * @param int   $expandIdx
     * @param mixed $expandValue
     *
     * @return array
     */
    public static function expand(array $dst, int $expandIdx, $expandValue) : array
    {
        return static::getInstance()->expand($dst, $expandIdx, $expandValue);
    }


    /**
     * @return _Arr
     */
    abstract public static function getInstance() : _Arr;
}
