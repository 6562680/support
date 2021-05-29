<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support\Facades\Generated;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Str;

abstract class GeneratedStrFacade
{
    /**
     * стандартная функция возвращает false, если не найдено
     * возврат -1 позволяет использовать вычитание в коротком синтаксисе сортировок и тильду для сдвига
     * usort($array, function ($a, $b) { return $str->strpos($hs, $a) - $str->strpos($hs, $b); }}
     *
     * @param string $haystack
     * @param string $needle
     * @param int    $offset
     *
     * @return int
     */
    public static function strpos($haystack, $needle, $offset): int
    {
        return static::getInstance()->strpos($haystack, $needle, $offset);
    }

    /**
     * стандартная функция возвращает false, если не найдено
     * возврат -1 позволяет использовать вычитание в коротком синтаксисе сортировок и тильду для сдвига
     * usort($array, function ($a, $b) { return $str->strpos($hs, $a) - $str->strpos($hs, $b); }}
     *
     * @param string $haystack
     * @param string $needle
     * @param int    $offset
     *
     * @return int
     */
    public static function strrpos($haystack, $needle, $offset): int
    {
        return static::getInstance()->strrpos($haystack, $needle, $offset);
    }

    /**
     * стандартная функция возвращает false, если не найдено
     * возврат -1 позволяет использовать вычитание в коротком синтаксисе сортировок и тильду для сдвига
     * usort($array, function ($a, $b) { return $str->strpos($hs, $a) - $str->strpos($hs, $b); }}
     *
     * @param string $haystack
     * @param string $needle
     * @param int    $offset
     *
     * @return int
     */
    public static function stripos($haystack, $needle, $offset): int
    {
        return static::getInstance()->stripos($haystack, $needle, $offset);
    }

    /**
     * стандартная функция возвращает false, если не найдено
     * возврат -1 позволяет использовать вычитание в коротком синтаксисе сортировок и тильду для сдвига
     * usort($array, function ($a, $b) { return $str->strpos($hs, $a) - $str->strpos($hs, $b); }}
     *
     * @param string $haystack
     * @param string $needle
     * @param int    $offset
     *
     * @return int
     */
    public static function strripos($haystack, $needle, $offset): int
    {
        return static::getInstance()->strripos($haystack, $needle, $offset);
    }

    /**
     * фикс. стандартная функция при попытке разбить пустую строку возвращает массив из пустой строки
     *
     * @param string   $string
     * @param null|int $len
     *
     * @return array
     */
    public static function split(string $string, int $len = null): array
    {
        return static::getInstance()->split($string, $len);
    }

    /**
     * фикс. стандартная функция не поддерживает лимит замен
     *
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
     * фикс. стандартная функция не поддерживает лимит замен
     *
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
     * если строка начинается на искомую, отрезает ее и возвращает укороченную
     * if (null !== ($substr = $str->ends('hello', 'h'))) {} // 'ello'
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
     * если строка заканчивается на искомую, отрезает ее и возвращает укороченную
     * if (null !== ($substr = $str->ends('hello', 'o'))) {} // 'hell'
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
     * ищет подстроку в строке и разбивает по ней результат
     * if ($explode = $str->contains('hello', 'h')) {} // ['', 'ello']
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
     * ищет все совпадения начинающиеся "с" и заканчивающиеся "на"
     * используется при замене подстановок в тексте
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
     * @param string   $needle
     * @param null|int $maxlen
     *
     * @return string
     */
    public static function prefix($needle, int $maxlen = null): string
    {
        return static::getInstance()->prefix($needle, $maxlen);
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
     * рекурсивно разрывает строку в многоуровневый массив
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
     * '1, 2, 3', включая пустые строки, исключение если нельзя привести к строке
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
     * '1, 2, 3', включая пустые строки, пропускает если нельзя привести к строке
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
     * '1, 2, 3', пропускает пустые строки, исключение если нельзя привести к строке
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
     * '1, 2, 3', пропускает пустые строки, пропускает если нельзя привести к строке
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
     * "`1`, `2` or `3`", всегда пропускает пустые строки, исключение если нельзя привести к строке
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
     * "`1`, `2` or `3`", всегда пропускает пустые строки, пропускает если нельзя привести к строке
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
     * @param mixed $value
     *
     * @return null|string
     */
    public static function strval($value): ?string
    {
        return static::getInstance()->strval($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|string
     */
    public static function wordval($value): ?string
    {
        return static::getInstance()->wordval($value);
    }

    /**
     * @param string|string[]|array $strings
     * @param null|bool             $uniq
     * @param null|string|array     $message
     * @param mixed                 ...$arguments
     *
     * @return string[]
     */
    public static function strvals($strings, $uniq = null, $message = null, ...$arguments): array
    {
        return static::getInstance()->strvals($strings, $uniq, $message, ...$arguments);
    }

    /**
     * @param string|string[]|array $strings
     * @param null|bool             $uniq
     * @param null|string|array     $message
     * @param mixed                 ...$arguments
     *
     * @return string[]
     */
    public static function theStrvals($strings, $uniq = null, $message = null, ...$arguments): array
    {
        return static::getInstance()->theStrvals($strings, $uniq, $message, ...$arguments);
    }

    /**
     * @param string|string[]|array $strings
     * @param null|bool             $uniq
     *
     * @return string[]
     */
    public static function strvalsSkip($strings, $uniq = null): array
    {
        return static::getInstance()->strvalsSkip($strings, $uniq);
    }

    /**
     * @param string|string[]|array $strings
     * @param null|bool             $uniq
     *
     * @return string[]
     */
    public static function theStrvalsSkip($strings, $uniq = null): array
    {
        return static::getInstance()->theStrvalsSkip($strings, $uniq);
    }

    /**
     * @param string|string[]|array $words
     * @param null|bool             $uniq
     * @param null|string|array     $message
     * @param mixed                 ...$arguments
     *
     * @return string[]
     */
    public static function wordvals($words, $uniq = null, $message = null, ...$arguments): array
    {
        return static::getInstance()->wordvals($words, $uniq, $message, ...$arguments);
    }

    /**
     * @param string|string[]|array $words
     * @param null|bool             $uniq
     * @param null|string|array     $message
     * @param mixed                 ...$arguments
     *
     * @return string[]
     */
    public static function theWordvals($words, $uniq = null, $message = null, ...$arguments): array
    {
        return static::getInstance()->theWordvals($words, $uniq, $message, ...$arguments);
    }

    /**
     * @param string|string[]|array $words
     * @param null|bool             $uniq
     *
     * @return string[]
     */
    public static function wordvalsSkip($words, $uniq = null): array
    {
        return static::getInstance()->wordvalsSkip($words, $uniq);
    }

    /**
     * @param string|string[]|array $words
     * @param null|bool             $uniq
     *
     * @return array
     */
    public static function theWordvalsSkip($words, $uniq = null): array
    {
        return static::getInstance()->theWordvalsSkip($words, $uniq);
    }

    /**
     * @return Str
     */
    abstract public static function getInstance(): Str;
}
