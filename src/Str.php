<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;

/**
 * Str
 */
class Str
{
    const REPLACER = "\0";

    const THE_MB_CASE_LIST = [
        MB_CASE_LOWER => true,
        MB_CASE_UPPER => true,
    ];


    /**
     * @param string      $str
     * @param string|null $needle
     * @param bool|null   $ignoreCase
     *
     * @return null|string
     */
    public function starts(string $str, string $needle = null, bool $ignoreCase = true) : ?string
    {
        $needle = $needle ?? '';

        if ('' === $str) return null;
        if ('' === $needle) return $str;

        $pos = $ignoreCase
            ? stripos($str, $needle)
            : strpos($str, $needle);

        return 0 === $pos
            ? substr($str, strlen($needle))
            : null;
    }

    /**
     * @param string      $str
     * @param string|null $needle
     * @param bool|null   $ignoreCase
     *
     * @return null|string
     */
    public function ends(string $str, string $needle = null, bool $ignoreCase = true) : ?string
    {
        $needle = $needle ?? '';

        if ('' === $str) return null;
        if ('' === $needle) return $str;

        $pos = $ignoreCase
            ? stripos($str, $needle)
            : strpos($str, $needle);

        return $pos === strlen($str) - strlen($needle)
            ? substr($str, 0, $pos)
            : null;
    }


    /**
     * @param string      $str
     * @param string|null $sym
     * @param int         $len
     *
     * @return string
     */
    public function lwrap(string $str, string $sym = null, $len = 1) : string
    {
        $sym = $sym ?? '';

        if ('' === $sym) return $str;

        $len = max(0, intval($len));

        return str_repeat($sym, $len) . $str;
    }

    /**
     * @param string      $str
     * @param string|null $sym
     * @param int         $len
     *
     * @return string
     */
    public function rwrap(string $str, string $sym = null, $len = 1) : string
    {
        $sym = $sym ?? '';

        if ('' === $sym) return $str;

        $len = max(0, intval($len));

        return $str . str_repeat($sym, $len);
    }

    /**
     * @param string      $str
     * @param string|null $sym
     * @param int         $len
     *
     * @return string
     */
    public function wrap(string $str, string $sym = null, $len = 1) : string
    {
        $sym = $sym ?? '';

        if ('' === $sym) return $str;

        $len = max(0, intval($len));

        return str_repeat($sym, $len) . $str . str_repeat($sym, $len);
    }


    /**
     * @param string      $str
     * @param string|null $needle
     * @param bool        $ignoreCase
     *
     * @return string
     */
    public function prepend(string $str, string $needle = null, bool $ignoreCase = true) : string
    {
        $needle = $needle ?? '';

        if ('' === $needle) return $str;

        $fn = $ignoreCase
            ? 'stripos'
            : 'strpos';

        return 0 === call_user_func($fn, $str, $needle)
            ? $str
            : $needle . $str;
    }

    /**
     * @param string      $str
     * @param string|null $needle
     * @param bool        $ignoreCase
     *
     * @return string
     */
    public function append(string $str, string $needle = null, bool $ignoreCase = true) : string
    {
        $needle = $needle ?? '';

        if ('' === $needle) return $str;

        $func = $ignoreCase
            ? 'strripos'
            : 'strrpos';

        return strlen($str) - strlen($needle) === call_user_func($func, $str, $needle)
            ? $str
            : $str . $needle;
    }

    /**
     * @param string      $str
     * @param null|string $needle
     * @param bool        $ignoreCase
     *
     * @return string
     */
    public function uncrop(string $str, string $needle = null, bool $ignoreCase = true) : string
    {
        return $this->append($this->prepend($str, $needle, $ignoreCase), $needle, $ignoreCase);
    }


    /**
     * @param string      $str
     * @param string|null $needle
     * @param bool|null   $ignoreCase
     * @param int         $limit
     *
     * @return string
     */
    public function lcrop(string $str, string $needle = null, bool $ignoreCase = null, int $limit = -1) : string
    {
        $needle = $needle ?? '';

        if ('' === $str) return $str;
        if ('' === $needle) return $str;

        $ignoreCase = $ignoreCase ?? true;

        while ( 1
            && $limit--
            && 0 === ( $ignoreCase
                ? stripos($str, $needle)
                : strpos($str, $needle)
            )
        ) {
            $str = substr($str, strlen($needle));
        }

        return $str;
    }

    /**
     * @param string      $str
     * @param string|null $needle
     * @param bool|null   $ignoreCase
     * @param int         $limit
     *
     * @return string
     */
    public function rcrop(string $str, string $needle = null, bool $ignoreCase = null, int $limit = -1) : string
    {
        $needle = $needle ?? '';

        if ('' === $str) return $str;
        if ('' === $needle) return $str;

        $ignoreCase = $ignoreCase ?? true;

        while ( 1
            && $limit--
            && ( $pos = $ignoreCase
                ? strripos($str, $needle)
                : strrpos($str, $needle) ) === strlen($str) - strlen($needle)
        ) {
            $str = substr($str, 0, $pos);
        }

        return $str;
    }

    /**
     * @param string      $str
     * @param string|null $needle
     * @param bool|null   $ignoreCase
     * @param int         $limit
     *
     * @return string
     */
    public function crop(string $str, string $needle = null, bool $ignoreCase = null, int $limit = -1) : string
    {
        return $this->rcrop($this->lcrop($str, $needle, $ignoreCase, $limit), $needle, $ignoreCase, $limit);
    }


