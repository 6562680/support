<?php
/**
 * @noinspection RedundantSuppression
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support;

use Gzhegow\Support\Traits\Load\ArrLoadTrait;
use Gzhegow\Support\Traits\Load\NumLoadTrait;
use Gzhegow\Support\Traits\Load\CacheLoadTrait;
use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Traits\Load\Str\SluggerLoadTrait;
use Gzhegow\Support\Traits\Load\Str\InflectorLoadTrait;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * XStr
 */
class XStr implements IStr
{
    use ArrLoadTrait;
    use CacheLoadTrait;
    use NumLoadTrait;

    use SluggerLoadTrait;
    use InflectorLoadTrait;


    const ENC_MB_INTERNAL_ENCODING = 'UTF-8';
    const ENC_MB_REGEX_ENCODING    = 'UTF-8';

    const MODE_ASCII   = 'ascii';
    const MODE_UNICODE = 'unicode';

    const SYMFONY_CACHE_ARRAY_ADAPTER = 'Symfony\Component\Cache\Adapter\ArrayAdapter';

    const THE_MODE_LIST = [
        self::MODE_ASCII   => true,
        self::MODE_UNICODE => true,
    ];


    /**
     * @var string[]
     */
    protected $multibyteStack = [
        self::MODE_ASCII,
    ];
    /**
     * @var string[]
     */
    protected $multibyteStackDefault = [
        self::MODE_ASCII,
    ];


    /**
     * @return string
     */
    public function loadTrims() : string
    {
        return " \t\n\r\0\x0B";
    }

    /**
     * @return string
     */
    public function loadSeparators() : string
    {
        return " \t\r\n\f\v";
    }

    /**
     * @return array
     */
    public function loadAccents() : array
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
    public function loadVowels() : array
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
     * @return ICache
     */
    protected function loadCache() : ICache
    {
        $commands = [
            'composer require symfony/cache',
        ];

        if (! class_exists($class = static::SYMFONY_CACHE_ARRAY_ADAPTER)) {
            throw new RuntimeException([
                'Please, run following: %s',
                $commands,
            ]);
        }

        $cache = SupportFactory::getInstance()->newCache();
        $cache->addPool($poolName = 'spaceCase', new $class());
        $cache->selectPool($poolName);

        $root = SupportFactory::getInstance()->getCache();
        $root->addPool(strtolower(str_replace('\\', '.', __CLASS__)), $cache);

        return $cache;
    }


    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function filterStringUtf8($value) : ?string
    {
        if (! is_string($value)) {
            return null;

        } elseif ('' === $value) {
            return null;
        }

        for ( $i = 0; $i < strlen($value); $i++ ) {
            if (ord($value[ $i ]) < 0x80) {
                continue; // 0bbbbbbb
            }

            if (( ord($value[ $i ]) & 0xE0 ) === 0xC0) {
                $n = 1; // 110bbbbb
            } elseif (( ord($value[ $i ]) & 0xF0 ) === 0xE0) {
                $n = 2; // 1110bbbb
            } elseif (( ord($value[ $i ]) & 0xF8 ) === 0xF0) {
                $n = 3; // 11110bbb
            } elseif (( ord($value[ $i ]) & 0xFC ) === 0xF8) {
                $n = 4; // 111110bb
            } elseif (( ord($value[ $i ]) & 0xFE ) === 0xFC) {
                $n = 5; // 1111110b
            } else {
                return null; // Does not match any model
            }

            for ( $j = 0; $j < $n; $j++ ) { // n bytes matching 10bbbbbb follow ?
                if (++$i === strlen($value) || ( ( ord($value[ $i ]) & 0xC0 ) !== 0x80 )) {
                    return null;
                }
            }
        }

        return $value;
    }


    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function filterString($value) : ?string
    {
        if (is_string($value)) {
            return $value;
        }

        return null;
    }

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function filterLetter($value) : ?string
    {
        if (is_string($value) && ( mb_strlen($value) === 1 )) {
            return $value;
        }

        return null;
    }

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function filterWord($value) : ?string
    {
        if (is_string($value) && ( '' !== $value )) {
            return $value;
        }

        return null;
    }


