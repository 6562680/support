<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 * @noinspection RedundantSuppression
 */

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Traits\Load\ArrLoadTrait;
use Gzhegow\Support\Traits\Load\CacheLoadTrait;
use Gzhegow\Support\Traits\Load\NumLoadTrait;
use Gzhegow\Support\Traits\Load\Str\InflectorLoadTrait;
use Gzhegow\Support\Traits\Load\Str\SluggerLoadTrait;

interface IStr
{
    /**
     * @return string
     */
    public function loadTrims(): string;

    /**
     * @return string
     */
    public function loadSeparators(): string;

    /**
     * @return array
     */
    public function loadAccents(): array;

    /**
     * @return array
     */
    public function loadVowels(): array;

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function filterStringUtf8($value): ?string;

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function filterString($value): ?string;

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function filterLetter($value): ?string;

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function filterWord($value): ?string;

    /**
     * @param int|string|mixed $value
     *
     * @return null|int|float|string
     */
    public function filterStringOrInt($value);

    /**
     * @param int|string|mixed $value
     *
     * @return null|int|float|string
     */
    public function filterLetterOrInt($value);

    /**
     * @param int|string|mixed $value
     *
     * @return null|int|float|string
     */
    public function filterWordOrInt($value);

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public function filterStringOrNum($value);

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public function filterLetterOrNum($value);

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public function filterWordOrNum($value);

    /**
     * @param string|mixed $value
     *
     * @return null|int|float|string|object
     */
    public function filterStrval($value);

    /**
     * @param string|mixed $value
     *
     * @return null|int|float|string|object
     */
    public function filterLetterval($value);

    /**
     * @param string|mixed $value
     *
     * @return null|int|float|string|object
     */
    public function filterWordval($value);

    /**
     * @param string|mixed $value
     *
     * @return null|int|float|string|object
     */
    public function filterTrimval($value);

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function strval($value): ?string;

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function letterval($value): ?string;

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function wordval($value): ?string;

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function trimval($value): ?string;

    /**
     * @param string|mixed $value
     *
     * @return string
     */
    public function theStrval($value): string;

    /**
     * @param string|mixed $value
     *
     * @return string
     */
    public function theLetterval($value): string;

    /**
     * @param string|mixed $value
     *
     * @return string
     */
    public function theWordval($value): string;

    /**
     * @param string|mixed $value
     *
     * @return string
     */
    public function theTrimval($value): string;

    /**
     * @param string|array $strings
     * @param null|bool    $uniq
     * @param null|bool    $recursive
     *
     * @return string[]
     */
    public function strvals($strings, bool $uniq = null, bool $recursive = null): array;

    /**
     * @param string|array $letters
     * @param null|bool    $uniq
     * @param null|bool    $recursive
     *
     * @return string[]
     */
    public function lettervals($letters, bool $uniq = null, bool $recursive = null): array;

    /**
     * @param string|array $words
     * @param null|bool    $uniq
     * @param null|bool    $recursive
     *
     * @return string[]
     */
    public function wordvals($words, bool $uniq = null, bool $recursive = null): array;

    /**
     * @param string|array $trims
     * @param null|bool    $uniq
     * @param null|bool    $recursive
     *
     * @return string[]
     */
    public function trimvals($trims, bool $uniq = null, bool $recursive = null): array;

    /**
     * @param string|array $strings
     * @param null|bool    $uniq
     * @param null|bool    $recursive
     *
     * @return string[]
     */
    public function theStrvals($strings, bool $uniq = null, bool $recursive = null): array;

    /**
     * @param string|array $letters
     * @param null|bool    $uniq
     * @param null|bool    $recursive
     *
     * @return string[]
     */
    public function theLettervals($letters, bool $uniq = null, bool $recursive = null): array;

    /**
     * @param string|array $words
     * @param null|bool    $uniq
     * @param null|bool    $recursive
     *
     * @return string[]
     */
    public function theWordvals($words, bool $uniq = null, bool $recursive = null): array;

    /**
     * @param string|array $trims
     * @param null|bool    $uniq
     * @param null|bool    $recursive
     *
     * @return string[]
     */
    public function theTrimvals($trims, bool $uniq = null, bool $recursive = null): array;

    /**
     * пишет слово с большой буквы
     *
     * @param string      $string
     * @param null|string $encoding
     *
     * @return string
     */
    public function lcfirst(string $string, string $encoding = null);

