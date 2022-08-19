<?php
/**
 * @noinspection RedundantSuppression
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support;

use Gzhegow\Support\Traits\Load\StrLoadTrait;
use Gzhegow\Support\Traits\Load\PhpLoadTrait;
use Gzhegow\Support\Traits\Load\NumLoadTrait;
use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Exceptions\Logic\OutOfRangeException;
use Gzhegow\Support\Exceptions\Runtime\UnderflowException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * XArr
 */
class XArr implements IArr
{
    use NumLoadTrait;
    use PhpLoadTrait;
    use StrLoadTrait;


    const ERROR_REF_EMPTY_KEY    = 1;
    const ERROR_REF_MISSING_KEY  = 2;
    const ERROR_REF_NOT_AN_ARRAY = 3;
    const ERROR_REF_NO_ERROR     = 0;


    /**
     * @param string|array $path
     * @param array        $src
     * @param null|mixed   $default
     *
     * @return mixed
     */
    public function get($path, array &$src, $default = null) // : mixed
    {
        $result = func_num_args() === 3
            ? $this->getRef($path, $src, $default)
            : $this->getRef($path, $src);

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
        $this->ref($src, $path, $error);

        return $error === static::ERROR_REF_NO_ERROR;
    }

    /**
     * @param null|array   $dst
     * @param string|array $path
     * @param mixed        $value
     *
     * @return static
     */
    public function set(?array &$dst, $path, $value)
    {
        $this->setRef($dst, $path, $value);

        return $this;
    }


    /**
     * @param int   $idx
     * @param array $src
     *
     * @return mixed
     */
    public function getIdx(int $idx, array &$src)
    {
        $result = $this->getRefIdx($idx, $src);

        return $result;
    }

    /**
     * @param int   $idx
     * @param array $src
     *
     * @return bool
     */
    public function hasIdx(int $idx, array &$src) : bool
    {
        $this->ref($src, $idx, $error);

        return $error === static::ERROR_REF_NO_ERROR;
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
        $result = $this->ref($src, $path, $error);

        if (! $error) {
            return $result;
        }

        if (func_num_args() === 3) {
            return $this->setRef($src, $path, $default);
        }

        throw new OutOfRangeException([
            'Path not found: %s',
            $path,
        ]);
    }

    /**
     * @param int   $idx
     * @param array $src
     *
     * @return mixed
     */
    public function &getRefIdx(int $idx, array &$src) // : mixed
    {
        $result = $this->refIdx($src, $idx, $error);

        if (! $error) {
            return $result;
        }

        throw new OutOfRangeException('Index not found: ' . $idx);
    }


    /**
     * @param null|array   $dst
     * @param string|array $path
     * @param mixed        $value
     *
     * @return mixed
     */
    public function &setRef(?array &$dst, $path, $value) // : mixed
    {
        $fullpath = $this->path($path);

        if (null === key($fullpath)) {
            throw new InvalidArgumentException([ 'Empty path passed: %s', $path ]);
        }

        $last = array_pop($fullpath);

        $valueRef =& $dst;
        if ($fullpath) {
            while ( null !== ( $k = key($fullpath) ) ) {
                $valueRef =& $valueRef[ $fullpath[ $k ] ];

                next($fullpath);
            }
        }

        $valueRef[ $last ] = $value;

        return $valueRef[ $last ];
    }

    /**
     * @param null|array $dst
     * @param int        $idx
     * @param mixed      $value
     *
     * @return mixed
     */
    public function &setRefIdx(?array &$dst, int $idx, $value) // : mixed
    {
        $valueRef =& $this->refIdx($dst, $idx, $error);

        if ($error) {
            $valueRef = $value;

            return $valueRef;
        }

        throw new OutOfRangeException('Index not found: ' . $idx);
    }


    /**
     * @param array|mixed   $array
     * @param null|callable $of
     *
     * @return null|array
     */
    public function filterArray($array, callable $of = null) : ?array
    {
        if (! is_array($array)) return null;
        if (! $array) return $array;

        foreach ( $array as &$val ) {
            if ($of && ! $of($val)) {
                return null;
            }
        }
        unset($val);

        return $array;
    }

