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
        $indexer = Indexer::getInstance()->setSeparator('.');

        return new _Arr(
            Php::getInstance(),
            Type::getInstance(),

            $indexer
        );
    }


    /**
     * @param string|array $path
     * @param array        $src
     * @param null         $default
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
     * @return _Arr
     */
    public static function del(array &$src, ...$path)
    {
        return static::getInstance()->del($src, ...$path);
    }

    /**
     * @param string|array $path
     * @param array        $src
     * @param null         $default
     *
     * @return mixed
     */
    public static function &ref($path, array &$src, $default = null)
    {
        return static::getInstance()->ref($path, $src, $default);
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
     * Inserts element into certain pos between existing elements
     *
     * @param array $array
     * @param int   $pos
     * @param null  $value
     *
     * @return array
     */
    public static function expand(array $array, int $pos, $value = null) : array
    {
        return static::getInstance()->expand($array, $pos, $value);
    }
}