    /**
     * Explodes string recursive by several delimiters, especially for parsing Accept Header
     *
     * @param mixed    $delimiters
     * @param string   $string
     * @param int|null $limit
     *
     * @return array
     */
    public function explode($delimiters, string $string, int $limit = null) : array
    {
        $results = [];
        $results[] = $string;

        $delimiters = is_array($delimiters)
            ? $delimiters
            : [ $delimiters ];

        foreach ( $delimiters as $delimiter ) {
            if (! is_string($delimiter)) {
                throw new InvalidArgumentException('Each delimiter should be string', [ func_get_args(), $delimiter ]);
            }

            array_walk_recursive($results, function (&$ref) use ($delimiter, $limit) {
                if (false !== mb_strpos($ref, $delimiter)) {
                    $ref = isset($limit)
                        ? explode($delimiter, $ref, $limit)
                        : explode($delimiter, $ref);
                }
            });
        }

        return null !== key($results)
            ? reset($results)
            : [];
    }


    /**
     * Creates string like '1, 2, 3'
     *
     * @param string $delimiter
     * @param mixed  ...$parts
     *
     * @return string
     */
    public function join(string $delimiter, ...$parts) : string
    {
        $array = array_reduce($parts, function ($carry, $part) use ($delimiter) {
            $part = is_array($part)
                ? $part
                : [ $part ];

            foreach ( $part as $p ) {
                if (null === $p) {
                    throw new InvalidArgumentException('Each Part should be not null');
                }

                if ($p != ( $str = strval($p) )) {
                    throw new InvalidArgumentException('Each Part should be stringable');
                }

                $carry[] = trim($str, $delimiter);
            }

            return $carry;
        }, []);

        $result = implode($delimiter, $array);

        return $result;
    }

    /**
     * Creates string like "1, 2 or 3"
     *
     * @param array       $parts
     * @param null|string $delimiter
     * @param null|string $lastDelimiter
     * @param string      $wrapper
     *
     * @return string
     */
    public function concat(array $parts, string $delimiter = null, string $lastDelimiter = null, string $wrapper = ''
    ) : string
    {
        $delimiter = $delimiter ?? '';

        $array = array_reduce($parts, function ($carry, $part) use ($delimiter, $wrapper) {
            $part = is_array($part)
                ? $part
                : [ $part ];

            foreach ( $part as $p ) {
                if ($p != ( $str = strval($p) )) {
                    throw new InvalidArgumentException('Each Part should be stringable');
                }

                $carry[] = $str;
            }

            return $carry;
        }, []);

        $last = null;
        if (isset($lastDelimiter)) {
            $last = $wrapper . array_pop($array) . $wrapper;
        }

        foreach ( $array as $idx => $str ) {
            $array[ $idx ] = $wrapper . trim($str, $delimiter) . $wrapper;
        }

        $result = implode($delimiter, $array);

        if (isset($last)) {
            $result = $result . $lastDelimiter . $last;
        }

        return $result;
    }


    /**
     * @param string $value
     * @param string $delimiter
     *
     * @return string
     */
    public function snake(string $value, string $delimiter = '_') : string
    {
        $result = $this->_snake($value, $delimiter);

        return $result;
    }

    /**
     * @param string $value
     *
     * @param string $delimiter
     *
     * @return string
     */
    public function usnake(string $value, string $delimiter = '_') : string
    {
        $result = $this->_snake($value, $delimiter, MB_CASE_UPPER);

        return $result;
    }


    /**
     * @param string $value
     *
     * @return string
     */
    public function kebab(string $value) : string
    {
        $result = $this->snake($value, '-');

        return $result;
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function ukebab(string $value) : string
    {
        $result = $this->usnake($value, '-');

        return $result;
    }


    /**
     * @param string $value
     *
     * @return string
     */
    public function pascal(string $value) : string
    {
        $result = $this->usnake($value, '');

        return $result;
    }


    /**
     * @param string $value
     *
     * @return string
     */
    public function camel(string $value) : string
    {
        $result = $this->pascal($value);

        $result = mb_convert_case($value[ 0 ], MB_CASE_LOWER, 'UTF-8') . mb_substr($result, 1);

        return $result;
    }


    /**
     * @param string     $value
     * @param string     $delimiter
     * @param string|int $case
     *
     * @return string
     */
    protected function _snake(string $value, string $delimiter = '_', string $case = MB_CASE_LOWER) : string
    {
        if ('' === $value) {
            return $value;
        }

        if (! isset(static::THE_MB_CASE_LIST[ $case ])) {
            throw new InvalidArgumentException('Unknown MB_CASE_ passed', $case);
        }

        $result = $value;

        $replacements = [];
        foreach ( array_merge([ $delimiter ], [ '_', '-' ]) as $str ) {
            $replacements[ $str ] = true;
        }

        $left = mb_substr($result, 0, 1);
        $right = mb_substr($result, 1);

        $regexDelimiters = preg_quote(implode('', array_keys($replacements)), '/');

        $right = preg_replace('/[\s' . $regexDelimiters . ']*(\p{Lu})/', $delimiter . '$1', $right);
        $right = preg_replace_callback('/[\s' . $regexDelimiters . ']+(\p{L})/', function ($m) use ($case) {
            return static::REPLACER . mb_convert_case($m[ 1 ], $case, 'UTF-8');
        }, $right);

        $result = mb_convert_case($left, $case, 'UTF-8') . $right;

        $result = str_replace(array_keys($replacements), '', $result);
        $result = str_replace(static::REPLACER, $delimiter, $result);

        return $result;
    }
}