    /**
     * @param array|mixed   $list
     * @param null|callable $of
     *
     * @return null|array
     */
    public function filterList($list, callable $of = null) : ?array
    {
        if (! is_iterable($list)) return null;
        if (! $list) return $list; // empty array is a list

        // contains string key? not a list
        foreach ( $list as $key => &$val ) {
            if (! is_int($key)) {
                return null;
            }

            if ($of && ! $of($val)) {
                return null;
            }
        }
        unset($val);

        return $list;
    }

    /**
     * @param array|mixed   $dict
     * @param null|callable $of
     *
     * @return null|array
     */
    public function filterDict($dict, callable $of = null) : ?array
    {
        if (! is_array($dict)) return null;
        if (! $dict) return $dict; // empty array is a dict

        foreach ( $dict as $key => &$val ) {
            if (null === $this->getStr()->filterWord($key)) {
                return null;
            }

            if ($of && ! $of($val)) {
                return null;
            }
        }
        unset($val);

        return $dict;
    }

    /**
     * @param array|mixed   $assoc
     * @param null|callable $of
     *
     * @return null|array
     */
    public function filterAssoc($assoc, callable $of = null) : ?array
    {
        if (! is_array($assoc)) return null;
        if (! $assoc) return $assoc; // empty array is an assoc

        $theStr = $this->getStr();

        // contains simulateonsly string/int key? is an assoc
        $hasStr = false;
        $hasInt = false;
        foreach ( $assoc as $key => $val ) {
            $hasInt = $hasInt || is_int($key);
            $hasStr = $hasStr || ( null !== $theStr->filterWord($key) );

            if ($hasInt && $hasStr) {
                break;
            }
        }

        if (! ( $hasInt && $hasStr )) {
            return null;
        }

        if ($of) {
            foreach ( $assoc as &$val ) {
                if (! $of($val)) {
                    return null;
                }
            }
            unset($val);
        }

        return $assoc;
    }


    /**
     * проверяет, содержит ли массив вложенные массивы
     *
     * @param array|mixed $array
     * @param null|int    $depth
     *
     * @return null|array
     */
    public function filterArrayDeep($array, int $depth = null) : ?array
    {
        $depth = $depth ?? 0;

        if (! is_array($array)) {
            return null;
        }

        $queue = $array;

        while ( null !== ( $k = key($queue) ) ) {
            if (is_array($queue[ $k ])) {
                if (! $depth--) {
                    return $array;

                } else {
                    $queue = array_merge($queue, $queue[ $k ]);
                }
            }

            unset($queue[ $k ]);
        }

        return null;
    }

    /**
     * проверяет, можно ли массив безопасно сериализовать
     *
     * @param array|mixed $array
     *
     * @return null|array
     */
    public function filterArrayPlain($array) : ?array
    {
        if (! is_array($array)) {
            return null;
        }

        $queue = [ $array ];
        while ( null !== ( $k = key($queue) ) ) {
            $cur = $queue[ $k ];
            unset($queue[ $k ]);

            if (is_null($cur) || is_scalar($cur)) {
                continue;

            } elseif (is_array($cur)) {
                foreach ( $cur as $value ) {
                    $queue[] = $value;
                }

                continue;
            }

            return null;
        }

        return $array;
    }


    /**
     * проверяет, может ли переменная быть приведена к массиву
     *
     * @param mixed $value
     *
     * @return null|mixed
     */
    public function filterArrval($value) // : ?mixed
    {
        if (is_array($value)
            || is_null($value)
            || is_scalar($value)
            || is_iterable($value)
        ) {
            return $value;

        } elseif (is_object($value)) {
            $result = null;

            try {
                $result = $value->toArray();
            }
            catch ( \Throwable $e ) {
            }

            return null !== $result
                ? $value
                : null;
        }

        return null;
    }


    /**
     * \Generator может передать любой объект в качестве ключа для foreach, пригодится
     *
     * @param int|string|mixed $value
     *
     * @return null|int|string
     */
    public function filterArrayKey($value) // : ?int|string
    {
        if (null !== $this->getStr()->filterStringOrInt($value)) {
            return $value;
        }

        return null;
    }


