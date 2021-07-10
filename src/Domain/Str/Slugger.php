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
     * @param IStr $str
     *
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
                        'Case change cause lenght difference, you should move pair into sequence: %s / %s',
                        [ $a => $bb ],
                        [ $bb, $bbLower, $bbUpper ],
                    ]);
                }

                if (! isset($map[ $bbLower ])) {
                    $map[ $aLower ][] = $bbLower;
                }

                if (! isset($map[ $bbUpper ])) {
                    $map[ $aUpper ][] = $bbUpper;
                }
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

            'ẚ' => [ 'ẚ' => 'a' ],
            'ß' => [ 'ß' => 'ss' ],
        ];
    }

    /**
     * @return string[]
     */
    protected function symbolsMapDefault() : array
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
