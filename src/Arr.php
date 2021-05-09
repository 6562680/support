<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Domain\Arr\ExpandVo;
use Gzhegow\Support\Domain\Arr\WalkIterator;
use Gzhegow\Support\Exceptions\Logic\OutOfRangeException;
use Gzhegow\Support\Exceptions\Runtime\UnderflowException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * Arr
 */
class Arr
{
    const ERROR_FETCHREF_EMPTY_KEY    = 1;
    const ERROR_FETCHREF_MISSING_KEY  = 2;
    const ERROR_FETCHREF_NOT_AN_ARRAY = 3;
    const ERROR_FETCHREF_NO_ERROR     = 0;


    /**
     * @var Filter
     */
    protected $filter;
    /**
     * @var Php
     */
    protected $php;

    /**
     * @var Indexer
     */
    protected $indexer;



    /**
     * Constructor
     *
     * @param Filter       $filter
     * @param Php          $php
     * @param null|Indexer $indexer
     */
    public function __construct(
        Filter $filter,
        Php $php,

        Indexer $indexer = null
    )
    {
        $this->filter = $filter;
        $this->php = $php;

        $this->indexer = $indexer ?? $this->newIndexer();
    }


    /**
     * @return Indexer
     */
    protected function newIndexer() : Indexer
    {
        $indexer = new Indexer($this->filter, $this->php);
        $indexer->setSeparator('.');

        return $indexer;
    }


    /**
     * @param iterable $iterable
     * @param int      $flags
     *
     * @return WalkIterator
     */
    protected function newWalkIterator(iterable $iterable, int $flags = 0)
    {
        return new WalkIterator($iterable, $flags);
    }

    /**
     * @param mixed      $value
     * @param int|string $idx
     * @param int        $ordering
     * @param int        $priority
     * @param null|int   $idxInt
     *
     * @return ExpandVo
     */
    protected function newExpandVo($value, $idx, int $ordering, int $priority = 0, int $idxInt = null) : ExpandVo
    {
        return new ExpandVo($value, $idx, $ordering, $priority, $idxInt);
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
            ? $this->getRef($path, $src, $default)
            : $this->getRef($path, $src);

        return $result;
    }

    /**
     * @param string|array $path
     * @param array        $src
     * @param null         $default
     *
     * @return mixed
     */
    public function &getRef($path, array &$src, $default = null) // : mixed
    {
        $result = $this->fetchRef($src, $path, $error);

        if ($error === static::ERROR_FETCHREF_NO_ERROR) {
            return $result;
        }

        if (3 === func_num_args()) {
            return $this->put($src, $path, $default);
        }

        throw new OutOfRangeException('Path not found', func_get_args());
    }


