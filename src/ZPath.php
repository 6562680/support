<?php
/**
 * @noinspection RedundantSuppression
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * ZPath
 */
class ZPath implements IPath
{
    /**
     * @var IFilter
     */
    protected $filter;
    /**
     * @var IPhp
     */
    protected $php;
    /**
     * @var IStr
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
     * @param IFilter $filter
     * @param IPhp    $php
     * @param IStr    $str
     */
    public function __construct(
        IFilter $filter,
        IPhp $php,
        IStr $str
    )
    {
        $this->filter = $filter;
        $this->php = $php;
        $this->str = $str;
    }


    /**
     * @return static
     */
    public function reset()
    {
        $this->separator = '/';
        $this->delimiters = [ '/' ];

        return $this;
    }


    /**
     * @param null|string       $separator
     * @param null|string|array $delimiters
     *
     * @return static
     */
    public function clone(?string $separator, ?array $delimiters)
    {
        $instance = clone $this;

        if (isset($separator)) $this->withSeparator($separator);
        if (isset($delimiters)) $this->withDelimiters($delimiters);

        return $instance;
    }


    /**
     * @param null|string       $separator
     * @param null|string|array $delimiters
     *
     * @return static
     */
    public function with(?string $separator, ?array $delimiters)
    {
        $this->reset();

        if (isset($separator)) $this->withSeparator($separator);
        if (isset($delimiters)) $this->withDelimiters($delimiters);

        return $this;
    }


    /**
     * @param string $separator
     *
     * @return static
     */
    public function withSeparator(string $separator)
    {
        $this->str->theWordval($separator);

        $this->separator = $separator;

        return $this;
    }

    /**
     * @param string[] $delimiters
     *
     * @return static
     */
    public function withDelimiters(array $delimiters)
    {
        $list = $this->str->theWordvals($delimiters, true);

        if (! $list) {
            throw new InvalidArgumentException(
                [ 'At least one delimiter should be passed: %s', $delimiters ]
            );
        }

        $this->delimiters = $list;

        return $this;
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
        $separators = $this->separators();
        $separatorsImplode = implode('', $separators);

        // network: \\c\\documents
        // path: dir;./dir;~/dir;/dir
        // url: ftp://web;//web
        [ $protocol, $list ] = $this->protocol(...$strvals);

        $split = $this->str->explode($separators, $list);

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
     * @param string|string[] ...$strvals
     *
     * @return string
     */
    public function join(...$strvals) : string
    {
        $separators = $this->separators();
        $separatorsImplode = implode('', $separators);

        // network: \\c\\documents
        // path: dir;./dir;~/dir;/dir
        // url: ftp://web;//web
        [ $protocol, $list ] = $this->protocol(...$strvals);

        foreach ( $list as $idx => $l ) {
            $list[ $idx ] = ltrim($l, $separatorsImplode);
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
        $separators = $this->separators();

        $words = $this->str->strvals($strvals);
        $words = array_filter($words, 'strlen');

        $result = array_shift($words);

        $resultSteps = $this->str->explode($separators, $result);
        $resultSteps = array_values(array_filter($resultSteps, 'strlen'));

        foreach ( $words as $word ) {
            $wordSteps = $this->str->explode($separators, $word);
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
     * @param null|int $level
     *
     * @return string
     */
    public function dirname(string $path, int $level = null) : string
    {
        $level = max(0, $level ?? 1);

        $explode = $this->split($path);

        $result = $this->join(
            $extracted = array_splice($explode, 0, -$level)
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

        if (null !== ( $result = $this->str->starts($normalizedPath, $normalizedBase) )) {
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
        $separators = $this->separators();

        $list = $this->str->theStrvals($strings);

        $delimiters = implode('', $separators);

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


    /**
     * @return array
     */
    protected function separators() : array
    {
        return array_merge([ $this->separator ], $this->delimiters);
    }


    /**
     * @return IPath
     */
    public static function getInstance() : IPath
    {
        return SupportFactory::getInstance()->getPath();
    }
}
