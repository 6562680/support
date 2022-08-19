<?php
/**
 * @noinspection RedundantSuppression
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support;


use Gzhegow\Support\Traits\Load\StrLoadTrait;


/**
 * XPath
 */
class XPath implements IPath
{
    use StrLoadTrait;


    /**
     * @var string
     */
    protected $separator = '/';
    /**
     * @var string[]
     */
    protected $separatorAliases = [ '/' ];


    /**
     * @param null|string $separator
     *
     * @return static
     */
    public function withSeparator(?string $separator)
    {
        if (isset($separator)) {
            $separator = $this->getStr()->theLetterval($separator);
        }

        $this->separator = $separator ?? $this->loadSeparator();

        return $this;
    }

    /**
     * @param null|string[] $separatorAliases
     *
     * @return static
     */
    public function withSeparatorAliases(?array $separatorAliases)
    {
        if (isset($separatorAliases)) {
            $separatorAliases = $this->getStr()->theLettervals($separatorAliases, true);
        }

        $this->separatorAliases = $separatorAliases ?? $this->loadSeparatorAliases();

        return $this;
    }


    /**
     * @return string
     */
    public function loadSeparator() : string
    {
        return '/';
    }

    /**
     * @return string[]
     */
    public function loadSeparatorAliases() : array
    {
        return [ '/' ];
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
    public function getSeparatorAliases() : array
    {
        return $this->separatorAliases;
    }


    /**
     * @param string $path
     *
     * @return string
     */
    public function optimize(string $path) : string
    {
        $separators = $this->separators();

        $result = str_replace($separators, $this->separator, $path);

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
     * @param string|string[] ...$strings
     *
     * @return array
     */
    public function split(...$strings) : array
    {
        $separators = $this->separators();
        $separatorsImplode = implode('', $separators);

        // network: \\c\\documents
        // path: dir;./dir;~/dir;/dir
        // url: ftp://web;//web
        [ $protocol, $list ] = $this->protocol(...$strings);

        $split = $this->getStr()->explode($separators, $list);

        foreach ( $split as $idx => $e ) {
            $split[ $idx ] = trim($e, $separatorsImplode);
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
     * @param string|string[] ...$strings
     *
     * @return string
     */
    public function join(...$strings) : string
    {
        $separators = $this->separators();
        $separatorsImplode = implode('', $separators);

        // network: \\c\\documents
        // path: dir;./dir;~/dir;/dir
        // url: ftp://web;//web
        [ $protocol, $list ] = $this->protocol(...$strings);

        foreach ( $list as $idx => $l ) {
            $list[ $idx ] = ltrim($l, $separatorsImplode);
        }

        $result = $this->getStr()->joinSkip($this->separator, $list);

        if ('' !== $protocol) {
            $result = $protocol . $result;
        }

        return $result;
    }


    /**
     * @param string|string[] ...$strings
     *
     * @return string
     */
    public function concat(...$strings) : string
    {
        $theStr = $this->getStr();

        $separators = $this->separators();
        $separatorsImplode = implode('', $separators);

        $words = $theStr->wordvals($strings, null, true);

        $left = rtrim(array_shift($words), $separatorsImplode);
        $leftSplit = $theStr->explode($separators, $left);

        foreach ( $words as $right ) {
            $right = trim($right, $separatorsImplode);
            $rightSplit = $theStr->explode($separators, $right);

            $last = end($leftSplit);
            $i = key($leftSplit);
            if (false !== ( $ii = array_search($last, $rightSplit) )) {
                $match = [];

                while ( $ii >= 0 ) {
                    if ($leftSplit[ $i-- ] === $rightSplit[ $ii ]) {
                        $match[ $ii-- ] = true;
                    } else {
                        break;
                    }
                }

                if ($ii === -1) {
                    foreach ( $match as $ii => $bool ) {
                        unset($rightSplit[ $ii ]);
                    }
                }
            }

            foreach ( $rightSplit as $word ) {
                $leftSplit[] = $word;
            }
        }

        $result = $theStr->implode($this->separator, $leftSplit);
        $result = rtrim($result, $separatorsImplode);

        return $result;
    }


    /**
     * @param string   $path
     * @param null|int $level
     *
     * @return string
     */
    public function dirname(string $path, int $level = null) : string
    {
        $level = max(0, $level ?? 1);

        $explode = $this->split($path);

        $result = $this->join(
            array_slice($explode, 0, -$level)
        );

        return $result;
    }

    /**
     * @param string      $path
     * @param null|string $suffix
     * @param null|int    $level
     *
     * @return string
     */
    public function basename(string $path, string $suffix = null, int $level = null) : string
    {
        $result = [];

        $explode = $this->split($path);
        $last = array_pop($explode);

        if (isset($level)) {
            $level = max(0, $level ?? 0);

            $result[] = array_splice($explode, -$level);
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
    public function relative(string $path, string $base = null) : ?string
    {
        $base = $base ?? '';

        $normalizedPath = $this->normalize($path);

        if ('' === $base) {
            return $normalizedPath;
        }

        $normalizedBase = $this->normalize($base);

        if (null !== ( $result = $this->getStr()->starts($normalizedPath, $normalizedBase) )) {
            $result = ltrim($result, $this->separator);
        }

        return $result;
    }


    /**
     * @param string|array ...$strings
     *
     * @return array
     */
    public function protocol(...$strings) : array
    {
        $theStr = $this->getStr();

        $list = $theStr->theStrvals($strings, null, true);

        $separators = $this->separators();

        $delimiters = implode('', $separators);

        $first = null !== key($list)
            ? reset($list)
            : '';

        $implode = $this->optimize($first);
        $implodeTrim = ltrim($implode, $delimiters);

        $protocol = '';
        if ($count = ( $theStr->mb('strlen')($implode) - $theStr->mb('strlen')($implodeTrim) )) {
            $protocol = str_repeat($this->separator, $count);
        }

        return [ $protocol, $list ];
    }


    /**
     * @return array
     */
    protected function separators() : array
    {
        return array_merge([ $this->separator ], $this->separatorAliases);
    }


    /**
     * @return IPath
     */
    public static function getInstance() : IPath
    {
        return SupportFactory::getInstance()->getPath();
    }
}