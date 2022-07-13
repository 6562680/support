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
    const INTERNAL_ENCODING = 'UTF-8';


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
     * @var array
     */
    protected $cacheCase = [];


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

        $this->loadInternalEncoding();
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
     * @return array
     */
    public function getAccents() : array
    {
        $list = [
            '' => '£',

            'a' => 'àáâãāăȧảǎȁąạḁẚầấẫẩằắẵẳǡǟǻậặǽǣ',
            'A' => 'ÀÁÂÃĀĂȦẢǍȀĄẠḀAʾẦẤẪẨẰẮẴẲǠǞǺẬẶǼǢ',

            'aa' => 'å',
            'Aa' => 'Å',

            'ae' => 'äæ',
            'Ae' => 'ÄÆ',

            'c' => 'çćĉċč',
            'C' => 'ÇĆĈĊČ',

            'd' => 'ďđ',
            'D' => 'ĎĐ',

            'e' => 'èéêẽēĕėëẻěȅȇẹȩęḙḛềếễểḕḗệḝёє',
            'E' => 'ÈÉÊẼĒĔĖËẺĚȄȆẸȨĘḘḚỀẾỄỂḔḖỆḜЁЄ€',

            'g' => 'ĝğġģ',
            'G' => 'ĜĞĠĢ',

            'h' => 'ĥħ',
            'H' => 'ĤĦ',

            'i' => 'ìíîĩīĭïỉǐịįȉȋḭḯї',
            'I' => 'ÌÍÎĨĪĬÏỈǏỊĮȈȊḬḮЇ',

            'ij' => 'ĳ',
            'IJ' => 'Ĳ',

            'j' => 'ĵ',
            'J' => 'Ĵ',

            'k' => 'ķĸ',
            'K' => 'Ķ',

            'l' => 'ĺļľŀł',
            'L' => 'ĹĻĽĿŁ',

            'n' => 'ñńņňŊ',
            'N' => 'ÑŃŅŇŉŋ',

            'o' => 'òóôõōŏȯỏőǒȍȏơǫọøồốỗổȱȫȭṍṏṑṓờớỡởợǭộǿ',
            'O' => 'ÒÓÔÕŌŎȮỎŐǑȌȎƠǪỌØỒỐỖỔȰȪȬṌṎṐṒỜỚỠỞỢǬỘǾ',

            'oe' => 'öœ',
            'Oe' => 'Ö',
            'OE' => 'Œ',

            'r' => 'ŕŗř',
            'R' => 'ŔŖŘ',

            's' => 'śŝşšſ',
            'S' => 'ŚŜŞŠ',

            'ss' => 'ß',

            't' => 'ţťŧ',
            'T' => 'ŢŤŦ',

            'u' => 'ùúûũūŭủůűǔȕȗưụṳųṷṵṹṻǖǜǘǖǚừứữửựў',
            'U' => 'ÙÚÛŨŪŬỦŮŰǓȔȖƯỤṲŲṶṴṸṺǕǛǗǕǙỪỨỮỬỰЎ',

            'ue' => 'ü',
            'Ue' => 'Ü',

            'w' => 'ŵ',
            'W' => 'Ŵ',

            'y' => 'ýÿŷ',
            'Y' => 'ÝŶŸ',

            'z' => 'źżž',
            'Z' => 'ŹŻŽ',
        ];

        return $list;
    }

    /**
     * @return array
     */
    public function getVowels() : array
    {
        $list = [
            'a' => 'aàáâãāăȧäảåǎȁąạḁẚầấẫẩằắẵẳǡǟǻậặæǽǣая',
            'A' => 'AÀÁÂÃĀĂȦÄẢÅǍȀĄẠḀAʾẦẤẪẨẰẮẴẲǠǞǺẬẶÆǼǢАЯ',

            'e' => 'eèéêẽēĕėëẻěȅȇẹȩęḙḛềếễểḕḗệḝеёє',
            'E' => 'EÈÉÊẼĒĔĖËẺĚȄȆẸȨĘḘḚỀẾỄỂḔḖỆḜЕЁЄ€',

            'i' => 'iìíîĩīĭïỉǐịįȉȋḭḯиыії',
            'I' => 'IÌÍÎĨĪĬÏỈǏỊĮȈȊḬḮИЫІЇ',

            'o' => 'oòóôõōŏȯöỏőǒȍȏơǫọøồốỗổȱȫȭṍṏṑṓờớỡởợǭộǿœо',
            'O' => 'OÒÓÔÕŌŎȮÖỎŐǑȌȎƠǪỌØỒỐỖỔȰȪȬṌṎṐṒỜỚỠỞỢǬỘǾŒО',

            'u' => 'uùúûũūŭüủůűǔȕȗưụṳųṷṵṹṻǖǜǘǖǚừứữửựуюў',
            'U' => 'UÙÚÛŨŪŬÜỦŮŰǓȔȖƯỤṲŲṶṴṸṺǕǛǗǕǙỪỨỮỬỰУЮЎ',
        ];

        return $list;
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
    public function letterval($value) : ?string
    {
        if (null === $this->filter->filterLetterval($value)) {
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
        if (null === ( $val = $this->strval($value) )) {
            throw new InvalidArgumentException(
                [ 'Value should be convertable to strval: %s', $value ],
            );
        }

        return $val;
    }

    /**
     * @param mixed $value
     *
     * @return string
     */
    public function theLetterval($value) : string
    {
        if (null === ( $val = $this->letterval($value) )) {
            throw new InvalidArgumentException(
                [ 'Value should be convertable to letterval: %s', $value ],
            );
        }

        return $val;
    }

    /**
     * @param mixed $value
     *
     * @return string
     */
    public function theWordval($value) : string
    {
        if (null === ( $val = $this->wordval($value) )) {
            throw new InvalidArgumentException(
                [ 'Value should be convertable to wordval: %s', $value ],
            );
        }

        return $val;
    }

    /**
     * @param mixed $value
     *
     * @return string
     */
    public function theTrimval($value) : string
    {
        if (null === ( $val = $this->trimval($value) )) {
            throw new InvalidArgumentException(
                [ 'Value should be convertable to trimval: %s', $value ],
            );
        }

        return $val;
    }


    /**
     * @param string|array $strings
     * @param null|bool    $uniq
     * @param null|bool    $recursive
     *
     * @return string[]
     */
    public function strvals($strings, bool $uniq = null, bool $recursive = null) : array
    {
        $result = [];

        $strings = is_array($strings)
            ? $strings
            : [ $strings ];

        if ($recursive) {
            array_walk_recursive($strings, function ($item) use (&$result) {
                if (null !== ( $val = $this->strval($item) )) {
                    $result[] = $val;
                }
            });
        } else {
            foreach ( $strings as $item ) {
                if (null !== ( $val = $this->strval($item) )) {
                    $result[] = $val;
                }
            }
        }

        if ($uniq) {
            $arr = [];
            foreach ( $result as $i ) {
                $arr[ $i ] = true;
            }
            $result = array_keys($arr);
        }

        return $result;
    }

    /**
     * @param string|array $letters
     * @param null|bool    $uniq
     * @param null|bool    $recursive
     *
     * @return string[]
     */
    public function lettervals($letters, bool $uniq = null, bool $recursive = null) : array
    {
        $result = [];

        $letters = is_array($letters)
            ? $letters
            : [ $letters ];

        if ($recursive) {
            array_walk_recursive($letters, function ($item) use (&$result) {
                if (null !== ( $val = $this->letterval($item) )) {
                    $result[] = $val;
                }
            });
        } else {
            foreach ( $letters as $item ) {
                if (null !== ( $val = $this->letterval($item) )) {
                    $result[] = $val;
                }
            }
        }

        if ($uniq) {
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
     * @param null|bool    $recursive
     *
     * @return string[]
     */
    public function wordvals($words, bool $uniq = null, bool $recursive = null) : array
    {
        $result = [];

        $words = is_array($words)
            ? $words
            : [ $words ];

        if ($recursive) {
            array_walk_recursive($words, function ($item) use (&$result) {
                if (null !== ( $val = $this->wordval($item) )) {
                    $result[] = $val;
                }
            });
        } else {
            foreach ( $words as $item ) {
                if (null !== ( $val = $this->wordval($item) )) {
                    $result[] = $val;
                }
            }
        }

        if ($uniq) {
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
     * @param null|bool    $recursive
     *
     * @return string[]
     */
    public function trimvals($trims, bool $uniq = null, bool $recursive = null) : array
    {
        $result = [];

        $trims = is_array($trims)
            ? $trims
            : [ $trims ];

        if ($recursive) {
            array_walk_recursive($trims, function ($item) use (&$result) {
                if (null !== ( $val = $this->trimval($item) )) {
                    $result[] = $val;
                }
            });
        } else {
            foreach ( $trims as $item ) {
                if (null !== ( $val = $this->trimval($item) )) {
                    $result[] = $val;
                }
            }
        }

        foreach ( $trims as $trim ) {
            if (null !== ( $val = $this->trimval($trim) )) {
                $result[] = $val;
            }
        }

        if ($uniq) {
            $arr = [];
            foreach ( $result as $i ) {
                $arr[ $i ] = true;
            }
            $result = array_keys($arr);
        }

        return $result;
    }


    /**
     * @param string|array $letters
     * @param null|bool    $uniq
     * @param null|bool    $recursive
     *
     * @return string[]
     */
    public function theLettervals($letters, bool $uniq = null, bool $recursive = null) : array
    {
        $result = [];

        $letters = is_array($letters)
            ? $letters
            : [ $letters ];

        if ($recursive) {
            array_walk_recursive($letters, function ($item) use (&$result) {
                $result[] = $this->theLetterval($item);
            });
        } else {
            foreach ( $letters as $item ) {
                $result[] = $this->theLetterval($item);
            }
        }

        if ($uniq) {
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
     * @param null|bool    $recursive
     *
     * @return string[]
     */
    public function theStrvals($strings, bool $uniq = null, bool $recursive = null) : array
    {
        $result = [];

        $strings = is_array($strings)
            ? $strings
            : [ $strings ];

        if ($recursive) {
            array_walk_recursive($strings, function ($item) use (&$result) {
                $result[] = $this->theStrval($item);
            });
        } else {
            foreach ( $strings as $item ) {
                $result[] = $this->theStrval($item);
            }
        }

        if ($uniq) {
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
     * @param null|bool    $recursive
     *
     * @return string[]
     */
    public function theWordvals($words, bool $uniq = null, bool $recursive = null) : array
    {
        $result = [];

        $words = is_array($words)
            ? $words
            : [ $words ];

        if ($recursive) {
            array_walk_recursive($words, function ($item) use (&$result) {
                $result[] = $this->theWordval($item);
            });
        } else {
            foreach ( $words as $item ) {
                $result[] = $this->theWordval($item);
            }
        }

        if ($uniq) {
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
     * @param null|bool    $recursive
     *
     * @return string[]
     */
    public function theTrimvals($trims, bool $uniq = null, bool $recursive = null) : array
    {
        $result = [];

        $trims = is_array($trims)
            ? $trims
            : [ $trims ];

        if ($recursive) {
            array_walk_recursive($trims, function ($item) use (&$result) {
                $result[] = $this->theTrimval($item);
            });
        } else {
            foreach ( $trims as $item ) {
                $result[] = $this->theTrimval($item);
            }
        }

        if ($uniq) {
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

        $strCase = $ignoreCase
            ? str_ireplace($needle, $needle, $haystack)
            : $haystack;

        $result = [];

        if (false !== mb_strpos($haystack, $needle)) {
            $result = null
                ?? ( isset($limit) ? explode($needle, $strCase, $limit) : null )
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
     * разбивает строку/строки в один массив по разделителю/разделителям
     *
     * @param string|array $delimiters
     * @param string|array $strings
     * @param null|bool    $ignoreCase
     * @param null|int     $limit
     *
     * @return array
     */
    public function explode($delimiters, $strings, bool $ignoreCase = null, int $limit = null) : array
    {
        $delimiters = $this->theStrvals($delimiters, true);

        $sources = is_array($strings)
            ? $strings
            : ( $strings ? [ $strings ] : [] );

        $result = [];

        foreach ( $sources as $source ) {
            $source = $ignoreCase
                ? str_ireplace($delimiters, "\0", $source)
                : str_replace($delimiters, "\0", $source);

            $result = array_merge($result,
                isset($limit)
                    ? explode("\0", $source, $limit)
                    : explode("\0", $source)
            );
        }

        return $result;
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
    public function explodeRecursive($delimiters, $strings, bool $ignoreCase = null, int $limit = null) : array
    {
        $delimiters = $this->theStrvals($delimiters, true);

        $result = ( $isArray = is_array($strings) )
            ? $strings
            : ( $strings ? [ $strings ] : [] );

        foreach ( $delimiters as $delimiter ) {
            array_walk_recursive($result, function (string &$ref) use ($delimiter, $ignoreCase, $limit) {
                if ('' === $delimiter) {
                    $ref = [ $ref ];

                } elseif ($split = $this->contains($ref, $delimiter, $ignoreCase, $limit)) {
                    $ref = $split;

                } else {
                    $ref = [ $ref ];
                }
            });
        }

        $result = $isArray
            ? $result
            : reset($result);

        return $result;
    }

    /**
     * разбивает строку/строки в массив по разделителю/разделителям рекурсивно, только если разделители найдены
     *
     * @param string|array $delimiters
     * @param string       $strings
     * @param null|bool    $ignoreCase
     * @param int|null     $limit
     *
     * @return string|array
     */
    public function explodeRecursiveSkip($delimiters, $strings, bool $ignoreCase = null, int $limit = null) // : string|array
    {
        $delimiters = $this->theStrvals($delimiters, true);

        $result = ( $isArray = is_array($strings) )
            ? $strings
            : ( $strings ? [ $strings ] : [] );

        foreach ( $delimiters as $delimiter ) {
            array_walk_recursive($result, function (string &$ref) use ($delimiter, $ignoreCase, $limit) {
                if ('' === $delimiter) return;

                if ($split = $this->contains($ref, $delimiter, $ignoreCase, $limit)) {
                    $ref = $split;
                }
            });
        }

        $result = $isArray
            ? $result
            : reset($result);

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
        $result = $this->theStrvals($strings, null, true);

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
        $result = $this->strvals($strings, null, true);

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
        $result = $this->theStrvals($strings, null, true);
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
        $result = $this->strvals($strings, null, true);
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

        $result = $this->theWordvals($strings, null, true);
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
        $strings,
        string $delimiter = null,
        string $lastDelimiter = null,
        string $wrapper = null
    ) : string
    {
        $delimiter = $delimiter ?? '';
        $lastDelimiter = $lastDelimiter ?? $delimiter;
        $wrapper = $wrapper ?? '';

        $result = $this->wordvals($strings, null, true);
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
     * урезает английское слово до префикса из нескольких букв - когда имя индекса в бд слишком длинное
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

        $source = preg_replace('/(?:[^\w]|[_])+/', '', $string);
        $sourceLetters = mb_str_split($source);

        $len = min($len, count($sourceLetters));

        if (0 === $len) return '';

        $vowels = implode('', $this->getVowels());

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
    public function prefixCompact($strings, $delimiters = null, int $limit = null) : string
    {
        $list = $this->wordvals($strings);

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
     * @param string $string
     *
     * @return string
     */
    public function unaccent(string $string) : string
    {
        if (preg_match('/[\x80-\xff]/', $string) === false) {
            return $string;
        }

        if (null !== $this->filter->filterUtf8($string)) {
            $replacements = [];
            foreach ( $this->getAccents() as $replacement => $letters ) {
                foreach ( str_split($letters) as $search ) {
                    $replacements[ $search ] = $replacements;
                }
            }

            $string = strtr($string, $replacements);

        } else {
            $characters = [];

            // Assume ISO-8859-1 if not UTF-8

            $characters[ 'in' ] =
                chr(128)
                . chr(131)
                . chr(138)
                . chr(142)
                . chr(154)
                . chr(158)
                . chr(159)
                . chr(162)
                . chr(165)
                . chr(181)
                . chr(192)
                . chr(193)
                . chr(194)
                . chr(195)
                . chr(196)
                . chr(197)
                . chr(199)
                . chr(200)
                . chr(201)
                . chr(202)
                . chr(203)
                . chr(204)
                . chr(205)
                . chr(206)
                . chr(207)
                . chr(209)
                . chr(210)
                . chr(211)
                . chr(212)
                . chr(213)
                . chr(214)
                . chr(216)
                . chr(217)
                . chr(218)
                . chr(219)
                . chr(220)
                . chr(221)
                . chr(224)
                . chr(225)
                . chr(226)
                . chr(227)
                . chr(228)
                . chr(229)
                . chr(231)
                . chr(232)
                . chr(233)
                . chr(234)
                . chr(235)
                . chr(236)
                . chr(237)
                . chr(238)
                . chr(239)
                . chr(241)
                . chr(242)
                . chr(243)
                . chr(244)
                . chr(245)
                . chr(246)
                . chr(248)
                . chr(249)
                . chr(250)
                . chr(251)
                . chr(252)
                . chr(253)
                . chr(255);

            $characters[ 'out' ] = 'EfSZszYcYuAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy';

            $string = strtr($string, $characters[ 'in' ], $characters[ 'out' ]);

            $doubleChars = [];

            $doubleChars[ 'in' ] = [
                chr(140),
                chr(156),
                chr(198),
                chr(208),
                chr(222),
                chr(223),
                chr(230),
                chr(240),
                chr(254),
            ];

            $doubleChars[ 'out' ] = [ 'OE', 'oe', 'AE', 'DH', 'TH', 'ss', 'ae', 'dh', 'th' ];

            $string = str_replace($doubleChars[ 'in' ], $doubleChars[ 'out' ], $string);
        }

        return $string;
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
    public function pascal($words, string $separator = null, string $spaces = null) : string
    {
        $words = is_array($words)
            ? $words
            : [ $words ];

        $separator = $separator ?? '';

        $spaces = $spaces ?? '_-';
        $spaces = ' ' . $spaces;

        foreach ( $words as $word ) {
            if (! is_string($word)) {
                throw new InvalidArgumentException(
                    [ 'Each Word should be string: ', $words ]
                );
            }
        }

        if (mb_strlen($separator) > 1) {
            throw new InvalidArgumentException(
                [ 'Separator should be one letter: ', $separator ]
            );
        }

        $separators = $spaces . $separator;

        $result = implode(' ', $words);
        $result = ucwords($result, $separators);

        $result = $separator
            ? strtr($result, $separators, str_repeat($separator, mb_strlen($separators)))
            : str_replace(str_split($separators), '', $result);

        return $result;
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
    public function camel($words, string $separator = null, string $spaces = null) : string
    {
        $result = $this->pascal($words, $separator, $spaces);

        $result = lcfirst($result);

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
    public function pascalCase($strings, string $keep = null, string $separator = null) : string
    {
        $separator = $separator ?? '';

        $result = $this->spaceCase($strings, $keep, $separator);

        $result = ucwords($result, ' ');
        $result = str_replace(' ', $separator, $result);

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
    public function camelCase($strings, string $keep = null, string $separator = null) : string
    {
        $result = $this->pascalCase($strings, $keep, $separator);

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
    public function snakeCase($strings, string $keep = null, string $separator = null) : string
    {
        $separator = $separator ?? '_';

        $result = $this->spaceCase($strings, $keep, $separator);

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
    public function kebabCase($strings, string $keep = null, string $separator = null) : string
    {
        $separator = $separator ?? '-';

        $result = $this->snakeCase($strings, $keep, $separator);

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
    public function spaceCase($words, string $keep = null, string $separator = null) : string
    {
        $words = is_array($words)
            ? $words
            : [ $words ];

        $separator = $separator ?? '';
        $keep = $keep ?? '';

        foreach ( $words as $word ) {
            if (! is_string($word)) {
                throw new InvalidArgumentException(
                    [ 'Each Word should be string: ', $words ]
                );
            }
        }

        if (mb_strlen($separator) > 1) {
            throw new InvalidArgumentException(
                [ 'Separator should be one letter: ', $separator ]
            );
        }

        $string = implode(' ', $words);

        $cacheKey = $string . '.' . $keep . '.' . $separator;
        if (! isset($this->cacheCase[ $cacheKey ])) {
            $utf8Flag = ( null !== $this->filter->filterUtf8($string) ) ? 'u' : '';

            $hasSeparator = strlen($separator);

            $separatorKeepRegex = '';
            if ($hasSeparator || strlen($keep)) {
                $separatorKeepRegex = preg_quote($separator . $keep, '/');
            }

            $result = preg_replace('/\p{Lu}/' . $utf8Flag, ' $0', lcfirst($string));
            $result = preg_replace('/(?:[^\w' . $separatorKeepRegex . ']|[_])+/' . $utf8Flag, ' ', $result);

            if ($hasSeparator) {
                $result = preg_replace('/[' . $separator . ' ]+/' . $utf8Flag, ' ', $result);
            }

            $this->cacheCase[ $cacheKey ] = $result;
        }

        return $this->cacheCase[ $cacheKey ];
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
    public function slugify(string $string, string $delimiter = null, string $locale = null) : string
    {
        $result = $this->slugger()->slug($string, $delimiter, $locale);

        return $result;
    }


    /**
     * @param string   $singular
     * @param null|int $limit
     * @param null|int $offset
     *
     * @return array
     */
    public function pluralize(string $singular, $limit = null, $offset = null) : array
    {
        $result = $this->inflector()->pluralize($singular, $limit, $offset);

        return $result;
    }

    /**
     * @param string   $plural
     * @param null|int $limit
     * @param null|int $offset
     *
     * @return array
     */
    public function singularize(string $plural, $limit = null, $offset = null) : array
    {
        $result = $this->inflector()->singularize($plural, $limit, $offset);

        return $result;
    }


    /**
     * @return IStr
     */
    public static function getInstance() : IStr
    {
        return SupportFactory::getInstance()->getStr();
    }
}