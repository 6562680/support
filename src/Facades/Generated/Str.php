<?php

/**
 * This file is auto-generated.
 *
 * * @noinspection PhpUnhandledExceptionInspection
 * * @noinspection PhpDocMissingThrowsInspection
 */

namespace Gzhegow\Support\Facades\Generated;

use Gzhegow\Support\Str as _Str;

abstract class Str
{
    /**
     * Determine if string starts with, returns string without needle or null if nothing found
     *
     * @param string      $str
     * @param string|null $needle
     * @param bool|null   $ignoreCase
     *
     * @return null|string
     */
    public static function starts(string $str, string $needle = null, bool $ignoreCase = true) : ?string
    {
        return static::getInstance()->starts($str, $needle, $ignoreCase);
    }

    /**
     * Determine if string ends with, returns string without needle or null if nothing found
     *
     * @param string      $str
     * @param string|null $needle
     * @param bool|null   $ignoreCase
     *
     * @return null|string
     */
    public static function ends(string $str, string $needle = null, bool $ignoreCase = true) : ?string
    {
        return static::getInstance()->ends($str, $needle, $ignoreCase);
    }

    /**
     * Determine if string contains needle, returns array of parts without needle or empty array if nothing found
     *
     * @param string      $str
     * @param string|null $needle
     * @param null|int    $limit
     * @param bool|null   $ignoreCase
     *
     * @return array
     */
    public static function contains(
        string $str,
        string $needle = null,
        int $limit = null,
        bool $ignoreCase = true
    ) : array
    {
        return static::getInstance()->contains($str, $needle, $limit, $ignoreCase);
    }

    /**
     * Search all sequences starts & ends from given substr
     * and return array that contains all of them without enclosures
     *
     * @param string   $start
     * @param string   $end
     * @param string   $haystack
     * @param null|int $offset
     * @param bool     $ignoreCase
     *
     * @return array
     */
    public static function match(
        string $start,
        string $end,
        string $haystack,
        int $offset = null,
        bool $ignoreCase = true
    ) : array
    {
        return static::getInstance()->match($start, $end, $haystack, $offset, $ignoreCase);
    }

    /**
     * Adds some string(-s) to start
     *
     * @param string      $str
     * @param string|null $sym
     * @param int         $len
     *
     * @return string
     */
    public static function lwrap(string $str, string $sym = null, $len = 1) : string
    {
        return static::getInstance()->lwrap($str, $sym, $len);
    }

    /**
     * Adds some strings(-s) to end
     *
     * @param string      $str
     * @param string|null $sym
     * @param int         $len
     *
     * @return string
     */
    public static function rwrap(string $str, string $sym = null, $len = 1) : string
    {
        return static::getInstance()->rwrap($str, $sym, $len);
    }

    /**
     * Wraps string into another(-s), for example - quotes
     *
     * @param string      $str
     * @param string|null $sym
     * @param int         $len
     *
     * @return string
     */
    public static function wrap(string $str, string $sym = null, $len = 1) : string
    {
        return static::getInstance()->wrap($str, $sym, $len);
    }

    /**
     * Prepend string if string don't starts with
     *
     * @param string      $str
     * @param string|null $needle
     * @param bool        $ignoreCase
     *
     * @return string
     */
    public static function prepend(string $str, string $needle = null, bool $ignoreCase = true) : string
    {
        return static::getInstance()->prepend($str, $needle, $ignoreCase);
    }

    /**
     * Append string if string don't ends with
     *
     * @param string      $str
     * @param string|null $needle
     * @param bool        $ignoreCase
     *
     * @return string
     */
    public static function append(string $str, string $needle = null, bool $ignoreCase = true) : string
    {
        return static::getInstance()->append($str, $needle, $ignoreCase);
    }

    /**
     * Wrap string if
     *
     * @param string      $str
     * @param null|string $needle
     * @param bool        $ignoreCase
     *
     * @return string
     */
    public static function uncrop(string $str, string $needle = null, bool $ignoreCase = true) : string
    {
        return static::getInstance()->uncrop($str, $needle, $ignoreCase);
    }

    /**
     * @param string      $str
     * @param string|null $needle
     * @param bool|null   $ignoreCase
     * @param int         $limit
     *
     * @return string
     */
    public static function lcrop(string $str, string $needle = null, bool $ignoreCase = null, int $limit = -1) : string
    {
        return static::getInstance()->lcrop($str, $needle, $ignoreCase, $limit);
    }

    /**
     * @param string      $str
     * @param string|null $needle
     * @param bool|null   $ignoreCase
     * @param int         $limit
     *
     * @return string
     */
    public static function rcrop(string $str, string $needle = null, bool $ignoreCase = null, int $limit = -1) : string
    {
        return static::getInstance()->rcrop($str, $needle, $ignoreCase, $limit);
    }

