<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support\Facades\Generated;

use Gzhegow\Support\Domain\Str\Inflector;
use Gzhegow\Support\Domain\Str\InflectorInterface;
use Gzhegow\Support\Domain\Str\Slugger;
use Gzhegow\Support\Domain\Str\SluggerInterface;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Str;

abstract class GeneratedStrFacade
{
    /**
     * @return string
     */
    public static function getTrims(): string
    {
        return static::getInstance()->getTrims();
    }

    /**
     * @return string
     */
    public static function getVowels(): string
    {
        return static::getInstance()->getVowels();
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
     * @param mixed $value
     *
     * @return null|string
     */
    public static function trimval($value): ?string
    {
        return static::getInstance()->trimval($value);
    }

    /**
     * @param mixed $value
     *
     * @return string
     */
    public static function theStrval($value): string
    {
        return static::getInstance()->theStrval($value);
    }

    /**
     * @param mixed $value
     *
     * @return string
     */
    public static function theWordval($value): string
    {
        return static::getInstance()->theWordval($value);
    }

    /**
     * @param mixed $value
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
     *
     * @return string[]
     */
    public static function strvals($strings, $uniq = null): array
    {
        return static::getInstance()->strvals($strings, $uniq);
    }

    /**
     * @param string|array $words
     * @param null|bool    $uniq
     *
     * @return string[]
     */
    public static function wordvals($words, $uniq = null): array
    {
        return static::getInstance()->wordvals($words, $uniq);
    }

    /**
     * @param string|array $trims
     * @param null|bool    $uniq
     *
     * @return string[]
     */
    public static function trimvals($trims, $uniq = null): array
    {
        return static::getInstance()->trimvals($trims, $uniq);
    }

    /**
     * @param string|array $strings
     * @param null|bool    $uniq
     *
     * @return string[]
     */
    public static function theStrvals($strings, $uniq = null): array
    {
        return static::getInstance()->theStrvals($strings, $uniq);
    }

    /**
     * @param string|array $words
     * @param null|bool    $uniq
     *
     * @return string[]
     */
    public static function theWordvals($words, $uniq = null): array
    {
        return static::getInstance()->theWordvals($words, $uniq);
    }

    /**
     * @param string|array $trims
     * @param null|bool    $uniq
     *
     * @return string[]
     */
    public static function theTrimvals($trims, $uniq = null): array
    {
        return static::getInstance()->theTrimvals($trims, $uniq);
    }

    /**
     * @param null|SluggerInterface $slugger
     *
     * @return SluggerInterface
     */
    public static function slugger(SluggerInterface $slugger = null): SluggerInterface
    {
        return static::getInstance()->slugger($slugger);
    }

    /**
     * @param null|InflectorInterface $inflector
     *
     * @return InflectorInterface
     */
    public static function inflector(InflectorInterface $inflector = null): InflectorInterface
    {
        return static::getInstance()->inflector($inflector);
    }

    /**
     * стандартная функция возвращает false, если не найдено, false при вычитании приравнивается к 0
     * возврат -1 позволяет использовать вычитание в коротком синтаксисе сортировок и тильду для битового сдвига
     * usort($array, function ($a, $b) { return $str->strpos($haystack, $a) - $str->strpos($haystack, $b); }}
     *
     * @param string   $haystack
     * @param string   $needle
     * @param null|int $offset
     *
     * @return int
     */
    public static function strpos(string $haystack, string $needle, int $offset = null): int
    {
        return static::getInstance()->strpos($haystack, $needle, $offset);
    }

    /**
     * стандартная функция возвращает false, если не найдено, false при вычитании приравнивается к 0
     * возврат -1 позволяет использовать вычитание в коротком синтаксисе сортировок и тильду для битового сдвига
     * usort($array, function ($a, $b) { return $str->strrpos($haystack, $a) - $str->strrpos($haystack, $b); }}
     *
     * @param string   $haystack
     * @param string   $needle
     * @param null|int $offset
     *
     * @return int
     */
    public static function strrpos(string $haystack, string $needle, int $offset = null): int
    {
        return static::getInstance()->strrpos($haystack, $needle, $offset);
    }

    /**
     * стандартная функция возвращает false, если не найдено, false при вычитании приравнивается к 0
     * возврат -1 позволяет использовать вычитание в коротком синтаксисе сортировок и тильду для битового сдвига
     * usort($array, function ($a, $b) { return $str->stripos($haystack, $a) - $str->stripos($haystack, $b); }}
     *
     * @param string   $haystack
     * @param string   $needle
     * @param null|int $offset
     *
     * @return int
     */
    public static function stripos(string $haystack, string $needle, int $offset = null): int
    {
        return static::getInstance()->stripos($haystack, $needle, $offset);
    }

    /**
     * стандартная функция возвращает false, если не найдено, false при вычитании приравнивается к 0
     * возврат -1 позволяет использовать вычитание в коротком синтаксисе сортировок и тильду для битового сдвига
     * usort($array, function ($a, $b) { return $str->strripos($haystack, $a) - $str->strripos($haystack, $b); }}
     *
     * @param string   $haystack
     * @param string   $needle
     * @param null|int $offset
     *
     * @return int
     */
    public static function strripos(string $haystack, string $needle, int $offset = null): int
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
     * @param string      $haystack
     * @param string|null $needle
     * @param bool|null   $ignoreCase
     * @param int         $limit
     *
     * @return string
     */
    public static function lcrop(string $haystack, string $needle, bool $ignoreCase = null, int $limit = -1): string
    {
        return static::getInstance()->lcrop($haystack, $needle, $ignoreCase, $limit);
    }

    /**
     * Обрезает у строки подстроку с конца (rtrim, только для строк а не букв)
     *
     * @param string      $haystack
     * @param string|null $needle
     * @param bool|null   $ignoreCase
     * @param int         $limit
     *
     * @return string
     */
    public static function rcrop(string $haystack, string $needle, bool $ignoreCase = null, int $limit = -1): string
    {
        return static::getInstance()->rcrop($haystack, $needle, $ignoreCase, $limit);
    }

    /**
     * Обрезает у строки подстроки с обеих сторон (trim, только для строк а не букв)
     *
     * @param string          $haystack
     * @param string|string[] $needles
     * @param bool|null       $ignoreCase
     * @param int             $limit
     *
     * @return string
     */
    public static function crop(string $haystack, $needles, bool $ignoreCase = null, int $limit = -1): string
    {
        return static::getInstance()->crop($haystack, $needles, $ignoreCase, $limit);
    }

    /**
     * если строка начинается на искомую, отрезает ее и возвращает укороченную
     * if (null !== ($substr = $str->ends('hello', 'h'))) {} // 'ello'
     *
     * @param string      $haystack
     * @param string|null $needle
     * @param bool|null   $ignoreCase
     *
     * @return null|string
     */
    public static function starts(string $haystack, string $needle, bool $ignoreCase = null): ?string
    {
        return static::getInstance()->starts($haystack, $needle, $ignoreCase);
    }

    /**
     * если строка заканчивается на искомую, отрезает ее и возвращает укороченную
     * if (null !== ($substr = $str->ends('hello', 'o'))) {} // 'hell'
     *
     * @param string      $haystack
     * @param string|null $needle
     * @param bool|null   $ignoreCase
     *
     * @return null|string
     */
    public static function ends(string $haystack, string $needle, bool $ignoreCase = null): ?string
    {
        return static::getInstance()->ends($haystack, $needle, $ignoreCase);
    }

    /**
     * ищет подстроку в строке и разбивает по ней результат
     * if ($explode = $str->contains('hello', 'h')) {} // ['', 'ello']
     *
     * @param string      $haystack
     * @param string|null $needle
     * @param null|int    $limit
     * @param bool|null   $ignoreCase
     *
     * @return array
     */
    public static function contains(string $haystack, string $needle, bool $ignoreCase = null, int $limit = null): array
    {
        return static::getInstance()->contains($haystack, $needle, $ignoreCase, $limit);
    }

    /**
     * Добавляет подстроку в начале строки
     *
     * @param string      $str
     * @param string|null $wrapper
     * @param null|int    $len
     *
     * @return string
     */
    public static function lwrap(string $str, string $wrapper = null, int $len = null): string
    {
        return static::getInstance()->lwrap($str, $wrapper, $len);
    }

    /**
     * Добавляет подстроку в конце строки
     *
     * @param string      $str
     * @param string|null $wrapper
     * @param null|int    $len
     *
     * @return string
     */
    public static function rwrap(string $str, string $wrapper = null, int $len = null): string
    {
        return static::getInstance()->rwrap($str, $wrapper, $len);
    }

    /**
     * Оборачивает строку в другие, например в кавычки
     *
     * @param string          $str
     * @param string|string[] $wrappers
     * @param null|int        $len
     *
     * @return string
     */
    public static function wrap(string $str, $wrappers, int $len = null): string
    {
        return static::getInstance()->wrap($str, $wrappers, $len);
    }

    /**
     * Добавляет подстроку в начало строки, если её уже там нет
     *
     * @param string      $str
     * @param string|null $prepend
     * @param bool        $ignoreCase
     *
     * @return string
     */
    public static function prepend(string $str, string $prepend, bool $ignoreCase = null): string
    {
        return static::getInstance()->prepend($str, $prepend, $ignoreCase);
    }

    /**
     * Добавляет подстроку в конец строки, если её уже там нет
     *
     * @param string      $str
     * @param string|null $append
     * @param bool        $ignoreCase
     *
     * @return string
     */
    public static function append(string $str, string $append, bool $ignoreCase = null): string
    {
        return static::getInstance()->append($str, $append, $ignoreCase);
    }

    /**
     * Оборачивает строку в подстроки, если их уже там нет
     *
     * @param string          $str
     * @param string|string[] $overlays
     * @param bool            $ignoreCase
     *
     * @return string
     */
    public static function overlay(string $str, $overlays, bool $ignoreCase = null): string
    {
        return static::getInstance()->overlay($str, $overlays, $ignoreCase);
    }

    /**
     * рекурсивно разрывает строку в многоуровневый массив вне зависимости от того найдено совпадение или нет (explode recursive)
     *
     * @param string|array $delimiters
     * @param string|array $strings
     * @param null|bool    $ignoreCase
     * @param int|null     $limit
     *
     * @return array
     */
    public static function separate($delimiters, $strings, bool $ignoreCase = null, int $limit = null): array
    {
        return static::getInstance()->separate($delimiters, $strings, $ignoreCase, $limit);
    }

    /**
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
     * разбирает значение заголовка во вложенный массив, если разделители найдены в каждой подстроке
     *
     * @param string|array $delimiters
     * @param string       $strings
     * @param null|bool    $ignoreCase
     * @param int|null     $limit
     *
     * @return string|array
     */
    public static function partition($delimiters, $strings, bool $ignoreCase = null, int $limit = null)
    {
        return static::getInstance()->partition($delimiters, $strings, $ignoreCase, $limit);
    }

    /**
     * '1, 2, 3', включая пустые строки, исключение если нельзя привести к строке
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
     * '1, 2, 3', включая пустые строки, пропускает если нельзя привести к строке
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
        array $strings,
        string $delimiter = null,
        string $lastDelimiter = null,
        string $wrapper = null
    ): string {
        return static::getInstance()->concatSkip($strings, $delimiter, $lastDelimiter, $wrapper);
    }

    /**
     * урезает английское слово(-а) до префикса из нескольких букв - когда имя индекса в бд слишком длинное
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
     * @param null|int          $limit
     *
     * @return string
     */
    public static function compact($strings, $delimiters = null, int $limit = null): string
    {
        return static::getInstance()->compact($strings, $delimiters, $limit);
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
     * camelCase
     *
     * @param string|array $strings
     * @param null|string  $separator
     * @param null|string  $delimiters
     *
     * @return string
     */
    public static function camel($strings, string $separator = null, string $delimiters = null): string
    {
        return static::getInstance()->camel($strings, $separator, $delimiters);
    }

    /**
     * PascalCase
     *
     * @param string|array $strings
     * @param null|string  $separator
     * @param null|string  $delimiters
     *
     * @return string
     */
    public static function pascal($strings, string $separator = null, string $delimiters = null): string
    {
        return static::getInstance()->pascal($strings, $separator, $delimiters);
    }

    /**
     * snake_case
     *
     * @param string|array $strings
     * @param null|string  $separator
     * @param null|string  $delimiters
     *
     * @return string
     */
    public static function snake($strings, string $separator = null, string $delimiters = null): string
    {
        return static::getInstance()->snake($strings, $separator, $delimiters);
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
     * @param string   $singular
     * @param null|int $limit
     * @param int      $offset
     *
     * @return null|string|array
     */
    public static function pluralize(string $singular, $limit = null, $offset = 0)
    {
        return static::getInstance()->pluralize($singular, $limit, $offset);
    }

    /**
     * @param string   $plural
     * @param null|int $limit
     * @param int      $offset
     *
     * @return null|string|array
     */
    public static function singularize(string $plural, $limit = null, $offset = 0)
    {
        return static::getInstance()->singularize($plural, $limit, $offset);
    }

    /**
     * @return Str
     */
    abstract public static function getInstance(): Str;
}
