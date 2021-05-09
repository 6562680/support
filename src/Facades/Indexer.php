<?php

/**
 * This file is auto-generated.
 *
 * * @noinspection PhpUnhandledExceptionInspection
 * * @noinspection PhpDocMissingThrowsInspection
 */

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Indexer as _Indexer;

class Indexer
{
    /**
     * @return _Indexer
     */
    public static function getInstance() : _Indexer
    {
        return new _Indexer(
            Filter::getInstance(),
            Php::getInstance()
        );
    }


    /**
     * @return string
     */
    public static function getSeparator() : string
    {
        return static::getInstance()->getSeparator();
    }

    /**
     * @param string $separator
     *
     * @return _Indexer
     */
    public static function setSeparator(string $separator)
    {
        return static::getInstance()->setSeparator($separator);
    }

    /**
     * @param string|string[] $keys
     *
     * @return string
     */
    public static function index(...$keys) : string
    {
        return static::getInstance()->index(...$keys);
    }

    /**
     * @param string|string[] $keys
     *
     * @return string
     */
    public static function indexUnsafe(...$keys) : string
    {
        return static::getInstance()->indexUnsafe(...$keys);
    }

    /**
     * @param string|string[] $indexes
     *
     * @return array
     */
    public static function path(...$indexes) : array
    {
        return static::getInstance()->path(...$indexes);
    }

    /**
     * @param string|string[] $indexes
     *
     * @return array
     */
    public static function pathUnsafe(...$indexes) : array
    {
        return static::getInstance()->pathUnsafe(...$indexes);
    }

    /**
     * @param mixed $value
     *
     * @return string
     */
    public static function indexValue($value) : string
    {
        return static::getInstance()->indexValue($value);
    }
}