    /**
     * @param string      $str
     * @param string|null $needle
     * @param bool|null   $ignoreCase
     * @param int         $limit
     *
     * @return string
     */
    public static function crop(string $str, string $needle = null, bool $ignoreCase = null, int $limit = -1) : string
    {
        return static::getInstance()->crop($str, $needle, $ignoreCase, $limit);
    }

    /**
     * @param mixed         $separators
     * @param mixed|mixed[] ...$parts
     *
     * @return array
     */
    public static function split($separators, ...$parts) : array
    {
        return static::getInstance()->split($separators, ...$parts);
    }

    /**
     * Explodes string recursive by several delimiters, especially for parsing 'Accept' Header
     *
     * @param mixed    $separators
     * @param string   $string
     * @param int|null $limit
     *
     * @return array
     */
    public static function explode($separators, string $string, int $limit = null) : array
    {
        return static::getInstance()->explode($separators, $string, $limit);
    }

    /**
     * Creates string like '1, 2, 3', includes empty strings, throws error on non-stringables
     *
     * @param string        $delimiter
     * @param mixed|mixed[] ...$parts
     *
     * @return string
     */
    public static function implode(string $delimiter, ...$parts) : string
    {
        return static::getInstance()->implode($delimiter, ...$parts);
    }

    /**
     * Creates string like '1, 2, 3', includes empty strings, skips non-stringables
     *
     * @param string        $delimiter
     * @param mixed|mixed[] ...$parts
     *
     * @return string
     */
    public static function implodeForce(string $delimiter, ...$parts) : string
    {
        return static::getInstance()->implodeForce($delimiter, ...$parts);
    }

    /**
     * Creates string like '1, 2, 3', skips empty strings, throws error on non-stringables
     *
     * @param string        $delimiter
     * @param mixed|mixed[] ...$parts
     *
     * @return string
     */
    public static function join(string $delimiter, ...$parts) : string
    {
        return static::getInstance()->join($delimiter, ...$parts);
    }

    /**
     * Creates string like '1, 2, 3', skips empty strings, skips non-stringables
     *
     * @param string        $delimiter
     * @param mixed|mixed[] ...$parts
     *
     * @return string
     */
    public static function joinForce(string $delimiter, ...$parts) : string
    {
        return static::getInstance()->joinForce($delimiter, ...$parts);
    }

    /**
     * Creates string like "`1`, `2` or `3`", skips empty strings, throws error on non-stringables
     *
     * @param mixed|mixed[] $parts
     * @param null|string   $delimiter
     * @param null|string   $lastDelimiter
     * @param null|string   $wrapper
     *
     * @return string
     */
    public static function concat(
        $parts,
        string $delimiter = null,
        string $lastDelimiter = null,
        string $wrapper = null
    ) : string
    {
        return static::getInstance()->concat($parts, $delimiter, $lastDelimiter, $wrapper);
    }

    /**
     * Creates string like "`1`, `2` or `3`", skips empty strings, skips non-stringables
     *
     * @param mixed|mixed[] $items
     * @param null|string   $delimiter
     * @param null|string   $wrapper
     * @param null|string   $lastDelimiter
     *
     * @return string
     */
    public static function concatForce(
        array $items,
        string $delimiter = null,
        string $lastDelimiter = null,
        string $wrapper = null
    ) : string
    {
        return static::getInstance()->concatForce($items, $delimiter, $lastDelimiter, $wrapper);
    }

    /**
     * snake_case
     *
     * @param string $value
     * @param string $delimiter
     *
     * @return string
     */
    public static function snake(string $value, string $delimiter = '_') : string
    {
        return static::getInstance()->snake($value, $delimiter);
    }

    /**
     * Usnake_Case
     *
     * @param string $value
     *
     * @param string $delimiter
     *
     * @return string
     */
    public static function usnake(string $value, string $delimiter = '_') : string
    {
        return static::getInstance()->usnake($value, $delimiter);
    }

    /**
     * kebab-case
     *
     * @param string $value
     *
     * @return string
     */
    public static function kebab(string $value) : string
    {
        return static::getInstance()->kebab($value);
    }

    /**
     * Ukebab-Case
     *
     * @param string $value
     *
     * @return string
     */
    public static function ukebab(string $value) : string
    {
        return static::getInstance()->ukebab($value);
    }

    /**
     * camelCase
     *
     * @param string $value
     *
     * @return string
     */
    public static function camel(string $value) : string
    {
        return static::getInstance()->camel($value);
    }

    /**
     * PascalCase
     *
     * @param string $value
     *
     * @return string
     */
    public static function pascal(string $value) : string
    {
        return static::getInstance()->pascal($value);
    }


    /**
     * @return _Str
     */
    abstract public static function getInstance() : _Str;
}
