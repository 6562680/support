<?php

namespace Gzhegow\Support\Domain\Str;

use Gzhegow\Support\Str;
use Gzhegow\Support\Exceptions\RuntimeException;


/**
 * Slugger
 */
class Slugger implements SluggerInterface
{
    /**
     * @var Str
     */
    protected $str;

    /**
     * @var \Symfony\Component\String\Slugger\SluggerInterface $symfonySlugger
     */
    protected $symfonySlugger;

    /**
     * @var string|callable
     */
    protected $defaultLocale;
    /**
     * @var array|callable
     */
    protected $sequencesMap = [];
    /**
     * @var array|callable
     */
    protected $symbolsMap = [];


    /**
     * Constructor
     *
     * @param Str $str
     */
    public function __construct(Str $str)
    {
        $this->str = $str;
    }


    /**
     * @return null|string
     */
    public function getDefaultLocale() : ?string
    {
        $defaultLocale = null
            ?? ( is_callable($this->defaultLocale) ? call_user_func($this->defaultLocale) : null )
            ?? ( is_string($this->defaultLocale) ? $this->defaultLocale : null )
            ?? null;

        return $defaultLocale;
    }

    /**
     * @return array
     */
    public function getSequencesMap() : array
    {
        $sequencesMap = array_merge(
            $default = $this->sequenceMapDefault(),
            $new = null
                ?? ( is_callable($this->sequencesMap) ? call_user_func($this->sequencesMap) : null )
                ?? ( is_array($this->sequencesMap) ? $this->sequencesMap : null )
                ?? []
        );

        $sequences = [];
        foreach ( $sequencesMap as $sequence ) {
            $keys = array_keys($sequence);
            $sequence = array_values($sequence);

            $cnt = count($sequence);
            $max = implode('', array_fill(0, $cnt, 1));

            $search = [];
            $replacement = [];
            for ( $i = 0; $i <= bindec($max); $i++ ) {
                $bin = str_pad(decbin($i), $cnt, '0', STR_PAD_LEFT);

                for ( $ii = 0; $ii < $cnt; $ii++ ) {
                    if ('1' === $bin[ $ii ]) {
                        $search[ $ii ] = mb_strtoupper($keys[ $ii ]);
                        $replacement[ $ii ] = mb_strtoupper($sequence[ $ii ]);

                    } else {
                        $search[ $ii ] = $keys[ $ii ];
                        $replacement[ $ii ] = $sequence[ $ii ];
                    }
                }
            }

            $sequences[ implode('', $search) ] = implode('', $replacement);
        }

        return $sequences;
    }

    /**
     * @return array
     */
    public function getSymbolsMap() : array
    {
        $symbolsMap = array_merge(
            $default = $this->symbolsMapDefault(),
            $new = null
                ?? ( is_callable($this->symbolsMap) ? call_user_func($this->symbolsMap) : null )
                ?? ( is_array($this->symbolsMap) ? $this->symbolsMap : null )
                ?? []
        );

        $map = [];
        foreach ( $symbolsMap as $a => $b ) {
            $map[ $lower = mb_strtolower($a) ] = [];
            $map[ $upper = mb_strtoupper($a) ] = [];

            $b = is_array($b)
                ? $b
                : [ $b ];

            $list = [];
            foreach ( $b as $bb ) {
                $list = array_merge($list, $this->str->split($bb));
            }

            foreach ( $list as $l ) {
                $map[ $lower ][] = mb_strtolower($l);
                $map[ $upper ][] = mb_strtoupper($l);
            }
        }

        return $map;
    }


    /**
     * @param array|\Closure $defaultLocale
     *
     * @return static
     */
    public function defaultLocale($defaultLocale)
    {
        if (! ( is_string($defaultLocale) || is_callable($defaultLocale) )) {
            return $this;
        }

        $this->defaultLocale = $defaultLocale;

        return $this;
    }

    /**
     * @param array|\Closure $sequencesMap
     *
     * @return static
     */
    public function sequencesMap($sequencesMap)
    {
        if (! ( is_array($sequencesMap) || is_callable($sequencesMap) )) {
            return $this;
        }

        $this->sequencesMap = $sequencesMap;

        return $this;
    }