    /**
     * пишет слово с большой буквы
     *
     * @param string      $string
     * @param null|string $encoding
     *
     * @return string
     */
    public function ucfirst(string $string, string $encoding = null);

    /**
     * пишет каждое слово в предложении с малой буквы
     *
     * @param string      $string
     * @param string      $separators
     * @param null|string $encoding
     *
     * @return string
     */
    public function lcwords(string $string, string $separators = " \t\r\n\x0C\x0B", string $encoding = null);

    /**
     * пишет каждое слово в предложении с большой буквы
     *
     * @param string      $string
     * @param string      $separators
     * @param null|string $encoding
     *
     * @return string
     */
    public function ucwords(string $string, string $separators = " \t\r\n\x0C\x0B", string $encoding = null);

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
    public function strpos(string $string, string $needle, int $offset = null): int;

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
    public function strrpos(string $string, string $needle, int $offset = null): int;

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
    public function stripos(string $string, string $needle, int $offset = null): int;

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
    public function strripos(string $string, string $needle, int $offset = null): int;

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
     * @param string      $string
     * @param string|null $needle
     * @param bool|null   $ignoreCase
     * @param int         $limit
     *
     * @return string
     */
    public function lcrop(string $string, string $needle, bool $ignoreCase = null, int $limit = -1): string;

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
    public function rcrop(string $string, string $needle, bool $ignoreCase = null, int $limit = -1): string;

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
    public function crop(string $string, $needles, bool $ignoreCase = null, int $limit = -1): string;

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
    public function starts(string $string, string $needle, bool $ignoreCase = null): ?string;

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
    public function ends(string $string, string $needle, bool $ignoreCase = null): ?string;

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
    public function contains(string $string, string $needle, bool $ignoreCase = null, int $limit = null): array;

    /**
     * Добавляет подстроку в начале строки
     *
     * @param string      $string
     * @param string|null $repeat
     * @param null|int    $times
     *
     * @return string
     */
    public function unltrim(string $string, string $repeat = null, int $times = null): string;

    /**
     * Добавляет подстроку в конце строки
     *
     * @param string      $string
     * @param string|null $repeat
     * @param null|int    $times
     *
     * @return string
     */
    public function unrtrim(string $string, string $repeat = null, int $times = null): string;

    /**
     * Оборачивает строку в другие, например в кавычки
     *
     * @param string          $string
     * @param string|string[] $repeats
     * @param null|int        $times
     *
     * @return string
     */
    public function untrim(string $string, $repeats, int $times = null): string;

    /**
     * Добавляет подстроку в начало строки, если её уже там нет
     *
     * @param string      $string
     * @param string|null $prepend
     * @param bool        $ignoreCase
     *
     * @return string
     */
    public function prepend(string $string, string $prepend, bool $ignoreCase = null): string;

    /**
     * Добавляет подстроку в конец строки, если её уже там нет
     *
     * @param string      $string
     * @param string|null $append
     * @param bool        $ignoreCase
     *
     * @return string
     */
    public function append(string $string, string $append, bool $ignoreCase = null): string;

    /**
     * Оборачивает строку в подстроки, если их уже там нет
     *
     * @param string          $string
     * @param string|string[] $wraps
     * @param bool            $ignoreCase
     *
     * @return string
     */
    public function wrap(string $string, $wraps, bool $ignoreCase = null): string;

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
    public function explode($delimiters, $strings, bool $ignoreCase = null, int $limit = null): array;

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
    public function explodeRecursive($delimiters, $strings, bool $ignoreCase = null, int $limit = null): array;

    /**
     * '1, 2, 3', включая пустые строки, исключение если нельзя привести к строке, антоним explode
     *
     * @param string       $delimiter
     * @param string|array ...$strings
     *
     * @return string
     */
    public function implode(string $delimiter, ...$strings): string;

    /**
     * '1, 2, 3', включая пустые строки, пропускает если нельзя привести к строке, антоним explodeSkip
     *
     * @param string       $delimiter
     * @param string|array ...$strings
     *
     * @return string
     */
    public function implodeSkip(string $delimiter, ...$strings): string;

    /**
     * '1:2,3', включая пустые строки, исключение если нельзя привести к строке, антоним explodeRecursive
     *
     * @param string|array $delimiters
     * @param array        $strings
     *
     * @return void
     */
    public function implodeRecursive($delimiters, array $strings): string;

