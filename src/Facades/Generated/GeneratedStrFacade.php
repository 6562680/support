<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpDocMissingThrowsInspection
 */

namespace Gzhegow\Support\Facades\Generated;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Str;

abstract class GeneratedStrFacade
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
    public static function starts(string $str, string $needle = null, bool $ignoreCase = true): ?string
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
    public static function ends(string $str, string $needle = null, bool $ignoreCase = true): ?string
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
    ): array {
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
    ): array {
        return static::getInstance()->match($start, $end, $haystack, $offset, $ignoreCase);
    }

    /**
     * @param string|string[] $search
     * @param string|string[] $replace
     * @param string|string[] $subject
     * @param null|int        $limit
     * @param null|int        $count
     *
     * @return string|string[]
     */
    public static function replace($search, $replace, $subject, int $limit = null, int &$count = null)
    {
        return static::getInstance()->replace($search, $replace, $subject, $limit, $count);
    }

    /**
     * @param string|string[] $search
     * @param string|string[] $replace
     * @param string|string[] $subject
     * @param null|int        $limit
     * @param null|int        $count
     *
     * @return string|string[]
     */
    public static function ireplace($search, $replace, $subject, int $limit = null, int &$count = null)
    {
        return static::getInstance()->ireplace($search, $replace, $subject, $limit, $count);
    }

    /**
     * @param string $haystack
     * @param mixed  $needle
     * @param int    $offset
     *
     * @return int
     */
    public static function strpos($haystack, $needle, $offset): int
    {
        return static::getInstance()->strpos($haystack, $needle, $offset);
    }

    /**
     * @param string $haystack
     * @param mixed  $needle
     * @param int    $offset
     *
     * @return int
     */
    public static function strrpos($haystack, $needle, $offset): int
    {
        return static::getInstance()->strrpos($haystack, $needle, $offset);
    }

    /**
     * @param string $haystack
     * @param mixed  $needle
     * @param int    $offset
     *
     * @return int
     */
    public static function stripos($haystack, $needle, $offset): int
    {
        return static::getInstance()->stripos($haystack, $needle, $offset);
    }

    /**
     * @param string $haystack
     * @param mixed  $needle
     * @param int    $offset
     *
     * @return int
     */
    public static function strripos($haystack, $needle, $offset): int
    {
        return static::getInstance()->strripos($haystack, $needle, $offset);
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
    public static function lwrap(string $str, string $sym = null, $len = 1): string
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
    public static function rwrap(string $str, string $sym = null, $len = 1): string
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
    public static function wrap(string $str, string $sym = null, $len = 1): string
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
    public static function prepend(string $str, string $needle = null, bool $ignoreCase = true): string
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
    public static function append(string $str, string $needle = null, bool $ignoreCase = true): string
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
    public static function uncrop(string $str, string $needle = null, bool $ignoreCase = true): string
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
    public static function lcrop(string $str, string $needle = null, bool $ignoreCase = null, int $limit = -1): string
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
    public static function rcrop(string $str, string $needle = null, bool $ignoreCase = null, int $limit = -1): string
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
    public static function crop(string $str, string $needle = null, bool $ignoreCase = null, int $limit = -1): string
    {
        return static::getInstance()->crop($str, $needle, $ignoreCase, $limit);
    }

    /**
     * @param string|string[]|array $delimiters
     * @param string|string[]|array ...$strvals
     *
     * @return array
     */
    public static function split($delimiters, ...$strvals): array
    {
        return static::getInstance()->split($delimiters, ...$strvals);
    }

    /**
     * @param string|string[]|array $delimiters
     * @param string|string[]|array ...$strvals
     *
     * @return array
     */
    public static function explode($delimiters, ...$strvals): array
    {
        return static::getInstance()->explode($delimiters, ...$strvals);
    }

    /**
     * Explodes string recursive by several delimiters, especially for parsing 'Accept' Header
     *
     * @param string|string[]|array $delimiters
     * @param string                $string
     * @param int|null              $limit
     *
     * @return array
     */
    public static function separate($delimiters, string $string, int $limit = null): array
    {
        return static::getInstance()->separate($delimiters, $string, $limit);
    }

    /**
     * Creates string like '1, 2, 3', includes empty strings, throws error on non-stringables
     *
     * @param string                $delimiter
     * @param string|string[]|array ...$strvals
     *
     * @return string
     */
    public static function implode(string $delimiter, ...$strvals): string
    {
        return static::getInstance()->implode($delimiter, ...$strvals);
    }

    /**
     * Creates string like '1, 2, 3', includes empty strings, skips non-stringables
     *
     * @param string                $delimiter
     * @param string|string[]|array ...$strvals
     *
     * @return string
     */
    public static function implodeskip(string $delimiter, ...$strvals): string
    {
        return static::getInstance()->implodeskip($delimiter, ...$strvals);
    }

    /**
     * Creates string like '1, 2, 3', skips empty strings, throws error on non-stringables
     *
     * @param string                $delimiter
     * @param string|string[]|array ...$strvals
     *
     * @return string
     */
    public static function join(string $delimiter, ...$strvals): string
    {
        return static::getInstance()->join($delimiter, ...$strvals);
    }

    /**
     * Creates string like '1, 2, 3', skips empty strings, skips non-stringables
     *
     * @param string                $delimiter
     * @param string|string[]|array ...$strvals
     *
     * @return string
     */
    public static function joinskip(string $delimiter, ...$strvals): string
    {
        return static::getInstance()->joinskip($delimiter, ...$strvals);
    }

    /**
     * Creates string like "`1`, `2` or `3`", skips empty strings, throws error on non-stringables
     *
     * @param string|string[]|array $strings
     * @param null|string           $delimiter
     * @param null|string           $lastDelimiter
     * @param null|string           $wrapper
     *
     * @return string
     */
    public static function concat(
        $strings,
        string $delimiter = null,
        string $lastDelimiter = null,
        string $wrapper = null
    ): string {
        return static::getInstance()->concat($strings, $delimiter, $lastDelimiter, $wrapper);
    }

    /**
     * Creates string like "`1`, `2` or `3`", skips empty strings, skips non-stringables
     *
     * @param string|string[]|array $strings
     * @param null|string           $delimiter
     * @param null|string           $wrapper
     * @param null|string           $lastDelimiter
     *
     * @return string
     */
    public static function concatskip(
        array $strings,
        string $delimiter = null,
        string $lastDelimiter = null,
        string $wrapper = null
    ): string {
        return static::getInstance()->concatskip($strings, $delimiter, $lastDelimiter, $wrapper);
    }

    /**
     * snake_case
     *
     * @param string $value
     * @param string $delimiter
     *
     * @return string
     */
    public static function snake(string $value, string $delimiter = '_'): string
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
    public static function usnake(string $value, string $delimiter = '_'): string
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
    public static function kebab(string $value): string
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
    public static function ukebab(string $value): string
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
    public static function camel(string $value): string
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
    public static function pascal(string $value): string
    {
        return static::getInstance()->pascal($value);
    }

    /**
     * @param string|string[]|array ...$numbers
     *
     * @return string[]
     */
    public static function numbers(...$numbers): array
    {
        return static::getInstance()->numbers(...$numbers);
    }

    /**
     * @param string|string[]|array ...$numbers
     *
     * @return string[]
     */
    public static function theNumbers(...$numbers): array
    {
        return static::getInstance()->theNumbers(...$numbers);
    }

    /**
     * @param string|string[]|array ...$numbers
     *
     * @return string[]
     */
    public static function numbersskip(...$numbers): array
    {
        return static::getInstance()->numbersskip(...$numbers);
    }

    /**
     * @param string|string[]|array ...$numbers
     *
     * @return string[]
     */
    public static function theNumbersskip(...$numbers): array
    {
        return static::getInstance()->theNumbersskip(...$numbers);
    }

    /**
     * @param string|string[]|array ...$strings
     *
     * @return string[]
     */
    public static function strings(...$strings): array
    {
        return static::getInstance()->strings(...$strings);
    }

    /**
     * @param string|string[]|array ...$strings
     *
     * @return string[]
     */
    public static function theStrings(...$strings): array
    {
        return static::getInstance()->theStrings(...$strings);
    }

    /**
     * @param string|string[]|array ...$strings
     *
     * @return string[]
     */
    public static function stringsskip(...$strings): array
    {
        return static::getInstance()->stringsskip(...$strings);
    }

    /**
     * @param string|string[]|array ...$strings
     *
     * @return string[]
     */
    public static function theStringsskip(...$strings): array
    {
        return static::getInstance()->theStringsskip(...$strings);
    }

    /**
     * @param string|string[]|array ...$words
     *
     * @return string[]
     */
    public static function words(...$words): array
    {
        return static::getInstance()->words(...$words);
    }

    /**
     * @param string|string[]|array ...$words
     *
     * @return string[]
     */
    public static function theWords(...$words): array
    {
        return static::getInstance()->theWords(...$words);
    }

    /**
     * @param string|string[]|array ...$words
     *
     * @return string[]
     */
    public static function wordsskip(...$words): array
    {
        return static::getInstance()->wordsskip(...$words);
    }

    /**
     * @param string|string[]|array ...$words
     *
     * @return array
     */
    public static function theWordsskip(...$words): array
    {
        return static::getInstance()->theWordsskip(...$words);
    }

    /**
     * @return Str
     */
    abstract public static function getInstance(): Str;
}
