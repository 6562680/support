<?php

/**
 * This file is auto-generated.
 *
 * * @noinspection PhpUnhandledExceptionInspection
 * * @noinspection PhpDocMissingThrowsInspection
 */

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Preg as _Preg;
use Gzhegow\Support\Domain\Preg\RegExp;

class Preg
{
    /**
     * @param string|string[] $regex
     * @param null|string     $delimiter
     * @param null|string     $flags
     *
     * @return RegExp
     */
    public static function newRegExp($regex, string $delimiter = null, string $flags = null) : RegExp
    {
        return static::getInstance()->newRegExp($regex, $delimiter, $flags);
    }

    /**
     * @param string|string[] $regex
     * @param null|string     $delimiter
     * @param null|string     $flags
     *
     * @return RegExp
     */
    public static function new($regex, string $delimiter = null, string $flags = null) : string
    {
        return static::getInstance()->new($regex, $delimiter, $flags);
    }


    /**
     * @return _Preg
     */
    public static function getInstance() : _Preg
    {
        return new _Preg(
            Str::getInstance()
        );
    }


    /**
     * @param mixed $regex
     *
     * @return bool
     */
    public static function isValid($regex) : bool
    {
        return static::getInstance()->isValid($regex);
    }

    /**
     * @param string|string[] $regex
     * @param string|string[] ...$regexes
     *
     * @return RegExp
     */
    public static function concat($regex, ...$regexes) : string
    {
        return static::getInstance()->concat($regex, ...$regexes);
    }
}