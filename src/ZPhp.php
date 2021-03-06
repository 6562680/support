<?php
/**
 * @noinspection RedundantSuppression
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Exceptions\Runtime\UnexpectedValueException;


/**
 * ZPhp
 */
class ZPhp implements IPhp
{
    /**
     * @var IFilter
     */
    protected $filter;


    /**
     * Constructor
     *
     * @param IFilter $filter
     */
    public function __construct(
        IFilter $filter
    )
    {
        $this->filter = $filter;
    }


    /**
     * @param callable $callable
     *
     * @return \ReflectionFunction
     */
    protected function newReflectionFunction($callable) : \ReflectionFunction
    {
        try {
            $rf = new \ReflectionFunction($callable);
        }
        catch ( \ReflectionException $e ) {
            throw new RuntimeException(
                [ 'Unable to reflect function: %s', $callable ],
                null,
                $e
            );
        }

        return $rf;
    }


    /**
     * @param mixed &$value
     *
     * @return bool
     */
    public function isBlank(&$value) : bool
    {
        if (0 === $value) {
            return false;
        }

        if (0.0 === $value) {
            return false;
        }

        if (empty($value)) {
            return true;
        }

        if (is_object($value)) {
            if (is_countable($value)) {
                return ! count($value);

            } elseif (is_iterable($value)) {
                $i = iterator_count($value);

                return $i === 0;
            }
        }

        return false;
    }

    /**
     * @param mixed &$value
     *
     * @return bool
     */
    public function isNotBlank(&$value) : bool
    {
        return ! $this->isBlank($value);
    }


    /**
     * @param string|mixed $phpKeyword
     *
     * @return bool
     */
    public function isPhpKeyword($phpKeyword) : bool
    {
        return null !== $this->filterPhpKeyword($phpKeyword);
    }


    /**
     * @param \Closure $func
     * @param string   $returnType
     *
     * @return bool
     */
    public function isFactory(\Closure $func, string $returnType) : bool
    {
        return null !== $this->filterFactory($func, $returnType);
    }


    /**
     * @param string|mixed $phpKeyword
     *
     * @return null|string
     */
    public function filterPhpKeyword($phpKeyword) : ?string
    {
        if (! ctype_alpha($phpKeyword)) {
            return false;
        }

        $tokens = token_get_all('<?php ' . $phpKeyword . '; ?>');

        $token = is_null($tokens[ 1 ] ?? null)
            ? []
            : [ $tokens[ 1 ] ];

        $tokenClaim = reset($token);

        if (! is_int($tokenClaim)) {
            return null;
        }

        if ($tokenClaim !== T_STRING) {
            return null;
        }

        return $phpKeyword;
    }


    /**
     * проверяет возвращаемый тип у замыкания
     *
     * @param \Closure        $factory
     * @param string|callable $returnType
     *
     * @return null|\Closure
     */
    public function filterFactory(\Closure $factory, $returnType) : ?\Closure
    {
        $reflectionFunction = $this->newReflectionFunction($factory);

        $reflectionType = $reflectionFunction->getReturnType();

        // factory requires a type
        $types = [];
        if ($reflectionType) {
            $types = ( is_a($reflectionType, 'ReflectionUnionType') )
                ? $reflectionType->getTypes()
                : [ $reflectionType ];

        } else {
            $lines = array_map('trim', explode("\n", $reflectionFunction->getDocComment()));

            foreach ( $lines as $line ) {
                if (0 === strpos($line, $needle = '* @return ')) {
                    $line = substr($line, strlen($needle));

                    $types = explode(' ', $line)[ 0 ];
                    $types = explode('|', $types);
                }
            }
        }

        // factory returns only one type
        if (count($types) > 1) {
            return null;
        }

        $type = reset($types);

        $returnTypeCallback = is_callable($returnType)
            ? $this->bind($returnType, $type)
            : function ($type) use ($returnType) {
                if (is_a($type, 'ReflectionType')) {
                    if (is_a($type, 'ReflectionNamedType')) {
                        return false
                            || ( $type->isBuiltin() && ( $type->getName() !== $returnType ) )
                            || ( is_a($type->getName(), $returnType) );

                    } elseif ($type->allowsNull()) {
                        return 'null' === $returnType;
                    }
                } else {
                    return $type === $returnType;
                }

                return false;
            };

        $result = $returnTypeCallback($type)
            ? $factory
            : null;

        return $result;
    }


