<?php

namespace Gzhegow\Support;


/**
 * Path
 */
class Path
{
    /**
     * @var Php
     */
    protected $php;
    /**
     * @var Str
     */
    protected $str;


    /**
     * @var string
     */
    protected $separator = '/';
    /**
     * @var string[]
     */
    protected $delimiters = [ '/' ];


    /**
     * Constructor
     *
     * @param Php $php
     * @param Str $str
     */
    public function __construct(
        Php $php,
        Str $str
    )
    {
        $this->str = $str;
        $this->php = $php;
    }


    /**
     * @param string|string[] $delimiters
     *
     * @return static
     */
    public function using(...$delimiters) : self
    {
        $delimiters = $this->str->theWords(...$delimiters);
        $delimiters = array_unique($delimiters);

        $this->separator = $delimiters[ 0 ];
        $this->delimiters = $delimiters;

        return $this;
    }



    /**
     * @param string $string
     *
     * @return string
     */
    public function optimize(string $string) : string
    {
        $result = str_replace($this->delimiters, $this->separator, $string);

        return $result;
    }

    /**
     * @param string     $string
     * @param null|array $delimiters
     *
     * @return string
     */
    public function pregOptimize(string $string, array &$delimiters = null) : string
    {
        $pattern = '(' . implode('|', array_map('preg_quote', $this->delimiters)) . ')';

        $result = preg_replace_callback($pattern, function ($m) use (&$delimiters) {
            $delimiters[] = $m[ 0 ];

            return $this->separator;
        }, $string);

        return $result;
    }


    /**
     * @param string|string[] ...$strvals
     *
     * @return array
     */
    public function split(...$strvals) : array
    {
        $strvals[] = '';

        $list = $this->str->stringsskip(...$strvals);

        $first = array_shift($list);
        $first = $this->optimize($first);

        $trim = ltrim($first, $this->separator);
        $prefix = str_repeat($this->separator, mb_strlen($first) - mb_strlen($trim));

        $split = $this->str->explode($this->delimiters, $first, $list);
        $split = array_filter($split, 'strlen');

        if ('' !== $prefix) {
            array_unshift($split, $prefix);
        }

        $result = array_values($split);

        return $result;
    }

    /**
     * @param string|string[] ...$strvals
     *
     * @return string
     */
    public function join(...$strvals) : string
    {
        $strvals[] = '';

        $list = $this->str->stringsskip(...$strvals);

        $first = array_shift($list);
        $first = $this->optimize($first);

        $trim = ltrim($first, $this->separator);
        $prefix = str_repeat($this->separator, mb_strlen($first) - mb_strlen($trim));

        $result = $this->str->joinskip($this->separator, $first, $list);

        if ('' !== $prefix) {
            $result = $prefix . $result;
        }

        return $result;
    }

    /**
     * @param string|string[] ...$strvals
     *
     * @return string
     */
    public function normalize(...$strvals) : string
    {
        $strvals[] = '';

        $list = $this->str->stringsskip(...$strvals);

        $first = array_shift($list);
        $first = $this->optimize($first);

        $trim = ltrim($first, $this->separator);
        $prefix = str_repeat($this->separator, mb_strlen($first) - mb_strlen($trim));

        $split = $this->str->explode($this->delimiters, $first, $list);
        $split = array_filter($split, 'strlen');

        $result = $this->str->joinskip($this->separator, $split);

        if ('' !== $prefix) {
            $result = $prefix . $result;
        }

        return $result;
    }


    /**
     * @param string|string[] ...$strvals
     *
     * @return string
     */
    public function concat(...$strvals) : string
    {
        $words = $this->str->stringsskip(...$strvals);
        $words = array_filter($words, 'strlen');

        $concat = array_shift($words);
        $concat = $this->normalize($concat);

        foreach ( $words as $word ) {
            $split = $this->str->explode($this->delimiters, $word);
            $split = array_values(array_filter($split, 'strlen'));

            while ( null !== key($split) ) {
                array_pop($split);

                $search = implode($this->separator, $split);
                $cut = $this->str->ends($concat, $search);

                if (null !== $cut) {
                    $concat = rtrim($cut, $this->separator);

                    continue;
                }

                break;
            }

            $concat = $this->join($concat, $word);
        }

        $result = $concat;

        return $result;
    }


    /**
     * @param string      $path
     * @param null|string $suffix
     * @param null|int    $levels
     *
     * @return null|string
     */
    public function basename(string $path, string $suffix = null, int $levels = null) : ?string
    {
        $levels = max(0, $levels ?? 0);

        $split = $this->split($path);
        $last = array_pop($split);

        $result = [];

        if ($levels) {
            $result = array_slice($split, -1 * $levels);
        }

        $cut = $this->str->ends($last, $suffix);
        $last = ( null !== $cut )
            ? $cut
            : $last;

        $result[] = $last;

        $result = $this->normalize($result);

        return $result;
    }

    /**
     * @param string      $path
     * @param string|null $base
     *
     * @return string
     */
    public function basepath(string $path, string $base = '') : ?string
    {
        $normalizedPath = $this->normalize($path);

        if ('' === $base) {
            return $normalizedPath;
        }

        $normalizedBase = $this->normalize($base);

        if (null === ( $result = $this->str->starts($normalizedPath, $normalizedBase) )) {
            return null;
        }

        $result = ltrim($result, $this->separator);

        return $result;
    }
}
