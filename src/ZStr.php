<?php
/**
 * @noinspection RedundantSuppression
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support;

use Gzhegow\Support\Domain\Str\Slugger;
use Gzhegow\Support\Domain\Str\Inflector;
use Gzhegow\Support\Domain\Str\SluggerInterface;
use Gzhegow\Support\Domain\Str\InflectorInterface;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * ZStr
 */
class ZStr implements IStr
{
    const CASE_LOWER = MB_CASE_LOWER;
    const CASE_UPPER = MB_CASE_UPPER;

    const INTERNAL_ENCODING = 'UTF-8';

    const REPLACER = "\0";

    const THE_CASE_LIST = [
        self::CASE_LOWER => true,
        self::CASE_UPPER => true,
    ];


    /**
     * @var IFilter
     */
    protected $filter;


    /**
     * @var IPhp
     */
    protected $php;


    /**
     * @var SluggerInterface
     */
    protected $slugger;
    /**
     * @var InflectorInterface
     */
    protected $inflector;


    /**
     * Constructor
     *
     * @param IFilter $filter
     */
    public function __construct(
        IFilter $filter
    )
    {
        $this->filter = $filter;
    }


    /**
     * @return static
     */
    protected function loadInternalEncoding()
    {
        mb_internal_encoding(static::INTERNAL_ENCODING);

        return $this;
    }


    /**
     * @return string
     */
    public function getTrims() : string
    {
        return " \t\n\r\0\x0B";
    }

    /**
     * @return string
     */
    public function getSeparators() : string
    {
        return " \t\r\n\f\v";
    }