    /**
     * @param int|string|mixed $value
     *
     * @return null|int|float|string
     */
    public function filterStringOrInt($value) // : ?null|int|float|string
    {
        if (is_string($value) || is_int($value)) {
            return $value;
        }

        return null;
    }

    /**
     * @param int|string|mixed $value
     *
     * @return null|int|float|string
     */
    public function filterLetterOrInt($value) // : ?null|int|float|string
    {
        if (( is_string($value) && ( 1 === $this->mb('strlen')($value) ) )
            || is_int($value)
        ) {
            return $value;
        }

        return null;
    }

    /**
     * @param int|string|mixed $value
     *
     * @return null|int|float|string
     */
    public function filterWordOrInt($value) // : ?null|int|float|string
    {
        if (( is_string($value) && ( '' !== $value ) )
            || is_int($value)
        ) {
            return $value;
        }

        return null;
    }


    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public function filterStringOrNum($value) // : ?null|int|float|string
    {
        if (is_string($value)
            || ( null !== $this->getNum()->filterNum($value) )
        ) {
            return $value;
        }

        return null;
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public function filterLetterOrNum($value) // : ?null|int|float|string
    {
        if (( is_string($value) && ( 1 === $this->mb('strlen')($value) ) )
            || ( null !== $this->getNum()->filterNum($value) )
        ) {
            return $value;
        }

        return null;
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public function filterWordOrNum($value) // : ?null|int|float|string
    {
        if (( is_string($value) && ( '' !== $value ) )
            || ( null !== $this->getNum()->filterNum($value) )
        ) {
            return $value;
        }

        return null;
    }


    /**
     * @param string|mixed $value
     *
     * @return null|int|float|string|object
     */
    public function filterStrval($value) // : ?null|int|float|string|object
    {
        if (null !== $this->filterStringOrNum($value)) {
            return $value;
        }

        if (is_object($value)) {
            try {
                $test = $value;

                if (false !== settype($test, 'string')) {
                    return $value; // __toString()
                }
            }
            catch ( \Throwable $e ) {
            }
        }

        return null;
    }

    /**
     * @param string|mixed $value
     *
     * @return null|int|float|string|object
     */
    public function filterLetterval($value) // : ?null|int|float|string|object
    {
        if (null === $this->filterStrval($value)) {
            return null;
        }

        if ($this->mb('strlen')(strval($value)) !== 1) {
            return null;
        }

        return $value;
    }

    /**
     * @param string|mixed $value
     *
     * @return null|int|float|string|object
     */
    public function filterWordval($value)// : ?null|int|float|string|object
    {
        if ('' === $value) {
            return null;

        } elseif (null !== $this->filterStrval($value)) {
            return $value;
        }

        return null;
    }

    /**
     * @param string|mixed $value
     *
     * @return null|int|float|string|object
     */
    public function filterTrimval($value)// : ?null|int|float|string|object
    {
        if ('' === $value) {
            return null;

        } elseif (null === $this->filterStrval($value)) {
            return null;
        }

        if ('' === trim($value)) {
            return null;
        }

        return $value;
    }


    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function strval($value) : ?string
    {
        if (null === $this->filterStrval($value)) {
            return null;
        }

        $result = strval($value);

        return $result;
    }

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function letterval($value) : ?string
    {
        if (null === $this->filterLetterval($value)) {
            return null;
        }

        $result = strval($value);

        return $result;
    }

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function wordval($value) : ?string
    {
        if (null === $this->filterWordval($value)) {
            return null;
        }

        $result = strval($value);

        return $result;
    }

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function trimval($value) : ?string
    {
        if (null === $this->filterTrimval($value)) {
            return null;
        }

        $result = trim($value);

        return $result;
    }


    /**
     * @param string|mixed $value
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
     * @param string|mixed $value
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
     * @param string|mixed $value
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
     * @param string|mixed $value
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
            : ( $strings ? [ $strings ] : [] );

        if ($strings) {
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
     * пишет слово с большой буквы
     *
     * @param string      $string
     * @param null|string $encoding
     *
     * @return string
     */
    public function lcfirst(string $string, string $encoding = null)
    {
        $mode = end($this->multibyteStack);

        $result = $mode === static::MODE_ASCII
            ? lcfirst($string)
            : ( ''
                . mb_strtolower(mb_substr($string, 0, 1, $encoding), $encoding)
                . mb_substr($string, 1, null, $encoding)
            );

        return $result;
    }

    /**
     * пишет слово с большой буквы
     *
     * @param string      $string
     * @param null|string $encoding
     *
     * @return string
     */
    public function ucfirst(string $string, string $encoding = null)
    {
        $mode = end($this->multibyteStack);

        $result = $mode === static::MODE_ASCII
            ? ucfirst($string)
            : mb_convert_case($string, MB_CASE_TITLE, $encoding);

        return $result;
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
    public function lcwords(string $string, string $separators = " \t\r\n\f\v", string $encoding = null)
    {
        $mode = end($this->multibyteStack);

        $result = preg_replace_callback(
            '~([' . preg_quote($separators, '/') . '])(\w)~',
            function ($m) use ($mode, $encoding) {
                return $m[ 1 ]
                    . ( ( $mode === static::MODE_UNICODE )
                        ? mb_convert_case($m[ 2 ], MB_CASE_TITLE, $encoding)
                        : lcfirst($m[ 2 ])
                    );
            },
            $string
        );

        return $result;
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
    public function ucwords(string $string, string $separators = " \t\r\n\f\v", string $encoding = null)
    {
        $mode = end($this->multibyteStack);

        $result = ( $mode === static::MODE_ASCII )
            ? ucwords($string, $separators)
            : mb_convert_case($string, MB_CASE_TITLE, $encoding);

        return $result;
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
    public function strpos(string $string, string $needle, int $offset = null) : int
    {
        $result = false === ( $pos = $this->mb('strpos')($string, $needle, $offset) )
            ? -1 : $pos;

        return $result;
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
    public function strrpos(string $string, string $needle, int $offset = null) : int
    {
        $result = false === ( $pos = $this->mb('strrpos')($string, $needle, $offset) )
            ? -1 : $pos;

        return $result;
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
    public function stripos(string $string, string $needle, int $offset = null) : int
    {
        $result = false === ( $pos = $this->mb('stripos')($string, $needle, $offset) )
            ? -1 : $pos;

        return $result;
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
    public function strripos(string $string, string $needle, int $offset = null) : int
    {
        $result = false === ( $pos = $this->mb('strripos')($string, $needle, $offset) )
            ? -1 : $pos;

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
            return ( 5 === func_num_args() )
                ?? str_replace($strings, $replacements, $subjects, $count)
                ?? str_replace($strings, $replacements, $subjects);
        }

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

            $lenSearch = $this->mb('strlen')($curSearch);

            foreach ( array_keys($subjectArray) as $idx ) {
                $curLimit = $limit;

                while ( 0 < $curLimit-- ) {
                    if ($reverse) {
                        if (false !== ( $pos = $this->mb('strrpos')($subjectArray[ $idx ], $curSearch) )) {
                            $count++;

                            $subjectArray[ $idx ] = $this->mb('substr')($subjectArray[ $idx ], 0, $pos)
                                . $curReplace
                                . $this->mb('substr')($subjectArray[ $idx ], $pos + $lenSearch);
                        }

                    } else {
                        if (false !== ( $pos = $this->mb('strpos')($subjectArray[ $idx ], $curSearch) )) {
                            $count++;

                            $subjectArray[ $idx ] = $this->mb('substr')($subjectArray[ $idx ], 0, $pos)
                                . $curReplace
                                . $this->mb('substr')($subjectArray[ $idx ], $pos + $lenSearch);
                        }
                    }
                }
            }
        }

        $result = 1 < count($subjectArray)
            ? $subjectArray
            : reset($subjectArray);

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
            return ( 5 === func_num_args() )
                ?? str_ireplace($strings, $replacements, $subjects, $count)
                ?? str_ireplace($strings, $replacements, $subjects);
        }

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

            $lenSearch = $this->mb('strlen')($curSearch);

            foreach ( array_keys($subjectArray) as $idx ) {
                $curLimit = $limit;

                while ( 0 < $curLimit-- ) {
                    if ($reverse) {
                        if (false !== ( $pos = $this->mb('strripos')($subjectArray[ $idx ], $curSearch) )) {
                            $count++;

                            $subjectArray[ $idx ] = $this->mb('substr')($subjectArray[ $idx ], 0, $pos)
                                . $curReplace
                                . $this->mb('substr')($subjectArray[ $idx ], $pos + $lenSearch);
                        }

                    } else {
                        if (false !== ( $pos = $this->mb('stripos')($subjectArray[ $idx ], $curSearch) )) {
                            $count++;

                            $subjectArray[ $idx ] = $this->mb('substr')($subjectArray[ $idx ], 0, $pos)
                                . $curReplace
                                . $this->mb('substr')($subjectArray[ $idx ], $pos + $lenSearch);
                        }
                    }
                }
            }
        }

        $result = 1 < count($subjectArray)
            ? $subjectArray
            : reset($subjectArray);

        return $result;
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
    public function lcrop(string $string, string $needle, bool $ignoreCase = null, int $limit = -1) : string
    {
        $ignoreCase = $ignoreCase ?? true;

        if ('' === $string) return $string;
        if ('' === $needle) return $string;

        $result = $string;

        $pos = $ignoreCase
            ? $this->mb('stripos')($result, $needle)
            : $this->mb('strpos')($result, $needle);

        while ( $pos === 0 ) {
            if (! $limit--) {
                break;
            }

            $result = $this->mb('substr')($result,
                $this->mb('strlen')($needle)
            );

            $pos = $ignoreCase
                ? $this->mb('stripos')($result, $needle)
                : $this->mb('strpos')($result, $needle);
        }

        return $result;
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
    public function rcrop(string $string, string $needle, bool $ignoreCase = null, int $limit = -1) : string
    {
        $ignoreCase = $ignoreCase ?? true;

        if ('' === $string) return $string;
        if ('' === $needle) return $string;

        $result = $string;

        $pos = $ignoreCase
            ? $this->mb('strripos')($result, $needle)
            : $this->mb('strrpos')($result, $needle);

        while ( $pos === ( $this->mb('strlen')($result) - $this->mb('strlen')($needle) ) ) {
            if (! $limit--) {
                break;
            }

            $result = $this->mb('substr')($result, 0, $pos);

            $pos = $ignoreCase
                ? $this->mb('strripos')($result, $needle)
                : $this->mb('strrpos')($result, $needle);
        }

        return $result;
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
    public function crop(string $string, $needles, bool $ignoreCase = null, int $limit = -1) : string
    {
        $needles = is_array($needles)
            ? $needles
            : ( $needles ? [ $needles ] : [] );

        if (! $needles) {
            return $string;
        }

        $needleRcrop = $needleLcrop = array_shift($needles);

        if ($needles) $needleRcrop = array_shift($needles);

        $result = $string;
        $result = $this->lcrop($result, $needleLcrop, $ignoreCase, $limit);
        $result = $this->rcrop($result, $needleRcrop, $ignoreCase, $limit);

        return $result;
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
    public function starts(string $string, string $needle, bool $ignoreCase = null) : ?string
    {
        $ignoreCase = $ignoreCase ?? true;

        if ('' === $string) return null;
        if ('' === $needle) return $string;

        $pos = $ignoreCase
            ? $this->mb('stripos')($string, $needle)
            : $this->mb('strpos')($string, $needle);

        $result = 0 === $pos
            ? $this->mb('substr')($string, $this->mb('strlen')($needle))
            : null;

        return $result;
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
    public function ends(string $string, string $needle, bool $ignoreCase = null) : ?string
    {
        $ignoreCase = $ignoreCase ?? true;

        if ('' === $string) return null;
        if ('' === $needle) return $string;

        $pos = $ignoreCase
            ? $this->mb('strripos')($string, $needle)
            : $this->mb('strrpos')($string, $needle);

        $result = $pos === $this->mb('strlen')($string) - $this->mb('strlen')($needle)
            ? $this->mb('substr')($string, 0, $pos)
            : null;

        return $result;
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
    public function contains(string $string, string $needle, bool $ignoreCase = null, int $limit = null) : array
    {
        $ignoreCase = $ignoreCase ?? true;

        if ('' === $string) return [];
        if ('' === $needle) return [ $string ];

        $strCase = $ignoreCase
            ? str_ireplace($needle, $needle, $string)
            : $string;

        $result = [];

        if (false !== mb_strpos($strCase, $needle)) {
            $result = null
                ?? ( isset($limit) ? explode($needle, $strCase, $limit) : null )
                ?? ( explode($needle, $strCase) );
        }

        return $result;
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
    public function unltrim(string $string, string $repeat = null, int $times = null) : string
    {
        $repeat = $repeat ?? '';
        $times = $times ?? 1;

        if ('' === $repeat) return $string;

        $times = max(0, $times);

        $result = str_repeat($repeat, $times) . $string;

        return $result;
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
    public function unrtrim(string $string, string $repeat = null, int $times = null) : string
    {
        $repeat = $repeat ?? '';
        $times = $times ?? 1;

        if ('' === $repeat) return $string;

        $times = max(0, $times);

        $result = $string . str_repeat($repeat, $times);

        return $result;
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
    public function untrim(string $string, $repeats, int $times = null) : string
    {
        $repeats = is_array($repeats)
            ? $repeats
            : ( $repeats ? [ $repeats ] : [] );

        if (! $repeats) {
            return $string;
        }

        $repeatUnrtrim = $repeatUnltrim = array_shift($repeats);

        if ($repeats) $repeatUnrtrim = array_shift($repeats);

        $result = $string;
        $result = $this->unltrim($result, $repeatUnltrim, $times);
        $result = $this->unrtrim($result, $repeatUnrtrim, $times);

        return $result;
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
    public function prepend(string $string, string $prepend, bool $ignoreCase = null) : string
    {
        $ignoreCase = $ignoreCase ?? true;

        if ('' === $prepend) return $string;

        $fn = $ignoreCase
            ? $this->mb('stripos')
            : $this->mb('strpos');

        $result = 0 === $fn($string, $prepend)
            ? $string
            : $prepend . $string;

        return $result;
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
    public function append(string $string, string $append, bool $ignoreCase = null) : string
    {
        $ignoreCase = $ignoreCase ?? true;

        if ('' === $append) return $string;

        $fn = $ignoreCase
            ? $this->mb('strripos')
            : $this->mb('strrpos');

        $result = ( ( $this->mb('strlen')($string) - $this->mb('strlen')($append) ) === $fn($string, $append) )
            ? $string
            : $string . $append;

        return $result;
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
    public function wrap(string $string, $wraps, bool $ignoreCase = null) : string
    {
        $wraps = is_array($wraps)
            ? $wraps
            : ( $wraps ? [ $wraps ] : [] );

        if (! $wraps) {
            return $string;
        }

        $wrapAppend = $wrapPrepend = array_shift($wraps);

        if ($wraps) $wrapAppend = array_shift($wraps);

        $result = $string;
        $result = $this->prepend($result, $wrapPrepend, $ignoreCase);
        $result = $this->append($result, $wrapAppend, $ignoreCase);

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
     * '1, 2, 3', включая пустые строки, исключение если нельзя привести к строке, антоним explode
     *
     * @param string       $delimiter
     * @param string|array ...$strings
     *
     * @return string
     */
    public function implode(string $delimiter, ...$strings) : string
    {
        $result = $this->theStrvals($strings, null, true);

        $result = implode($delimiter, $result);

        return $result;
    }

    /**
     * '1, 2, 3', включая пустые строки, пропускает если нельзя привести к строке, антоним explodeSkip
     *
     * @param string       $delimiter
     * @param string|array ...$strings
     *
     * @return string
     */
    public function implodeSkip(string $delimiter, ...$strings) : string
    {
        $result = $this->strvals($strings, null, true);

        $result = implode($delimiter, $result);

        return $result;
    }


    /**
     * '1:2,3', включая пустые строки, исключение если нельзя привести к строке, антоним explodeRecursive
     *
     * @param string|array $delimiters
     * @param array        $strings
     *
     * @return void
     */
    public function implodeRecursive($delimiters, array $strings) : string
    {
        /**
         * @var array $fullpath
         */

        $delimiters = $this->theStrvals($delimiters, true);

        foreach ( $this->getArr()->walk($strings, true, true, true) as $fullpath => &$value ) {
            $delimiter = $delimiters[ count($fullpath) ] ?? '';

            if (is_array($value)) {
                $value = implode($delimiter, $value);

            } else {
                $value = $this->theStrval($value);

                if ('' !== $delimiter) {
                    $value = trim($value, $delimiter);
                }
            }
        }
    }

    /**
     * '1:2,3', включая пустые строки, пропускает если нельзя привести к строке, антоним explodeRecursive
     *
     * @param string|array $delimiters
     * @param array        $strings
     *
     * @return void
     */
    public function implodeRecursiveSkip($delimiters, array $strings) : string
    {
        /**
         * @var array $fullpath
         */

        $delimiters = $this->theStrvals($delimiters, true);

        foreach ( $this->getArr()->walk($strings, true, true, true) as $fullpath => &$value ) {
            $delimiter = $delimiters[ count($fullpath) ] ?? '';

            if (is_array($value)) {
                $value = implode($delimiter, $value);

            } else {
                $value = $this->strval($value);

                if ('' !== $delimiter) {
                    $value = trim($value, $delimiter);
                }
            }
        }
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
     * '1:2,3', включая пустые строки, исключение если нельзя привести к строке, антоним explodeRecursive
     *
     * @param string|array $delimiters
     * @param array        $strings
     *
     * @return void
     */
    public function joinRecursive($delimiters, array $strings) : string
    {
        /**
         * @var array $fullpath
         */

        $delimiters = $this->theStrvals($delimiters, true);

        foreach ( $this->getArr()->walk($strings, true, true, true) as $fullpath => &$value ) {
            $delimiter = $delimiters[ count($fullpath) ] ?? '';

            if (is_array($value)) {
                foreach ( $value as $k => $v ) {
                    if ('' === $v) {
                        unset($value[ $k ]);
                    }
                }

                $value = implode($delimiter, $value);

            } else {
                $value = $this->theStrval($value);

                if ('' !== $delimiter) {
                    $value = trim($value, $delimiter);
                }
            }
        }
    }

    /**
     * '1:2,3', включая пустые строки, пропускает если нельзя привести к строке, антоним explodeRecursive
     *
     * @param string|array $delimiters
     * @param array        $strings
     *
     * @return void
     */
    public function joinRecursiveSkip($delimiters, array $strings) : string
    {
        /**
         * @var array $fullpath
         */

        $delimiters = $this->theStrvals($delimiters, true);

        foreach ( $this->getArr()->walk($strings, true, true, true) as $fullpath => &$value ) {
            $delimiter = $delimiters[ count($fullpath) ] ?? '';

            if (is_array($value)) {
                foreach ( $value as $k => $v ) {
                    if ('' === $v) {
                        unset($value[ $k ]);
                    }
                }

                $value = implode($delimiter, $value);

            } else {
                $value = $this->strval($value);

                if ('' !== $delimiter) {
                    $value = trim($value, $delimiter);
                }
            }
        }
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

        $mode = end($this->multibyteStack);

        $len = $len ?? 3;
        $len = max(0, $len);

        $source = ( $mode === static::MODE_ASCII )
            ? preg_replace('/(?:[^\w]|[_])+/', '', $string)
            : preg_replace('/(?:[^\w]|[_])+/u', '', $string);

        $sourceLetters = $this->mb('str_split')($source);

        $len = min($len, count($sourceLetters));

        if (0 === $len) return '';

        $vowels = implode('', $this->loadVowels());

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
     * @param null|int          $len
     *
     * @return string
     */
    public function prefixCompact($strings, $delimiters = null, int $len = null) : string
    {
        $list = $this->wordvals($strings);

        if (null !== $delimiters) {
            $list = $this->explode($delimiters, $list);
        }

        $result = [];
        foreach ( $list as $string ) {
            $result[] = $this->prefix($string, $len);
        }

        $result = implode($delimiters[ 0 ] ?? '', $result);

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

        $mode = end($this->multibyteStack);

        $flags = '';
        $flags .= $ignoreCase ? 'i' : '';
        $flags .= ( $mode === static::MODE_UNICODE ) ? 'u' : '';

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
     * Функция заменяет "умляут" символы на их соответствующие в ASCII
     *
     * @param string $string
     *
     * @return string
     */
    public function unaccent(string $string) : string
    {
        if (preg_match('/[\x80-\xff]/', $string) === false) {
            return $string;
        }

        if (null !== $this->filterStringUtf8($string)) {
            $replacements = [];
            foreach ( $this->loadAccents() as $replacement => $letters ) {
                foreach ( $this->mb('str_split')($letters) as $search ) {
                    $replacements[ $search ] = $replacement;
                }
            }

            $string = strtr($string, $replacements);

        } else {
            // Assume ISO-8859-1 if not UTF-8
            $characters = [];
            $chrs = []
                + [ 128 => true, 131 => true, 138 => true, ]
                + [ 142 => true, ]
                + [ 154 => true, 158 => true, 159 => true, ]
                + [ 162 => true, 165 => true, ]
                + [ 181 => true, ]
                + [ 192 => true, 193 => true, 194 => true, 195 => true, 196 => true, 197 => true, 199 => true, ]
                + [ 200 => true, 201 => true, 202 => true, 203 => true, 204 => true, 205 => true, 206 => true, 207 => true, 209 => true, ]
                + [ 210 => true, 211 => true, 212 => true, 213 => true, 214 => true, 216 => true, 217 => true, 218 => true, 219 => true, ]
                + [ 220 => true, 221 => true, 224 => true, 225 => true, 226 => true, 227 => true, 228 => true, 229 => true, ]
                + [ 231 => true, 232 => true, 233 => true, 234 => true, 235 => true, 236 => true, 237 => true, 238 => true, 239 => true, ]
                + [ 241 => true, 242 => true, 243 => true, 244 => true, 245 => true, 246 => true, 248 => true, 249 => true, ]
                + [ 250 => true, 251 => true, 252 => true, 253 => true, 255 => true, ];

            $characters[ 'in' ] = implode('', array_map('chr', array_keys($chrs)));
            $characters[ 'out' ] = 'EfSZszYcYuAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy';

            $string = strtr($string, $characters[ 'in' ], $characters[ 'out' ]);

            $doubleCharacters = [];
            $doubleChrs = []
                + [ 140 => true ]
                + [ 156 => true ]
                + [ 198 => true ]
                + [ 208 => true ]
                + [ 222 => true, 223 => true ]
                + [ 230 => true ]
                + [ 240 => true ]
                + [ 254 => true ];

            $doubleCharacters[ 'in' ] = array_map('chr', array_keys($doubleChrs));
            $doubleCharacters[ 'out' ] = [ 'OE', 'oe', 'AE', 'DH', 'TH', 'ss', 'ae', 'dh', 'th' ];

            $string = str_replace($doubleCharacters[ 'in' ], $doubleCharacters[ 'out' ], $string);
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
        $words = $this->theStrvals($words);

        $separator = $separator ?? '';
        $spaces = ' ' . ( $spaces ?? '_-' );

        if ($this->mb('strlen')($separator) > 1) {
            throw new InvalidArgumentException([
                'The `separator` should be one letter: %s',
                $separator,
            ]);
        }

        $separators = $spaces . $separator;

        $result = implode(' ', $words);
        $result = $this->ucwords($result, $separators);

        $result = $separator
            ? strtr($result, $separators, str_repeat($separator, mb_strlen($separators)))
            : str_replace($this->mb('str_split')($separators), '', $result);

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

        $result = $this->lcfirst($result);

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

        $result = $this->ucwords($result, ' ');
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

        $result = $this->lcfirst($result);

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

        $result = array_map([ $this, 'lcfirst' ], explode(' ', $result));
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
    public function spaceCase($strings, string $keep = null, string $separator = null) : string
    {
        $strings = $this->theStrvals($strings);

        $separator = $separator ?? '';
        $keep = $keep ?? '';

        if ($this->mb('strlen')($separator) > 1) {
            throw new InvalidArgumentException([
                'The `separator` should be one letter: %s',
                $separator,
            ]);
        }

        $string = implode(' ', $strings);

        $mode = end($this->multibyteStack);

        $cache = $this->getCache();
        $cacheItem = $cache->getItem(
            json_encode([ $mode, $string, $keep, $separator ])
        );
        if (! $cacheItem->isHit()) {
            $flags = ( $mode === static::MODE_UNICODE )
                ? 'u'
                : '';

            $hasSeparator = ( '' !== $separator );

            $separatorKeepRegex = '';
            if ($hasSeparator || ( '' !== $keep )) {
                $separatorKeepRegex = preg_quote($separator . $keep, '/');
            }

            $result = preg_replace('~\p{Lu}~' . $flags, ' $0', $this->mb('lcfirst')($string));
            $result = preg_replace('~(?:[^\w' . $separatorKeepRegex . ']|[_])+~' . $flags, ' ', $result);

            if ($hasSeparator) {
                $result = preg_replace('~[' . $separator . ' ]+~' . $flags, ' ', $result);
            }

            $cacheItem->set($result);

            $cache->save($cacheItem);
        }

        $result = $cacheItem->get();

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
        $result = $this->getSlugger()->slug($string, $delimiter, $locale);

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
        $result = $this->getSlugger()->slug($string, $delimiter, $locale);

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
        $result = $this->getInflector()->pluralize($singular, $limit, $offset);

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
        $result = $this->getInflector()->singularize($plural, $limit, $offset);

        return $result;
    }


    /**
     * @param string $function
     *
     * @return string
     */
    public function mb(string $function) : string
    {
        $mode = end($this->multibyteStack);

        if ($mode === static::MODE_UNICODE
            && extension_loaded('mbstring')
        ) {
            if (! static::$mbInternalEncoding) {
                mb_internal_encoding(static::ENC_MB_INTERNAL_ENCODING);
                mb_regex_encoding(static::ENC_MB_REGEX_ENCODING);

                static::$mbInternalEncoding = true;
            }

            $function = 'mb_' . $function;
        }

        return $function;
    }


    /**
     * @param string $function
     * @param mixed  ...$arguments
     *
     * @return mixed
     */
    public function multibyte(string $function, ...$arguments)
    {
        $this->beginMultibyteMode($this->detectMultibyte(...$arguments));

        $result = $this->{$function}(...$arguments);

        $this->endMultibyteMode();

        return $result;
    }


    /**
     * @param string $mode
     *
     * @return void
     */
    public function beginMultibyteMode(string $mode) : void
    {
        if (! isset(static::THE_MODE_LIST[ $mode ])) {
            throw new InvalidArgumentException('Unsupported mode: ' . $mode);
        }

        $this->multibyteStack[] = $mode;
    }

    /**
     * @return void
     */
    public function endMultibyteMode() : void
    {
        array_pop($this->multibyteStack);

        $this->multibyteStack = $this->multibyteStack ?: $this->multibyteStackDefault;
    }

    /**
     * @param string   $mode
     * @param \Closure $closure
     *
     * @return void
     */
    public function multibyteMode(string $mode, \Closure $closure) : void
    {
        $this->beginMultibyteMode($mode);

        $closure($this);

        $this->endMultibyteMode();
    }


    /**
     * @param string|array|mixed $arguments
     *
     * @return string
     */
    public function detectMultibyte(...$arguments) : string
    {
        $isRecursive = false;
        foreach ( $arguments as $item ) {
            if (is_array($item)) {
                $isRecursive = true;
                break;
            }
        }

        if (! $isRecursive) {
            foreach ( $arguments as $item ) {
                if ($this->filterStringUtf8($item)) {
                    return static::MODE_UNICODE;
                }
            }

        } else {
            $queue = $arguments;
            while ( null === ( $k = key($queue) ) ) {
                if (! is_array($queue[ $k ])) {
                    if (null !== $this->filterStringUtf8($queue[ $k ])) {
                        return static::MODE_UNICODE;
                    }
                } else {
                    foreach ( $queue[ $k ] as $i ) {
                        $queue[] = $i;
                    }
                }

                unset($queue[ $k ]);
            }
        }

        return false;
    }


    /**
     * @return IStr
     */
    public static function getInstance() : IStr
    {
        return SupportFactory::getInstance()->getStr();
    }


    /**
     * @var bool
     */
    protected static $mbInternalEncoding;
}