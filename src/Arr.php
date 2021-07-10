<?php
/**
 * @noinspection RedundantSuppression
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\Error;
use Gzhegow\Support\Domain\Arr\ValueObject\ExpandValue;
use Gzhegow\Support\Exceptions\Logic\OutOfRangeException;
use Gzhegow\Support\Exceptions\Runtime\UnderflowException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * Arr
 */
class Arr implements IArr
{
    const ERROR_FETCHREF_EMPTY_KEY    = 1;
    const ERROR_FETCHREF_MISSING_KEY  = 2;
    const ERROR_FETCHREF_NOT_AN_ARRAY = 3;
    const ERROR_FETCHREF_NO_ERROR     = 0;


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
     * @var callable
     */
    protected $indexer;


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

        $this->reset();
    }


    /**
     * @return static
     */
    public function reset()
    {
        $this->indexer = $this->loadIndexerDefault();

        return $this;
    }


    /**
     * @param $indexer
     *
     * @return static
     */
    public function clone(?callable $indexer)
    {
        $instance = clone $this;

        if (isset($indexer)) $this->withIndexer($indexer);

        return $instance;
    }


    /**
     * @param null|callable $indexer
     *
     * @return static
     */
    public function with(?callable $indexer)
    {
        $this->reset();

        if (isset($indexer)) $this->withIndexer($indexer);

        return $this;
    }


    /**
     * @param callable $indexer
     *
     * @return static
     */
    public function withIndexer(callable $indexer)
    {
        $this->indexer = $indexer;

        return $this;
    }


    /**
     * @return \Closure
     */
    protected function loadIndexerDefault()
    {
        return function (&$value) {
            switch ( true ):
                case is_string($value):
                    break;

                case ( is_float($value) && is_nan($value) ):
                    $value = 'NaN';
                    break;

                case is_null($value):
                case is_bool($value):
                case is_int($value):
                case is_float($value):
                    $value = strval($value);
                    break;

                default:
                    throw new Error(
                        [ 'Unable to index passed element: %s', $value ]
                    );

            endswitch;
        };
    }


    /**
     * @param mixed      $value
     * @param int|string $idx
     * @param int        $ordering
     * @param int        $priority
     * @param null|int   $idxInt
     *
     * @return ExpandValue
     */
    protected function newExpandValue($value, $idx, int $ordering, int $priority = null, int $idxInt = null) : ExpandValue
    {
        $priority = $priority ?? 0;

        return new ExpandValue($value, $idx, $ordering, $priority, $idxInt);
    }


    /**
     * @param string|array $path
     * @param array        $src
     * @param null|mixed   $default
     *
     * @return mixed
     */
    public function &getRef($path, array &$src, $default = "\0") // : mixed
    {
        $result = $this->reference($src, $path, $error);

        if ($error === static::ERROR_FETCHREF_NO_ERROR) {
            return $result;
        }

        if ("\0" !== $default) {
            return $this->put($src, $path, $default);
        }

        throw new OutOfRangeException([ 'Index not found: %s', $path ]);
    }


    /**
     * @param mixed $value
     *
     * @return null|array
     */
    public function arrval($value) : ?array
    {
        if (is_array($value)) {
            return $value;

        } elseif (is_null($value)) {
            return [];

        } elseif (is_scalar($value)) {
            return [ $value ];

        } elseif (is_iterable($value)) {
            $result = [];

            foreach ( $value as $key => $item ) {
                ( null === ( $keyval = $this->keyval($key) ) )
                    ? ( $result[ $keyval ] = $item )
                    : ( $result[] = $item );
            }

            return $result;

        } elseif (is_object($value)) {
            // if (method_exists($value, 'toArray')) // too slow

            $result = null;

            try {
                $result = $value->toArray();
            }
            catch ( \Throwable $e ) {
            }

            /** @noinspection PhpExpressionAlwaysNullInspection */

            return $result;
        }

        return null;
    }

    /**
     * @param mixed $value
     *
     * @return array
     */
    public function theArrval($value) : array
    {
        if (null === ( $arrval = $this->arrval($value) )) {
            throw new InvalidArgumentException(
                [ 'Value should be convertable to arrval: %s', $value ],
            );
        }

        return $arrval;
    }


    /**
     * @param mixed $value
     *
     * @return null|int|float
     */
    public function keyval($value) // : ?int|float
    {
        if (null !== $this->filter->filterStrval($value)) {
            return strval($value);
        }

        if (null !== $this->filter->filterIntval($value)) {
            return intval($value);
        }

        return null;
    }

    /**
     * @param mixed $value
     *
     * @return null|int|float
     */
    public function theKeyval($value) // : ?int|float
    {
        if (null === ( $keyval = $this->keyval($value) )) {
            throw new InvalidArgumentException(
                [ 'Value should be convertable to keyval: %s', $value ],
            );
        }

        return $keyval;
    }


    /**
     * @param int|string|array $keys
     * @param null|bool        $uniq
     *
     * @return string[]
     */
    public function keyvals($keys, $uniq = null) : array
    {
        $result = [];

        $keys = is_array($keys)
            ? $keys
            : [ $keys ];

        array_walk_recursive($keys, function ($key) use (&$result) {
            $result[] = $this->keyval($key);
        });

        if ($uniq ?? false) {
            $arr = [];
            foreach ( $result as $i ) {
                $arr[ $i ] = true;
            }
            $result = array_keys($arr);
        }

        return $result;
    }

    /**
     * @param int|string|array $keys
     * @param null|bool        $uniq
     *
     * @return string[]
     */
    public function theKeyvals($keys, $uniq = null) : array
    {
        $result = [];

        $keys = is_array($keys)
            ? $keys
            : [ $keys ];

        array_walk_recursive($keys, function ($key) use (&$result) {
            $result[] = $this->theKeyval($key);
        });

        if ($uniq ?? false) {
            $arr = [];
            foreach ( $result as $i ) {
                $arr[ $i ] = true;
            }
            $result = array_keys($arr);
        }

        return $result;
    }


    /**
     * @param string|array $path
     * @param array        $src
     * @param null|mixed   $default
     *
     * @return mixed
     */
    public function get($path, array &$src, $default = "\0") // : mixed
    {
        $result = $this->getRef($path, $src, $default);

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
        $this->reference($src, $path, $error);

        return $error === static::ERROR_FETCHREF_NO_ERROR;
    }


    /**
     * @param null|array   $dst
     * @param string|array $path
     * @param mixed        $value
     *
     * @return Arr
     */
    public function set(?array &$dst, $path, $value)
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
        if (false === $this->delete($src, ...$path)) {
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
     * @param null|array   $dst
     * @param string|array $path
     * @param mixed        $value
     *
     * @return mixed
     */
    public function &put(?array &$dst, $path, $value) // : mixed
    {
        $fullpath = $this->path($path);

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
        $keys = $this->theKeyvals($keys);

        $result = $this->str->explode($separators, $keys);

        return $result;
    }

    /**
     * @param string|string[]|array $keys
     * @param string|string[]|array $separators
     *
     * @return string
     */
    public function pathkey($keys, $separators = '.') : string
    {
        $keys = $this->theKeyvals($keys);

        $result = $this->str->explode($separators, $keys);

        $result = implode($separators[ 0 ], $result);

        return $result;
    }


    /**
     * @param string|string[]|array $separators
     * @param string|string[]|array ...$keys
     *
     * @return string
     */
    public function index($separators = '.', ...$keys) : string
    {
        $keys = $this->theKeyvals($keys);

        $result = $this->str->explode($separators, $keys);

        $result = array_filter($result, 'strlen');

        $result = implode($separators[ 0 ], $result);

        return $result;
    }

    /**
     * возвращает индекс любого числа аргументов для создания поиска по массивам
     *
     * @param mixed ...$values
     *
     * @return string
     */
    public function indexed(...$values) : string
    {
        $list = $this->php->listval(...$values);

        $this->walk_recursive($list, $this->indexer);

        return json_encode($list);
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
        $keys = $this->theKeyvals($keys, true);

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
        $keys = $this->theKeyvals($keys, true);

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
        $keys = $this->theKeyvals($keys, true);

        foreach ( $keys as $key ) {
            unset($array[ $key ]);
        }

        $result = $array;

        return $result;
    }


    /**
     * array_combine позволяющий передать разное число ключей и значений
     *
     * @param string|array     $keys
     * @param null|mixed|array $values
     * @param null|bool        $drop
     *
     * @return array
     */
    public function combine(array $keys, $values = null, bool $drop = null) : array
    {
        $keys = $this->theKeyvals($keys);
        $drop = $drop ?? false;

        if (! is_array($values)) {
            $values = array_fill(0, count($keys), $values);
        }

        [ $strkeys, $intkeys ] = $this->php->kwargs($values);

        $result = [];
        foreach ( $keys as $key ) {
            if (array_key_exists($key, $strkeys)) {
                $result[ $key ] = $strkeys[ $key ];

            } elseif ($intkeys) {
                $index = key($intkeys);
                $result[ $key ] = $intkeys[ $index ];

                array_shift($intkeys);
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
     * array_combine + array_map
     *
     * @param string|array $keys
     * @param iterable     $collection
     * @param null|bool    $drop
     *
     * @return array
     */
    public function combineMap(array $keys, iterable $collection, bool $drop = null) : array
    {
        $result = [];

        foreach ( $collection as $idx => $array ) {
            $result[ $idx ] = $this->combine($keys, $array);
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
     * разбивает массив на два по указанному булеву критерию
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
     * разбивает массив на группированный список и остаток, замыкание должно возвращать имя группы
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
     * рекурсивно собирает массив в одноуровневый соединяя ключи через разделитель
     * пустые массивы пропускаются
     *
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
            if (! is_iterable($value)) {
                $result[ $this->pathkey($fullpath, $separators) ] = $value;
            }
        }

        return $result;
    }

    /**
     * рекурсивно собирает массив в одноуровневый соединяя ключи через разделитель
     * пустые массивы и цифровые ключи на последнем уровне остаются массивами
     *
     * @param iterable              $iterable
     * @param string|string[]|array $separators
     *
     * @return array
     */
    public function dotarr(iterable $iterable, $separators = '.') : array
    {
        $result = [];

        $nodes = [];
        foreach ( $this->crawl($iterable) as $fullpath => $value ) {
            $path = [];
            while ( is_string($current = current($fullpath)) ) {
                $path[] = $current;

                array_shift($fullpath);
            }

            $nodeKey = $this->pathkey($path, $separators);

            ( count($fullpath) )
                ? ( $this->set($nodes[ $nodeKey ], $fullpath, $value) )
                : ( $result[ $nodeKey ] = $value );
        }

        foreach ( $nodes as $nodeKey => $array ) {
            foreach ( $array as $idx => $node ) {
                ( $nodeKey === '' )
                    ? $result[ $idx ] = $node
                    : $result[ $nodeKey ][ $idx ] = $node;
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
     * @param array    $array
     * @param null|int $mode
     *
     * @return \Generator
     */
    public function walk(array $array, int $mode = null) : \Generator
    {
        $modes = [
            \RecursiveIteratorIterator::LEAVES_ONLY => true,
            \RecursiveIteratorIterator::SELF_FIRST  => true,
            \RecursiveIteratorIterator::CHILD_FIRST => true,
        ];

        $mode = isset($modes[ $mode ])
            ? $mode : \RecursiveIteratorIterator::LEAVES_ONLY;

        $queue = [ $array ];
        $tree = [ [] ];

        $index = 0;
        $branches = [];
        $leaves = [];
        $pathes = [];
        while ( null !== key($queue) ) {
            $current = array_shift($queue);
            $path = array_shift($tree);

            $hasChildren = ( is_array($current) && [] !== $current );

            if ([] !== $path) {
                $pathes[ $index ] = $path;

                ( $hasChildren )
                    ? ( $branches[ $index ] = $current )
                    : ( $leaves[ $index ] = $current );
            }

            if ($hasChildren) {
                foreach ( $current as $k => $v ) {
                    $fullpath = $path;
                    $fullpath[] = $k;

                    $queue[] = $v;
                    $tree[] = $fullpath;
                }
            }

            $index++;
        }

        for ( $i = 0; $i < $index; $i++ ) {
            $hasLeaf = array_key_exists($i, $leaves);
            $hasBranch = ! $hasLeaf
                && ( $mode === \RecursiveIteratorIterator::SELF_FIRST )
                && array_key_exists($i, $branches);

            if ($hasLeaf) {
                yield $pathes[ $i ] => $leaves[ $i ];
            }

            if ($hasBranch) {
                yield $pathes[ $i ] => $branches[ $i ];
            }
        }

        if ($mode === \RecursiveIteratorIterator::CHILD_FIRST) {
            foreach ( array_reverse(array_keys($branches)) as $i ) {
                yield $pathes[ $i ] => $branches[ $i ];
            }
        }

        return $this;
    }

    /**
     * @param iterable $iterable
     * @param null|int $mode
     * @param null|int $flags
     *
     * @return \Generator
     */
    public function crawl(iterable $iterable, int $mode = null, int $flags = null) : \Generator
    {
        $mode = $mode ?? \RecursiveIteratorIterator::LEAVES_ONLY;
        $flags = $flags ?? 0;

        $it = new \RecursiveArrayIterator($iterable, $flags);
        $iit = new \RecursiveIteratorIterator($it, $mode, $flags);

        foreach ( $iit as $key => $value ) {
            $fullpath = [];

            for ( $i = 0; $i < $iit->getDepth(); $i++ ) {
                $fullpath[] = $iit->getSubIterator($i)->key();
            }

            $fullpath[] = $iit->getInnerIterator()->key();

            yield $fullpath => $value;
        }

        return $this;
    }


    /**
     * @param array    $array
     * @param callable $callback
     * @param mixed    ...$args
     *
     * @return static
     */
    public function walk_recursive(array &$array, $callback, ...$args)
    {
        $queue = [];
        $pathes = [];

        $queue[] =& $array;
        $pathes[] = [];

        while ( null !== ( $key = key($queue) ) ) {
            next($queue);

            $processChildren = true;

            if ([] !== $pathes[ $key ]) {
                try {
                    ( 3 <= func_num_args() )
                        ? $callback($queue[ $key ], $pathes[ $key ], ...$args)
                        : $callback($queue[ $key ], $pathes[ $key ]);
                }
                catch ( \Exception $e ) {
                    $processChildren = false;
                }
            }

            $hasChildren = $processChildren
                && ( is_array($queue[ $key ]) && [] !== $queue[ $key ] );

            if ($hasChildren) {
                foreach ( array_keys($queue[ $key ]) as $k ) {
                    $fullpath = $pathes[ $key ];
                    $fullpath[] = $k;

                    $queue[] =& $queue[ $key ][ $k ];
                    $pathes[] = $fullpath;
                }
            }
        }

        return $this;
    }

    /**
     * @param array    $iterable
     * @param callable $callback
     * @param mixed    ...$args
     *
     * @return static
     */
    public function crawl_recursive(iterable $iterable, $callback, ...$args)
    {
        $queue = [];
        $pathes = [];

        $queue[] = $iterable;
        $pathes[] = [];

        while ( null !== ( $key = key($queue) ) ) {
            next($queue);

            $processChildren = true;

            if ([] !== $pathes[ $key ]) {
                try {
                    ( 3 <= func_num_args() )
                        ? $callback($queue[ $key ], $pathes[ $key ], ...$args)
                        : $callback($queue[ $key ], $pathes[ $key ]);
                }
                catch ( \Exception $e ) {
                    $processChildren = false;
                }
            }

            $hasChildren = $processChildren
                && ( is_iterable($queue[ $key ]) && [] !== $queue[ $key ] );

            if ($hasChildren) {
                foreach ( $queue[ $key ] as $k => $v ) {
                    $fullpath = $pathes[ $key ];
                    $fullpath[] = $k;

                    $queue[] = $queue[ $key ][ $k ];
                    $pathes[] = $fullpath;
                }
            }
        }

        return $this;
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
            foreach ( $input as $index => $val ) {
                if (is_string($index)) {
                    if (isset($exists[ $index ])) {
                        throw new InvalidArgumentException(
                            'Duplicate string key: ' . $index
                        );
                    }

                    $exists[ $index ] = true;
                }
            }
        }

        $values = [];

        foreach ( $expands as $expand ) {
            $pos = 0;
            $lastIntIdx = -INF;
            foreach ( $expand as $index => $val ) {
                $indexInteger = is_int($index)
                    ? $index
                    : $lastIntIdx;

                $values[] = $this->newExpandValue($val, $index, $pos++, $isNew = 1, $indexInteger);

                $lastIntIdx = $indexInteger;
            }
        }

        $pos = 0;
        $lastIntIdx = -INF;
        foreach ( $dst as $index => $val ) {
            $indexInteger = is_int($index)
                ? $index
                : $lastIntIdx;

            $values[] = $this->newExpandValue($val, $index, $pos++, $isNew = 0, $indexInteger);

            $lastIntIdx = $indexInteger;
        }

        $funcSorter = function (ExpandValue $a, ExpandValue $b) : int {
            return null
                ?? ( $a->getIndexInteger() - $b->getIndexInteger() ?: null )
                ?? ( $b->getPriority() - $a->getPriority() ?: null )
                ?? ( $a->getPosition() - $b->getPosition() ?: null )
                ?? strnatcasecmp($a->getIndexString(), $b->getIndexString());
        };
        usort($values, $funcSorter);

        $conflicts = [];
        foreach ( $values as $val ) {
            $conflicts[ $val->getIndexInteger() ][] = $val;
        }

        $result = [];

        $increment = 0;
        $indexIntegerPrev = key($conflicts);
        foreach ( array_keys($conflicts) as $indexInteger ) {
            $increment = max(0, $increment - ( $indexInteger - $indexIntegerPrev ));

            foreach ( $conflicts[ $indexInteger ] as $val ) {
                $newIndexInteger = $indexInteger + $increment;
                $newIndexString = null;

                $index = $val->getIndex();

                if (is_int($index)) {
                    $increment++;

                } else {
                    $newIndexString = $index;
                }

                $result[ $newIndexString ?? $newIndexInteger ] = $val->getValue();
            }

            $indexIntegerPrev = $indexInteger;
        }

        return $result;
    }


    /**
     * @param array        $source
     * @param string|array $path
     * @param null|int     $error
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


    /**
     * @return IArr
     */
    public static function getInstance()
    {
        return SupportFactory::getInstance()->getArr();
    }
}