    /**
     * @return string
     */
    public function getVowels() : string
    {
        $list = [
            'a' => 'aàáâãāăȧäảåǎȁąạḁẚầấẫẩằắẵẳǡǟǻậặæǽǣая',
            'e' => 'eèéêẽēĕėëẻěȅȇẹȩęḙḛềếễểḕḗệḝеёє',
            'i' => 'iìíîĩīĭïỉǐịįȉȋḭḯиыії',
            'o' => 'oòóôõōŏȯöỏőǒȍȏơǫọøồốỗổȱȫȭṍṏṑṓờớỡởợǭộǿœо',
            'u' => 'uùúûũūŭüủůűǔȕȗưụṳųṷṵṹṻǖǜǘǖǚừứữửựуюў',
        ];

        $vowels = '';
        foreach ( $list as $l ) {
            $vowels .= mb_strtolower($l) . mb_strtoupper($l);
        }

        return $vowels;
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
     * @return null|string
     */
    public function trimval($value) : ?string
    {
        if (null === $this->filter->filterTrimval($value)) {
            return null;
        }

        $result = trim($value);

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
     * @param mixed $value
     *
     * @return string
     */
    public function theTrimval($value) : string
    {
        if (null === ( $trimval = $this->trimval($value) )) {
            throw new InvalidArgumentException(
                [ 'Value should be convertable to trimval: %s', $value ],
            );
        }

        return $trimval;
    }


    /**
     * @param string|array $strings
     * @param null|bool    $uniq
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
     * @param string|array $words
     * @param null|bool    $uniq
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
     * @param string|array $trims
     * @param null|bool    $uniq
     *
     * @return string[]
     */
    public function trimvals($trims, $uniq = null) : array
    {
        $result = [];

        $trims = is_array($trims)
            ? $trims
            : [ $trims ];

        array_walk_recursive($trims, function ($trim) use (&$result) {
            if (null !== ( $trimval = $this->trimval($trim) )) {
                $result[] = $trimval;
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
     * @param string|array $strings
     * @param null|bool    $uniq
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
     * @param string|array $words
     * @param null|bool    $uniq
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
     * @param string|array $trims
     * @param null|bool    $uniq
     *
     * @return string[]
     */
    public function theTrimvals($trims, $uniq = null) : array
    {
        $result = [];

        $trims = is_array($trims)
            ? $trims
            : [ $trims ];

        array_walk_recursive($trims, function ($trim) use (&$result) {
            $result[] = $this->theTrimval($trim);
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
     * @return \Gzhegow\Support\IPhp
     * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
     * @noinspection PhpFullyQualifiedNameUsageInspection
     */
    public function php() : \Gzhegow\Support\IPhp
    {
        if (! isset($this->php)) {
            $this->php = SupportFactory::getInstance()->newPhp();
        }

        return $this->php;
    }


    /**
     * @param null|SluggerInterface $slugger
     *
     * @return SluggerInterface
     */
    public function slugger(SluggerInterface $slugger = null) : SluggerInterface
    {
        if ($slugger) {
            $this->slugger = $slugger;
        }

        if (! $this->slugger) {
            $this->slugger = new Slugger($this, $this->php());
        }

        return $this->slugger;
    }

    /**
     * @param null|InflectorInterface $inflector
     *
     * @return InflectorInterface
     */
    public function inflector(InflectorInterface $inflector = null) : InflectorInterface
    {
        if ($inflector) {
            $this->inflector = $inflector;
        }

        if (! $this->inflector) {
            $this->inflector = new Inflector();
        }

        return $this->inflector;
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
            ? -1 : $pos;

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
            ? -1 : $pos;

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
            ? -1 : $pos;

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
            ? -1 : $pos;

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
        $len = $len ?? 1;

        if ('' === $string) {
            return [];
        }

        if ($len < 1) {
            throw new InvalidArgumentException([ 'Len should integer greater than 0: %s', $len ]);
        }

        $letters = [];

        for ( $i = 0; $i < mb_strlen($string); $i += $len ) {
            $letters[] = mb_substr($string, $i, $len);
        }

        return $letters;
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
     * @param string|null $repeat
     * @param null|int    $len
     *
     * @return string
     */
    public function unltrim(string $str, string $repeat = null, int $len = null) : string
    {
        $repeat = $repeat ?? '';
        $len = $len ?? 1;

        if ('' === $repeat) return $str;

        $len = max(0, $len);

        $result = str_repeat($repeat, $len) . $str;

        return $result;
    }

    /**
     * Добавляет подстроку в конце строки
     *
     * @param string      $str
     * @param string|null $repeat
     * @param null|int    $len
     *
     * @return string
     */
    public function unrtrim(string $str, string $repeat = null, int $len = null) : string
    {
        $repeat = $repeat ?? '';
        $len = $len ?? 1;

        if ('' === $repeat) return $str;

        $len = max(0, $len);

        $result = $str . str_repeat($repeat, $len);

        return $result;
    }

    /**
     * Оборачивает строку в другие, например в кавычки
     *
     * @param string          $str
     * @param string|string[] $repeats
     * @param null|int        $len
     *
     * @return string
     */
    public function untrim(string $str, $repeats, int $len = null) : string
    {
        $wraps = is_array($repeats)
            ? $repeats
            : [ $repeats ];

        $lwrap = array_shift($wraps);
        $rwrap = null !== key($wraps)
            ? current($wraps)
            : $lwrap;

        $result = $str;
        $result = $this->unltrim($result, $lwrap, $len);
        $result = $this->unrtrim($result, $rwrap, $len);

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
     * @param string|string[] $wraps
     * @param bool            $ignoreCase
     *
     * @return string
     */
    public function wrap(string $str, $wraps, bool $ignoreCase = null) : string
    {
        $wraps = is_array($wraps)
            ? $wraps
            : [ $wraps ];

        $overlayPrepend = array_shift($wraps);
        $overlayAppend = null !== key($wraps)
            ? current($wraps)
            : $overlayPrepend;

        $result = $str;
        $result = $this->prepend($result, $overlayPrepend, $ignoreCase);
        $result = $this->append($result, $overlayAppend, $ignoreCase);

        return $result;
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
    public function separate($delimiters, $strings, bool $ignoreCase = null, int $limit = null) : array
    {
        $delimiters = $this->theStrvals($delimiters, true);

        $strings = ( $isArray = is_array($strings) )
            ? $strings
            : [ $strings ];

        foreach ( $delimiters as $delimiter ) {
            array_walk_recursive($strings, function (string &$ref) use ($delimiter, $ignoreCase, $limit) {
                if ($split = $this->contains($ref, $delimiter, $ignoreCase, $limit)) {
                    $ref = $split;

                } else {
                    $ref = [ $ref ];
                }
            });
        }

        $result = $isArray
            ? $strings
            : reset($strings);

        return $result;
    }

    /**
     * @param string|array $delimiters
     * @param string|array $strings
     * @param null|bool    $ignoreCase
     * @param null|int     $limit
     *
     * @return array
     */
    public function explode($delimiters, $strings, bool $ignoreCase = null, int $limit = null) : array
    {
        $segragated = $this->separate($delimiters, $strings, $ignoreCase, $limit);

        $result = [];
        array_walk_recursive($segragated, function ($v) use (&$result) {
            $result[] = $v;
        });

        return $result;
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
    public function partition($delimiters, $strings, bool $ignoreCase = null, int $limit = null) // : string|array
    {
        $delimiters = $this->theStrvals($delimiters, true);

        $strings = ( $isArray = is_array($strings) )
            ? $strings
            : [ $strings ];

        foreach ( $delimiters as $delimiter ) {
            array_walk_recursive($strings, function (string &$ref) use ($delimiter, $ignoreCase, $limit) {
                if ('' !== $delimiter) {
                    if ($split = $this->contains($ref, $delimiter, $ignoreCase, $limit)) {
                        $ref = $split;
                    }
                }
            });
        }

        $result = $isArray
            ? $strings
            : reset($strings);

        return $result;
    }


    /**
     * '1, 2, 3', включая пустые строки, исключение если нельзя привести к строке
     *
     * @param string       $delimiter
     * @param string|array ...$strings
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
     * @param string       $delimiter
     * @param string|array ...$strings
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
     * @param string       $delimiter
     * @param string|array ...$strings
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
     * @param string       $delimiter
     * @param string|array ...$strings
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

        $vowels = $this->getVowels();

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
     * @param string|array      $strings
     * @param null|string|array $delimiters
     * @param null|int          $limit
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
     * PascalCase
     *
     * @param string|array $strings
     * @param null|string  $keep
     * @param null|string  $separator
     *
     * @return string
     */
    public function pascal($strings, string $keep = null, string $separator = null) : string
    {
        $separator = $separator ?? '';

        $result = $this->space($strings, $keep, $separator);

        $result = array_map('ucfirst', explode(' ', $result));
        $result = implode($separator, $result);

        return $result;
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
    public function camel($strings, string $keep = null, string $separator = null) : string
    {
        $result = $this->pascal($strings, $keep, $separator);

        $result = lcfirst($result);

        return $result;
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
    public function snake($strings, string $keep = null, string $separator = null) : string
    {
        $separator = $separator ?? '_';

        $result = $this->space($strings, $keep, $separator);

        $result = array_map('lcfirst', explode(' ', $result));
        $result = implode($separator, $result);

        return $result;
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
    public function kebab($strings, string $keep = null, string $separator = null) : string
    {
        $separator = $separator ?? '-';

        $result = $this->snake($strings, $keep, $separator);

        return $result;
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
    public function space($strings, string $keep = null, string $separator = null) : string
    {
        $separator = $separator ?? '';
        $keep = $keep ?? '';

        if (! $strings = $this->wordvals($strings)) {
            return '';
        }

        $result = trim(implode(' ', $strings));
        if (! strlen($result)) {
            return '';
        }

        $result = preg_replace('/\p{Lu}/', ' $0', lcfirst($result));
        $result = preg_replace('/(?:[^\w' . preg_quote($separator . $keep, '/') . ']|[_])+/', ' ', $result);

        if (strlen($separator)) {
            $result = preg_replace('/[' . $separator . ' ]+/', ' ', $result);
        }

        return $result;
    }


    /**
     * @param string      $string
     * @param null|string $delimiter
     * @param null|string $locale
     *
     * @return string
     */
    public function slug(string $string, string $delimiter = null, string $locale = null) : string
    {
        $result = $this->slugger()->slug($string, $delimiter, $locale);

        $result = strtolower($result);

        return $result;
    }

    /**
     * @param string      $string
     * @param null|string $delimiter
     * @param null|string $locale
     *
     * @return string
     */
    public function slugCase(string $string, string $delimiter = null, string $locale = null) : string
    {
        $result = $this->slugger()->slug($string, $delimiter, $locale);

        return $result;
    }


    /**
     * @param string   $singular
     * @param null|int $limit
     * @param int      $offset
     *
     * @return null|string|array
     */
    public function pluralize(string $singular, $limit = null, $offset = 0) // : ?string|array
    {
        $result = $this->inflector()->pluralize($singular, $limit, $offset);

        return $result;
    }

    /**
     * @param string   $plural
     * @param null|int $limit
     * @param int      $offset
     *
     * @return null|string|array
     */
    public function singularize(string $plural, $limit = null, $offset = 0) // : ?string|array
    {
        $result = $this->inflector()->singularize($plural, $limit, $offset);

        return $result;
    }


    /**
     * @return IStr
     */
    public static function getInstance()
    {
        return SupportFactory::getInstance()->getStr();
    }
}
