<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Domain\Arr\TreeIterator;
use Gzhegow\Support\Exceptions\Logic\OutOfRangeException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * Arr
 */
class Arr
{
    const ERROR_MISSING_KEY  = 1;
    const ERROR_NOT_AN_ARRAY = 2;
    const ERROR_NO_ERROR     = 0;


    /**
     * @var Php
     */
    protected $php;
    /**
     * @var Type
     */
    protected $type;

    /**
     * @var Indexer
     */
    protected $indexer;


    /**
     * Constructor
     *
     * @param Php          $php
     * @param Type         $type
     *
     * @param null|Indexer $indexer
     */
    public function __construct(
        Php $php,
        Type $type,

        Indexer $indexer = null
    )
    {
        $this->php = $php;
        $this->type = $type;

        $this->indexer = $indexer ?? $this->newIndexer();
    }


    /**
     * @return Indexer
     */
    protected function newIndexer() : Indexer
    {
        $indexer = new Indexer($this->php, $this->type);
        $indexer->setSeparator('.');

        return $indexer;
    }


    /**
     * @param string|array $path
     * @param array        $src
     * @param null         $default
     *
     * @return mixed
     */
    public function get($path, array &$src, $default = null) // : mixed
    {
        $result = ( 3 === func_num_args() )
            ? $this->ref($path, $src, $default)
            : $this->ref($path, $src);

        return $result;
    }


    /**
     * @param string|array $path
     * @param array        $src
     *
     * @return bool
     */
    public function has($path, array &$src) : bool
    {
        $this->traverse($src, $path, $error);

        return ( $error = static::ERROR_NO_ERROR )
            ? true
            : false;
    }


    /**
     * @param array        $dst
     * @param string|array $path
     * @param mixed        $value
     *
     * @return Arr
     */
    public function set(array &$dst, $path, $value)
    {
        $this->put($dst, $path, $value);

        return $this;
    }


    /**
     * @param array        $src
     * @param string|array $path
     *
     * @return Arr
     */
    public function del(array &$src, ...$path)
    {
        $fullpath = $this->path($path);

        $ref =& $src;

        $prev = null;
        $node = null;
        foreach ( $fullpath as &$node ) {
            $prev =& $ref;

            if (! array_key_exists($node, $ref)) {
                unset($prev);
                break;
            }

            $ref = &$ref[ $node ];
        }

        if (1
            && isset($prev)
            && ( 0
                || isset($prev[ $node ])
                || array_key_exists($node, $prev)
            )
        ) {
            unset($prev[ $node ]);
        }
        unset($node);
        unset($prev);

        unset($ref);

        return $this;
    }


    /**
     * @param string|array $path
     * @param array        $src
     * @param null         $default
     *
     * @return mixed
     */
    public function &ref($path, array &$src, $default = null) // : mixed
    {
        $result = $this->traverse($src, $path, $error);

        if (! $error) {
            return $result;
        }

        if (3 === func_num_args()) {
            return $this->put($src, $path, $default);
        }

        throw new OutOfRangeException('Path not found', func_get_args());
    }

    /**
     * @param array        $dst
     * @param string|array $path
     * @param mixed        $value
     *
     * @return mixed
     */
    public function &put(array &$dst, $path, $value) // : mixed
    {
        $fullpath = $this->path($path);
        $last = array_pop($fullpath);

        $valueRef =& $dst;

        if ($fullpath) {
            while ( null !== key($fullpath) ) {
                $valueRef =& $valueRef[ current($fullpath) ];

                next($fullpath);
            }
        }

        $valueRef[ $last ] = $value;

        return $valueRef[ $last ];
    }


    /**
     * @param iterable $iterable
     *
     * @return array
     */
    public function dot(iterable $iterable) : array
    {
        $result = [];

        $generator = $this->walk($iterable, \RecursiveIteratorIterator::SELF_FIRST);

        foreach ( $generator as $fullpath => $value ) {
            if (is_iterable($value)) continue;

            $result[ $this->dotkeyUnsafe($fullpath) ] = $value;
        }

        return $result;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function undot(array $data) : array
    {
        $result = [];

        foreach ( $data as $dot => $value ) {
            $path = $this->pathUnsafe($dot);

            $ref =& $result;
            while ( null !== key($path) ) {
                $ref =& $ref[ current($path) ];

                next($path);
            }
            $ref = $value;

            unset($ref);
        }

        return $result;
    }


    /**
     * @param array $path
     *
     * @return string
     */
    public function dotkey(...$path) : string
    {
        $result = $this->indexer->index(...$path);

        return $result;
    }

    /**
     * @param array $path
     *
     * @return string
     */
    public function dotkeyUnsafe(...$path) : string
    {
        $result = $this->indexer->indexUnsafe(...$path);

        return $result;
    }


    /**
     * @param mixed ...$path
     *
     * @return array
     */
    public function path(...$path) : array
    {
        $result = $this->indexer->pathUnsafe(...$path);

        return $result;
    }

    /**
     * @param mixed ...$path
     *
     * @return array
     */
    public function pathUnsafe(...$path) : array
    {
        $result = $this->indexer->path(...$path);

        return $result;
    }


    /**
     * @param iterable $iterable
     * @param int      $flags
     *
     * @return \Generator
     */
    public function walk(iterable $iterable, int $flags = 0) : \Generator
    {
        $it = new TreeIterator($iterable, $flags);

        foreach ( $it as $fullpath => $val ) {
            yield $fullpath => $val;
        }

        return $this;
    }


    /**
     * Inserts element into certain pos between existing elements
     *
     * @param array $array
     * @param int   $pos
     * @param null  $value
     *
     * @return array
     */
    public function expand(array $array, int $pos, $value = null) : array
    {
        if ($pos < 0) {
            throw new InvalidArgumentException('Pos should be non-negative', func_get_args());
        }

        $result = array_merge(
            array_slice($array, 0, $pos),
            [ $pos => $value ],
            array_slice($array, $pos)
        );

        return $result;
    }


    /**
     * @param array           $ref
     * @param string|string[] $path
     * @param null|int        $error
     *
     * @return mixed
     */
    protected function &traverse(array &$ref, $path, int &$error = null) // : mixed
    {
        $error = static::ERROR_NO_ERROR;

        $p = $this->path($path);

        $result =& $ref;
        while ( null !== key($p) ) {
            $key = array_shift($p);

            if (! array_key_exists($key, $ref)) {
                $error = static::ERROR_MISSING_KEY;

                unset($result);
                $result = null;

                break;
            }

            if ($p && ! is_array($ref[ $key ])) {
                $error = static::ERROR_MISSING_KEY + static::ERROR_NOT_AN_ARRAY;

                unset($result);
                $result = null;

                break;
            }

            $result =& $result[ $key ];
        }

        return $result;
    }
}
