<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * Str
 */
class Str
{
    const CASE_REPLACER = "\0";

    /** @php internal */
    const MB_CASE_LOWER = MB_CASE_UPPER;
    const MB_CASE_UPPER = MB_CASE_LOWER;

    const THE_MB_CASE_LIST = [
        self::MB_CASE_LOWER => true,
        self::MB_CASE_UPPER => true,
    ];


    /**
     * @var Filter
     */
    protected $filter;


    /**
     * Constructor
     *
     * @param Filter $filter
     */
    public function __construct(
        Filter $filter
    )
    {
        $this->filter = $filter;
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
    public function strpos(string $haystack, string $needle, int $offset = null) : int
    {
        $result = false === ( $pos = mb_strpos($haystack, $needle, $offset) )
            ? -1
            : $pos;

        return $result;
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
    public function strrpos(string $haystack, string $needle, int $offset = null) : int
    {
        $result = false === ( $pos = mb_strrpos($haystack, $needle, $offset) )
            ? -1
            : $pos;

        return $result;
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
    public function stripos(string $haystack, string $needle, int $offset = null) : int
    {
        $result = false === ( $pos = mb_stripos($haystack, $needle, $offset) )
            ? -1
            : $pos;

        return $result;
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
    public function strripos(string $haystack, string $needle, int $offset = null) : int
    {
        $result = false === ( $pos = mb_strripos($haystack, $needle, $offset) )
            ? -1
            : $pos;

        return $result;
    }


    /**
     * фикс. стандартная функция при попытке разбить пустую строку возвращает массив из пустой строки
     *
     * @param string   $string
     * @param null|int $len
     *
     * @return array
     */
    public function split(string $string, int $len = null) : array
    {
        $result = $string !== ''
            ? str_split($string, $len)
            : [];

        return $result;
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
    public function replace($strings, $replacements, $subjects, int $limit = null, int &$count = null) // : string|string[]
    {
        $searchArray = $this->theStrvals($strings);
        $replaceArray = $this->theStrvals($replacements);
        $subjectArray = $this->theStrvals($subjects);

        if ([] === $searchArray) return $subjects;
        if ([] === $replaceArray) return $subjects;
        if ([] === $subjectArray) return $subjects;

        if (null === $limit) {
            $result = ( 5 === func_num_args() )
                ? str_replace($strings, $replacements, $subjects, $count)
                : str_replace($strings, $replacements, $subjects);

        } else {
            $reverse = $limit < 0;

            $count = 0;
            $limit = abs($limit);

            $cntSearch = count($searchArray);
            $cntReplace = count($replaceArray);

            $len = max(0, $cntSearch, $cntReplace);

            for ( $i = 0; $i < $len; $i++ ) {
                $curSearch = $searchArray[ $i ] = $searchArray[ $i ]
                    ?? $searchArray[ 0 ];

                $curReplace = $replaceArray[ $i ] = $replaceArray[ $i ]
                    ?? $replaceArray[ 0 ];

                $lenSearch = mb_strlen($curSearch);

                foreach ( array_keys($subjectArray) as $idx ) {
                    $curLimit = $limit;

                    while ( 0 < $curLimit-- ) {
                        if ($reverse) {
                            if (false !== ( $pos = mb_strrpos($subjectArray[ $idx ], $curSearch) )) {
                                $count++;

                                $subjectArray[ $idx ] = mb_substr($subjectArray[ $idx ], 0, $pos)
                                    . $curReplace
                                    . mb_substr($subjectArray[ $idx ], $pos + $lenSearch);
                            }
                        } else {
                            if (false !== ( $pos = mb_strpos($subjectArray[ $idx ], $curSearch) )) {
                                $count++;

                                $subjectArray[ $idx ] = mb_substr($subjectArray[ $idx ], 0, $pos)
                                    . $curReplace
                                    . mb_substr($subjectArray[ $idx ], $pos + $lenSearch);
                            }
                        }
                    }
                }
            }

            $result = 1 < count($subjectArray)
                ? $subjectArray
                : reset($subjectArray);
        }

        return $result;
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
    public function ireplace($strings, $replacements, $subjects, int $limit = null, int &$count = null) // : string|string[]
    {
        $searchArray = $this->theStrvals($strings);
        $replaceArray = $this->theStrvals($replacements);
        $subjectArray = $this->theStrvals($subjects);

        if ([] === $searchArray) return $subjects;
        if ([] === $replaceArray) return $subjects;
        if ([] === $subjectArray) return $subjects;

        if (null === $limit) {
            $result = ( 5 === func_num_args() )
                ? str_ireplace($strings, $replacements, $subjects, $count)
                : str_ireplace($strings, $replacements, $subjects);

        } else {
            $reverse = $limit < 0;

            $count = 0;
            $limit = abs($limit);

            $cntSearch = count($searchArray);
            $cntReplace = count($replaceArray);

            $len = max(0, $cntSearch, $cntReplace);

            for ( $i = 0; $i < $len; $i++ ) {
                $curSearch = $searchArray[ $i ] = $searchArray[ $i ]
                    ?? $searchArray[ 0 ];

                $curReplace = $replaceArray[ $i ] = $replaceArray[ $i ]
                    ?? $replaceArray[ 0 ];

                $lenSearch = mb_strlen($curSearch);

                foreach ( array_keys($subjectArray) as $idx ) {
                    $curLimit = $limit;

                    while ( 0 < $curLimit-- ) {
                        if ($reverse) {
                            if (false !== ( $pos = mb_strripos($subjectArray[ $idx ], $curSearch) )) {
                                $count++;

                                $subjectArray[ $idx ] = mb_substr($subjectArray[ $idx ], 0, $pos)
                                    . $curReplace
                                    . mb_substr($subjectArray[ $idx ], $pos + $lenSearch);
                            }
                        } else {
                            if (false !== ( $pos = mb_stripos($subjectArray[ $idx ], $curSearch) )) {
                                $count++;

                                $subjectArray[ $idx ] = mb_substr($subjectArray[ $idx ], 0, $pos)
                                    . $curReplace
                                    . mb_substr($subjectArray[ $idx ], $pos + $lenSearch);
                            }
                        }
                    }
                }
            }

            $result = 1 < count($subjectArray)
                ? $subjectArray
                : reset($subjectArray);
        }

        return $result;
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
    public function lcrop(string $haystack, string $needle, bool $ignoreCase = null, int $limit = -1) : string
    {
        $ignoreCase = $ignoreCase ?? true;

        if ('' === $haystack) return $haystack;
        if ('' === $needle) return $haystack;

        $result = $haystack;

        $pos = $ignoreCase
            ? mb_stripos($result, $needle)
            : mb_strpos($result, $needle);

        while ( $pos === 0 ) {
            if (! $limit--) {
                break;
            }

            $result = mb_substr($result, mb_strlen($needle));

            $pos = $ignoreCase
                ? mb_stripos($result, $needle)
                : mb_strpos($result, $needle);
        }

        return $result;
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
    public function rcrop(string $haystack, string $needle, bool $ignoreCase = null, int $limit = -1) : string
    {
        $ignoreCase = $ignoreCase ?? true;

        if ('' === $haystack) return $haystack;
        if ('' === $needle) return $haystack;

        $result = $haystack;

        $pos = $ignoreCase
            ? mb_strripos($result, $needle)
            : mb_strrpos($result, $needle);

        while ( $pos === ( mb_strlen($result) - mb_strlen($needle) ) ) {
            if (! $limit--) {
                break;
            }

            $result = mb_substr($result, 0, $pos);

            $pos = $ignoreCase
                ? mb_strripos($result, $needle)
                : mb_strrpos($result, $needle);
        }

        return $result;
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
    public function crop(string $haystack, $needles, bool $ignoreCase = null, int $limit = -1) : string
    {
        $needles = is_array($needles)
            ? $needles
            : [ $needles ];

        $needleLcrop = array_shift($needles);
        $needleRcrop = null !== key($needles)
            ? current($needles)
            : $needleLcrop;

        $result = $haystack;
        $result = $this->lcrop($result, $needleLcrop, $ignoreCase, $limit);
        $result = $this->rcrop($result, $needleRcrop, $ignoreCase, $limit);

        return $result;
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
    public function starts(string $haystack, string $needle, bool $ignoreCase = null) : ?string
    {
        $ignoreCase = $ignoreCase ?? true;

        if ('' === $haystack) return null;
        if ('' === $needle) return $haystack;

        $pos = $ignoreCase
            ? mb_stripos($haystack, $needle)
            : mb_strpos($haystack, $needle);

        $result = 0 === $pos
            ? mb_substr($haystack, mb_strlen($needle))
            : null;

        return $result;
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
    public function ends(string $haystack, string $needle, bool $ignoreCase = null) : ?string
    {
        $ignoreCase = $ignoreCase ?? true;

        if ('' === $haystack) return null;
        if ('' === $needle) return $haystack;

        $pos = $ignoreCase
            ? mb_strripos($haystack, $needle)
            : mb_strrpos($haystack, $needle);

        $result = $pos === mb_strlen($haystack) - mb_strlen($needle)
            ? mb_substr($haystack, 0, $pos)
            : null;

        return $result;
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
    public function contains(string $haystack, string $needle, bool $ignoreCase = null, int $limit = null) : array
    {
        $ignoreCase = $ignoreCase ?? true;

        if ('' === $haystack) return [];
        if ('' === $needle) return [ $haystack ];

        $limit = null !== $limit
            ? max(0, $limit)
            : null;

        $strCase = $ignoreCase
            ? str_ireplace($needle, $needle, $haystack)
            : $haystack;

        $result = [];

        if (false !== mb_strpos($haystack, $needle)) {
            $result = null
                ?? ( '' === $needle ? [ $haystack ] : null )
                ?? ( $limit ? explode($needle, $strCase, $limit) : null )
                ?? ( explode($needle, $strCase) );
        }

        return $result;
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
    public function lwrap(string $str, string $wrapper = null, int $len = null) : string
    {
        $wrapper = $wrapper ?? '';
        $len = $len ?? 1;

        if ('' === $wrapper) return $str;

        $len = max(0, $len);

        $result = str_repeat($wrapper, $len) . $str;

        return $result;
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
    public function rwrap(string $str, string $wrapper = null, int $len = null) : string
    {
        $wrapper = $wrapper ?? '';
        $len = $len ?? 1;

        if ('' === $wrapper) return $str;

        $len = max(0, $len);

        $result = $str . str_repeat($wrapper, $len);

        return $result;
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
    public function wrap(string $str, $wrappers, int $len = null) : string
    {
        $wraps = is_array($wrappers)
            ? $wrappers
            : [ $wrappers ];

        $lwrap = array_shift($wraps);
        $rwrap = null !== key($wraps)
            ? current($wraps)
            : $lwrap;

        $result = $str;
        $result = $this->lwrap($result, $lwrap, $len);
        $result = $this->rwrap($result, $rwrap, $len);

        return $result;
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
    public function prepend(string $str, string $prepend, bool $ignoreCase = null) : string
    {
        $ignoreCase = $ignoreCase ?? true;

        if ('' === $prepend) return $str;

        $fn = $ignoreCase
            ? 'mb_stripos'
            : 'mb_strpos';

        $result = 0 === call_user_func($fn, $str, $prepend)
            ? $str
            : $prepend . $str;

        return $result;
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
    public function append(string $str, string $append, bool $ignoreCase = null) : string
    {
        $ignoreCase = $ignoreCase ?? true;

        if ('' === $append) return $str;

        $func = $ignoreCase
            ? 'mb_strripos'
            : 'mb_strrpos';

        $result = ( ( mb_strlen($str) - mb_strlen($append) ) === call_user_func($func, $str, $append) )
            ? $str
            : $str . $append;

        return $result;
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
    public function overlay(string $str, $overlays, bool $ignoreCase = null) : string
    {
        $overlays = is_array($overlays)
            ? $overlays
            : [ $overlays ];

        $overlayPrepend = array_shift($overlays);
        $overlayAppend = null !== key($overlays)
            ? current($overlays)
            : $overlayPrepend;

        $result = $str;
        $result = $this->prepend($result, $overlayPrepend, $ignoreCase);
        $result = $this->append($result, $overlayAppend, $ignoreCase);

        return $result;
    }


    /**
     * @param string|string[]|array $delimiters
     * @param string|string[]|array ...$strings
     *
     * @return array
     */
    public function explode($delimiters, ...$strings) : array
    {
        $delimiters = $this->theStrvals($delimiters, true);

        $key = key($delimiters);
        do {
            $delimiter = ( null !== $key )
                ? array_shift($delimiters)
                : null;

            array_walk_recursive($strings, function (&$ref) use ($delimiter) {
                if (null === $this->filter->filterStrval($ref)) {
                    throw new InvalidArgumentException(
                        [ 'Each value should be stringable: %s', $ref ],
                    );
                }

                if ($split = $this->contains($ref, $delimiter, null, false)) {
                    $ref = $split;
                }
            });
        } while ( null !== ( $key = key($delimiters) ) );

        $result = [];
        array_walk_recursive($strings, function ($v) use (&$result) {
            $result[] = $v;
        });

        return $result;
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
    public function separate($delimiters, string $string, int $limit = null) : array
    {
        $results = [];
        $results[] = $string;

        $delimiters = $this->theStrvals($delimiters, true);

        foreach ( $delimiters as $delimiter ) {
            array_walk_recursive($results, function (string &$ref) use ($delimiter, $limit) {
                if ('' === $delimiter) {
                    $ref = [ $ref ];

                } elseif ($split = $this->contains($ref, $delimiter, $limit, false)) {
                    $ref = $split;

                }
            });
        }

        $result = null !== key($results)
            ? reset($results)
            : [];

        return $result;
    }


    /**
     * '1, 2, 3', включая пустые строки, исключение если нельзя привести к строке
     *
     * @param string                $delimiter
     * @param string|string[]|array ...$strings
     *
     * @return string
     */
    public function implode(string $delimiter, ...$strings) : string
    {
        $result = $this->theStrvals($strings);

        if ('' !== $delimiter) {
            foreach ( $result as $idx => $val ) {
                $result[ $idx ] = trim($val, $delimiter);
            }
        }

        $result = implode($delimiter, $result);

        return $result;
    }

    /**
     * '1, 2, 3', включая пустые строки, пропускает если нельзя привести к строке
     *
     * @param string                $delimiter
     * @param string|string[]|array ...$strings
     *
     * @return string
     */
    public function implodeSkip(string $delimiter, ...$strings) : string
    {
        $result = $this->strvals($strings);

        if ('' !== $delimiter) {
            foreach ( $result as $idx => $val ) {
                $result[ $idx ] = trim($val, $delimiter);

                if ('' === $result[ $idx ]) {
                    unset($result[ $idx ]);
                }
            }
        }

        $result = implode($delimiter, $result);

        return $result;
    }


    /**
     * '1, 2, 3', пропускает пустые строки, исключение если нельзя привести к строке
     *
     * @param string                $delimiter
     * @param string|string[]|array ...$strings
     *
     * @return string
     */
    public function join(string $delimiter, ...$strings) : string
    {
        $result = $this->theStrvals($strings);
        $result = array_filter($result, 'strlen');

        if ('' !== $delimiter) {
            foreach ( $result as $idx => $val ) {
                $result[ $idx ] = trim($val, $delimiter);
            }
        }

        $result = implode($delimiter, $result);

        return $result;
    }

    /**
     * '1, 2, 3', пропускает пустые строки, пропускает если нельзя привести к строке
     *
     * @param string                $delimiter
     * @param string|string[]|array ...$strings
     *
     * @return string
     */
    public function joinSkip(string $delimiter, ...$strings) : string
    {
        $result = $this->strvals($strings);
        $result = array_filter($result, 'strlen');

        if ('' !== $delimiter) {
            foreach ( $result as $idx => $val ) {
                $result[ $idx ] = trim($val, $delimiter);

                if ('' === $result[ $idx ]) {
                    unset($result[ $idx ]);
                }
            }
        }

        $result = implode($delimiter, $result);

        return $result;
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
    public function concat(
        $strings,
        string $delimiter = null,
        string $lastDelimiter = null,
        string $wrapper = null
    ) : string
    {
        $delimiter = $delimiter ?? '';
        $lastDelimiter = $lastDelimiter ?? $delimiter;
        $wrapper = $wrapper ?? '';

        $result = $this->theWordvals($strings);
        $result = array_filter($result, 'strlen');

        $last = null;
        if (null !== $lastDelimiter) {
            $last = $wrapper . array_pop($result) . $wrapper;
        }

        foreach ( $result as $idx => $strval ) {
            $result[ $idx ] = $wrapper . $strval . $wrapper;
        }

        $result = implode($delimiter, $result);

        if (null !== $last) {
            $result = $result . $lastDelimiter . $last;
        }

        return $result;
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
    public function concatSkip(
        array $strings,
        string $delimiter = null,
        string $lastDelimiter = null,
        string $wrapper = null
    ) : string
    {
        $delimiter = $delimiter ?? '';
        $lastDelimiter = $lastDelimiter ?? $delimiter;
        $wrapper = $wrapper ?? '';

        $result = $this->wordvals($strings);
        $result = array_filter($result, 'strlen');

        $last = null;
        if (null !== $lastDelimiter) {
            $last = $wrapper . array_pop($result) . $wrapper;
        }

        foreach ( $result as $idx => $strval ) {
            $result[ $idx ] = $wrapper . $strval . $wrapper;
        }

        $result = implode($delimiter, $result);

        if (null !== $last) {
            $result = $result . $lastDelimiter . $last;
        }

        return $result;
    }



    /**
     * урезает английское слово(-а) до префикса из нескольких букв - когда имя индекса в бд слишком длинное
     *
     * @param string   $string
     * @param null|int $len
     *
     * @return string
     */
    public function prefix(string $string, int $len = null) : string
    {
        if ('' === $string) return '';

        $len = $len ?? 3;
        $len = max(0, $len);

        $source = preg_replace('/[\p{C}\p{P}\p{S}\p{Z}]/', '', $string);
        $sourceLetters = mb_str_split($source);

        $len = min($len, count($sourceLetters));

        if (0 === $len) return '';

        $vowels = $this->vowels();

        $sourceConsonants = [];
        $sourceVowels = [];
        foreach ( $sourceLetters as $i => $letter ) {
            ( '' === trim($letter, $vowels) )
                ? ( $sourceVowels[ $i ] = $letter )
                : ( $sourceConsonants[] = $letter );
        }

        $letters = [];

        $hasVowel = false;
        $left = $len;
        for ( $i = 0; $i < $len; $i++ ) {
            $letter = null;
            if (isset($sourceVowels[ $i ])) {
                if (! $hasVowel) {
                    $letter = $sourceVowels[ $i ];
                    $hasVowel = true;

                } elseif ($left > count($sourceConsonants)) {
                    $letter = $sourceVowels[ $i ];
                }
            }

            $letter = $letter ?? array_shift($sourceConsonants);
            $left--;

            $letters[] = $letter;
        }

        $result = implode('', $letters);

        return $result;
    }

    /**
     * применяет prefix() ко всем строкам, затем соединяет результаты, чтобы урезать итоговый размер строки
     *
     * @param string|string[]|array      $strings
     * @param null|string|string[]|array $delimiters
     * @param null|int                   $limit
     *
     * @return string
     */
    public function compact($strings, $delimiters = null, int $limit = null) : string
    {
        $list = $this->strvals($strings);
        $list = array_filter($list, 'strlen');

        if (null !== $delimiters) {
            $list = $this->explode($delimiters, $list);
        }

        $result = [];
        foreach ( $list as $string ) {
            $result[] = $this->prefix($string, $limit);
        }

        $result = implode('', $result);

        return $result;
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
    public function match(string $start, string $end, string $haystack,
        int $offset = null,
        bool $ignoreCase = null
    ) : array
    {
        $offset = $offset ?? 0;
        $ignoreCase = $ignoreCase ?? true;

        $flags = 'u';
        $flags .= $ignoreCase ? 'i' : '';

        $isMatch = preg_match_all('/'
            . preg_quote($start, '/')
            . '(.*?)'
            . preg_quote($end, '/')
            . '/' . $flags,
            $haystack,
            $result
        );

        if (false === $isMatch) {
            $result = [];

        } else {
            $result = $result[ 1 ] ?? [];

            if ($offset) {
                array_splice($result, $offset);
            }
        }

        return $result;
    }


    /**
     * snake_case
     *
     * @param string $value
     * @param string $delimiter
     *
     * @return string
     */
    public function snake(string $value, string $delimiter = '_') : string
    {
        $result = $this->case($value, $delimiter);

        return $result;
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
    public function usnake(string $value, string $delimiter = '_') : string
    {
        $result = $this->case($value, $delimiter, MB_CASE_UPPER);

        return $result;
    }


    /**
     * kebab-case
     *
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
     * Ukebab-Case
     *
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
     * camelCase
     *
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
     * PascalCase
     *
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
     * @param mixed $value
     *
     * @return null|string
     */
    public function strval($value) : ?string
    {
        if (null === $this->filter->filterStrval($value)) {
            return null;
        }

        $result = strval($value);

        return $result;
    }

    /**
     * @param mixed $value
     *
     * @return null|string
     */
    public function wordval($value) : ?string
    {
        if (null === $this->filter->filterWordval($value)) {
            return null;
        }

        $result = strval($value);

        return $result;
    }


    /**
     * @param mixed $value
     *
     * @return string
     */
    public function theStrval($value) : string
    {
        if (null === ( $strval = $this->strval($value) )) {
            throw new InvalidArgumentException(
                [ 'Value should be convertable to strval: %s', $value ],
            );
        }

        return $strval;
    }

    /**
     * @param mixed $value
     *
     * @return string
     */
    public function theWordval($value) : string
    {
        if (null === ( $wordval = $this->wordval($value) )) {
            throw new InvalidArgumentException(
                [ 'Value should be convertable to wordval: %s', $value ],
            );
        }

        return $wordval;
    }


    /**
     * @param string|string[]|array $strings
     * @param null|bool             $uniq
     *
     * @return string[]
     */
    public function strvals($strings, $uniq = null) : array
    {
        $result = [];

        $strings = is_array($strings)
            ? $strings
            : [ $strings ];

        array_walk_recursive($strings, function ($string) use (&$result) {
            if (null !== ( $strval = $this->strval($string) )) {
                $result[] = $strval;
            }
        });

        if ($uniq ?? false) {
            $arr = [];
            foreach ( $result as $i ) {
                $arr[ $i ] = true;
            }
            $result = array_keys($arr);
        }

        return $result;
    }

    /**
     * @param string|string[]|array $words
     * @param null|bool             $uniq
     *
     * @return string[]
     */
    public function wordvals($words, $uniq = null) : array
    {
        $result = [];

        $words = is_array($words)
            ? $words
            : [ $words ];

        array_walk_recursive($words, function ($word) use (&$result) {
            if (null !== ( $wordval = $this->wordval($word) )) {
                $result[] = $wordval;
            }
        });

        if ($uniq ?? false) {
            $arr = [];
            foreach ( $result as $i ) {
                $arr[ $i ] = true;
            }
            $result = array_keys($arr);
        }

        return $result;
    }


    /**
     * @param string|string[]|array $strings
     * @param null|bool             $uniq
     *
     * @return string[]
     */
    public function theStrvals($strings, $uniq = null) : array
    {
        $result = [];

        $strings = is_array($strings)
            ? $strings
            : [ $strings ];

        array_walk_recursive($strings, function ($string) use (&$result) {
            $result[] = $this->theStrval($string);
        });

        if ($uniq ?? false) {
            $arr = [];
            foreach ( $result as $i ) {
                $arr[ $i ] = true;
            }
            $result = array_keys($arr);
        }

        return $result;
    }

    /**
     * @param string|string[]|array $words
     * @param null|bool             $uniq
     *
     * @return string[]
     */
    public function theWordvals($words, $uniq = null) : array
    {
        $result = [];

        $words = is_array($words)
            ? $words
            : [ $words ];

        array_walk_recursive($words, function ($word) use (&$result) {
            $result[] = $this->theWordval($word);
        });

        if ($uniq ?? false) {
            $arr = [];
            foreach ( $result as $i ) {
                $arr[ $i ] = true;
            }
            $result = array_keys($arr);
        }

        return $result;
    }


    /**
     * @param string     $value
     * @param string     $delimiter
     * @param string|int $mbCase
     *
     * @return string
     */
    protected function case(string $value, string $delimiter = '_', string $mbCase = MB_CASE_LOWER) : string
    {
        if ('' === $value) {
            return $value;
        }

        if (! isset(static::THE_MB_CASE_LIST[ $mbCase ])) {
            throw new InvalidArgumentException('Unknown MbCase passed', $mbCase);
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
        $right = preg_replace_callback('/[\s' . $regexDelimiters . ']+(\p{L})/',
            function ($m) use ($mbCase) {
                return static::CASE_REPLACER . mb_convert_case($m[ 1 ], $mbCase, 'UTF-8');
            },
            $right
        );

        $result = mb_convert_case($left, $mbCase, 'UTF-8') . $right;

        $result = str_replace(array_keys($replacements), '', $result);
        $result = str_replace(static::CASE_REPLACER, $delimiter, $result);

        return $result;
    }


    /**
     * @return string
     */
    protected function vowels() : string
    {
        $vowels = [];

        // latin
        $vowels[ 'a' ] = 'aàáâãāăȧäảåǎȁąạḁẚầấẫẩằắẵẳǡǟǻậặæǽǣ';
        $vowels[ 'e' ] = 'eèéêẽēĕėëẻěȅȇẹȩęḙḛềếễểḕḗệḝ';
        $vowels[ 'i' ] = 'iìíîĩīĭıïỉǐịįȉȋḭḯ';
        $vowels[ 'o' ] = 'oòóôõōŏȯöỏőǒȍȏơǫọøồốỗổȱȫȭṍṏṑṓờớỡởợǭộǿœ';
        $vowels[ 'u' ] = 'uùúûũūŭüủůűǔȕȗưụṳųṷṵṹṻǖǜǘǖǚừứữửự';
        $vowels[ 'A' ] = 'AÀÁÂÃĀĂȦÄẢÅǍȀȂĄẠḀẦẤẪẨẰẮẴẲǠǞǺẬẶÆǼǢ';
        $vowels[ 'E' ] = 'EÈÉÊẼĒĔĖËẺĚȄȆẸȨĘḘḚỀẾỄỂḔḖỆḜ';
        $vowels[ 'I' ] = 'IÌÍÎĨĪĬİÏỈǏỊĮȈȊḬḮ';
        $vowels[ 'O' ] = 'OÒÓÔÕŌŎȮÖỎŐǑȌȎƠǪỌØỒỐỖỔȰȪȬṌṐṒỜỚỠỞỢǬỘǾŒ';
        $vowels[ 'U' ] = 'UÙÚÛŨŪŬÜỦŮŰǓȔȖƯỤṲŲṶṴṸṺǛǗǕǙỪỨỮỬỰ';

        // ru
        $vowels[ 'a' ] .= 'ая';
        $vowels[ 'e' ] .= 'её';
        $vowels[ 'i' ] .= 'иы';
        $vowels[ 'o' ] .= 'о';
        $vowels[ 'u' ] .= 'ую';
        $vowels[ 'A' ] .= 'АЯ';
        $vowels[ 'E' ] .= 'ЕЁ';
        $vowels[ 'I' ] .= 'ИЫ';
        $vowels[ 'O' ] .= 'О';
        $vowels[ 'U' ] .= 'УЮ';

        // ua
        $vowels[ 'e' ] .= 'є';
        $vowels[ 'i' ] .= 'ії';
        $vowels[ 'E' ] .= 'Є';
        $vowels[ 'I' ] .= 'ІЇ';

        // by
        $vowels[ 'u' ] .= 'ў';
        $vowels[ 'U' ] .= 'Ў';

        $vowels = implode('', $vowels);

        return $vowels;
    }
}