    /**
     * @param array|\Closure $symbolsMap
     *
     * @return static
     */
    public function symbolsMap($symbolsMap)
    {
        if (! ( is_array($symbolsMap) || is_callable($symbolsMap) )) {
            return $this;
        }

        $this->symbolsMap = $symbolsMap;

        return $this;
    }


    /**
     * @param null|\Symfony\Component\String\Slugger\SluggerInterface $symfonySlugger
     *
     * @return \Symfony\Component\String\Slugger\SluggerInterface
     */
    public function symfonySlugger($symfonySlugger = null)
    {
        $commands = [
            'composer require symfony/string',
            'composer require symfony/translation-contracts',
        ];

        if ($symfonySlugger) {
            if (! interface_exists($interface = 'Symfony\Component\String\Slugger\SluggerInterface')) {
                throw new RuntimeException([ 'Please, run following: %s', $commands ]);
            }

            if (! is_a($symfonySlugger, $interface)) {
                throw new RuntimeException([ 'Slugger should implements %s: %s', $interface, $symfonySlugger ]);
            }

            $this->symfonySlugger = $symfonySlugger;
        }

        if (! $this->symfonySlugger) {
            if (! class_exists($class = 'Symfony\Component\String\Slugger\AsciiSlugger')) {
                throw new RuntimeException([ 'Please, run following: %s', $commands ]);
            }

            $defaultLocale = null;
            if ('C' !== ( $locale = setlocale(LC_ALL, 0) )) {
                $defaultLocale = $locale;
            }

            $func = 'locale_get_default';
            if (extension_loaded('intl') && function_exists($func)) {
                $defaultLocale = $func();
            }

            $this->symfonySlugger = new $class($defaultLocale, $this->getSymbolsMap());
        }

        return $this->symfonySlugger;
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
        $delimiter = $delimiter ?? '-';

        if (null !== ( $slug = $this->translitSymfonySlugger($string, $delimiter, $locale) )) {
            return $slug;

        } else {
            $result = null
                ?? $this->translitTransliterator($string)
                // ?? $this->translitIconv($string)
                ?? $this->translitNative($string);

            $replacer = '-';

            $result = preg_replace('/' . preg_quote($delimiter, '/') . '/u', $replacer, $result);
            $result = preg_replace('/[^\\p{L}\d]+/u', $replacer, $result);
            $result = preg_replace('/([^a-z0-9])/iu', $replacer, $result);

            $result = trim($result, $replacer);

            $result = preg_replace('/' . preg_quote($replacer, '/') . '/u', $delimiter, $result);
        }

        return $result;
    }


    /**
     * @param string      $string
     * @param null|string $delimiter
     * @param null|string $locale
     *
     * @return null|string
     */
    protected function translitSymfonySlugger(string $string, string $delimiter = null, string $locale = null) : ?string
    {
        if (! interface_exists($interface = 'Symfony\Component\String\Slugger\SluggerInterface')) {
            return null;
        }

        $delimiter = $delimiter ?? '-';

        $isUTF = true;
        if (class_exists($class = 'Symfony\Component\String\BinaryString')) {
            $isUTF = ( new $class($string) )->{$method = 'isUtf8'}();
        }

        if ($isUTF) {
            $func = 'transliterator_transliterate';

            if (! ( extension_loaded('intl') && function_exists($func) )) {
                return null;
            }
        }

        $result = $this->symfonySlugger()->slug($string, $delimiter, $locale)->toString();

        return $result;
    }

    /**
     * @param string $string
     *
     * @return null|string
     */
    protected function translitTransliterator(string $string) : ?string
    {
        $func = 'transliterator_transliterate';

        if (! ( extension_loaded('intl') && function_exists($func) )) {
            return null;
        }

        $join = [];

        // split unicode accents and symbols, e.g. "Å" > "A°"
        $join[] = 'NFKD';

        // convert everything to the Latin charset e.g. "ま" > "ma":
        $join[] = 'Latin';

        // convert to ASCII
        $join[] = 'Latin/US-ASCII';

        // cache, remove non-printables, restore
        $join[] = 'NFD';
        $join[] = '[:Nonspacing Mark:] Remove';
        $join[] = 'NFC';

        $join = implode('; ', $join);

        $result = $func($join, $string);

        return $result;
    }

