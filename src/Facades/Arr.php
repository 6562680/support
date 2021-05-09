<?php

/**
 * This file is auto-generated.
 *
 * * @noinspection PhpUnhandledExceptionInspection
 * * @noinspection PhpDocMissingThrowsInspection
 */

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Arr as _Arr;

class Arr
{
    /**
     * @return _Arr
     */
    public static function getInstance() : _Arr
    {
        return new _Arr(
            Filter::getInstance(),
            Php::getInstance()
        );
    }


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
    public static function del(array $src, ...$path) : array
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
     * @param iterable $iterable
     *
     * @return array
     */
    public static function dot(iterable $iterable) : array
    {
        return static::getInstance()->dot($iterable);
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public static function undot(array $data) : array
    {
        return static::getInstance()->undot($data);
    }

    /**
     * @param array $path
     *
     * @return string
     */
    public static function dotkey(...$path) : string
    {
        return static::getInstance()->dotkey(...$path);
    }

    /**
     * @param array $path
     *
     * @return string
     */
    public static function dotkeyUnsafe(...$path) : string
    {
        return static::getInstance()->dotkeyUnsafe(...$path);
    }

    /**
     * @param mixed ...$path
     *
     * @return array
     */
    public static function path(...$path) : array
    {
        return static::getInstance()->path(...$path);
    }

    /**
     * @param mixed ...$path
     *
     * @return array
     */
    public static function pathUnsafe(...$path) : array
    {
        return static::getInstance()->pathUnsafe(...$path);
    }

    /**
     * @param iterable $iterable
     * @param int      $flags
     *
     * @return \Generator
     */
    public static function walk(iterable $iterable, int $flags = 0) : \Generator
    {
        yield static::getInstance()->walk($iterable, $flags);
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
}
