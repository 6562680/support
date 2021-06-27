<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support\Interfaces;

use Gzhegow\Support\Domain\Str\Inflector;
use Gzhegow\Support\Domain\Str\InflectorInterface;
use Gzhegow\Support\Domain\Str\Slugger;
use Gzhegow\Support\Domain\Str\SluggerInterface;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Str;

interface StrInterface
{
    /**
     * @return string
     */
    public function getTrims(): string;

    /**
     * @return string
     */
    public function getVowels(): string;

    /**
     * @param mixed $value
     *
     * @return null|string
     */
    public function strval($value): ?string;

    /**
     * @param mixed $value
     *
     * @return null|string
     */
    public function wordval($value): ?string;

    /**
     * @param mixed $value
     *
     * @return null|string
     */
    public function trimval($value): ?string;

    /**
     * @param mixed $value
     *
     * @return string
     */
    public function theStrval($value): string;

    /**
     * @param mixed $value
     *
     * @return string
     */
    public function theWordval($value): string;

    /**
     * @param mixed $value
     *
     * @return string
     */
    public function theTrimval($value): string;

    /**
     * @param string|array $strings
     * @param null|bool    $uniq
     *
     * @return string[]
     */
    public function strvals($strings, $uniq = null): array;

    /**
     * @param string|array $words
     * @param null|bool    $uniq
     *
     * @return string[]
     */
    public function wordvals($words, $uniq = null): array;

    /**
     * @param string|array $trims
     * @param null|bool    $uniq
     *
     * @return string[]
     */
    public function trimvals($trims, $uniq = null): array;

    /**
     * @param string|array $strings
     * @param null|bool    $uniq
     *
     * @return string[]
     */
    public function theStrvals($strings, $uniq = null): array;

    /**
     * @param string|array $words
     * @param null|bool    $uniq
     *
     * @return string[]
     */
    public function theWordvals($words, $uniq = null): array;

    /**
     * @param string|array $trims
     * @param null|bool    $uniq
     *
     * @return string[]
     */
    public function theTrimvals($trims, $uniq = null): array;

    /**
     * @param null|SluggerInterface $slugger
     *
     * @return SluggerInterface
     */
    public function slugger(SluggerInterface $slugger = null): SluggerInterface;

    /**
     * @param null|InflectorInterface $inflector
     *
     * @return InflectorInterface
     */
    public function inflector(InflectorInterface $inflector = null): InflectorInterface;

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
    public function strpos(string $haystack, string $needle, int $offset = null): int;

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
    public function strrpos(string $haystack, string $needle, int $offset = null): int;

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
    public function stripos(string $haystack, string $needle, int $offset = null): int;

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
    public function strripos(string $haystack, string $needle, int $offset = null): int;

    /**
     * фикс. стандартная функция при попытке разбить пустую строку возвращает массив из пустой строки
     *
     * @param string   $string
     * @param null|int $len
     *
     * @return array
     */
    public function split(string $string, int $len = null): array;

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
    public function replace($strings, $replacements, $subjects, int $limit = null, int &$count = null);

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
    public function ireplace($strings, $replacements, $subjects, int $limit = null, int &$count = null);

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
    public function lcrop(string $haystack, string $needle, bool $ignoreCase = null, int $limit = -1): string;

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
    public function rcrop(string $haystack, string $needle, bool $ignoreCase = null, int $limit = -1): string;

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
    public function crop(string $haystack, $needles, bool $ignoreCase = null, int $limit = -1): string;

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
    public function starts(string $haystack, string $needle, bool $ignoreCase = null): ?string;

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
    public function ends(string $haystack, string $needle, bool $ignoreCase = null): ?string;

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
    public function contains(string $haystack, string $needle, bool $ignoreCase = null, int $limit = null): array;

    /**
     * Добавляет подстроку в начале строки
     *
     * @param string      $str
     * @param string|null $wrapper
     * @param null|int    $len
     *
     * @return string
     */
    public function lwrap(string $str, string $wrapper = null, int $len = null): string;

    /**
     * Добавляет подстроку в конце строки
     *
     * @param string      $str
     * @param string|null $wrapper
     * @param null|int    $len
     *
     * @return string
     */
    public function rwrap(string $str, string $wrapper = null, int $len = null): string;

    /**
     * Оборачивает строку в другие, например в кавычки
     *
     * @param string          $str
     * @param string|string[] $wrappers
     * @param null|int        $len
     *
     * @return string
     */
    public function wrap(string $str, $wrappers, int $len = null): string;

    /**
     * Добавляет подстроку в начало строки, если её уже там нет
     *
     * @param string      $str
     * @param string|null $prepend
     * @param bool        $ignoreCase
     *
     * @return string
     */
    public function prepend(string $str, string $prepend, bool $ignoreCase = null): string;