    /**
     * @param string|array $path
     * @param array        $src
     *
     * @return bool
     */
    public function has($path, array &$src) : bool
    {
        $this->fetchRef($src, $path, $error);

        return $error === static::ERROR_FETCHREF_NO_ERROR;
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
     * @return array
     */
    public function del(array $src, ...$path) : ?array
    {
        if (false === ( $status = $this->delete($src, ...$path) )) {
            throw new UnderflowException('Unable to delete due to missing/invalid key', func_get_args());
        }

        return $src;
    }

    /**
     * @param array        $src
     * @param string|array $path
     *
     * @return bool
     */
    public function delete(array &$src, ...$path) : bool
    {
        $result = false;

        $fullpath = $this->path($path);

        $ref =& $src;

        $prev = null;
        $node = null;
        foreach ( $fullpath as $node ) {
            $prev =& $ref;

            if (! is_array($ref)) {
                unset($prev);

                break;
            }

            if (! array_key_exists($node, $ref)) {
                unset($prev);

                break;
            }

            $ref = &$ref[ $node ];
        }

        if (1
            && isset($prev)
            && ( isset($prev[ $node ]) || array_key_exists($node, $prev) )
        ) {
            unset($prev[ $node ]);

            $result = true;
        }
        unset($node);
        unset($prev);

        unset($ref);

        return $result;
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

        if (null === key($fullpath)) {
            throw new InvalidArgumentException('Empty path passed', func_get_args());
        }

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
        $result = $this->indexer->path(...$path);

        return $result;
    }

    /**
     * @param mixed ...$path
     *
     * @return array
     */
    public function pathUnsafe(...$path) : array
    {
        $result = $this->indexer->pathUnsafe(...$path);

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
        $it = $this->newWalkIterator($iterable, $flags);

        foreach ( $it as $fullpath => $val ) {
            yield $fullpath => $val;
        }

        return $this;
    }


    /**
     * Вставляет элементы в указанные позиции по индексам, изменяя числовые индексы существующих элементов
     *
     * Механизм применяется в dran-n-drop элементов списка при пользовательской сортировке
     * и в инжекторе зависимостей, чтобы между переданными параметрами воткнуть свой
     *
     * @param array   $dst
     * @param mixed[] ...$expands
     *
     * @return array
     */
    public function expandMany(array $dst, array ...$expands) : array
    {
        $inputs = $expands;
        $inputs[] = $dst;
        $exists = [];
        foreach ( $inputs as $input ) {
            foreach ( $input as $idx => $val ) {
                if (is_string($idx)) {
                    if (isset($exists[ $idx ])) {
                        throw new InvalidArgumentException(
                            'Duplicate string key: ' . $idx
                        );
                    }

                    $exists[ $idx ] = true;
                }
            }
        }

        $values = [];

        foreach ( $expands as $expand ) {
            $pos = 0;
            $lastIntIdx = -INF;
            foreach ( $expand as $idx => $val ) {
                $intIdx = is_int($idx)
                    ? $idx
                    : $lastIntIdx;

                $values[] = $this->newExpandVo($val, $idx, $pos++, $isNew = 1, $intIdx);

                $lastIntIdx = $intIdx;
            }
        }

        $pos = 0;
        $lastIntIdx = -INF;
        foreach ( $dst as $idx => $val ) {
            $intIdx = is_int($idx)
                ? $idx
                : $lastIntIdx;

            $values[] = $this->newExpandVo($val, $idx, $pos++, $isNew = 0, $intIdx);

            $lastIntIdx = $intIdx;
        }

        $funcSorter = function (ExpandVo $a, ExpandVo $b) : int {
            return null
                ?? ( $a->getIdxInt() - $b->getIdxInt() ?: null )
                ?? ( $b->getPriority() - $a->getPriority() ?: null )
                ?? ( $a->getOrdering() - $b->getOrdering() ?: null )
                ?? strnatcasecmp($a->getIdxStr(), $b->getIdxStr());
        };
        usort($values, $funcSorter);

        $conflicts = [];
        foreach ( $values as $val ) {
            $conflicts[ $val->getIdxInt() ][] = $val;
        }

        $result = [];

        $increment = 0;
        $intIdxPrev = key($conflicts);
        foreach ( array_keys($conflicts) as $intIdx ) {
            $increment = max(0, $increment - ( $intIdx - $intIdxPrev ));

            foreach ( $conflicts[ $intIdx ] as $val ) {
                $newIdxInt = $intIdx + $increment;
                $newIdxStr = null;

                $idx = $val->getIdx();
                if (is_int($idx)) {
                    $increment++;

                } else {
                    $newIdxStr = $idx;
                }

                $result[ $newIdxStr ?? $newIdxInt ] = $val->getValue();
            }

            $intIdxPrev = $intIdx;
        }

        return $result;
    }

    /**
     * @param array $dst
     * @param int   $expandIdx
     * @param mixed $expandValue
     *
     * @return array
     */
    public function expand(array $dst, int $expandIdx, $expandValue) : array
    {
        $result = $this->expandMany($dst, [ $expandIdx => $expandValue ]);

        return $result;
    }


    /**
     * @param array           $source
     * @param string|string[] $path
     * @param null|int        $error
     *
     * @return mixed
     */
    protected function &fetchRef(array &$source, $path, int &$error = null) // : mixed
    {
        $error = static::ERROR_FETCHREF_EMPTY_KEY;

        $fullpath = $this->path($path);

        $ref =& $source;
        while ( null !== key($fullpath) ) {
            $step = array_shift($fullpath);

            if (! array_key_exists($step, $ref)) {
                $error = static::ERROR_FETCHREF_MISSING_KEY;

                unset($ref);
                $ref = null;

                break;
            }

            if (count($fullpath) && ! is_array($ref[ $step ])) {
                $error = static::ERROR_FETCHREF_NOT_AN_ARRAY;

                unset($ref);
                $ref = null;

                break;
            }

            $ref =& $ref[ $step ];

            $error = static::ERROR_FETCHREF_NO_ERROR;
        }

        return $ref;
    }
}
