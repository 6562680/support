<?php
/**
 * @noinspection RedundantSuppression
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support;

use Gzhegow\Support\Traits\Load\StrLoadTrait;
use Gzhegow\Support\Traits\Load\ArrLoadTrait;
use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Domain\Php\ValueObject\PhpInvokableInfo;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Exceptions\Runtime\UnexpectedValueException;


/**
 * XPhp
 */
class XPhp implements IPhp
{
    use ArrLoadTrait;
    use StrLoadTrait;


    /**
     * @return PhpInvokableInfo
     */
    public function newInvokableInfo() : PhpInvokableInfo
    {
        return SupportFactory::getInstance()->newPhpInvokableInfo();
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
     * @noinspection PhpParameterByRefIsNotUsedAsReferenceInspection
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

        if (is_countable($value)) {
            return count($value) === 0;
        }

        if (is_iterable($value)) {
            return iterator_count($value) === 0;
        }

        return false;
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
     * @param bool|mixed $value
     *
     * @return null|bool
     */
    public function filterBool($value) : ?bool
    {
        if (is_bool($value)) {
            return $value;
        }

        return null;
    }


    /**
     * @param string|array|\Closure|callable|mixed $callable
     * @param null|PhpInvokableInfo                $invokableInfo
     *
     * @return null|string|array|\Closure|callable
     */
    public function filterCallable($callable, PhpInvokableInfo &$invokableInfo = null) // : ?string|array|\Closure
    {
        if (( null !== $this->filterClosure($callable, $invokableInfo) )
            || ( null !== $this->filterCallableString($callable, $invokableInfo) )
            || ( null !== $this->filterCallableArray($callable, $invokableInfo) )
        ) {
            return $callable;
        }

        return null;
    }


    /**
     * @param string|array|callable|mixed $callableString
     * @param null|PhpInvokableInfo       $invokableInfo
     *
     * @return null|string|array|callable
     */
    public function filterCallableString($callableString, PhpInvokableInfo &$invokableInfo = null) // : ?string|array
    {
        if (! is_array($callableString)
            && ( ( null !== $this->filterCallableStringFunction($callableString, $invokableInfo) )
                || ( null !== $this->filterCallableStringStatic($callableString, $invokableInfo) )
            )
        ) {
            return $callableString;
        }

        return null;
    }

    /**
     * @param string|callable|mixed $callableString
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return null|string|callable
     */
    public function filterCallableStringFunction($callableString, PhpInvokableInfo &$invokableInfo = null) : ?string
    {
        $invokableInfo = $invokableInfo ?? $this->newInvokableInfo();

        if (( null !== $this->getStr()->filterWord($callableString) )
            && function_exists($callableString)
        ) {
            $invokableInfo->setFunction($callableString);
            $invokableInfo->setCallable($callableString);

            return $callableString;
        }

        return null;
    }

    /**
     * @param string|callable|mixed $callableString
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return null|string|callable
     */
    public function filterCallableStringStatic($callableString, PhpInvokableInfo &$invokableInfo = null) : ?string
    {
        if (! ( null !== $this->getStr()->filterWord($callableString) )
            && ( 1 === substr_count($callableString, '::') )
        ) {
            return null;
        }

        $callable = explode('::', $callableString, 2);

        if (null !== $this->filterCallableArrayStatic($callable, $invokableInfo)) {
            return $callableString;
        }

        return null;
    }


    /**
     * @param array|callable|mixed  $callableArray
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return null|array|callable
     */
    public function filterCallableArray($callableArray, PhpInvokableInfo &$invokableInfo = null) : ?array
    {
        if (is_array($callableArray)
            && ( $this->filterCallableArrayStatic($callableArray, $invokableInfo)
                || $this->filterCallableArrayPublic($callableArray, $invokableInfo)
            )
        ) {
            return $callableArray;
        }

        return null;
    }

    /**
     * @param array|callable|mixed  $callableArray
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return null|array|callable
     */
    public function filterCallableArrayStatic($callableArray, PhpInvokableInfo &$invokableInfo = null) : ?array
    {
        $theStr = $this->getStr();

        $invokableInfo = $invokableInfo ?? $this->newInvokableInfo();

        if (is_array($callableArray)
            && isset($callableArray[ 0 ]) && ( null !== $theStr->filterWord($callableArray[ 0 ]) )
            && isset($callableArray[ 1 ]) && ( null !== $theStr->filterWord($callableArray[ 1 ]) )
            && is_callable($callableArray)
        ) {
            $invokableInfo->setClass($callableArray[ 0 ]);
            $invokableInfo->setMethod($callableArray[ 1 ]);
            $invokableInfo->setCallable($callableArray);

            return $callableArray;
        }

        return null;
    }

    /**
     * @param array|callable|mixed  $callableArray
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return null|array|callable
     */
    public function filterCallableArrayPublic($callableArray, PhpInvokableInfo &$invokableInfo = null) : ?array
    {
        $invokableInfo = $invokableInfo ?? $this->newInvokableInfo();

        if (is_array($callableArray)
            && isset($callableArray[ 0 ]) && is_object($callableArray[ 0 ])
            && isset($callableArray[ 1 ]) && ( null !== $this->getStr()->filterWord($callableArray[ 1 ]) )
            && is_callable($callableArray)
        ) {
            $invokableInfo->setObject($callableArray[ 0 ]);
            $invokableInfo->setClass(get_class($callableArray[ 0 ]));
            $invokableInfo->setMethod($callableArray[ 1 ]);
            $invokableInfo->setCallable($callableArray);

            return $callableArray;
        }

        return null;
    }


    /**
     * @param \Closure|mixed        $closure
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return null|\Closure
     */
    public function filterClosure($closure, PhpInvokableInfo &$invokableInfo = null) : ?\Closure
    {
        $invokableInfo = $invokableInfo ?? $this->newInvokableInfo();

        if (is_object($closure) && ( get_class($closure) === \Closure::class )) {
            $invokableInfo->setClosure($closure);
            $invokableInfo->setClass(\Closure::class);

            return $closure;
        }

        return null;
    }

    /**
     * @param \Closure              $factory
     * @param string|callable       $returnType
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return null|\Closure
     */
    public function filterClosureFactory($factory, $returnType, PhpInvokableInfo &$invokableInfo = null) : ?\Closure
    {
        if (null === $this->filterClosure($factory, $invokableInfo)) {
            return null;
        }

        $reflectionFunction = $this->newReflectionFunction($factory);

        $reflectionType = $reflectionFunction->getReturnType();

        // factory requires a type
        $types = [];
        if ($reflectionType) {
            $types = is_a($reflectionType, 'ReflectionUnionType')
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

        // factory must return only one type
        if (count($types) > 1) {
            return null;
        }

        $type = reset($types);

        $returnTypeCallback = is_callable($returnType)
            ? $this->bind($returnType, $type)
            : static function ($type) use ($returnType) {
                if (is_a($type, 'ReflectionNamedType')) {
                    return false
                        || ( $type->isBuiltin() && ( $type->getName() !== $returnType ) )
                        || ( is_a($type->getName(), $returnType, true) );
                }

                return $type === $returnType;
            };

        $result = $returnTypeCallback($type)
            ? $factory
            : null;

        return $result;
    }


    /**
     * @param array|mixed $methodArray
     *
     * @return null|array
     */
    public function filterMethodArray($methodArray) : ?array
    {
        $theStr = $this->getStr();

        if (is_array($methodArray)
            && isset($methodArray[ 0 ])
            && isset($methodArray[ 1 ]) && ( null !== $theStr->filterWord($methodArray[ 1 ]) )
        ) {
            $isObject = is_object($methodArray[ 0 ]);
            $isClass = ! $isObject
                && ( null !== $theStr->filterWord($methodArray[ 0 ]) )
                && class_exists($methodArray[ 0 ]);

            if (! $isObject && ! $isClass) {
                return null;
            }

            return $methodArray;
        }

        return null;
    }

    /**
     * @param array|mixed           $methodArray
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return null|array
     */
    public function filterMethodArrayReflection($methodArray, PhpInvokableInfo &$invokableInfo = null) : ?array
    {
        [ $objectOrClass, $method ] = $this->filterMethodArray($methodArray);

        try {
            $rm = new \ReflectionMethod($objectOrClass, $method);

            $invokableInfo = $invokableInfo ?? $this->newInvokableInfo();
            $invokableInfo->setMethod($rm->getName());

            if (is_object($objectOrClass)) {
                $invokableInfo->setObject($objectOrClass);
                $invokableInfo->setClass(get_class($objectOrClass));

            } elseif ($objectOrClass) {
                $invokableInfo->setClass($objectOrClass);
            }
        }
        catch ( \ReflectionException $e ) {
            return null;
        }

        return $methodArray;
    }

    /**
     * @param string|mixed          $handler
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return null|string|callable
     */
    public function filterHandler($handler, PhpInvokableInfo &$invokableInfo = null) : ?string
    {
        if (! ( null !== $this->getStr()->filterWord($handler) )
            && ( 1 === substr_count($handler, '@') )
        ) {
            return null;
        }

        [ $class, $method ] = explode('@', $handler, 2);

        try {
            $rm = new \ReflectionMethod($class, $method);

            $invokableInfo = $invokableInfo ?? $this->newInvokableInfo();
            $invokableInfo->setClass($class);
            $invokableInfo->setMethod($method);

            if (! $rm->isPublic() || $rm->isStatic() || $rm->isAbstract()) {
                return null;
            }

            return $handler;
        }
        catch ( \ReflectionException $e ) {
        }

        return null;
    }


    /**
     * @param object|mixed $value
     *
     * @return null|object
     */
    public function filterThrowable($value) // : ?object
    {
        if ($value instanceof \Throwable) {
            return $value;
        }

        return null;
    }

    /**
     * @param object|mixed $value
     *
     * @return null|object
     */
    public function filterError($value) // : ?object
    {
        if ($value instanceof \Error) {
            return $value;
        }

        return null;
    }

    /**
     * @param object|mixed $value
     *
     * @return null|object
     */
    public function filterException($value) // : ?object
    {
        if ($value instanceof \Exception) {
            return $value;
        }

        return null;
    }

    /**
     * @param object|mixed $value
     *
     * @return null|object
     */
    public function filterRuntimeException($value) // : ?object
    {
        if ($value instanceof \RuntimeException) {
            return $value;
        }

        return null;
    }

    /**
     * @param object|mixed $value
     *
     * @return null|object
     */
    public function filterLogicException($value) // : ?object
    {
        if ($value instanceof \LogicException) {
            return $value;
        }

        return null;
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
    public function uniqhash($value) : string
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
    public function kwargsPreserveKeys(...$arguments) : array
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
     * @param int|float $min
     * @param int|float ...$max
     *
     * @return static
     */
    public function sleep($min, ...$max)
    {
        $sleeps = $this->getArr()->listval($min, ...$max);

        foreach ( $sleeps as $sleep ) {
            if (! is_numeric($sleep)) {
                throw new InvalidArgumentException(
                    [ 'Each sleep should be numeric: %s', $sleep ],
                );
            }
        }

        $sleepMin = max(0, min($sleeps));
        $sleepMax = max(0, ...$sleeps);

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
     * выполняет функцию как шаг array_filter
     *
     * @param null|callable $func
     * @param               $arg
     * @param array         $arguments
     *
     * @return bool|array
     */
    public function callFilter(?callable $func, $arg, ...$arguments) : bool
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
    public function callMap(?callable $func, $arg, ...$arguments) // : mixed
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
    public function callReduce(?callable $func, $arg, $carry = null, ...$arguments) // : mixed
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
            : ( $num ? [ $num ] : [] );

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
     * @param int|null $limit
     *
     * @return string
     */
    public function obGetFlush(int $limit = null) : string
    {
        $limit = $limit ?? -1;

        $content = '';

        while ( ob_get_level() ) {
            $content .= ob_get_flush();

            if (! $limit--) break;
        }

        return $content;
    }

    /**
     * @param int|null $limit
     *
     * @return void
     */
    public function obEndFlush(int $limit = null)
    {
        $limit = $limit ?? -1;

        while ( ob_get_level() ) {
            ob_end_flush();

            if (! $limit--) break;
        }
    }


    /**
     * @return IPhp
     */
    public static function getInstance() : IPhp
    {
        return SupportFactory::getInstance()->getPhp();
    }
}