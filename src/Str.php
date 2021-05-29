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
    public function strpos($haystack, $needle, $offset) : int
    {
        $result = false === ( $pos = mb_strpos($haystack, $needle, $offset) )
            ? -1
            : $pos;

        return $result;
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
    public function strrpos($haystack, $needle, $offset) : int
    {
        $result = false === ( $pos = mb_strrpos($haystack, $needle, $offset) )
            ? -1
            : $pos;

        return $result;
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
    public function stripos($haystack, $needle, $offset) : int
    {
        $result = false === ( $pos = mb_stripos($haystack, $needle, $offset) )
            ? -1
            : $pos;

        return $result;
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
    public function strripos($haystack, $needle, $offset) : int
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
     * @param string|string[] $search
     * @param string|string[] $replace
     * @param string|string[] $subject
     * @param null|int        $limit
     * @param null|int        $count
     *
     * @return string|string[]
     */
    public function replace($search, $replace, $subject, int $limit = null, int &$count = null) // : string|string[]
    {
        $searchArray = $this->strvals($search);
        $replaceArray = $this->strvals($replace);
        $subjectArray = $this->strvals($subject);

        if ([] === $searchArray) return $subject;
        if ([] === $replaceArray) return $subject;
        if ([] === $subjectArray) return $subject;

        if (null === $limit) {
            $result = ( 5 === func_num_args() )
                ? str_replace($search, $replace, $subject, $count)
                : str_replace($search, $replace, $subject);

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
     * @param string|string[] $search
     * @param string|string[] $replace
     * @param string|string[] $subject
     * @param null|int        $limit
     * @param null|int        $count
     *
     * @return string|string[]
     */
    public function ireplace($search, $replace, $subject, int $limit = null, int &$count = null) // : string|string[]
    {
        $searchArray = $this->strvals($search);
        $replaceArray = $this->strvals($replace);
        $subjectArray = $this->strvals($subject);

        if ([] === $searchArray) return $subject;
        if ([] === $replaceArray) return $subject;
        if ([] === $subjectArray) return $subject;

        if (null === $limit) {
            $result = ( 5 === func_num_args() )
                ? str_ireplace($search, $replace, $subject, $count)
                : str_ireplace($search, $replace, $subject);

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
     * если строка начинается на искомую, отрезает ее и возвращает укороченную
     * if (null !== ($substr = $str->ends('hello', 'h'))) {} // 'ello'
     *
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
            ? mb_stripos($str, $needle)
            : mb_strpos($str, $needle);

        $result = 0 === $pos
            ? mb_substr($str, mb_strlen($needle))
            : null;

        return $result;
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
    public function ends(string $str, string $needle = null, bool $ignoreCase = true) : ?string
    {
        $needle = $needle ?? '';

        if ('' === $str) return null;
        if ('' === $needle) return $str;

        $pos = $ignoreCase
            ? mb_strripos($str, $needle)
            : mb_strrpos($str, $needle);

        $result = $pos === mb_strlen($str) - mb_strlen($needle)
            ? mb_substr($str, 0, $pos)
            : null;

        return $result;
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
    public function contains(string $str, string $needle = null, int $limit = null, bool $ignoreCase = true) : array
    {
        $needle = $needle ?? '';

        if ('' === $str) return [];
        if ('' === $needle) return [ $str ];

        $limit = null !== $limit
            ? max(0, $limit)
            : null;

        $strCase = $ignoreCase
            ? str_ireplace($needle, $needle, $str)
            : $str;

        $result = [];

        if (false !== ( $pos = mb_strpos($str, $needle) )) {
            $result = null
                ?? ( '' === $needle ? [ $str ] : null )
                ?? ( $limit ? explode($needle, $strCase, $limit) : null )
                ?? ( explode($needle, $strCase) );
        }

        return $result;
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
    public function match(string $start, string $end, string $haystack,
        int $offset = null,
        bool $ignoreCase = true
    ) : array
    {
        $offset = $offset ?? 0;

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
     * Adds some string(-s) to start
     *
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

        $result = str_repeat($sym, $len) . $str;

        return $result;
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
    public function rwrap(string $str, string $sym = null, $len = 1) : string
    {
        $sym = $sym ?? '';

        if ('' === $sym) return $str;

        $len = max(0, intval($len));

        $result = $str . str_repeat($sym, $len);

        return $result;
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
    public function wrap(string $str, string $sym = null, $len = 1) : string
    {
        $sym = $sym ?? '';

        if ('' === $sym) return $str;

        $len = max(0, intval($len));

        $result = str_repeat($sym, $len) . $str . str_repeat($sym, $len);

        return $result;
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
    public function prepend(string $str, string $needle = null, bool $ignoreCase = true) : string
    {
        $needle = $needle ?? '';

        if ('' === $needle) return $str;

        $fn = $ignoreCase
            ? 'mb_stripos'
            : 'mb_strpos';

        $result = 0 === call_user_func($fn, $str, $needle)
            ? $str
            : $needle . $str;

        return $result;
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
    public function append(string $str, string $needle = null, bool $ignoreCase = true) : string
    {
        $needle = $needle ?? '';

        if ('' === $needle) return $str;

        $func = $ignoreCase
            ? 'mb_strripos'
            : 'mb_strrpos';

        $result = ( ( mb_strlen($str) - mb_strlen($needle) ) === call_user_func($func, $str, $needle) )
            ? $str
            : $str . $needle;

        return $result;
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
    public function uncrop(string $str, string $needle = null, bool $ignoreCase = true) : string
    {
        $prepend = $this->prepend($str, $needle, $ignoreCase);

        $result = $this->append($prepend, $needle, $ignoreCase);

        return $result;
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

        $result = $str;

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

        $result = $str;

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
     * @param string      $str
     * @param string|null $needle
     * @param bool|null   $ignoreCase
     * @param int         $limit
     *
     * @return string
     */
    public function crop(string $str, string $needle = null, bool $ignoreCase = null, int $limit = -1) : string
    {
        $lcrop = $this->lcrop($str, $needle, $ignoreCase, $limit);

        $result = $this->rcrop($lcrop, $needle, $ignoreCase, $limit);

        return $result;
    }


    /**
     * @param string   $needle
     * @param null|int $maxlen
     *
     * @return string
     */
    public function prefix($needle, int $maxlen = null) : string
    {
        if (null === $this->filter->filterStrval($needle)) {
            throw new InvalidArgumentException(
                [ 'Needle should be stringable: %s', $needle ]
            );
        }

        $needle = strval($needle);
        $maxlen = max(0, $maxlen ?? 3);

        if ('' === $needle) return '';
        if (0 === $maxlen) return '';

        if (! preg_match('/[a-zıəöü]/iu', $needle)) {
            throw new InvalidArgumentException(
                [ 'Needle could be UTF-8 but only english/ANSI letters allowed: %s' ]
            );
        }

        $lenTotal = min($maxlen, mb_strlen($needle));

        $needleLower = mb_strtolower($needle);

        $result[] = $needleLower[ 0 ];
        $needleLower = mb_substr($needle, 1);
        $lenTotal--;

        $needleNoVowels = preg_replace('/[aeiouıəöü]/iu', '', $needleLower);

        $source = ( mb_strlen($needleNoVowels) >= $lenTotal )
            ? $needleNoVowels
            : $needleLower;

        for ( $i = 0; $i < $lenTotal; $i++ ) {
            $result[ $i + 1 ] = $source[ 0 ];

            $source = mb_substr($source, 1);
        }

        $result = implode('', $result);

        return $result;
    }


    /**
     * @param string|string[]|array $delimiters
     * @param string|string[]|array ...$strvals
     *
     * @return array
     */
    public function explode($delimiters, ...$strvals) : array
    {
        $delimiters = $this->theStrvals($delimiters, true);

        $key = key($delimiters);
        do {
            $delimiter = ( null !== $key )
                ? array_shift($delimiters)
                : null;

            array_walk_recursive($strvals, function (&$ref) use ($delimiter) {
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
        array_walk_recursive($strvals, function ($v) use (&$result) {
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
     * @param string|string[]|array ...$strvals
     *
     * @return string
     */
    public function implode(string $delimiter, ...$strvals) : string
    {
        $result = $this->strvals($strvals);

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
     * @param string|string[]|array ...$strvals
     *
     * @return string
     */
    public function implodeskip(string $delimiter, ...$strvals) : string
    {
        $result = $this->strvalsSkip($strvals);

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
     * @param string|string[]|array ...$strvals
     *
     * @return string
     */
    public function join(string $delimiter, ...$strvals) : string
    {
        $result = $this->strvals($strvals);
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
     * @param string|string[]|array ...$strvals
     *
     * @return string
     */
    public function joinskip(string $delimiter, ...$strvals) : string
    {
        $result = $this->strvalsSkip($strvals);
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

        $result = $this->wordvals($strings);

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
    public function concatskip(
        array $strings,
        string $delimiter = null,
        string $lastDelimiter = null,
        string $wrapper = null
    ) : string
    {
        $delimiter = $delimiter ?? '';
        $lastDelimiter = $lastDelimiter ?? $delimiter;
        $wrapper = $wrapper ?? '';

        $result = $this->wordvalsSkip($strings);

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
     * snake_case
     *
     * @param string $value
     * @param string $delimiter
     *
     * @return string
     */
    public function snake(string $value, string $delimiter = '_') : string
    {
        $result = $this->caseChange($value, $delimiter);

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
        $result = $this->caseChange($value, $delimiter, MB_CASE_UPPER);

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
     * @param string|string[]|array $strings
     * @param null|bool             $uniq
     * @param null|string|array     $message
     * @param mixed                 ...$arguments
     *
     * @return string[]
     */
    public function strvals($strings, $uniq = null, $message = null, ...$arguments) : array
    {
        $result = [];

        $strings = is_array($strings)
            ? $strings
            : [ $strings ];

        if ($hasMessage = (null !== $message)) {
            $this->filter->assert($message, ...$arguments);
        }

        array_walk_recursive($strings, function ($string) use (&$result) {
            if (null === ( $strval = $this->strval($string) )) {
                throw new InvalidArgumentException($this->filter->assert()->flushMessage($string)
                    ?? [ 'Each item should be stringable: %s', $string ],
                );
            }

            $result[] = $strval;
        });

        if ($hasMessage) {
            $this->filter->assert()->flushMessage();
        }

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
     * @param null|string|array     $message
     * @param mixed                 ...$arguments
     *
     * @return string[]
     */
    public function theStrvals($strings, $uniq = null, $message = null, ...$arguments) : array
    {
        $result = $this->strvals($strings, $uniq, $message, ...$arguments);

        if (! count($result)) {
            throw new InvalidArgumentException(
                [ 'At least one string should be provided: %s', $strings ],
            );
        }

        return $result;
    }

    /**
     * @param string|string[]|array $strings
     * @param null|bool             $uniq
     *
     * @return string[]
     */
    public function strvalsSkip($strings, $uniq = null) : array
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
     * @param string|string[]|array $strings
     * @param null|bool             $uniq
     *
     * @return string[]
     */
    public function theStrvalsSkip($strings, $uniq = null) : array
    {
        $result = $this->strvalsSkip($strings, $uniq);

        if (! count($result)) {
            throw new InvalidArgumentException(
                [ 'At least one string should be provided: %s', $strings ],
            );
        }

        return $result;
    }


    /**
     * @param string|string[]|array $words
     * @param null|bool             $uniq
     * @param null|string|array     $message
     * @param mixed                 ...$arguments
     *
     * @return string[]
     */
    public function wordvals($words, $uniq = null, $message = null, ...$arguments) : array
    {
        $result = [];

        $words = is_array($words)
            ? $words
            : [ $words ];

        if ($hasMessage = (null !== $message)) {
            $this->filter->assert($message, ...$arguments);
        }

        array_walk_recursive($words, function ($word) use (&$result) {
            if (null === ( $wordval = $this->wordval($word) )) {
                throw new InvalidArgumentException($this->filter->assert()->flushMessage($word)
                    ?? [ 'Each word should be stringable and not empty: %s', $word ],
                );
            }

            $result[] = $wordval;
        });

        if ($hasMessage) {
            $this->filter->assert()->flushMessage();
        }

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
     * @param null|string|array     $message
     * @param mixed                 ...$arguments
     *
     * @return string[]
     */
    public function theWordvals($words, $uniq = null, $message = null, ...$arguments) : array
    {
        $result = $this->wordvals($words, $uniq, $message, ...$arguments);

        if (! count($result)) {
            throw new InvalidArgumentException(
                [ 'At least one word should be provided: %s', $words ],
            );
        }

        return $result;
    }

    /**
     * @param string|string[]|array $words
     * @param null|bool             $uniq
     *
     * @return string[]
     */
    public function wordvalsSkip($words, $uniq = null) : array
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
     * @param string|string[]|array $words
     * @param null|bool             $uniq
     *
     * @return array
     */
    public function theWordvalsSkip($words, $uniq = null) : array
    {
        $result = $this->wordvalsSkip($words, $uniq);

        if (! count($result)) {
            throw new InvalidArgumentException(
                [ 'At least one word should be provided: %s', $words ],
            );
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
    protected function caseChange(string $value, string $delimiter = '_', string $mbCase = MB_CASE_LOWER) : string
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
}