    /**
     * @param mixed &$value
     *
     * @return mixed
     */
    public function assertBlank(&$value) // : mixed
    {
        if (false === $this->isBlank($value)) {
            throw new InvalidArgumentException([ 'Value should be empty: %s', $value ]);
        }

        return $value;
    }

    /**
     * @param mixed &$value
     *
     * @return mixed
     */
    public function assertNotBlank(&$value) // : mixed
    {
        if (false === $this->isNotBlank($value)) {
            throw new InvalidArgumentException([ 'Value should not be blank: %s', $value ]);
        }

        return $value;
    }


    /**
     * @param mixed &$value
     *
     * @return mixed
     */
    public function assertIsset(&$value) // : mixed
    {
        if (false === isset($value)) {
            throw new InvalidArgumentException([ 'Value should exists: %s', $value ]);
        }

        return $value;
    }


    /**
     * @param string $key
     * @param array  $array
     *
     * @return mixed
     */
    public function assertKeyExists(string $key, array $array) // : mixed
    {
        if (false === array_key_exists($key, $array)) {
            throw new InvalidArgumentException('Key not found: ' . $key);
        }

        return $array[ $key ];
    }


    /**
     * @param string|mixed $phpKeyword
     *
     * @return string
     */
    public function assertPhpKeyword($phpKeyword) : string
    {
        if (null === $this->filterPhpKeyword($phpKeyword)) {
            throw new InvalidArgumentException(
                [ 'Invalid PhpKeyword passed: %s', $phpKeyword ]
            );
        }

        return $phpKeyword;
    }


    /**
     * @param \Closure $func
     * @param string   $returnType
     *
     * @return \Closure
     */
    public function assertFactory(\Closure $func, $returnType) : \Closure
    {
        if (null === $this->filterFactory($func, $returnType)) {
            throw new InvalidArgumentException(
                [ '\Closure has invalid return type: %s', $returnType ]
            );
        }

        return $func;
    }


