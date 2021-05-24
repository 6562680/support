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
     * @param string|string[]|array ...$delimiters
     *
     * @return static
     */
    public function clone(...$delimiters)
    {
        $instance = clone $this;

        $instance->using(...$delimiters);

        return $instance;
    }


    /**
     * @return string
     */
    public function getSeparator() : string
    {
        return $this->separator;
    }

    /**
     * @return string[]
     */
    public function getDelimiters() : array
    {
        return $this->delimiters;
    }


    /**
     * @param string|string[] $delimiters
     *
     * @return static
     */
    public function using(...$delimiters)
    {
        $delimiters = $this->str->theWords($delimiters, true);

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
     * @param null|array $replacements
     *
     * @return string
     */
    public function pregOptimize(string $string, array &$replacements = null) : string
    {
        $pattern = '(' . implode('|', array_map('preg_quote', $this->delimiters)) . ')';

        $result = preg_replace_callback($pattern, function ($m) use (&$replacements) {
            $replacements[] = $m[ 0 ];

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

        $list = $this->str->stringsskip($strvals);

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

        $list = $this->str->stringsskip($strvals);

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

        $list = $this->str->stringsskip($strvals);

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
        $words = $this->str->stringsskip($strvals);
        $words = array_filter($words, 'strlen');

        $result = array_shift($words);

        $resultSteps = $this->str->explode($this->delimiters, $result);
        $resultSteps = array_values(array_filter($resultSteps, 'strlen'));

        foreach ( $words as $word ) {
            $wordSteps = $this->str->explode($this->delimiters, $word);
            $wordSteps = array_values(array_filter($wordSteps, 'strlen'));

            $len = count($wordSteps);

            while ( $len ) {
                $resultSplit = array_slice($resultSteps, -1 * $len);
                $wordSplit = array_slice($wordSteps, 0, $len);

                if ($resultSplit === $wordSplit) {
                    $resultSteps = array_merge($resultSteps,
                        array_slice($wordSteps, $len)
                    );

                    continue( 2 );
                }

                $len--;
            }

            $resultSteps = array_merge($resultSteps, $wordSteps);
        }

        $result = $this->str->join($this->separator, $resultSteps);

        return $result;
    }


    /**
     * @param string   $path
     * @param null|int $levels
     *
     * @return null|string
     */
    public function dirname(string $path, int $levels = null) : ?string
    {
        $levels = max(1, $levels ?? 1);

        $split = $this->split($path);
        $len = count($split);

        $levels = min($len, $levels);

        $result = $this->normalize(
            array_splice($split, 0, $len - $levels)
        );

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
            $result[] = array_slice($split, -1 * $levels);
        }

        $result[] = basename($last, $suffix);

        $result = $this->normalize($result);

        return $result;
    }

    /**
     * @param string      $path
     * @param string|null $base
     *
     * @return string
     */
    public function relative(string $path, string $base = '') : ?string
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
