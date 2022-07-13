<?php

namespace Gzhegow\Support\Domain\Str;

use Gzhegow\Support\IStr;
use Gzhegow\Support\IPhp;
use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Exceptions\Runtime\UnexpectedValueException;


/**
 * Slugger
 */
class Slugger implements SluggerInterface
{
    const SYMFONY_ASCII_SLUGGER     = 'Symfony\Component\String\Slugger\AsciiSlugger';
    const SYMFONY_BINARY_STRING     = 'Symfony\Component\String\BinaryString';
    const SYMFONY_SLUGGER_INTERFACE = 'Symfony\Component\String\Slugger\SluggerInterface';


    /**
     * @var IStr
     */
    protected $str;


    /**
     * @var IPhp
     */
    protected $php;


    /**
     * @var \Symfony\Component\String\Slugger\SluggerInterface $symfonySlugger
     */
    protected $symfonySlugger;

    /**
     * @var string|callable
     */
    protected $localeDefault;

    /**
     * @var array|callable
     */
    protected $sequencesMap = [];
    /**
     * @var array|callable
     */
    protected $symbolsMap = [];
    /**
     * @var array|callable
     */
    protected $ignoreSymbols = [];


    /**
     * Constructor
     *
     * @param IStr $str
     * @param IPhp $php
     */
    public function __construct(
        IStr $str,
        IPhp $php
    )
    {
        $this->str = $str;
        $this->php = $php;
    }


    /**
     * @return null|string
     */
    public function getLocaleDefault() : ?string
    {
        $localeDefault = null
            ?? ( is_callable($this->localeDefault) ? call_user_func($this->localeDefault) : null )
            ?? ( is_string($this->localeDefault) ? $this->localeDefault : null )
            ?? null;

        return $localeDefault;
    }

    /**
     * @return null|string
     */
    public function getLocaleDefaultFromPhp() : ?string
    {
        $localeDefault = null;

        if (extension_loaded('intl') && function_exists($func = 'locale_get_default')) {
            $localeDefault = $func();

        } elseif ('C' !== ( $locale = setlocale(LC_ALL, 0) )) {
            $localeDefault = $locale;
        }

        return $localeDefault;
    }


    /**
     * @return array
     */
    public function getSequencesMapNative() : array
    {
        $sequencesMap = $this->fetchSequenceMapNative();

        $sequences = $this->prepareSequencesMap($sequencesMap);

        return $sequences;
    }

    /**
     * @return array
     */
    public function getSequencesMap() : array
    {
        $sequencesMap = null
            ?? ( is_callable($this->sequencesMap) ? call_user_func($this->sequencesMap) : null )
            ?? ( is_array($this->sequencesMap) ? $this->sequencesMap : null )
            ?? [];

        $sequences = $this->prepareSequencesMap($sequencesMap);

        return $sequences;
    }


    /**
     * @return array
     */
    public function getSymbolsMapNative() : array
    {
        $symbolsMap = $this->fetchSymbolsMapNative();

        $symbols = $this->prepareSymbolsMap($symbolsMap);

        return $symbols;
    }

    /**
     * @return array
     */
    public function getSymbolsMap() : array
    {
        $symbolsMap = null
            ?? ( is_callable($this->symbolsMap) ? call_user_func($this->symbolsMap) : null )
            ?? ( is_array($this->symbolsMap) ? $this->symbolsMap : null )
            ?? [];

        $symbols = $this->prepareSymbolsMap($symbolsMap);

        return $symbols;
    }


    /**
     * @return array
     */
    public function getIgnoreSymbols() : array
    {
        $ignoreSymbols = null
            ?? ( is_callable($this->ignoreSymbols) ? call_user_func($this->ignoreSymbols) : null )
            ?? ( is_array($this->ignoreSymbols) ? $this->ignoreSymbols : null )
            ?? [];

        $ignore = $this->prepareIgnoreSymbols($ignoreSymbols);

        return $ignore;
    }


    /**
     * @param array|\Closure $localeDefault
     *
     * @return static
     */
    public function localeDefault($localeDefault)
    {
        if (! ( is_string($localeDefault) || is_callable($localeDefault) )) {
            return $this;
        }

        $this->localeDefault = $localeDefault;

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
     * @param array|\Closure $ignoreSymbols
     *
     * @return static
     */
    public function ignoreSymbols($ignoreSymbols)
    {
        if (! ( is_array($ignoreSymbols) || is_callable($ignoreSymbols) )) {
            return $this;
        }

        $this->ignoreSymbols = $ignoreSymbols;

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
            if (! interface_exists($interface = static::SYMFONY_SLUGGER_INTERFACE)) {
                throw new RuntimeException([ 'Please, run following: %s', $commands ]);
            }

            if (! is_a($symfonySlugger, $interface)) {
                throw new RuntimeException([ 'Slugger should implements %s: %s', $interface, $symfonySlugger ]);
            }

            $this->symfonySlugger = $symfonySlugger;
        }

        if (! $this->symfonySlugger) {
            if (! class_exists($class = static::SYMFONY_ASCII_SLUGGER)) {
                throw new RuntimeException([ 'Please, run following: %s', $commands ]);
            }

            $defaultLocale = null
                ?? $this->getLocaleDefault()
                ?? $this->getLocaleDefaultFromPhp()
                ?? 'en';

            $this->symfonySlugger = new $class($defaultLocale, array_combine(
                $this->getIgnoreSymbols(),
                $this->getIgnoreSymbols()
            ));
        }

        return $this->symfonySlugger;
    }


