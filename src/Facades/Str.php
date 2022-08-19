<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 * @noinspection RedundantSuppression
 */

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\IStr;
use Gzhegow\Support\SupportFactory;
use Gzhegow\Support\Traits\Load\ArrLoadTrait;
use Gzhegow\Support\Traits\Load\CacheLoadTrait;
use Gzhegow\Support\Traits\Load\NumLoadTrait;
use Gzhegow\Support\Traits\Load\Str\InflectorLoadTrait;
use Gzhegow\Support\Traits\Load\Str\SluggerLoadTrait;
use Gzhegow\Support\XStr;

class Str
{
    /**
     * @return ICache
     */
    public static function loadCache(): \Gzhegow\Support\ICache
    {
        return static::getInstance()->loadCache();
    }

    /**
     * @return string
     */
    public static function loadTrims(): string
    {
        return static::getInstance()->loadTrims();
    }

    /**
     * @return string
     */
    public static function loadSeparators(): string
    {
        return static::getInstance()->loadSeparators();
    }

    /**
     * @return array
     */
    public static function loadAccents(): array
    {
        return static::getInstance()->loadAccents();
    }

    /**
     * @return array
     */
    public static function loadVowels(): array
    {
        return static::getInstance()->loadVowels();
    }

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public static function filterStringUtf8($value): ?string
    {
        return static::getInstance()->filterStringUtf8($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public static function filterString($value): ?string
    {
        return static::getInstance()->filterString($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public static function filterLetter($value): ?string
    {
        return static::getInstance()->filterLetter($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public static function filterWord($value): ?string
    {
        return static::getInstance()->filterWord($value);
    }

    /**
     * @param int|string|mixed $value
     *
     * @return null|int|float|string
     */
    public static function filterStringOrInt($value)
    {
        return static::getInstance()->filterStringOrInt($value);
    }

    /**
     * @param int|string|mixed $value
     *
     * @return null|int|float|string
     */
    public static function filterLetterOrInt($value)
    {
        return static::getInstance()->filterLetterOrInt($value);
    }

    /**
     * @param int|string|mixed $value
     *
     * @return null|int|float|string
     */
    public static function filterWordOrInt($value)
    {
        return static::getInstance()->filterWordOrInt($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public static function filterStringOrNum($value)
    {
        return static::getInstance()->filterStringOrNum($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public static function filterLetterOrNum($value)
    {
        return static::getInstance()->filterLetterOrNum($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public static function filterWordOrNum($value)
    {
        return static::getInstance()->filterWordOrNum($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return null|int|float|string|object
     */
    public static function filterStrval($value)
    {
        return static::getInstance()->filterStrval($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return null|int|float|string|object
     */
    public static function filterLetterval($value)
    {
        return static::getInstance()->filterLetterval($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return null|int|float|string|object
     */
    public static function filterWordval($value)
    {
        return static::getInstance()->filterWordval($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return null|int|float|string|object
     */
    public static function filterTrimval($value)
    {
        return static::getInstance()->filterTrimval($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public static function strval($value): ?string
    {
        return static::getInstance()->strval($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public static function letterval($value): ?string
    {
        return static::getInstance()->letterval($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public static function wordval($value): ?string
    {
        return static::getInstance()->wordval($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public static function trimval($value): ?string
    {
        return static::getInstance()->trimval($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return string
     */
    public static function theStrval($value): string
    {
        return static::getInstance()->theStrval($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return string
     */
    public static function theLetterval($value): string
    {
        return static::getInstance()->theLetterval($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return string
     */
    public static function theWordval($value): string
    {
        return static::getInstance()->theWordval($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return string
     */
    public static function theTrimval($value): string
    {
        return static::getInstance()->theTrimval($value);
    }

    /**
     * @param string|array $strings
     * @param null|bool    $uniq
     * @param null|bool    $recursive
     *
     * @return string[]
     */
    public static function strvals($strings, bool $uniq = null, bool $recursive = null): array
    {
        return static::getInstance()->strvals($strings, $uniq, $recursive);
    }

    /**
     * @param string|array $letters
     * @param null|bool    $uniq
     * @param null|bool    $recursive
     *
     * @return string[]
     */
    public static function lettervals($letters, bool $uniq = null, bool $recursive = null): array
    {
        return static::getInstance()->lettervals($letters, $uniq, $recursive);
    }

    /**
     * @param string|array $words
     * @param null|bool    $uniq
     * @param null|bool    $recursive
     *
     * @return string[]
     */
    public static function wordvals($words, bool $uniq = null, bool $recursive = null): array
    {
        return static::getInstance()->wordvals($words, $uniq, $recursive);
    }

    /**
     * @param string|array $trims
     * @param null|bool    $uniq
     * @param null|bool    $recursive
     *
     * @return string[]
     */
    public static function trimvals($trims, bool $uniq = null, bool $recursive = null): array
    {
        return static::getInstance()->trimvals($trims, $uniq, $recursive);
    }

    /**
     * @param string|array $strings
     * @param null|bool    $uniq
     * @param null|bool    $recursive
     *
     * @return string[]
     */
    public static function theStrvals($strings, bool $uniq = null, bool $recursive = null): array
    {
        return static::getInstance()->theStrvals($strings, $uniq, $recursive);
    }

    /**
     * @param string|array $letters
     * @param null|bool    $uniq
     * @param null|bool    $recursive
     *
     * @return string[]
     */
    public static function theLettervals($letters, bool $uniq = null, bool $recursive = null): array
    {
        return static::getInstance()->theLettervals($letters, $uniq, $recursive);
    }

    /**
     * @param string|array $words
     * @param null|bool    $uniq
     * @param null|bool    $recursive
     *
     * @return string[]
     */
    public static function theWordvals($words, bool $uniq = null, bool $recursive = null): array
    {
        return static::getInstance()->theWordvals($words, $uniq, $recursive);
    }

    /**
     * @param string|array $trims
     * @param null|bool    $uniq
     * @param null|bool    $recursive
     *
     * @return string[]
     */
    public static function theTrimvals($trims, bool $uniq = null, bool $recursive = null): array
    {
        return static::getInstance()->theTrimvals($trims, $uniq, $recursive);
    }

    /**
     * пишет слово с большой буквы
     *
     * @param string      $string
     * @param null|string $encoding
     *
     * @return string
     */
    public static function lcfirst(string $string, string $encoding = null)
    {
        return static::getInstance()->lcfirst($string, $encoding);
    }

    /**
     * пишет слово с большой буквы
     *
     * @param string      $string
     * @param null|string $encoding
     *
     * @return string
     */
    public static function ucfirst(string $string, string $encoding = null)
    {
        return static::getInstance()->ucfirst($string, $encoding);
    }

    /**
     * пишет каждое слово в предложении с малой буквы
     *
     * @param string      $string
     * @param string      $separators
     * @param null|string $encoding
     *
     * @return string
     */
    public static function lcwords(string $string, string $separators = " \t\r\n\x0C\x0B", string $encoding = null)
    {
        return static::getInstance()->lcwords($string, $separators, $encoding);
    }

    /**
     * пишет каждое слово в предложении с большой буквы
     *
     * @param string      $string
     * @param string      $separators
     * @param null|string $encoding
     *
     * @return string
     */
    public static function ucwords(string $string, string $separators = " \t\r\n\x0C\x0B", string $encoding = null)
    {
        return static::getInstance()->ucwords($string, $separators, $encoding);
    }

    /**
     * стандартная функция возвращает false, если не найдено, false при вычитании приравнивается к 0
     * возврат -1 позволяет использовать вычитание в коротком синтаксисе сортировок и тильду для битового сдвига
     * usort($array, function ($a, $b) { return $str->strpos($haystack, $a) - $str->strpos($haystack, $b); }}
     *
     * @param string   $string
     * @param string   $needle
     * @param null|int $offset
     *
     * @return int
     */
    public static function strpos(string $string, string $needle, int $offset = null): int
    {
        return static::getInstance()->strpos($string, $needle, $offset);
    }

    /**
     * стандартная функция возвращает false, если не найдено, false при вычитании приравнивается к 0
     * возврат -1 позволяет использовать вычитание в коротком синтаксисе сортировок и тильду для битового сдвига
     * usort($array, function ($a, $b) { return $str->strrpos($haystack, $a) - $str->strrpos($haystack, $b); }}
     *
     * @param string   $string
     * @param string   $needle
     * @param null|int $offset
     *
     * @return int
     */
    public static function strrpos(string $string, string $needle, int $offset = null): int
    {
        return static::getInstance()->strrpos($string, $needle, $offset);
    }

    /**
     * стандартная функция возвращает false, если не найдено, false при вычитании приравнивается к 0
     * возврат -1 позволяет использовать вычитание в коротком синтаксисе сортировок и тильду для битового сдвига
     * usort($array, function ($a, $b) { return $str->stripos($haystack, $a) - $str->stripos($haystack, $b); }}
     *
     * @param string   $string
     * @param string   $needle
     * @param null|int $offset
     *
     * @return int
     */
    public static function stripos(string $string, string $needle, int $offset = null): int
    {
        return static::getInstance()->stripos($string, $needle, $offset);
    }

    /**
     * стандартная функция возвращает false, если не найдено, false при вычитании приравнивается к 0
     * возврат -1 позволяет использовать вычитание в коротком синтаксисе сортировок и тильду для битового сдвига
     * usort($array, function ($a, $b) { return $str->strripos($haystack, $a) - $str->strripos($haystack, $b); }}
     *
     * @param string   $string
     * @param string   $needle
     * @param null|int $offset
     *
     * @return int
     */
    public static function strripos(string $string, string $needle, int $offset = null): int
    {
        return static::getInstance()->strripos($string, $needle, $offset);
    }

    /**
     * фикс. стандартная функция не поддерживает лимит замен
     *
     * @param string|string[] $strings
     * @param string|string[] $replacements
     * @param string|string[] $subjects
     * @param null|int        $limit
     * @param null|int        $count
     *
     * @return string|string[]
     */
    public static function replace($strings, $replacements, $subjects, int $limit = null, int &$count = null)
    {
        return static::getInstance()->replace($strings, $replacements, $subjects, $limit, $count);
    }

    /**
     * фикс. стандартная функция не поддерживает лимит замен
     *
     * @param string|string[] $strings
     * @param string|string[] $replacements
     * @param string|string[] $subjects
     * @param null|int        $limit
     * @param null|int        $count
     *
     * @return string|string[]
     */
    public static function ireplace($strings, $replacements, $subjects, int $limit = null, int &$count = null)
    {
        return static::getInstance()->ireplace($strings, $replacements, $subjects, $limit, $count);
    }

    /**
     * Обрезает у строки подстроку с начала (ltrim, только для строк а не букв)
     *
     * @param string      $string
     * @param string|null $needle
     * @param bool|null   $ignoreCase
     * @param int         $limit
     *
     * @return string
     */
    public static function lcrop(string $string, string $needle, bool $ignoreCase = null, int $limit = -1): string
    {
        return static::getInstance()->lcrop($string, $needle, $ignoreCase, $limit);
    }

    /**
     * Обрезает у строки подстроку с конца (rtrim, только для строк а не букв)
     *
     * @param string      $string
     * @param string|null $needle
     * @param bool|null   $ignoreCase
     * @param int         $limit
     *
     * @return string
     */
    public static function rcrop(string $string, string $needle, bool $ignoreCase = null, int $limit = -1): string
    {
        return static::getInstance()->rcrop($string, $needle, $ignoreCase, $limit);
    }

    /**
     * Обрезает у строки подстроки с обеих сторон (trim, только для строк а не букв)
     *
     * @param string          $string
     * @param string|string[] $needles
     * @param bool|null       $ignoreCase
     * @param int             $limit
     *
     * @return string
     */
    public static function crop(string $string, $needles, bool $ignoreCase = null, int $limit = -1): string
    {
        return static::getInstance()->crop($string, $needles, $ignoreCase, $limit);
    }

    /**
     * если строка начинается на искомую, отрезает ее и возвращает укороченную
     * if (null !== ($substr = $str->ends('hello', 'h'))) {} // 'ello'
     *
     * @param string      $string
     * @param string|null $needle
     * @param bool|null   $ignoreCase
     *
     * @return null|string
     */
    public static function starts(string $string, string $needle, bool $ignoreCase = null): ?string
    {
        return static::getInstance()->starts($string, $needle, $ignoreCase);
    }

    /**
     * если строка заканчивается на искомую, отрезает ее и возвращает укороченную
     * if (null !== ($substr = $str->ends('hello', 'o'))) {} // 'hell'
     *
     * @param string      $string
     * @param string|null $needle
     * @param bool|null   $ignoreCase
     *
     * @return null|string
     */
    public static function ends(string $string, string $needle, bool $ignoreCase = null): ?string
    {
        return static::getInstance()->ends($string, $needle, $ignoreCase);
    }

    /**
     * ищет подстроку в строке и разбивает по ней результат
     *
     * @param string      $string
     * @param string|null $needle
     * @param null|int    $limit
     * @param bool|null   $ignoreCase
     *
     * @return array
     */
    public static function contains(string $string, string $needle, bool $ignoreCase = null, int $limit = null): array
    {
        return static::getInstance()->contains($string, $needle, $ignoreCase, $limit);
    }

    /**
     * Добавляет подстроку в начале строки
     *
     * @param string      $string
     * @param string|null $repeat
     * @param null|int    $times
     *
     * @return string
     */
    public static function unltrim(string $string, string $repeat = null, int $times = null): string
    {
        return static::getInstance()->unltrim($string, $repeat, $times);
    }

    /**
     * Добавляет подстроку в конце строки
     *
     * @param string      $string
     * @param string|null $repeat
     * @param null|int    $times
     *
     * @return string
     */
    public static function unrtrim(string $string, string $repeat = null, int $times = null): string
    {
        return static::getInstance()->unrtrim($string, $repeat, $times);
    }

    /**
     * Оборачивает строку в другие, например в кавычки
     *
     * @param string          $string
     * @param string|string[] $repeats
     * @param null|int        $times
     *
     * @return string
     */
    public static function untrim(string $string, $repeats, int $times = null): string
    {
        return static::getInstance()->untrim($string, $repeats, $times);
    }

    /**
     * Добавляет подстроку в начало строки, если её уже там нет
     *
     * @param string      $string
     * @param string|null $prepend
     * @param bool        $ignoreCase
     *
     * @return string
     */
    public static function prepend(string $string, string $prepend, bool $ignoreCase = null): string
    {
        return static::getInstance()->prepend($string, $prepend, $ignoreCase);
    }

    /**
     * Добавляет подстроку в конец строки, если её уже там нет
     *
     * @param string      $string
     * @param string|null $append
     * @param bool        $ignoreCase
     *
     * @return string
     */
    public static function append(string $string, string $append, bool $ignoreCase = null): string
    {
        return static::getInstance()->append($string, $append, $ignoreCase);
    }

    /**
     * Оборачивает строку в подстроки, если их уже там нет
     *
     * @param string          $string
     * @param string|string[] $wraps
     * @param bool            $ignoreCase
     *
     * @return string
     */
    public static function wrap(string $string, $wraps, bool $ignoreCase = null): string
    {
        return static::getInstance()->wrap($string, $wraps, $ignoreCase);
    }

    /**
     * разбивает строку/строки в один массив по разделителю/разделителям
     *
     * @param string|array $delimiters
     * @param string|array $strings
     * @param null|bool    $ignoreCase
     * @param null|int     $limit
     *
     * @return array
     */
    public static function explode($delimiters, $strings, bool $ignoreCase = null, int $limit = null): array
    {
        return static::getInstance()->explode($delimiters, $strings, $ignoreCase, $limit);
    }

    /**
     * разбивает строку/строки в массив по разделителю/разделителям рекурсивно
     *
     * @param string|array $delimiters
     * @param string|array $strings
     * @param null|bool    $ignoreCase
     * @param int|null     $limit
     *
     * @return array
     */
    public static function explodeRecursive($delimiters, $strings, bool $ignoreCase = null, int $limit = null): array
    {
        return static::getInstance()->explodeRecursive($delimiters, $strings, $ignoreCase, $limit);
    }

    /**
     * '1, 2, 3', включая пустые строки, исключение если нельзя привести к строке, антоним explode
     *
     * @param string       $delimiter
     * @param string|array ...$strings
     *
     * @return string
     */
    public static function implode(string $delimiter, ...$strings): string
    {
        return static::getInstance()->implode($delimiter, ...$strings);
    }

    /**
     * '1, 2, 3', включая пустые строки, пропускает если нельзя привести к строке, антоним explodeSkip
     *
     * @param string       $delimiter
     * @param string|array ...$strings
     *
     * @return string
     */
    public static function implodeSkip(string $delimiter, ...$strings): string
    {
        return static::getInstance()->implodeSkip($delimiter, ...$strings);
    }

    /**
     * '1:2,3', включая пустые строки, исключение если нельзя привести к строке, антоним explodeRecursive
     *
     * @param string|array $delimiters
     * @param array        $strings
     *
     * @return void
     */
    public static function implodeRecursive($delimiters, array $strings)
    {
        return static::getInstance()->implodeRecursive($delimiters, $strings);
    }

    /**
     * '1:2,3', включая пустые строки, пропускает если нельзя привести к строке, антоним explodeRecursive
     *
     * @param string|array $delimiters
     * @param array        $strings
     *
     * @return void
     */
    public static function implodeRecursiveSkip($delimiters, array $strings)
    {
        return static::getInstance()->implodeRecursiveSkip($delimiters, $strings);
    }

    /**
     * '1, 2, 3', пропускает пустые строки, исключение если нельзя привести к строке
     *
     * @param string       $delimiter
     * @param string|array ...$strings
     *
     * @return string
     */
    public static function join(string $delimiter, ...$strings): string
    {
        return static::getInstance()->join($delimiter, ...$strings);
    }

    /**
     * '1, 2, 3', пропускает пустые строки, пропускает если нельзя привести к строке
     *
     * @param string       $delimiter
     * @param string|array ...$strings
     *
     * @return string
     */
    public static function joinSkip(string $delimiter, ...$strings): string
    {
        return static::getInstance()->joinSkip($delimiter, ...$strings);
    }

    /**
     * '1:2,3', включая пустые строки, исключение если нельзя привести к строке, антоним explodeRecursive
     *
     * @param string|array $delimiters
     * @param array        $strings
     *
     * @return void
     */
    public static function joinRecursive($delimiters, array $strings)
    {
        return static::getInstance()->joinRecursive($delimiters, $strings);
    }

    /**
     * '1:2,3', включая пустые строки, пропускает если нельзя привести к строке, антоним explodeRecursive
     *
     * @param string|array $delimiters
     * @param array        $strings
     *
     * @return void
     */
    public static function joinRecursiveSkip($delimiters, array $strings)
    {
        return static::getInstance()->joinRecursiveSkip($delimiters, $strings);
    }

    /**
     * "`1`, `2` or `3`", всегда пропускает пустые строки, исключение если нельзя привести к строке
     *
     * @param string|array $strings
     * @param null|string  $delimiter
     * @param null|string  $lastDelimiter
     * @param null|string  $wrapper
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
     * @param string|array $strings
     * @param null|string  $delimiter
     * @param null|string  $wrapper
     * @param null|string  $lastDelimiter
     *
     * @return string
     */
    public static function concatSkip(
        $strings,
        string $delimiter = null,
        string $lastDelimiter = null,
        string $wrapper = null
    ): string {
        return static::getInstance()->concatSkip($strings, $delimiter, $lastDelimiter, $wrapper);
    }

    /**
     * урезает английское слово до префикса из нескольких букв - когда имя индекса в бд слишком длинное
     *
     * @param string   $string
     * @param null|int $len
     *
     * @return string
     */
    public static function prefix(string $string, int $len = null): string
    {
        return static::getInstance()->prefix($string, $len);
    }

    /**
     * применяет prefix() ко всем строкам, затем соединяет результаты, чтобы урезать итоговый размер строки
     *
     * @param string|array      $strings
     * @param null|string|array $delimiters
     * @param null|int          $len
     *
     * @return string
     */
    public static function prefixCompact($strings, $delimiters = null, int $len = null): string
    {
        return static::getInstance()->prefixCompact($strings, $delimiters, $len);
    }

    /**
     * ищет все совпадения начинающиеся с "подстроки" и заканчивающиеся на "подстроку"
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
        bool $ignoreCase = null
    ): array {
        return static::getInstance()->match($start, $end, $haystack, $offset, $ignoreCase);
    }

    /**
     * Функция заменяет "умляут" символы на их соответствующие в ASCII
     *
     * @param string $string
     *
     * @return string
     */
    public static function unaccent(string $string): string
    {
        return static::getInstance()->unaccent($string);
    }

    /**
     * PascalCase, non-regex version
     *
     * @param string|string[] $words
     * @param null|string     $separator
     * @param null|string     $spaces
     *
     * @return string
     */
    public static function pascal($words, string $separator = null, string $spaces = null): string
    {
        return static::getInstance()->pascal($words, $separator, $spaces);
    }

    /**
     * camelCase (non-regex version)
     *
     * @param string|string[] $words
     * @param null|string     $separator
     * @param null|string     $spaces
     *
     * @return string
     */
    public static function camel($words, string $separator = null, string $spaces = null): string
    {
        return static::getInstance()->camel($words, $separator, $spaces);
    }

    /**
     * PascalCase
     *
     * @param string|array $strings
     * @param null|string  $keep
     * @param null|string  $separator
     *
     * @return string
     */
    public static function pascalCase($strings, string $keep = null, string $separator = null): string
    {
        return static::getInstance()->pascalCase($strings, $keep, $separator);
    }

    /**
     * camelCase
     *
     * @param string|array $strings
     * @param null|string  $keep
     * @param null|string  $separator
     *
     * @return string
     */
    public static function camelCase($strings, string $keep = null, string $separator = null): string
    {
        return static::getInstance()->camelCase($strings, $keep, $separator);
    }

    /**
     * snake_case
     *
     * @param string|array $strings
     * @param null|string  $separator
     * @param null|string  $keep
     *
     * @return string
     */
    public static function snakeCase($strings, string $keep = null, string $separator = null): string
    {
        return static::getInstance()->snakeCase($strings, $keep, $separator);
    }

    /**
     * kebab-case
     *
     * @param string|array $strings
     * @param null|string  $separator
     * @param null|string  $keep
     *
     * @return string
     */
    public static function kebabCase($strings, string $keep = null, string $separator = null): string
    {
        return static::getInstance()->kebabCase($strings, $keep, $separator);
    }

    /**
     * 'space case'
     *
     * @param string|array $strings
     * @param null|string  $separator
     * @param null|string  $keep
     *
     * @return string
     */
    public static function spaceCase($strings, string $keep = null, string $separator = null): string
    {
        return static::getInstance()->spaceCase($strings, $keep, $separator);
    }

    /**
     * @param string      $string
     * @param null|string $delimiter
     * @param null|string $locale
     *
     * @return string
     */
    public static function slug(string $string, string $delimiter = null, string $locale = null): string
    {
        return static::getInstance()->slug($string, $delimiter, $locale);
    }

    /**
     * @param string      $string
     * @param null|string $delimiter
     * @param null|string $locale
     *
     * @return string
     */
    public static function slugify(string $string, string $delimiter = null, string $locale = null): string
    {
        return static::getInstance()->slugify($string, $delimiter, $locale);
    }

    /**
     * @param string   $singular
     * @param null|int $limit
     * @param null|int $offset
     *
     * @return array
     */
    public static function pluralize(string $singular, $limit = null, $offset = null): array
    {
        return static::getInstance()->pluralize($singular, $limit, $offset);
    }

    /**
     * @param string   $plural
     * @param null|int $limit
     * @param null|int $offset
     *
     * @return array
     */
    public static function singularize(string $plural, $limit = null, $offset = null): array
    {
        return static::getInstance()->singularize($plural, $limit, $offset);
    }

    /**
     * @param string $function
     *
     * @return string
     */
    public static function mb(string $function): string
    {
        return static::getInstance()->mb($function);
    }

    /**
     * @param string $function
     * @param mixed  ...$arguments
     *
     * @return mixed
     */
    public static function multibyte(string $function, ...$arguments)
    {
        return static::getInstance()->multibyte($function, ...$arguments);
    }

    /**
     * @param string $mode
     *
     * @return void
     */
    public static function beginMultibyteMode(string $mode)
    {
        return static::getInstance()->beginMultibyteMode($mode);
    }

    /**
     * @return void
     */
    public static function endMultibyteMode()
    {
        return static::getInstance()->endMultibyteMode();
    }

    /**
     * @param string   $mode
     * @param \Closure $closure
     *
     * @return void
     */
    public static function multibyteMode(string $mode, \Closure $closure)
    {
        return static::getInstance()->multibyteMode($mode, $closure);
    }

    /**
     * @param string|array|mixed $arguments
     *
     * @return string
     */
    public static function detectMultibyte(...$arguments): string
    {
        return static::getInstance()->detectMultibyte(...$arguments);
    }

    /**
     * @return IStr
     */
    public static function getInstance(): IStr
    {
        return SupportFactory::getInstance()->getStr();
    }
}