    /**
     * @param string $string
     *
     * @return string
     */
    protected function translitNative(string $string) : string
    {
        $result = $string;

        $sequncesMap = $this->getSequencesMap();
        $result = str_replace(
            array_keys($sequncesMap),
            array_values($sequncesMap),
            $result
        );

        $symbolsMap = $this->getSymbolsMap();
        foreach ( $symbolsMap as $replacement => $search ) {
            $result = str_replace($search, $replacement, $result);
        }

        return $result;
    }


    /**
     * @return string[]
     */
    protected function sequenceMapDefault() : array
    {
        return [
            'ый' => [ 'ы' => 'i', 'й' => 'y' ],
            'ех' => [ 'е' => 'c', 'х' => 'kh' ],
            'сх' => [ 'с' => 'c', 'х' => 'kh' ],
            'цх' => [ 'ц' => 'c', 'х' => 'kh' ],
        ];
    }

    /**
     * @return string[]
     */
    protected function symbolsMapDefault() : array
    {
        return [
            '' => 'ъь',

            'a' => [ 'aàáâãāăȧäảåǎȁąạḁẚầấẫẩằắẵẳǡǟǻậặæǽǣая' ],
            'b' => [ 'þб' ],
            'c' => [ 'çćĉċčц' ],
            'd' => [ 'ðďд' ],
            'e' => [ 'eèéêẽēĕėëẻěȅȇẹȩęḙḛềếễểḕḗệḝеёє' ],
            'f' => [ 'ƒф' ],
            'g' => [ 'ĝğġģг' ],
            'h' => [ 'ĥħх' ],
            'i' => [ 'iìíîĩīĭïỉǐịįȉȋḭḯиыії' ],
            'j' => [ 'ĵй' ],
            'k' => [ 'ķĸĺļľŀłк' ],
            'l' => [ 'ĺļľŀłл' ],
            'm' => [ 'м' ],
            'n' => [ 'ñńņňʼnŋн' ],
            'o' => [ 'oòóôõōŏȯöỏőǒȍȏơǫọøồốỗổȱȫȭṍṏṑṓờớỡởợǭộǿœо' ],
            'p' => [ 'ƥп' ],
            'r' => [ 'ŕŗřр' ],
            's' => [ 'śŝşšșс' ],
            't' => [ 'ţťŧțт' ],
            'u' => [ 'uùúûũūŭüủůűǔȕȗưụṳųṷṵṹṻǖǜǘǖǚừứữửựуюў' ],
            'v' => [ 'в' ],
            'w' => [ 'ŵ' ],
            'y' => [ 'ýÿŷы' ],
            'z' => [ 'źżžз' ],

            'ch'   => [ 'ч' ],
            'dj'   => [ 'đ' ],
            'eh'   => [ 'э' ],
            'ij'   => [ 'ĳ' ],
            'oe'   => [ 'œ' ],
            'sh'   => [ 'ш' ],
            'shch' => [ 'щ' ],
            'ss'   => [ 'ßſ' ],
            'ue'   => [ 'ü' ],
            'ya'   => [ 'я' ],
            'yo'   => [ 'ё' ],
            'yu'   => [ 'ю' ],
            'zh'   => [ 'ж' ],
        ];
    }


    // iconv(): Detected an illegal character in input string
    // /**
    //  * @param string $string
    //  *
    //  * @return null|string
    //  */
    // protected function translitIconv(string $string) : ?string
    // {
    //     $func = 'iconv';
    //
    //     if (! ( extension_loaded('iconv') && function_exists($func) )) {
    //         return null;
    //     }
    //
    //     // $result = ( false !== ( $transliterated = $func('UTF-8', 'US-ASCII//IGNORE//TRANSLIT', $string) ) )
    //     $result = ( false !== ( $transliterated = $func('UTF-8', 'US-ASCII//TRANSLIT', $string) ) )
    //         ? $transliterated
    //         : null;
    //
    //     return $result;
    // }
}