    /**
     * @param array        $src
     * @param string|array $path
     *
     * @return array
     */
    public function del(array &$src, ...$path) : ?array
    {
        if (false === $this->delRef($src, ...$path)) {
            throw new UnderflowException([
                'Unable to delete due to missing/invalid key: %s',
                $path,
            ]);
        }

        return $src;
    }

    /**
     * @param array $src
     * @param int   $idx
     *
     * @return array
     */
    public function delIdx(array &$src, int $idx) : ?array
    {
        if (false === $this->delRefIdx($src, $idx)) {
            throw new UnderflowException([
                'Unable to delete due to missing/invalid idx: %s',
                $idx,
            ]);
        }

        return $src;
    }


    /**
     * @param array        $src
     * @param string|array $path
     *
     * @return bool
     */
    public function delRef(array &$src, ...$path) : bool
    {
        $result = false;

        $fullpath = $this->path($path);

        $ref =& $src;

        $slug = null;
        $refPrev = null;
        foreach ( $fullpath as $slug ) {
            $refPrev =& $ref;

            if (! is_array($ref)) {
                unset($refPrev);

                break;
            }

            if (! array_key_exists($slug, $ref)) {
                unset($refPrev);

                break;
            }

            $ref = &$ref[ $slug ];
        }

        if (1
            && isset($refPrev)
            && ( isset($refPrev[ $slug ]) || array_key_exists($slug, $refPrev) )
        ) {
            unset($refPrev[ $slug ]);

            $result = true;
        }
        unset($refPrev);
        unset($slug);

        unset($ref);

        return $result;
    }