    /**
     * @param string      $string
     * @param null|string $delimiter
     * @param null|string $locale
     *
     * @return null|string
     */
    public function slug(string $string, string $delimiter = null, string $locale = null) : ?string
    {
        $translitSymfonySlugger = null;
        $translitTransliterator = null;
        $translitNative = null;

        $result = null
            // ?? ($translitSymfonySlugger = $this->translitSymfonySlugger($string, $delimiter, $locale))
            // ?? ( $translitTransliterator = $this->translitTransliterator($string, $delimiter, $locale) )
            ?? ( $translitNative = $this->translitNative($string, $delimiter, $locale) ) //
        ;

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
        if (! strlen($string)) return '';

        if (! interface_exists($interface = static::SYMFONY_SLUGGER_INTERFACE)) {
            return null;
        }

        if (! class_exists($class = static::SYMFONY_BINARY_STRING)) {
            return null;
        }

        // @gzhegow > symfony transliterator fails if `intl` is not exists and string is in UTF encoding
        $isUTF = ( new $class($string) )->{$method = 'isUtf8'}();
        if ($isUTF && ! ( extension_loaded('intl') && function_exists($func = 'transliterator_transliterate') )) {
            return null;
        }

        $delimiter = $delimiter ?? '-';

        $result = $this->symfonySlugger()->slug($string, $delimiter, $locale)->toString();

        return $result;
    }

    /**
     * @param string      $string
     * @param null|string $delimiter
     * @param null|string $locale
     *
     * @return null|string
     */
    protected function translitTransliterator(string $string, string $delimiter = null, string $locale = null) : ?string
    {
        if (! strlen($string)) return '';

        if (! ( extension_loaded('intl') && function_exists($func = 'transliterator_transliterate') )) {
            return null;
        }

        $delimiter = $delimiter ?? '-';

        $result = $string;

        $result = $this->transliterateTransliterator($result, $delimiter, $locale);
        $result = $this->transliterateUser($result, $delimiter, $locale);
        $result = $this->transliterateDelimiter($result, $delimiter, $locale);

        return $result;
    }

    /**
     * @param string      $string
     * @param null|string $delimiter
     * @param null|string $locale
     *
     * @return string
     */
    protected function translitNative(string $string, string $delimiter = null, string $locale = null) : string
    {
        if (! strlen($string)) return '';

        $delimiter = $delimiter ?? '-';

        $result = $string;

        $result = $this->transliterateNative($result, $delimiter, $locale);
        $result = $this->transliterateUser($result, $delimiter, $locale);
        $result = $this->transliterateDelimiter($result, $delimiter, $locale);

        return $result;
    }


    /**
     * @param string      $string
     * @param null|string $delimiter
     * @param null|string $locale
     *
     * @return string
     */
    protected function transliterateTransliterator(string $string, string $delimiter = null, string $locale = null) : string
    {
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

        $func = 'transliterator_transliterate';
        $result = $func($join, $string);

        return $result;
    }


