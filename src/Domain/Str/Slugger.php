<?php

namespace Gzhegow\Support\Domain\Str;

use Gzhegow\Support\Exceptions\RuntimeException;


/**
 * Slugger
 */
class Slugger implements SluggerInterface
{
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

        $symbols = [];
        $symbolsRange = array_merge(
            range('A', 'Z'),
            range('a', 'z'),
            range('0', '9'),
        );
        foreach ( $symbolsRange as $s ) {
            $symbols[ $s ] = true;
        };

        $map = [];
        foreach ( $symbolsMap as $a => $b ) {
            if (isset($symbols[ $a ])) {
                $map[ $a ][] = $b;

            } elseif (isset($symbols[ $b ])) {
                $map[ $b ][] = $a;
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
                ?? $this->translitIconv($string)
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
     * @return null|string
     */
    protected function translitIconv(string $string) : ?string
    {
        $func = 'iconv';

        if (! ( extension_loaded('iconv') && function_exists($func) )) {
            return null;
        }

        $result = ( false !== ( $transliterated = $func('utf-8', 'us-ascii//TRANSLIT', $string) ) )
            ? $transliterated
            : null;

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
            [ 'ы' => 'i', 'й' => 'y' ], // 'ый'
            [ 'е' => 'c', 'х' => 'kh' ], // 'ех'
            [ 'с' => 'c', 'х' => 'kh' ], // 'сх'
            [ 'ц' => 'c', 'х' => 'kh' ], // 'цх'
        ];
    }

    /**
     * @return string[]
     */
    protected function symbolsMapDefault() : array
    {
        return [
            'À' => 'A',
            'Á' => 'A',
            'Â' => 'A',
            'Ã' => 'A',
            'Ä' => 'A',
            'Å' => 'A',
            'Æ' => 'A',
            'Ç' => 'C',
            'È' => 'E',
            'É' => 'E',
            'Ê' => 'E',
            'Ë' => 'E',
            'Ì' => 'I',
            'Í' => 'I',
            'Î' => 'I',
            'Ï' => 'I',
            'Ð' => 'D',
            'Ñ' => 'N',
            'Ò' => 'O',
            'Ó' => 'O',
            'Ô' => 'O',
            'Õ' => 'O',
            'Ö' => 'O',
            'Ø' => 'O',
            'Ù' => 'U',
            'Ú' => 'U',
            'Û' => 'U',
            'Ü' => 'U',
            'Ý' => 'Y',

            // 'Þ' => 'B',
            // 'ß' => 'Ss',

            'à' => 'a',
            'á' => 'a',
            'â' => 'a',
            'ã' => 'a',
            'ä' => 'a',
            'å' => 'a',
            'æ' => 'a',
            'ç' => 'c',
            'è' => 'e',
            'é' => 'e',
            'ê' => 'e',
            'ë' => 'e',
            'ì' => 'i',
            'í' => 'i',
            'î' => 'i',
            'ï' => 'i',
            'ð' => 'o',
            'ñ' => 'n',
            'ò' => 'o',
            'ó' => 'o',
            'ô' => 'o',
            'õ' => 'o',
            'ö' => 'o',
            'ø' => 'o',
            'ù' => 'u',
            'ú' => 'u',
            'û' => 'u',
            'ü' => 'ue',
            'ý' => 'y',
            'þ' => 'b',
            'ÿ' => 'y',
            'Ā' => 'A',
            'ā' => 'a',
            'Ă' => 'A',
            'ă' => 'a',
            'Ą' => 'A',
            'ą' => 'a',
            'Ć' => 'C',
            'ć' => 'c',
            'Ĉ' => 'C',
            'ĉ' => 'c',
            'Ċ' => 'C',
            'ċ' => 'c',
            'Č' => 'C',
            'č' => 'c',
            'Ď' => 'D',
            'ď' => 'd',
            'Đ' => 'Dj',
            'đ' => 'dj',
            'Ē' => 'E',
            'ē' => 'e',
            'Ĕ' => 'E',
            'ĕ' => 'e',
            'Ė' => 'E',
            'ė' => 'e',
            'Ę' => 'E',
            'ę' => 'e',
            'Ě' => 'E',
            'ě' => 'e',
            'Ĝ' => 'G',
            'ĝ' => 'g',
            'Ğ' => 'G',
            'ğ' => 'g',
            'Ġ' => 'G',
            'ġ' => 'g',
            'Ģ' => 'G',
            'ģ' => 'g',
            'Ĥ' => 'H',
            'ĥ' => 'h',
            'Ħ' => 'H',
            'ħ' => 'h',
            'Ĩ' => 'I',
            'ĩ' => 'i',
            'Ī' => 'I',
            'ī' => 'i',
            'Ĭ' => 'I',
            'ĭ' => 'i',
            'Į' => 'I',
            'į' => 'i',
            'İ' => 'I',
            'ı' => 'i',
            'Ĳ' => 'IJ',
            'ĳ' => 'ij',
            'Ĵ' => 'J',
            'ĵ' => 'j',
            'Ķ' => 'K',
            'ķ' => 'k',
            'ĸ' => 'k',
            'Ĺ' => 'K',
            'ĺ' => 'l',
            'Ļ' => 'K',
            'ļ' => 'l',
            'Ľ' => 'K',
            'ľ' => 'l',
            'Ŀ' => 'K',
            'ŀ' => 'l',
            'Ł' => 'K',
            'ł' => 'l',
            'Ń' => 'N',
            'ń' => 'n',
            'Ņ' => 'N',
            'ņ' => 'n',
            'Ň' => 'N',
            'ň' => 'n',
            'ŉ' => 'n',
            'Ŋ' => 'N',
            'ŋ' => 'n',
            'Ō' => 'O',
            'ō' => 'o',
            'Ŏ' => 'O',
            'ŏ' => 'o',
            'Ő' => 'O',
            'ő' => 'o',
            'Œ' => 'OE',
            'œ' => 'oe',
            'Ŕ' => 'R',
            'ŕ' => 'r',
            'Ŗ' => 'R',
            'ŗ' => 'r',
            'Ř' => 'R',
            'ř' => 'r',
            'Ś' => 'S',
            'Ŝ' => 'S',
            'Ş' => 'S',
            'Š' => 'S',
            'š' => 's',
            'Ţ' => 'T',
            'Ť' => 'T',
            'Ŧ' => 'T',
            'Ũ' => 'U',
            'ũ' => 'u',
            'Ū' => 'U',
            'ū' => 'u',
            'Ŭ' => 'U',
            'ŭ' => 'u',
            'Ů' => 'U',
            'ů' => 'u',
            'Ű' => 'U',
            'ű' => 'u',
            'Ų' => 'U',
            'ų' => 'u',
            'Ŵ' => 'W',
            'ŵ' => 'w',
            'Ŷ' => 'Y',
            'ŷ' => 'y',
            'Ÿ' => 'Y',
            'Ź' => 'Z',
            'ź' => 'z',
            'Ż' => 'Z',
            'ż' => 'z',
            'Ž' => 'Z',
            'ž' => 'z',

            // 'ſ' => 'ss',
            // 'ƒ' => 'f',
            // 'Ș' => 'S',
            // 'Ț' => 'T',

            'А' => 'A',
            'Б' => 'B',
            'В' => 'V',
            'Г' => 'G',
            'Д' => 'D',
            'Е' => 'E',
            'Ж' => 'Zh',
            'З' => 'Z',
            'И' => 'I',
            'Й' => 'J',
            'К' => 'K',
            'Л' => 'L',
            'М' => 'M',
            'Н' => 'N',
            'О' => 'O',
            'П' => 'P',
            'Р' => 'R',
            'С' => 'S',
            'Т' => 'T',
            'У' => 'U',
            'Ф' => 'F',
            'X' => 'H',
            'Ц' => 'C',
            'Ч' => 'Ch',
            'Ш' => 'Sh',
            'Щ' => 'Shch',
            'Ъ' => '',
            'Ы' => 'Y',
            'Ь' => '',
            'Э' => 'Eh',
            'Ю' => 'Yu',
            'Я' => 'Ya',

            'а' => 'a',
            'б' => 'b',
            'в' => 'v',
            'г' => 'g',
            'д' => 'd',
            'е' => 'e',
            'ж' => 'zh',
            'з' => 'z',
            'и' => 'i',
            'й' => 'j',
            'к' => 'k',
            'л' => 'l',
            'м' => 'm',
            'н' => 'n',
            'о' => 'o',
            'п' => 'p',
            'р' => 'r',
            'с' => 's',
            'т' => 't',
            'у' => 'u',
            'ф' => 'f',
            'х' => 'h',
            'ц' => 'c',
            'ч' => 'ch',
            'ш' => 'sh',
            'щ' => 'shch',
            'ъ' => '',
            'ы' => 'y',
            'ь' => '',
            'э' => 'eh',
            'ю' => 'yu',
            'я' => 'ya',

            'Ё' => 'YO',
            'ё' => 'yo',
        ];
    }
}