    /**
     * @param array $src
     * @param int   $idx
     *
     * @return bool
     */
    public function delRefIdx(array &$src, int $idx) : bool
    {
        $result = false;

        $abs = abs($idx);

        if ($idx < 0) end($src);

        while ( null !== ( $k = key($src) ) ) {
            if (! $abs--) {
                if (array_key_exists($k, $src)) {
                    $result = true;
                }

                unset($src[ $k ]);

                break;
            }

            ( $idx < 0 )
                ? prev($src)
                : next($src);
        }

        return $result;
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
        if (null !== $this->getNum()->filterIntval($value)) {
            return intval($value);
        }

        if (null !== $this->getStr()->filterStrval($value)) {
            return strval($value);
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
        if (null === ( $val = $this->keyval($value) )) {
            throw new InvalidArgumentException(
                [ 'Value should be convertable to keyval: %s', $value ],
            );
        }

        return $val;
    }


    /**
     * @param array|mixed ...$values
     *
     * @return array
     */
    public function listval(...$values) : array
    {
        $result = [];

        $list = [];
        foreach ( $values as $value ) {
            if (null === $this->filterList($value)) {
                $list[] = $value;

            } else {
                foreach ( $value as $v ) {
                    $list[] = $v;
                }
            }
        }

        foreach ( $list as $val ) {
            if (! is_null($val)) {
                $result[] = $val;
            }
        }

        return $result;
    }

    /**
     * @param array|mixed ...$lists
     *
     * @return array
     */
    public function listvalEach(...$lists) : array
    {
        $result = [];

        foreach ( $lists as $idx => $list ) {
            $result[ $idx ] = $this->listval($list);
        }

        return $result;
    }


    /**
     * @param array|mixed ...$enums
     *
     * @return array
     */
    public function enumval(...$enums) : array
    {
        $theNum = $this->getNum();
        $thePhp = $this->getPhp();
        $theStr = $this->getStr();

        $result = [];

        $queue = [];
        foreach ( $enums as $idx => $enum ) {
            $queue[] = [ $idx, $enum ];
        }

        while ( null !== ( $k = key($queue) ) ) {
            if (is_array($queue[ $k ][ 1 ])) {
                foreach ( $queue[ $k ][ 1 ] as $kk => $vv ) {
                    $queue[] = [ $kk, $vv ];
                }

            } else {
                $value = null
                    ?? ( true === $queue[ $k ][ 1 ] ? $queue[ $k ][ 0 ] : null )
                    ?? $theStr->filterWord($queue[ $k ][ 0 ])
                    ?? $theStr->filterWordOrNum($queue[ $k ][ 1 ])
                    ?? $theNum->filterInt($queue[ $k ][ 0 ]);

                if (null !== $value) {
                    $result[ $thePhp->uniqhash($value) ] = $value;
                }
            }

            unset($queue[ $k ]);
        }

        $result = array_values($result);

        return $result;
    }

    /**
     * @param array|mixed ...$enums
     *
     * @return array
     */
    public function enumvalEach(...$enums) : array
    {
        $result = [];

        foreach ( $enums as $idx => $enum ) {
            $result[ $idx ] = $this->enumval($enum);
        }

        return $result;
    }


    /**
     * @param string|string[]|array $path
     * @param string|string[]|array $separators
     *
     * @return array
     */
    public function path($path, $separators = '.') : array
    {
        $keypath = $this->theKeyvals($path, null, true);

        $result = $this->getStr()->explode($separators, $keypath);

        return $result;
    }

    /**
     * @param string|string[]|array $path
     * @param string|string[]|array $separators
     *
     * @return string
     */
    public function pathkey($path, $separators = '.') : string
    {
        $keypath = $this->theKeyvals($path, null, true);

        $result = $this->getStr()->explode($separators, $keypath);

        $result = implode($separators[ 0 ], $result);

        return $result;
    }


    /**
     * @param int|string|array $keys
     * @param null|bool        $uniq
     * @param null|bool        $recursive
     *
     * @return string[]
     */
    public function keyvals($keys, bool $uniq = null, bool $recursive = null) : array
    {
        $result = [];

        $keys = is_array($keys)
            ? array_reverse($keys)
            : [ $keys ];

        if ($recursive) {
            array_walk_recursive($keys, function ($item) use (&$result) {
                if (null !== ( $val = $this->keyval($item) )) {
                    $result[] = $val;
                }
            });

        } else {
            foreach ( $keys as $item ) {
                if (null !== ( $val = $this->keyval($item) )) {
                    $result[] = $val;
                }
            }
        }

        if ($uniq) {
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
     * @param null|bool        $recursive
     *
     * @return string[]
     */
    public function theKeyvals($keys, bool $uniq = null, bool $recursive = null) : array
    {
        $result = [];

        $keys = is_array($keys)
            ? $keys
            : [ $keys ];

        if ($recursive) {
            array_walk_recursive($keys, function ($item) use (&$result) {
                $result[] = $this->theKeyval($item);
            });

        } else {
            foreach ( $keys as $item ) {
                $result[] = $this->theKeyval($item);
            }
        }

        if ($uniq) {
            $arr = [];
            foreach ( $result as $i ) {
                $arr[ $i ] = true;
            }
            $result = array_keys($arr);
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
        $keys = $this->theKeyvals($keys, true, true);

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
        $keys = $this->theKeyvals($keys, true, true);

        foreach ( $keys as $key ) {
            unset($array[ $key ]);
        }

        return $array;
    }

    /**
     * очищает указанные ключи в массиве. если не передать ключи - очистит все
     *
     * @param array                 $array
     * @param string|string[]|array ...$keys
     *
     * @return array
     */
    public function drop(array $array, ...$keys) : array
    {
        $keys = $keys
            ? $this->keyvals($keys, true, true)
            : null;

        $keys = $keys ?? array_keys($array);

        foreach ( $keys as $key ) {
            $array[ $key ] = null;
        }

        return $array;
    }


    /**
     * возвращает срез массива по числовым порядковым номерам элементов $arr = [ 1, 2, 3, 4 ] -> $arr[-3:2] -> [ 1 ]
     *
     * @param array     $array
     * @param int       $start
     * @param null|int  $end
     * @param bool|null $preserveKeys
     *
     * @return array
     */
    public function slicePos(array $array, int $start, int $end = null, bool $preserveKeys = null) : array
    {
        $preserveKeys = $preserveKeys ?? false;

        $size = count($array);

        $first = null
            ?? ( ( 0 < $start ) ? $start : null )
            ?? ( ( 0 > $start ) ? $size + $start : null )
            ?? 0;

        $len = null
            ?? ( ( null === $end ) ? $size : null )
            ?? ( ( 0 < $end ) ? $end - $first : null )
            ?? ( ( 0 > $end ) ? ( ( $size + $end ) - $first ) : null )
            ?? 0;

        $result = array_slice($array, $start, $len, $preserveKeys);

        return $result;
    }

    /**
     * возвращает срез массива по числовым порядковым номерам элементов, изменяя сам массив $arr = [ 1, 2, 3, 4 ] -> $arr[-3:2] -> [ 1 ]
     *
     * @param array    $array
     * @param int      $start
     * @param null|int $end
     * @param mixed    $replacement
     *
     * @return array
     */
    public function splicePos(array &$array, int $start, int $end = null, $replacement = null) : array
    {
        $size = count($array);

        $first = null
            ?? ( ( 0 < $start ) ? $start : null )
            ?? ( ( 0 > $start ) ? $size + $start : null )
            ?? 0;

        $len = null
            ?? ( ( null === $end ) ? $size : null )
            ?? ( ( 0 < $end ) ? $end - $first : null )
            ?? ( ( 0 > $end ) ? ( ( $size + $end ) - $first ) : null )
            ?? 0;

        $result = array_splice($array, $start, $len, $replacement);

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

        $args = [];
        $kwargs = [];
        foreach ( $values as $i => $v ) {
            is_int($i)
                ? ( $args[ $i ] = $v )
                : ( $kwargs[ $i ] = $v );
        }

        $result = [];
        foreach ( $keys as $key ) {
            if (array_key_exists($key, $kwargs)) {
                $result[ $key ] = $kwargs[ $key ];

            } elseif ($args) {
                unset($values[ key($args) ]);

                $result[ $key ] = array_shift($args);

            } else {
                $result[ $key ] = null;
            }
        }

        if (! $drop) {
            $diff = array_diff_key($kwargs, $result);

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
     * @param iterable     $it
     * @param null|bool    $drop
     *
     * @return array
     */
    public function combineMap(array $keys, iterable $it, bool $drop = null) : array
    {
        $result = [];

        foreach ( $it as $idx => $value ) {
            $result[ $idx ] = $this->combine($keys, $value);
        }

        return $result;
    }


    /**
     * возвращает массив без повторов
     *
     * @param mixed ...$values
     *
     * @return array
     */
    public function unique(...$values) : array
    {
        $thePhp = $this->getPhp();

        $result = [];

        foreach ( $this->listval(...$values) as $value ) {
            $result[ $thePhp->uniqhash($value) ] = $value;
        }

        $result = array_values($result);

        return $result;
    }

    /**
     * возвращает массив без повторов, в каждом
     *
     * @param mixed ...$arrays
     *
     * @return array
     */
    public function uniqueEach(...$arrays) : array
    {
        $result = [];

        foreach ( $arrays as $idx => $array ) {
            $result[ $idx ] = $this->unique($array);
        }

        return $result;
    }


    /**
     * возвращает дубликаты во входящем массиве
     *
     * @param array|mixed ...$values
     *
     * @return array
     */
    public function duplicates(...$values) : array
    {
        $thePhp = $this->getPhp();

        $duplicates = [];
        $index = [];

        foreach ( $this->listval(...$values) as $value ) {
            $hash = $thePhp->uniqhash($value);

            if (isset($index[ $hash ])) {
                $duplicates[ $hash ][] = $value;
            }

            $index[ $hash ] = true;
        }

        return $duplicates;
    }

    /**
     * возвращает дубликаты во входящем массиве, в каждом
     *
     * @param array|mixed ...$arrays
     *
     * @return array
     */
    public function duplicatesEach(...$arrays) : array
    {
        $result = [];

        foreach ( $arrays as $idx => $array ) {
            $result[ $idx ] = $this->duplicates($array);
        }

        return $result;
    }


    /**
     * distinct это unique() с сохранением ключей
     *
     * @param array|mixed ...$values
     *
     * @return array
     */
    public function distinct(...$values) : array
    {
        $thePhp = $this->getPhp();

        $index = [];
        $list = [];

        foreach ( $this->listval(...$values) as $idx => $value ) {
            $index[ $thePhp->uniqhash($value) ] = $idx;
            $list[ $idx ] = $value;
        }

        $result = [];
        foreach ( $index as $idx ) {
            $result[ $idx ] = $list[ $idx ];
        }

        return $result;
    }

    /**
     * distinct это unique() с сохранением ключей, в каждом
     *
     * @param array|mixed ...$arrays
     *
     * @return array
     */
    public function distinctEach(...$arrays) : array
    {
        $result = [];

        foreach ( $arrays as $idx => $array ) {
            $result[ $idx ] = $this->distinct($array);
        }

        return $result;
    }


    /**
     * array_walk_recursive реализованный через стек и позволяющий получить путь до элемента
     *
     * @param array     $array
     * @param null|bool $childrenFirst
     * @param null|bool $withParents
     * @param null|bool $withRoot
     *
     * @return \Generator
     */
    public function &walk(array &$array,
        bool $childrenFirst = null,
        bool $withParents = null,
        bool $withRoot = null
    ) : \Generator
    {
        $childrenFirst = $childrenFirst ?? false;
        $withParents = $withParents ?? false;
        $withRoot = $withRoot ?? false;

        $stack = [
            // src, path, immediate
            [ &$array, [], false ],
        ];

        $isRoot = true;
        while ( null !== key($stack) ) {
            $cur = array_pop($stack);

            if (( true === $cur[ 2 ] )
                || ! ( is_array($cur[ 0 ]) && ! empty($cur[ 0 ]) )
            ) {
                yield $cur[ 1 ] => $cur[ 0 ];

            } else {
                if (( $withParents && ! $isRoot )
                    || ( $withRoot && $isRoot )
                ) {
                    $childrenFirst
                        ? ( $stack[] = [ &$cur[ 0 ], $cur[ 1 ], true ] )
                        : ( yield $cur[ 1 ] => $cur[ 0 ] );
                }

                if (! $childrenFirst) {
                    end($cur[ 0 ]);
                }

                while ( null !== ( $kk = key($cur[ 0 ]) ) ) {
                    $fullpath = $cur[ 1 ];
                    $fullpath[] = $kk;

                    $stack[] = [ &$cur[ 0 ][ $kk ], $fullpath, false ];

                    $childrenFirst
                        ? next($cur[ 0 ])
                        : prev($cur[ 0 ]);
                }
            }

            $isRoot = false;
        }
    }

    /**
     * array_walk_recursive реализованный через стек и позволяющий получить путь до элемента
     * позволяет остановить проход вглубь $gen->push(false), если обработка уровня закончена, а также обходить "только родителей"
     *
     * @param array     $array
     * @param null|bool $withChildren
     * @param null|bool $withParents
     * @param null|bool $withRoot
     * @param null|bool $continue
     *
     * @return \Generator
     */
    public function &walkeach(array &$array,
        bool &$continue = null,
        bool $withChildren = null,
        bool $withParents = null,
        bool $withRoot = null
    ) : \Generator
    {
        $continue = $continue ?? false;
        $withChildren = $withChildren ?? true;
        $withParents = $withParents ?? false;
        $withRoot = $withRoot ?? false;

        $stack = [
            // src, path, immediate
            [ &$array, [], false ],
        ];

        $isRoot = true;
        while ( null !== key($stack) ) {
            $cur = array_pop($stack);

            if (! ( is_array($cur[ 0 ]) && ! empty($cur[ 0 ]) )) {
                if ($continue) continue;

                if ($withChildren) {
                    yield $cur[ 1 ] => $cur[ 0 ];
                }

            } else {
                if (( $withParents && ! $isRoot )
                    || ( $withRoot && $isRoot )
                ) {
                    yield $cur[ 1 ] => $cur[ 0 ];
                }

                if ($continue) continue;

                end($cur[ 0 ]);
                while ( null !== ( $kk = key($cur[ 0 ]) ) ) {
                    $fullpath = $cur[ 1 ];
                    $fullpath[] = $kk;

                    $stack[] = [ &$cur[ 0 ][ $kk ], $fullpath, false ];

                    prev($cur[ 0 ]);
                }
            }

            $isRoot = false;
        }
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
    public function zip(array $array, array ...$arrays) : array
    {
        return $arrays
            ? array_map(null, $array, ...$arrays)
            : array_map(function ($val) {
                return [ $val ];
            }, $array);
    }


    /**
     * разбивает на два по указанному критерию
     *
     * @param array         $array
     * @param callable|null $condition
     *
     * @return array
     */
    public function two(array $array, callable $condition = null) : array
    {
        $result = [ [], [] ];

        foreach ( $array as $i => $item ) {
            $passes = $condition
                ? (bool) $condition($item, $i)
                : ! empty($item);

            ( $passes )
                ? ( $result[ 0 ][ $i ] = $item )
                : ( $result[ 1 ][ $i ] = $item );
        }

        return $result;
    }

    /**
     * разбивает на группированный список и остаток, замыкание должно возвращать имя группы
     *
     * @param array         $array
     * @param \Closure|null $fnGroupName
     *
     * @return array
     */
    public function group(array $array, \Closure $fnGroupName = null) : array
    {
        $result = [ [], [] ];

        foreach ( $array as $i => $item ) {
            $group = $fnGroupName
                ? $fnGroupName($item, $i)
                : null;

            if (null === $group) {
                $result[ 1 ][ $i ] = $item;

            } else {
                if (null === ( $group = $this->filterArrayKey($group) )) {
                    throw new RuntimeException([
                        'The `group` should be valid array key: %s',
                        $group,
                    ]);
                }

                $result[ 0 ][ $group ][ $i ] = $item;
            }
        }

        return $result;
    }


    /**
     * рекурсивно собирает массив в одноуровневый соединяя ключи через разделитель
     *
     * @param array                 $array
     * @param string|string[]|array $separators
     *
     * @return array
     */
    public function dot(array $array, $separators = '.') : array
    {
        $result = [];

        foreach ( $this->walk($array) as $fullpath => $value ) {
            $result[ $this->pathkey($fullpath, $separators) ] = $value;
        }

        return $result;
    }

    /**
     * рекурсивно собирает массив в одноуровневый соединяя ключи через разделитель
     * если нет потомков - выводим
     * если потомок - пустой массив - выводим
     * если массив потомков содержит цифровой ключ - обработка ветки останавливается и выводим
     *
     * @param array                 $array
     * @param string|string[]|array $separators
     *
     * @return array
     */
    public function dotarr(array $array, $separators = '.') : array
    {
        /** @var array $path */

        $dotarr = [];

        foreach ( $this->walkeach($array, $continue, true, true, true) as $path => $v ) {
            $continue = false;

            if (! is_array($v)) {
                $continue = true;

            } elseif (empty($v)) {
                $continue = true;

            } else {
                foreach ( $v as $kk => $vv ) {
                    if (is_int($kk)) {
                        $continue = true;

                        break;
                    }
                }
            }

            if ($continue) {
                $path
                    ? ( $dotarr[ $this->pathkey($path, $separators) ] = $v )
                    : ( $dotarr = $v );
            }
        }

        return $dotarr;
    }

    /**
     * превращает массив из dot-нотации во вложенный
     *
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
            while ( null !== ( $k = key($path) ) ) {
                if (! is_array($ref)) {
                    $ref = [ $ref ];
                }

                $ref =& $ref[ $path[ $k ] ];

                next($path);
            }
            $ref = $value;

            unset($ref);
        }

        return $result;
    }


    /**
     * Вставляет элемент в указанную позиции по номеру (начиная с 0), изменяя числовые индексы существующих элементов
     *
     * @param array       $array
     * @param int         $pos
     * @param mixed       $value
     * @param null|string $key
     *
     * @return array
     */
    public function expand(array $array, int $pos, $value, string $key = null) : array
    {
        $result = $this->expandMany($array, [
            [ $pos, $value, $key ],
        ]);

        return $result;
    }

    /**
     * Вставляет элементы в указанные позиции (начиная с 0), изменяя числовые индексы существующих элементов
     *
     * @param array           $array
     * @param null|int|string $after
     * @param mixed           $val
     * @param null|string     $key
     * @param null|bool       $strict
     *
     * @return array
     */
    public function expandAfter(array $array, $after, $val, string $key = null, bool $strict = null) : array
    {
        $strict = $strict ?? false;

        if (null !== $after) {
            $keys = array_keys($array);

            if (false === ( $pos = array_search($after, $keys, $strict) )) {
                throw new RuntimeException([
                    'Element with key is not found in array: %s',
                    $after,
                ]);
            }

            $pos += 1;
        }

        $pos = $pos ?? 0;

        $result = $this->expandMany($array, [
            [ $pos, $val, $key ],
        ]);

        return $result;
    }

    /**
     * Вставляет элементы в указанные позиции (начиная с 0), изменяя числовые индексы существующих элементов
     *
     * Механизм применяется
     * - в dran-n-drop элементов списка при пользовательской сортировке
     * - в инжекторе зависимостей, чтобы между переданными параметрами воткнуть свой
     *
     * @param array   $array
     * @param array[] ...$expands
     *
     * @return array
     */
    public function expandMany(array $array, array ...$expands) : array
    {
        $expands = $this->listvalEach(...$expands);

        foreach ( $expands as $expand ) {
            $mergesByPos = [];

            $posPrev = null;
            foreach ( $expand as [ $pos, $val, $key ] ) {
                $pos = $pos ?? $posPrev ?? count($array);
                $posPrev = $pos;

                if (null === $key) {
                    $mergesByPos[ $pos ][ $pos ] = $val;

                } else {
                    if (is_string($key) && array_key_exists($key, $array)) {
                        throw new RuntimeException(
                            'Key is already present in original array: ' . $key,
                        );
                    }

                    $mergesByPos[ $pos ][ $key ] = $val;
                }
            }

            foreach ( $mergesByPos as $pos => $merge ) {
                $slices = [];
                $slices[] = $this->slicePos($array, 0, $pos, true);
                $slices[] = $merge;
                $slices[] = $this->slicePos($array, $pos, null, true);

                $array = [];
                foreach ( $slices as $slice ) {
                    foreach ( $slice as $kk => $vv ) {
                        ( is_string($kk) || ! isset($array[ $kk ]) )
                            ? ( $array[ $kk ] = $vv )
                            : ( $array[] = $vv );
                    }
                }
            }
        }

        return $array;
    }


    /**
     * @param array        $src
     * @param string|array $path
     * @param null|int     $error
     *
     * @return mixed
     */
    protected function &ref(array &$src, $path, int &$error = null) // : mixed
    {
        $error = static::ERROR_REF_EMPTY_KEY;

        $fullpath = $this->path($path);

        $ref =& $src;
        while ( null !== ( $k = key($fullpath) ) ) {
            $slug = array_shift($fullpath);

            if (! array_key_exists($slug, $ref)) {
                $error = static::ERROR_REF_MISSING_KEY;

                unset($ref);
                $ref = null;

                break;
            }

            if (count($fullpath) && ! is_array($ref[ $slug ])) {
                $error = static::ERROR_REF_NOT_AN_ARRAY;

                unset($ref);
                $ref = null;

                break;
            }

            $ref =& $ref[ $slug ];

            $error = static::ERROR_REF_NO_ERROR;
        }

        return $ref;
    }

    /**
     * @param array    $src
     * @param int      $idx
     * @param null|int $error
     *
     * @return mixed
     */
    protected function &refIdx(array &$src, int $idx, int &$error = null) // : mixed
    {
        $error = static::ERROR_REF_EMPTY_KEY;

        $abs = abs($idx);

        if ($idx < 0) end($src);

        $ref =& $src;
        while ( null !== ( $k = key($src) ) ) {
            if (! $abs--) {
                $ref =& $src[ $k ];

                $error = static::ERROR_REF_NO_ERROR;

                break;
            }

            ( $idx < 0 )
                ? prev($src)
                : next($src);
        }

        return $ref;
    }


    /**
     * @return IArr
     */
    public static function getInstance() : IArr
    {
        return SupportFactory::getInstance()->getArr();
    }
}