    /**
     * @param string      $string
     * @param null|string $delimiter
     * @param null|string $locale
     *
     * @return string
     */
    protected function transliterateNative(string $string, string $delimiter = null, string $locale = null) : string
    {
        $result = $string;

        $sequncesMap = $this->getSequencesMapNative();
        $result = str_replace(
            array_keys($sequncesMap),
            array_values($sequncesMap),
            $result
        );

        $symbolsMap = $this->getSymbolsMapNative();
        foreach ( $symbolsMap as $replacement => $search ) {
            $result = str_replace($search, $replacement, $result);
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
    protected function transliterateUser(string $string, string $delimiter = null, string $locale = null) : string
    {
        $result = $string;

        $sequencesMap = $this->getSequencesMap();
        $result = str_replace(
            array_keys($sequencesMap),
            array_values($sequencesMap),
            $result
        );

        $symbolsMap = $this->getSymbolsMap();
        foreach ( $symbolsMap as $replacement => $search ) {
            $result = str_replace($search, $replacement, $result);
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
    protected function transliterateDelimiter(string $string, string $delimiter = null, string $locale = null) : string
    {
        $result = $string;

        $replacer = "\0";

        $result = preg_replace('~' . preg_quote($delimiter, '/') . '~u', $replacer, $result);

        $ignoreSymbols = $this->getIgnoreSymbols();
        $ignoreSymbols = preg_quote(implode('', $ignoreSymbols), '/');

        $result = preg_replace('~[^\p{L}\d' . $ignoreSymbols . ']+~u', $replacer, $result);

        $result = trim($result, $replacer);

        $result = str_replace($replacer, $delimiter, $result);

        return $result;
    }


    /**
     * @param array $sequencesMap
     *
     * @return array
     */
    protected function prepareSequencesMap(array $sequencesMap) : array
    {
        $sequences = [];

        foreach ( $sequencesMap as $sequence ) {
            $keys = array_keys($sequence);
            $sequence = array_values($sequence);

            $keysCase = [];
            foreach ( $keys as $idx => $letter ) {
                $keysCase[ $idx ][] = $letter;
                $keysCase[ $idx ][] = mb_strtoupper($letter);
            }

            $sequenceCase = [];
            foreach ( $sequence as $idx => $letter ) {
                $sequenceCase[ $idx ][] = $letter;
                $sequenceCase[ $idx ][] = mb_strtoupper($letter);
            }

            $keysCase = $this->php->sequence(...$keysCase);
            $sequenceCase = $this->php->sequence(...$sequenceCase);

            foreach ( array_keys($keysCase) as $idx ) {
                $search = implode('', $keysCase[ $idx ]);
                $replacement = implode('', $sequenceCase[ $idx ]);

                if (( $search !== $replacement ) && ! isset($sequences[ $replacement ])) {
                    $sequences[ $search ] = $replacement;
                }
            }
        }

        return $sequences;
    }


    /**
     * @param array $symbolsMap
     *
     * @return array
     */
    protected function prepareSymbolsMap(array $symbolsMap)
    {
        $symbols = [];

        foreach ( $symbolsMap as $a => $b ) {
            $aLower = mb_strtolower($a);
            $aUpper = mb_strtoupper($a);

            $b = is_array($b) ? $b : [ $b ];

            $list = [];
            foreach ( $b as $bb ) {
                $list = array_merge($list, $this->str->split($bb));
            }

            foreach ( $list as $bb ) {
                $bbLen = mb_strlen($bb);
                $bbLower = mb_strtolower($bb);
                $bbUpper = mb_strtoupper($bb);

                // incorrect: ß -> 'SS'
                if (false
                    || ( $bbLen !== mb_strlen($bbLower) )
                    || ( $bbLen !== mb_strlen($bbUpper) )
                ) {
                    throw new UnexpectedValueException([
                        'Case change cause unexpected lenght difference, you should move pair into sequenceMap: %s / %s',
                        [ $a => $bb ],
                        [ $bb, $bbLower, $bbUpper ],
                    ]);
                }

                if (! isset($symbols[ $bbLower ])) {
                    $symbols[ $aLower ][] = $bbLower;
                }

                if (! isset($symbols[ $bbUpper ])) {
                    $symbols[ $aUpper ][] = $bbUpper;
                }
            }
        }

        return $symbols;
    }


    /**
     * @param string|string[] $ignoreSymbols
     *
     * @return array
     */
    protected function prepareIgnoreSymbols($ignoreSymbols) : array
    {
        $ignoreSymbols = is_iterable($ignoreSymbols)
            ? $ignoreSymbols
            : ( $ignoreSymbols ? [ $ignoreSymbols ] : [] );

        $ignore = [];

        foreach ( $ignoreSymbols as $symbol ) {
            foreach ( $this->str->split($symbol) as $sym ) {
                $ignore[ $sym ] = true;
            }
        }

        return array_keys($ignore);
    }


    /**
     * @return string[]
     */
    protected function fetchSequenceMapNative() : array
    {
        return [
            'ый' => [ 'ы' => 'i', 'й' => 'y' ],
            'ех' => [ 'е' => 'c', 'х' => 'kh' ],
            'сх' => [ 'с' => 'c', 'х' => 'kh' ],
            'цх' => [ 'ц' => 'c', 'х' => 'kh' ],

            'ẚ' => [ 'ẚ' => 'a' ],
            'ß' => [ 'ß' => 'ss' ],
        ];
    }

    /**
     * @return string[]
     */
    protected function fetchSymbolsMapNative() : array
    {
        return [
            ' ' => 'ъь',

            'a' => [ 'aàáâãāăȧäảåǎȁąạḁầấẫẩằắẵẳǡǟǻậặæǽǣая' ],
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
            'ss'   => [ 'ſ' ],
            'ue'   => [ 'ü' ],
            'ya'   => [ 'я' ],
            'yo'   => [ 'ё' ],
            'yu'   => [ 'ю' ],
            'zh'   => [ 'ж' ],
        ];
    }
}