<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Domain\Arr\ExpandVo;
use Gzhegow\Support\Domain\Arr\WalkIterator;
use Gzhegow\Support\Domain\Arr\CrawlIterator;
use Gzhegow\Support\Exceptions\Logic\OutOfRangeException;
use Gzhegow\Support\Exceptions\Runtime\UnderflowException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Exceptions\Runtime\UnexpectedValueException;


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
     * @var Str
     */
    protected $str;


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
     * @param array $array
     * @param int   $flags
     *
     * @return WalkIterator
     */
    protected function newWalkIterator(array $array, int $flags = 0)
    {
        return new WalkIterator($array, $flags);
    }

    /**
     * @param iterable $iterable
     * @param int      $flags
     *
     * @return CrawlIterator
     */
    protected function newCrawlIterator(iterable $iterable, int $flags = 0)
    {
        return new CrawlIterator($iterable, $flags);
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
     * @param null|mixed   $default
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
     * @param null|mixed   $default
     *
     * @return mixed
     */
    public function &getRef($path, array &$src, $default = null) // : mixed
    {
        $result = $this->reference($src, $path, $error);

        if ($error === static::ERROR_FETCHREF_NO_ERROR) {
            return $result;
        }

        if (3 === func_num_args()) {
            return $this->put($src, $path, $default);
        }

        throw new OutOfRangeException([ 'Index not found: %s', $path ]);
    }


    /**
     * @param string|array $path
     * @param array        $src
     *
     * @return bool
     */
    public function has($path, array &$src) : bool
    {
        $this->reference($src, $path, $error);

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
            throw new UnderflowException([ 'Unable to delete due to missing/invalid key: %s', $path ]);
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

        $fullpath = $this->str->explode('.', $path);

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
        $fullpath = $this->str->explode('.', $path);

        if (null === key($fullpath)) {
            throw new InvalidArgumentException([ 'Empty path passed: %s', $path ]);
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
     * @param string|string[]|array $keys
     * @param string|string[]|array $separators
     *
     * @return array
     */
    public function path($keys, $separators = '.') : array
    {
        $keys = $this->keys($keys);

        $result = $this->str->explode($separators, ...$keys);

        return $result;
    }

    /**
     * @param string|string[]|array $keys
     * @param string|string[]|array $separators
     *
     * @return string
     */
    public function key($keys, $separators = '.') : string
    {
        $keys = $this->keys($keys);

        $explode = $this->str->explode($separators, $keys);

        $result = implode($separators[ 0 ], $explode);

        return $result;
    }


    /**
     * @param string|string[]|array $separators
     * @param string|string[]|array ...$keys
     *
     * @return string
     */
    public function indexkey($separators = '.', ...$keys) : string
    {
        $result = $this->key($keys, $separators);

        return $result;
    }

    /**
     * @param mixed $value
     *
     * @return string
     */
    public function indexval($value) : string
    {
        $list = is_array($value)
            ? $value
            : [ $value ];

        $this->filter->assert()->assertPlainArray($list);

        $result = json_encode($value);

        return $result;
    }


    /**
     * в функцию array_intersect_key требуются ключи. можно делать array_flip(), а так будет производительнее
     *
     * @param array $array
     *
     * @return array
     */
    public function clear(array $array) : array
    {
        $result = [];

        foreach ( array_keys($array) as $key ) {
            $result[ $key ] = null;
        }

        return $result;
    }


    /**
     * @param array                 $array
     * @param string|string[]|array ...$keys
     *
     * @return array
     */
    public function only(array $array, ...$keys) : array
    {
        $keys = $this->theKeys($keys, true);

        $result = [];

        foreach ( $keys as $key ) {
            if (! array_key_exists($key, $array)) {
                continue;
            }

            $result[ $key ] = $array[ $key ];
        }

        return $result;
    }

    /**
     * @param array                 $array
     * @param string|string[]|array ...$keys
     *
     * @return array
     */
    public function except(array $array, ...$keys) : array
    {
        $keys = $this->theKeys($keys, true);

        $result = [];

        foreach ( $array as $i => $item ) {
            if (in_array($i, $keys, false)) {
                continue;
            }

            $result[ $i ] = $array[ $i ];
        }

        return $result;
    }

    /**
     * @param array                 $array
     * @param string|string[]|array ...$keys
     *
     * @return array
     */
    public function drop(array $array, ...$keys)
    {
        $keys = $this->theKeys($keys, true);

        foreach ( $keys as $key ) {
            unset($array[ $key ]);
        }

        $result = $array;

        return $result;
    }


    /**
     * array_combine позволяющий передать разное число ключей и значений
     *
     * @param string|string[]    $keys
     * @param null|mixed|mixed[] $values
     * @param bool               $drop
     *
     * @return array
     */
    public function combine(array $keys, $values = null, bool $drop = null) : array
    {
        $keys = $this->theKeys($keys);
        $drop = $drop ?? false;

        if (! is_array($values)) {
            $values = array_fill(0, count($keys), $values);
        }

        [ $kwargs, $args ] = $this->php->kwargs($values);

        $result = [];
        foreach ( $keys as $key ) {
            if (array_key_exists($key, $kwargs)) {
                $result[ $key ] = $kwargs[ $key ];

            } elseif ($args) {
                $index = key($args);
                $result[ $key ] = $args[ $index ];

                array_shift($args);
                unset($values[ $index ]);

            } else {
                $result[ $key ] = null;
            }
        }

        if (! $drop) {
            $diff = array_diff_key($values, $result);

            foreach ( $diff as $key => $val ) {
                $result[ $key ] = $val;
            }
        }

        return $result;
    }


    /**
     * обменивает местами номер элемента массива и номер ключа в массиве
     * [ [$a1, $a2], [$b1, $b2]... ] => [ [$a1, $b1], [$a2, $b2]... ]
     *
     * @param array $array
     * @param array ...$arrays
     *
     * @return array
     */
    public function zip(array $array, ...$arrays) : array
    {
        return $arrays
            ? array_map(null, $array, ...$arrays)
            : array_map(function ($val) {
                return [ $val ];
            }, $array);
    }

    /**
     * разбивает массив на два по указанному критерию
     *
     * @param array         $array
     * @param callable|null $func
     *
     * @return array
     */
    public function partition(array $array, callable $func = null) : array
    {
        $result = [
            $array,
            [],
        ];

        foreach ( $array as $i => &$item ) {
            $skip = $func
                ? ( false === $func($item, $i) )
                : empty($item);

            if ($skip) {
                continue;
            }

            $result[ 1 ][ $i ] = $item;

            unset($result[ 0 ][ $i ]);
        }
        unset($item);

        return $result;
    }

    /**
     * разбивает массив на группированный список и остаток, замыкание возвращает имя группы
     *
     * @param array         $array
     * @param \Closure|null $func
     *
     * @return array
     */
    public function group(array $array, \Closure $func = null) : array
    {
        $result = [
            [],
            [],
        ];

        foreach ( $array as $i => $item ) {
            $res = $func
                ? $func($item, $i)
                : null;

            if (null !== $res) {
                $this->filter->assert()->assertKey($res);
            }

            ( null !== $res )
                ? ( $result[ 0 ][ $res ][ $i ] = $item )
                : ( $result[ 1 ][ $i ] = $item );
        }

        return $result;
    }


    /**
     * @param iterable              $iterable
     * @param string|string[]|array $separators
     *
     * @return array
     */
    public function dot(iterable $iterable, $separators = '.') : array
    {
        $result = [];

        $generator = $this->crawl($iterable, \RecursiveIteratorIterator::SELF_FIRST);

        foreach ( $generator as $fullpath => $value ) {
            if (is_iterable($value)) {
                continue;
            }

            $result[ $this->key($fullpath, $separators) ] = $value;
        }

        return $result;
    }

    /**
     * @param iterable              $iterable
     * @param string|string[]|array $separators
     *
     * @return array
     */
    public function dotarr(iterable $iterable, $separators = '.') : array
    {
        $result = $this->dot($iterable, $separators);

        foreach ( $result as $dotkey => $value ) {
            $path = $this->str->explode($separators, $dotkey);
            $last = array_pop($path);

            if (null !== $this->filter->filterInt($last)) {
                $result[ implode($separators[ 0 ], $path) ][] = $value;

                unset($result[ $dotkey ]);
            }
        }

        return $result;
    }

    /**
     * @param array                 $data
     * @param string|string[]|array $separators
     *
     * @return array
     */
    public function undot(array $data, $separators = '.') : array
    {
        $result = [];

        foreach ( $data as $key => $value ) {
            $path = $this->path($key, $separators);

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
     * @param array $array
     * @param int   $flags
     *
     * @return \Generator
     */
    public function walk(array $array, int $flags = 0) : \Generator
    {
        $it = $this->newWalkIterator($array, $flags);

        foreach ( $it as $fullpath => $val ) {
            yield $fullpath => $val;
        }

        return $this;
    }

    /**
     * @param iterable $iterable
     * @param int      $flags
     *
     * @return \Generator
     */
    public function crawl(iterable $iterable, int $flags = 0) : \Generator
    {
        $it = $this->newCrawlIterator($iterable, $flags);

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
     * @param array[] ...$expands
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
     * @param string|string[]|array $keys
     * @param null|bool             $uniq
     *
     * @return string[]
     */
    public function keys($keys, bool $uniq = null) : array
    {
        $result = [];

        $keys = is_array($keys)
            ? $keys
            : [ $keys ];

        array_walk_recursive($keys, function ($word) use (&$result) {
            $word = $this->filter->filterKey($word);

            if (null === $word) {
                throw new InvalidArgumentException(
                    [ 'Each key should be string or number: %s', $word ]
                );
            }

            $result[] = strval($word);
        });

        if ($uniq ?? false) {
            $result = array_values(array_unique($result));
        }

        return $result;
    }

    /**
     * @param string|string[]|array $keys
     * @param null|bool             $uniq
     *
     * @return array
     */
    public function theKeys($keys, bool $uniq = null) : array
    {
        $result = $this->keys($keys, $uniq);

        if (! count($result)) {
            throw new InvalidArgumentException(
                [ 'At least one word should be provided: %s', $keys ],
            );
        }

        return $result;
    }


    /**
     * @param string|string[]|array $keys
     * @param null|bool             $uniq
     *
     * @return array
     */
    public function keysskip($keys, bool $uniq = null) : array
    {
        $result = [];

        $keys = is_array($keys)
            ? $keys
            : [ $keys ];

        array_walk_recursive($keys, function ($word) use (&$result) {
            $word = $this->filter->filterKey($word);

            if (null !== $word) {
                $result[] = $word;
            }
        });

        if ($uniq ?? false) {
            $result = array_values(array_unique($result));
        }

        return $result;
    }

    /**
     * @param string|string[]|array $keys
     * @param null|bool             $uniq
     *
     * @return array
     */
    public function theKeysskip($keys, bool $uniq = null) : array
    {
        $result = $this->keysskip($keys, $uniq);

        if (! count($result)) {
            throw new InvalidArgumentException(
                [ 'At least one word should be provided: %s', $keys ]
            );
        }

        return $result;
    }


    /**
     * @param array                 $source
     * @param string|string[]|array $path
     * @param null|int              $error
     *
     * @return mixed
     */
    protected function &reference(array &$source, $path, int &$error = null) // : mixed
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
