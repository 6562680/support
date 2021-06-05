<?php

namespace Gzhegow\Support;


use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * Path
 */
class Path
{
    /**
     * @var Filter
     */
    protected $filter;
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
     * @param Filter $filter
     * @param Php    $php
     * @param Str    $str
     */
    public function __construct(
        Filter $filter,
        Php $php,
        Str $str
    )
    {
        $this->filter = $filter;
        $this->php = $php;
        $this->str = $str;
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
     * @param string $separator
     *
     * @return static
     */
    public function setSeparator(string $separator)
    {
        $this->separator = $separator;

        return $this;
    }

    /**
     * @param string[] $delimiters
     *
     * @return static
     */
    public function setDelimiters(array $delimiters)
    {
        $delimitersWord = $this->str->theWordvals($delimiters, true);
        if (! $delimitersWord) {
            throw new InvalidArgumentException(
                [ 'At least one delimiter should be passed: %s', $delimiters ]
            );
        }

        $this->separator = $delimitersWord[ 0 ];
        $this->delimiters = $delimitersWord;

        return $this;
    }


    /**
     * @param string|string[] $delimiters
     *
     * @return static
     */
    public function using(...$delimiters)
    {
        $this->setDelimiters($delimiters);

        return $this;
    }


    /**
     * @param string $path
     *
     * @return string
     */
    public function optimize(string $path) : string
    {
        $result = str_replace($this->delimiters, $this->separator, $path);

        return $result;
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public function normalize(string $path) : string
    {
        $path = $this->optimize($path);

        $strvals[] = '';
        $items = [];
        foreach ( explode($this->separator, $path) as $part ) {
            if ('.' == $part) {
                continue;
            }

            if ('..' == $part) {
                array_pop($items);

                continue;
            }

            $items[] = $part;
        }

        $result = implode($this->separator, $items);

        return $result;
    }


    /**
     * @param string|string[] ...$strvals
     *
     * @return array
     */
    public function split(...$strvals) : array
    {
        $delimiters = implode('', $this->delimiters);

        // network: \\c\\documents
        // path: dir;./dir;~/dir;/dir
        // url: ftp://web;//web
        [ $protocol, $list ] = $this->protocol(...$strvals);

        $split = $this->str->explode($this->delimiters, $list);

        foreach ( $split as $idx => $e ) {
            $split[ $idx ] = trim($e, $delimiters);
        }

        $split = array_filter($split, 'strlen');

        if ('' !== $protocol) {
            $first = array_shift($split);
            $first = $protocol . $first;
            array_unshift($split, $first);
        }

        $result = $split
            ? array_values($split)
            : [ '' ];

        return $result;
    }

    /**
     * @param string|string[] ...$strvals
     *
     * @return string
     */
    public function join(...$strvals) : string
    {
        $delimiters = implode('', $this->delimiters);

        // network: \\c\\documents
        // path: dir;./dir;~/dir;/dir
        // url: ftp://web;//web
        [ $protocol, $list ] = $this->protocol(...$strvals);

        foreach ( $list as $idx => $l ) {
            $list[ $idx ] = ltrim($l, $delimiters);
        }

        $result = $this->str->joinSkip($this->separator, $list);

        if ('' !== $protocol) {
            $result = $protocol . $result;
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
        $words = $this->str->strvals($strvals);
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

                    continue 2;
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
        $levels = $levels ?? 1;

        $explode = $this->split($path);

        $levelsTotal = count($explode);
        $levels = max(1, min($levels, $levelsTotal));

        $result = array_splice($explode, 0, $levelsTotal - $levels);

        $result = $this->join($result);

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
        $levels = $levels ?? 0;
        $levels = max(0, $levels);

        $explode = $this->split($path);
        $last = array_pop($explode);

        $result = [];

        if ($levels) {
            $result[] = array_slice($explode, -1 * $levels);
        }

        $result[] = basename($last, $suffix);

        $result = $this->join($result);

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


    /**
     * @param string|array ...$strings
     *
     * @return array
     */
    public function protocol(...$strings) : array
    {
        $list = $this->str->theStrvals($strings);

        $delimiters = implode('', $this->delimiters);

        $first = null !== key($list)
            ? reset($list)
            : '';

        $implode = $this->optimize($first);
        $implodeTrim = ltrim($implode, $delimiters);

        $protocol = '';
        if ($count = ( mb_strlen($implode) - mb_strlen($implodeTrim) )) {
            $protocol = str_repeat($this->separator, $count);
        }

        return [ $protocol, $list ];
    }
}