    /**
     * Добавляет подстроку в конец строки, если её уже там нет
     *
     * @param string      $str
     * @param string|null $append
     * @param bool        $ignoreCase
     *
     * @return string
     */
    public function append(string $str, string $append, bool $ignoreCase = null): string;

    /**
     * Оборачивает строку в подстроки, если их уже там нет
     *
     * @param string          $str
     * @param string|string[] $overlays
     * @param bool            $ignoreCase
     *
     * @return string
     */
    public function overlay(string $str, $overlays, bool $ignoreCase = null): string;

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
    public function separate($delimiters, $strings, bool $ignoreCase = null, int $limit = null): array;

    /**
     * @param string|array $delimiters
     * @param string|array $strings
     * @param null|bool    $ignoreCase
     * @param null|int     $limit
     *
     * @return array
     */
    public function explode($delimiters, $strings, bool $ignoreCase = null, int $limit = null): array;

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
    public function partition($delimiters, $strings, bool $ignoreCase = null, int $limit = null);

    /**
     * '1, 2, 3', включая пустые строки, исключение если нельзя привести к строке
     *
     * @param string       $delimiter
     * @param string|array ...$strings
     *
     * @return string
     */
    public function implode(string $delimiter, ...$strings): string;

    /**
     * '1, 2, 3', включая пустые строки, пропускает если нельзя привести к строке
     *
     * @param string       $delimiter
     * @param string|array ...$strings
     *
     * @return string
     */
    public function implodeSkip(string $delimiter, ...$strings): string;

    /**
     * '1, 2, 3', пропускает пустые строки, исключение если нельзя привести к строке
     *
     * @param string       $delimiter
     * @param string|array ...$strings
     *
     * @return string
     */
    public function join(string $delimiter, ...$strings): string;

    /**
     * '1, 2, 3', пропускает пустые строки, пропускает если нельзя привести к строке
     *
     * @param string       $delimiter
     * @param string|array ...$strings
     *
     * @return string
     */
    public function joinSkip(string $delimiter, ...$strings): string;

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
    public function concat(
        $strings,
        string $delimiter = null,
        string $lastDelimiter = null,
        string $wrapper = null
    ): string;

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
    public function concatSkip(
        array $strings,
        string $delimiter = null,
        string $lastDelimiter = null,
        string $wrapper = null
    ): string;

    /**
     * урезает английское слово(-а) до префикса из нескольких букв - когда имя индекса в бд слишком длинное
     *
     * @param string   $string
     * @param null|int $len
     *
     * @return string
     */
    public function prefix(string $string, int $len = null): string;

    /**
     * применяет prefix() ко всем строкам, затем соединяет результаты, чтобы урезать итоговый размер строки
     *
     * @param string|array      $strings
     * @param null|string|array $delimiters
     * @param null|int          $limit
     *
     * @return string
     */
    public function compact($strings, $delimiters = null, int $limit = null): string;

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
    public function match(
        string $start,
        string $end,
        string $haystack,
        int $offset = null,
        bool $ignoreCase = null
    ): array;

    /**
     * camelCase
     *
     * @param string|array $strings
     * @param null|string  $separator
     * @param null|string  $delimiters
     *
     * @return string
     */
    public function camel($strings, string $separator = null, string $delimiters = null): string;

    /**
     * PascalCase
     *
     * @param string|array $strings
     * @param null|string  $separator
     * @param null|string  $delimiters
     *
     * @return string
     */
    public function pascal($strings, string $separator = null, string $delimiters = null): string;

    /**
     * snake_case
     *
     * @param string|array $strings
     * @param null|string  $separator
     * @param null|string  $delimiters
     *
     * @return string
     */
    public function snake($strings, string $separator = null, string $delimiters = null): string;

    /**
     * @param string      $string
     * @param null|string $delimiter
     * @param null|string $locale
     *
     * @return string
     */
    public function slug(string $string, string $delimiter = null, string $locale = null): string;

    /**
     * @param string      $string
     * @param null|string $delimiter
     * @param null|string $locale
     *
     * @return string
     */
    public function slugLower(string $string, string $delimiter = null, string $locale = null): string;

    /**
     * @param string   $singular
     * @param null|int $limit
     * @param int      $offset
     *
     * @return null|string|array
     */
    public function pluralize(string $singular, $limit = null, $offset = 0);

    /**
     * @param string   $plural
     * @param null|int $limit
     * @param int      $offset
     *
     * @return null|string|array
     */
    public function singularize(string $plural, $limit = null, $offset = 0);
}