    /**
     * '1:2,3', включая пустые строки, пропускает если нельзя привести к строке, антоним explodeRecursive
     *
     * @param string|array $delimiters
     * @param array        $strings
     *
     * @return void
     */
    public function implodeRecursiveSkip($delimiters, array $strings): string;

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
     * '1:2,3', включая пустые строки, исключение если нельзя привести к строке, антоним explodeRecursive
     *
     * @param string|array $delimiters
     * @param array        $strings
     *
     * @return void
     */
    public function joinRecursive($delimiters, array $strings): string;

    /**
     * '1:2,3', включая пустые строки, пропускает если нельзя привести к строке, антоним explodeRecursive
     *
     * @param string|array $delimiters
     * @param array        $strings
     *
     * @return void
     */
    public function joinRecursiveSkip($delimiters, array $strings): string;

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
        $strings,
        string $delimiter = null,
        string $lastDelimiter = null,
        string $wrapper = null
    ): string;

    /**
     * урезает английское слово до префикса из нескольких букв - когда имя индекса в бд слишком длинное
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
     * @param null|int          $len
     *
     * @return string
     */
    public function prefixCompact($strings, $delimiters = null, int $len = null): string;

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
     * Функция заменяет "умляут" символы на их соответствующие в ASCII
     *
     * @param string $string
     *
     * @return string
     */
    public function unaccent(string $string): string;

    /**
     * PascalCase, non-regex version
     *
     * @param string|string[] $words
     * @param null|string     $separator
     * @param null|string     $spaces
     *
     * @return string
     */
    public function pascal($words, string $separator = null, string $spaces = null): string;

    /**
     * camelCase (non-regex version)
     *
     * @param string|string[] $words
     * @param null|string     $separator
     * @param null|string     $spaces
     *
     * @return string
     */
    public function camel($words, string $separator = null, string $spaces = null): string;

    /**
     * PascalCase
     *
     * @param string|array $strings
     * @param null|string  $keep
     * @param null|string  $separator
     *
     * @return string
     */
    public function pascalCase($strings, string $keep = null, string $separator = null): string;

    /**
     * camelCase
     *
     * @param string|array $strings
     * @param null|string  $keep
     * @param null|string  $separator
     *
     * @return string
     */
    public function camelCase($strings, string $keep = null, string $separator = null): string;

    /**
     * snake_case
     *
     * @param string|array $strings
     * @param null|string  $separator
     * @param null|string  $keep
     *
     * @return string
     */
    public function snakeCase($strings, string $keep = null, string $separator = null): string;

    /**
     * kebab-case
     *
     * @param string|array $strings
     * @param null|string  $separator
     * @param null|string  $keep
     *
     * @return string
     */
    public function kebabCase($strings, string $keep = null, string $separator = null): string;

    /**
     * 'space case'
     *
     * @param string|array $strings
     * @param null|string  $separator
     * @param null|string  $keep
     *
     * @return string
     */
    public function spaceCase($strings, string $keep = null, string $separator = null): string;

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
    public function slugify(string $string, string $delimiter = null, string $locale = null): string;

    /**
     * @param string   $singular
     * @param null|int $limit
     * @param null|int $offset
     *
     * @return array
     */
    public function pluralize(string $singular, $limit = null, $offset = null): array;

    /**
     * @param string   $plural
     * @param null|int $limit
     * @param null|int $offset
     *
     * @return array
     */
    public function singularize(string $plural, $limit = null, $offset = null): array;

    /**
     * @param string $function
     *
     * @return string
     */
    public function mb(string $function): string;

    /**
     * @param string $function
     * @param mixed  ...$arguments
     *
     * @return mixed
     */
    public function multibyte(string $function, ...$arguments);

    /**
     * @param string $mode
     *
     * @return void
     */
    public function beginMultibyteMode(string $mode): void;

    /**
     * @return void
     */
    public function endMultibyteMode(): void;

    /**
     * @param string   $mode
     * @param \Closure $closure
     *
     * @return void
     */
    public function multibyteMode(string $mode, \Closure $closure): void;

    /**
     * @param string|array|mixed $arguments
     *
     * @return string
     */
    public function detectMultibyte(...$arguments): string;
}