    /**
     * @param mixed ...$items
     *
     * @return array
     */
    public function listval(...$items) : array
    {
        $result = [];

        $list = [];
        foreach ( $items as $idx => $item ) {
            if (null === $this->filter->filterList($item)) {
                $list[] = $item;

            } else {
                foreach ( $item as $val ) {
                    $list[] = $val;
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
     * @param mixed ...$lists
     *
     * @return array
     */
    public function listvals(...$lists) : array
    {
        $result = [];

        foreach ( $lists as $idx => $list ) {
            $result[ $idx ] = $this->listval($list);
        }

        return $result;
    }


    /**
     * Превращает enum-список любой вложенности (значения могут быть в ключах или в полях) в список уникальных значений
     *
     * @param mixed ...$items
     *
     * @return array
     */
    public function enumval(...$items) : array
    {
        $result = [];

        array_walk_recursive($items, function ($val, $key) use (&$result) {
            if (null === $val
                || false === $val
                || '' === $val
            ) {
                return;
            }

            $value = null
                ?? ( true === $val ? $key : null )
                ?? $this->filter->filterWord($key)
                ?? $this->filter->filterWordOrNum($val)
                ?? $this->filter->filterInt($key);

            if (null === $value) {
                return;
            }

            $result[ $this->hash($value) ] = $value;
        });

        $result = array_values($result);

        return $result;
    }

    /**
     * Превращает каждый аргумент с помощью enumval
     *
     * @param mixed ...$enums
     *
     * @return array
     */
    public function enumvals(...$enums) : array
    {
        $result = [];

        foreach ( $enums as $idx => $map ) {
            $result[ $idx ] = $this->enumval($map);
        }

        return $result;
    }


    /**
     * @param mixed ...$values
     *
     * @return array
     */
    public function queueVal(...$values) : array
    {
        $result = [];

        while ( null !== key($values) ) {
            $current = array_shift($values);

            if (is_iterable($current)) {
                while ( null !== key($current) ) {
                    $values[] = current($current);
                    next($current);
                }

            } else {
                $result[] = $current;
            }
        }

        return $result;
    }

    /**
     * @param mixed ...$values
     *
     * @return array
     */
    public function stackVal(...$values) : array
    {
        $stack = [];

        end($values);
        while ( null !== key($values) ) {
            $stack[] = current($values);
            prev($values);
        }

        $result = [];
        while ( null !== key($stack) ) {
            $current = array_pop($stack);

            if (is_iterable($current)) {
                end($current);
                while ( null !== key($current) ) {
                    $stack[] = current($current);
                    prev($current);
                }

            } else {
                $result[] = $current;
            }
        }

        return $result;
    }


    /**
     * @param mixed ...$values
     *
     * @return array
     */
    public function unique(...$values) : array
    {
        $arr = [];
        foreach ( $values as $value ) {
            $arr[ $this->hash($value) ] = $value;
        }

        $result = array_values($arr);

        return $result;
    }

    /**
     * @param mixed ...$values
     *
     * @return array
     */
    public function uniqueFlatten(...$values) : array
    {
        $arr = [];

        while ( null !== key($values) ) {
            $current = array_shift($values);

            if (is_iterable($current)) {
                while ( null !== key($current) ) {
                    $values[] = current($current);
                    next($current);
                }

            } else {
                $arr[ $this->hash($current) ] = $current;
            }
        }

        return array_values($arr);
    }


    /**
     * @param mixed ...$values
     *
     * @return array
     */
    public function duplicates(...$values) : array
    {
        $arr = [];
        $duplicates = [];
        foreach ( $values as $value ) {
            $hash = $this->hash($value);

            if (isset($arr[ $hash ])) {
                $duplicates[ $hash ][] = $value;
            }

            $arr[ $hash ] = true;
        }

        return $duplicates;
    }

    /**
     * @param mixed ...$values
     *
     * @return array
     */
    public function duplicatesFlatten(...$values) : array
    {
        $arr = [];
        $duplicates = [];

        while ( null !== key($values) ) {
            $current = array_shift($values);

            if (is_iterable($current)) {
                while ( null !== key($current) ) {
                    $values[] = current($current);
                    next($current);
                }

            } else {
                $hash = $this->hash($current);

                if (isset($arr[ $hash ])) {
                    $duplicates[ $hash ][] = $current;
                }

                $arr[ $hash ] = true;
            }
        }

        return $duplicates;
    }


    /**
     * unique() с сохранением ключей
     *
     * @param mixed ...$values
     *
     * @return array
     */
    public function distinct(array $values) : array
    {
        $result = [];

        $index = [];
        foreach ( $values as $idx => $value ) {
            $index[ $this->hash($value) ] = $idx;
        }

        foreach ( $index as $idx ) {
            $result[ $idx ] = $values[ $idx ];
        }

        return $result;
    }


    /**
     * генерирует последовательность типа "каждый с каждым из каждого массива" (все возможные пересечения)
     *
     * @param mixed ...$arrays
     *
     * @return array
     */
    public function sequence(...$arrays) : array
    {
        $result = [];

        $lists = $this->listvals(...$arrays);

        $lenArrs = [];
        foreach ( $lists as $idx => $arr ) {
            $lenArrs[ $idx ] = count($arr);
        }

        $repArr = [];
        $lenArrsCurrent = $lenArrs;
        foreach ( $lenArrsCurrent as $idx => $len ) {
            unset($lenArrsCurrent[ $idx ]);

            $rep = 1;
            foreach ( $lenArrsCurrent as $lenMultiplier ) {
                $rep *= $lenMultiplier;
            }

            $repArr[ $idx ] = $rep;
        }

        $size = array_product($lenArrs);

        for ( $i = 0; $i < $size; $i++ ) {
            foreach ( $repArr as $idx => $rep ) {
                $result[ $i ][] = $lists[ $idx ][ ( $i / $rep ) % $lenArrs[ $idx ] ];
            }
        }

        return $result;
    }

    /**
     * генерирует последовательность типа "каждый с каждым"
     *
     * @param mixed ...$values
     *
     * @return array
     */
    public function sequenceFlatten(...$values) : array
    {
        $flatval = $this->queueVal($values);
        $size = count($flatval);

        $result = [ [] ];
        for ( $i = 0; $i < $size; $i++ ) {
            $res = [];

            foreach ( $result as $c ) {
                foreach ( $flatval as $f ) {
                    $line = $c;
                    $line[] = $f;

                    $res[] = $line;
                }
            }

            $result = $res;
        }

        return $result;
    }


    /**
     * генерирует последовательность типа "битовая маска" (каждое значение есть или нет, могут быть все или ни одного)
     *
     * @param array ...$values
     *
     * @return array
     */
    public function bitmask(...$values) : array
    {
        $result = [];

        $flatval = $this->queueVal($values);
        $size = count($flatval);

        $max = bindec(str_repeat('1', $size));

        for ( $i = 0; $i <= $max; $i++ ) {
            $bitmask = str_pad(decbin($i), $size, '0', STR_PAD_LEFT);

            $line = [];
            foreach ( str_split($bitmask) as $idx => $number ) {
                $line[] = '1' === $number
                    ? $flatval[ $idx ]
                    : null;
            }

            $result[ $bitmask ] = $line;
        }

        return $result;
    }


    /**
     * возвращает идентификатор значения любой переменной в виде строки для дальнейшего сравнения
     * идентификаторы могут быть позже использованы другими обьектами
     * поэтому его актуальность до тех пор, пока конкретный обьект существует в памяти
     *
     * @param mixed $value
     *
     * @return string
     */
    public function hash($value) : string
    {
        switch ( true ):
            case is_string($value):
                return $value;

            case is_int($value):
                return strval($value);

            case is_null($value):
                return '{NULL}';

            case true === $value:
                return '{TRUE}';

            case false === $value:
                return '{FALSE}';

            case ( is_float($value) && is_nan($value) ):
                return '{NaN}';

            case is_float($value):
                return crc32($value);

            case ( is_array($value) ):
                return crc32(serialize($value));

            case is_object($value):
                return '{' . spl_object_hash((object) $value) . '}';

            case ( is_resource($value) || 'resource (closed)' === gettype($value) ):
                return '{#' . intval($value) . '}';

        endswitch;

        throw new UnexpectedValueException(
            [ 'Unable to hash passed element: %s', $value ]
        );
    }


    /**
     * @param object $object
     *
     * @return array
     */
    public function objKeys(object $object) : array
    {
        return ( function () {
            return array_keys(get_object_vars($this));
        } )->call($object);
    }

    /**
     * @param object $object
     *
     * @return array
     */
    public function objVars(object $object) : array
    {
        return ( function () {
            return get_object_vars($this);
        } )->call($object);
    }

    /**
     * @param object $object
     *
     * @return array
     */
    public function objKeysPublic(object $object) : array
    {
        return array_keys(get_object_vars($object));
    }

    /**
     * @param object $object
     *
     * @return array
     */
    public function objVarsPublic(object $object) : array
    {
        return get_object_vars($object);
    }


    /**
     * @param mixed ...$arguments
     *
     * @return array
     */
    public function kwargs(...$arguments) : array
    {
        $kwargs = [];
        $args = [];

        foreach ( $arguments as $argument ) {
            if (is_array($argument)) {
                foreach ( $argument as $key => $val ) {
                    is_int($key)
                        ? ( $args[] = $val )
                        : ( $kwargs[ $key ] = $val );
                }
            } else {
                $args[] = $argument;
            }
        }

        return [ $kwargs, $args ];
    }

    /**
     * @param mixed ...$arguments
     *
     * @return array
     */
    public function kwargsFlatten(...$arguments) : array
    {
        $kwargs = [];
        $args = [];

        array_walk_recursive($arguments, function ($val, $key) use (&$kwargs, &$args) {
            is_int($key)
                ? ( $args[] = $val )
                : ( $kwargs[ $key ] = $val );
        });

        return [ $kwargs, $args ];
    }


    /**
     * @param mixed ...$arguments
     *
     * @return array
     */
    public function kwparams(...$arguments) : array
    {
        $kwargs = [];
        $args = [];

        foreach ( $arguments as $idx => $argument ) {
            if (is_array($argument)) {
                foreach ( $argument as $key => $val ) {
                    is_int($key)
                        ? ( $args[ $key ] = $val )
                        : ( $kwargs[ $key ] = $val );
                }
            } else {
                $args[ $idx ] = $argument;
            }
        }

        return [ $kwargs, $args ];
    }

    /**
     * @param mixed ...$arguments
     *
     * @return array
     */
    public function theKwparams(...$arguments) : array
    {
        $kwargs = [];
        $args = [];

        $flatten = [];
        foreach ( $arguments as $idx => $argument ) {
            if (is_array($argument)) {
                foreach ( $argument as $key => $val ) {
                    $flatten[] = [ $key, $val ];
                }
            } else {
                $flatten[] = [ $idx, $argument ];
            }
        }

        $registry = [];
        foreach ( $flatten as [ $key, $val ] ) {
            if (isset($registry[ $key ])) {
                throw new InvalidArgumentException('Duplicate key: ' . $key);
            }

            $registry[ $key ] = true;

            is_int($key)
                ? ( $args[ $key ] = $val )
                : ( $kwargs[ $key ] = $val );
        }

        return [ $kwargs, $args ];
    }


    /**
     * @param mixed ...$arguments
     *
     * @return array
     */
    public function kwparamsFlatten(...$arguments) : array
    {
        $kwargs = [];
        $args = [];

        array_walk_recursive($arguments, function ($val, $key) use (&$kwargs, &$args) {
            is_int($key)
                ? ( $args[ $key ] = $val )
                : ( $kwargs[ $key ] = $val );
        });

        return [ $kwargs, $args ];
    }

    /**
     * @param mixed ...$arguments
     *
     * @return array
     */
    public function theKwparamsFlatten(...$arguments) : array
    {
        $kwargs = [];
        $args = [];

        $flatten = [];
        array_walk_recursive($arguments, function ($val, $key) use (&$flatten) {
            $flatten[] = [ $key, $val ];
        });

        $registry = [];
        foreach ( $flatten as [ $key, $val ] ) {
            if (isset($registry[ $key ])) {
                throw new InvalidArgumentException('Duplicate key: ' . $key);
            }

            $registry[ $key ] = true;

            is_int($key)
                ? ( $args[ $key ] = $val )
                : ( $kwargs[ $key ] = $val );
        }

        return [ $kwargs, $args ];
    }


    /**
     * @param int|float|int[]|float[] $sleeps
     *
     * @return static
     */
    public function sleep(...$sleeps)
    {
        $sleeps = $this->listval(...$sleeps);

        foreach ( $sleeps as $sleep ) {
            if (! is_numeric($sleep)) {
                throw new InvalidArgumentException(
                    [ 'Each sleep should be numeric: %s', $sleep ],
                );
            }
        }

        $sleepMin = max(0, min($sleeps));
        $sleepMax = max(0, max($sleeps));

        $sleepCurrent = $sleepMin;

        if ($sleepCurrent !== $sleepMax) {
            $sleepCurrent = ( $sleepMin + lcg_value() * ( abs($sleepMax - $sleepMin) ) );

            // wait microseconds
            usleep($sleepCurrent * 1000 * 1000);

        } elseif (is_float($sleepCurrent)) {
            // wait microseconds
            usleep($sleepCurrent * 1000 * 1000);

        } else {
            // wait seconds
            sleep($sleepCurrent);
        }

        return $this;
    }


    /**
     * выполняет функцию как шаг array_filter
     *
     * @param null|callable $func
     * @param               $arg
     * @param array         $arguments
     *
     * @return bool|array
     */
    public function filter(?callable $func, $arg, ...$arguments) : bool
    {
        if (! $func) {
            return empty($arg);
        }

        $result = (bool) call_user_func(
            $this->bind($func, $arg, ...$arguments)
        );

        return $result;
    }

    /**
     * выполняет функцию как шаг array_map
     *
     * @param null|callable $func
     * @param               $arg
     * @param array         $arguments
     *
     * @return mixed
     */
    public function map(?callable $func, $arg, ...$arguments) // : mixed
    {
        if (! $func) {
            return $arg;
        }

        $result = call_user_func(
            $this->bind($func, $arg, ...$arguments)
        );

        return $result;
    }

    /**
     * выполняет функцию как шаг array_reduce
     *
     * @param null|callable $func
     * @param               $arg
     * @param null          $carry
     * @param array         $arguments
     *
     * @return mixed
     */
    public function reduce(?callable $func, $arg, $carry = null, ...$arguments) // : mixed
    {
        if (! $func) {
            return $carry;
        }

        $result = call_user_func(
            $this->bind($func, $carry, $arg, ...$arguments)
        );

        return $result;
    }


    /**
     * bind
     * копирует тело функции и присваивает аргументы на их места в переданном порядке
     * bind('is_array', [], 1, 2) -> Closure of (function is_array($var = []))
     *
     * @param callable $func
     * @param mixed    ...$arguments
     *
     * @return \Closure
     */
    public function bind(callable $func, ...$arguments) : \Closure
    {
        // string
        if (is_string($func)) {
            $bind = [];

            $rf = $this->newReflectionFunction($func);

            $requiredCnt = $rf->getNumberOfRequiredParameters();

            while ( $requiredCnt-- ) {
                $bind[] = null !== key($arguments)
                    ? current($arguments)
                    : null;

                next($arguments);
            }

            $func = \Closure::fromCallable($func);

        } else {
            $bind = $arguments;

        }

        $result = function (...$args) use ($func, $bind) {
            $bind = array_replace(
                $bind,
                array_slice($args, 0, count($bind))
            );

            return call_user_func_array($func, $bind);
        };

        return $result;
    }


    /**
     * call
     * шорткат для call_user_func с рефлексией, чтобы передать в функцию ожидаемое число аргументов
     * для \Closure не имеет смысла, а для string callable вполне
     *
     * @param callable $func
     * @param array    $arguments
     *
     * @return mixed
     */
    public function call(callable $func, ...$arguments) // : mixed
    {
        return call_user_func($this->bind($func, ...$arguments));
    }

    /**
     * apply
     * шорткат для call_user_func_array с рефлексией, чтобы передать в функцию ожидаемое число аргументов
     * для \Closure не имеет смысла, а для string callable вполне
     *
     * @param callable $func
     * @param array    $arguments
     *
     * @return mixed
     */
    public function apply(callable $func, array $arguments) // : mixed
    {
        return call_user_func($this->bind($func, ...$arguments));
    }


    /**
     * @param \ReflectionProperty $reflectionProperty
     *
     * @return null|\ReflectionType
     */
    public function reflectionPropertyGetType(\ReflectionProperty $reflectionProperty)
    {
        try {
            $reflectionType = $reflectionProperty->{'getType'}();
        }
        catch ( \Throwable $e ) {
            $reflectionType = null;
        }

        return $reflectionType;
    }


    /**
     * @param \ReflectionProperty $reflectionProperty
     *
     * @return null|bool
     */
    public function reflectionPropertyHasDefaultValue(\ReflectionProperty $reflectionProperty) : ?bool
    {
        try {
            $hasDefaultValue = $reflectionProperty->{'hasDefaultValue'}();
        }
        catch ( \Throwable $e ) {
            $hasDefaultValue = null;
        }

        return $hasDefaultValue;
    }


    /**
     * Выполняет func_get_arg($num) позволяя задать вероятные позиции аргумента и отфильтровать их
     *
     * @param null|array    $args
     * @param int|int[]     $num
     * @param null|callable $coalesce
     *
     * @return null|mixed
     */
    public function overload(?array &$args, $num, callable $coalesce = null) // : ?mixed
    {
        $args = $args ?? [];

        $num = is_array($num)
            ? $num
            : [ $num ];

        foreach ( $num as $n ) {
            if (! is_int($n)) {
                throw new InvalidArgumentException(
                    [ 'Each num should be integer: %s', $n ]
                );
            }
        }

        $numMin = max(0, min($num));
        $numMax = max(0, max($num));

        $result = null;
        for ( $i = $numMax; $i >= $numMin; $i-- ) {
            if (array_key_exists($i, $args)) {
                if (! $coalesce) {
                    $result = $args[ $i ];

                    $args[ $i ] = null;

                } elseif (null !== ( $result = $coalesce($args[ $i ], $num, $args) )) {
                    $args[ $i ] = null;

                    break;
                }
            }
        }

        return $result;
    }

    /**
     * Выполняет func_get_arg($num) позволяя задать вероятные позиции аргумента и проверить их
     *
     * @param null|array    $args
     * @param int|int[]     $num
     * @param null|callable $if
     *
     * @return null|mixed
     */
    public function overloadIf(?array &$args, $num, callable $if = null) // : ?mixed
    {
        $args = $args ?? [];

        $num = is_array($num)
            ? $num
            : [ $num ];

        foreach ( $num as $n ) {
            if (! is_int($n)) {
                throw new InvalidArgumentException(
                    [ 'Each num should be integer: %s', $n ]
                );
            }
        }

        $numMin = max(0, min($num));
        $numMax = max(0, max($num));

        $result = null;
        for ( $i = $numMax; $i >= $numMin; $i-- ) {
            if (array_key_exists($i, $args)) {
                if (! $if) {
                    $result = $args[ $i ];

                    $args[ $i ] = null;

                } elseif ($if($args[ $i ], $num, $args)) {
                    $result = $args[ $i ];

                    $args[ $i ] = null;

                    break;
                }
            }
        }

        return $result;
    }


    /**
     * @return IPhp
     */
    public static function getInstance() : IPhp
    {
        return SupportFactory::getInstance()->getPhp();
    }
}
