<?php

namespace Gzhegow\Di\Domain\Node;

use Gzhegow\Support\Arr;
use Gzhegow\Support\Php;
use Gzhegow\Support\Type;
use Psr\Container\ContainerInterface;
use Gzhegow\Di\Core\Registry\BindRegistry;
use Gzhegow\Di\Core\Registry\ItemRegistry;
use Gzhegow\Reflection\ReflectionInterface;
use Gzhegow\Di\Core\Registry\SharedRegistry;
use Gzhegow\Di\Core\Registry\ExtendRegistry;
use Gzhegow\Di\Domain\Provider\ProviderManager;
use Gzhegow\Di\Domain\Delegate\DelegateManager;
use Gzhegow\Di\Domain\Delegate\DelegateInterface;
use Gzhegow\Di\Domain\Injector\InjectorInterface;
use Gzhegow\Di\App\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Di\App\Exceptions\Runtime\Domain\AutowireException;
use Gzhegow\Di\App\Exceptions\Exception\Domain\NotFoundException;
use Gzhegow\Di\App\Exceptions\Runtime\Domain\AutowireLoopException;
use Gzhegow\Di\App\Exceptions\Runtime\Domain\MissingDelegateClassException;


/**
 * Node
 */
class Node implements
    ContainerInterface,
    InjectorInterface
{
    /**
     * @var Arr
     */
    protected $arr;
    /**
     * @var Php
     */
    protected $php;
    /**
     * @var Type
     */
    protected $type;
    /**
     * @var ReflectionInterface
     */
    protected $reflection;

    /**
     * @var NodeFactoryInterface
     */
    protected $nodeFactory;

    /**
     * @var BindRegistry
     */
    protected $bindRegistry;
    /**
     * @var ExtendRegistry
     */
    protected $extendRegistry;
    /**
     * @var ItemRegistry
     */
    protected $itemRegistry;
    /**
     * @var SharedRegistry
     */
    protected $sharedRegistry;

    /**
     * @var ProviderManager
     */
    protected $providerManager;
    /**
     * @var DelegateManager
     */
    protected $delegateManager;

    /**
     * @var mixed
     */
    protected $id;

    /**
     * @var null|Node
     */
    protected $parent;


    /**
     * Constructor
     *
     * @param Arr                  $arr
     * @param Php                  $php
     * @param Type                 $type
     *
     * @param ReflectionInterface  $reflection
     *
     * @param NodeFactoryInterface $nodeFactory
     *
     * @param BindRegistry         $bindRegistry
     * @param ExtendRegistry       $extendRegistry
     * @param ItemRegistry         $itemRegistry
     * @param SharedRegistry       $sharedRegistry
     *
     * @param DelegateManager      $delegateManager
     * @param ProviderManager      $providerManager
     *
     * @param mixed                $id
     *
     * @param Node|null            $parent
     */
    public function __construct(
        ReflectionInterface $reflection,

        Arr $arr,
        Php $php,
        Type $type,

        NodeFactoryInterface $nodeFactory,

        BindRegistry $bindRegistry,
        ExtendRegistry $extendRegistry,
        ItemRegistry $itemRegistry,
        SharedRegistry $sharedRegistry,

        DelegateManager $delegateManager,
        ProviderManager $providerManager,

        $id
    )
    {
        $this->arr = $arr;
        $this->php = $php;
        $this->type = $type;

        $this->reflection = $reflection;

        $this->nodeFactory = $nodeFactory;

        $this->bindRegistry = $bindRegistry;
        $this->extendRegistry = $extendRegistry;
        $this->itemRegistry = $itemRegistry;
        $this->sharedRegistry = $sharedRegistry;

        $this->providerManager = $providerManager;
        $this->delegateManager = $delegateManager;

        $this->id = $id;
    }


    /**
     * @param string $id
     * @param mixed  ...$arguments
     *
     * @return mixed
     * @throws NotFoundException
     */
    public function newAsRoot($id, ...$arguments)
    {
        $result = $this->resolveNew($id, ...$arguments);

        return $result;
    }

    /**
     * @param string $id
     * @param mixed  ...$arguments
     *
     * @return mixed
     * @throws NotFoundException
     */
    public function new($id, ...$arguments)
    {
        $result = $this->nodeFactory
            ->newNode($id, $this)
            ->resolveNew($id, ...$arguments);

        return $result;
    }


    /**
     * @return null|Node
     */
    public function getParent() : ?Node
    {
        return $this->parent;
    }


    /**
     * @param string $id
     * @param mixed  ...$arguments
     *
     * @return mixed
     * @throws NotFoundException
     */
    public function getAsRoot($id, ...$arguments)
    {
        $result = $this->resolveGet($id, ...$arguments);

        return $result;
    }

    /**
     * @param string $id
     * @param mixed  ...$arguments
     *
     * @return mixed
     * @throws NotFoundException
     */
    public function get($id, ...$arguments)
    {
        $result = $this->nodeFactory
            ->newNode($id, $this)
            ->resolveGet($id, ...$arguments);

        return $result;
    }


    /**
     * @param string $id
     *
     * @return bool|void
     */
    public function has($id)
    {
        return 0
            || $this->bindRegistry->hasBind($id)
            || $this->itemRegistry->hasItem($id)
            || $this->type->isClass($id);
    }


    /**
     * @param null|Node $parent
     */
    public function setParent(Node $parent) : void
    {
        $this->parent = $parent;

        $this->validateLoop();
    }


    /**
     * @param string $id
     * @param mixed  ...$arguments
     *
     * @return mixed
     * @throws NotFoundException
     */
    public function createAsRoot($id, ...$arguments)
    {
        $result = $this->resolveCreate($id, ...$arguments);

        return $result;
    }

    /**
     * @param string $id
     * @param mixed  ...$arguments
     *
     * @return mixed
     * @throws NotFoundException
     */
    public function create($id, ...$arguments)
    {
        $result = $this->nodeFactory
            ->newNode($id, $this)
            ->resolveCreate($id, ...$arguments);

        return $result;
    }


    /**
     * @param callable $func
     * @param array    $arguments
     *
     * @return mixed
     * @throws NotFoundException
     */
    public function handle($func, ...$arguments)
    {
        /** @var \Closure $closure */

        $isClosure = false;
        $isHandler = false;
        $isCallable = false;
        if (! ( 0
            || ( $isClosure = $this->type->isClosure($func) )
            || ( $isHandler = $this->type->isHandler($func) )
            || ( $isCallable = $this->type->isCallableArray($func) )
        )) {
            throw new InvalidArgumentException('Func should be closure, callable or handler', func_get_args());
        }

        [ $kwargs, $args ] = $this->php->kwparams(...$arguments);

        $params = array_merge($args, $kwargs);

        $arguments = [];
        switch ( true ) {
            case $isClosure:
                $arguments = $this->autowireClosure($func, $params);

                break;

            case $isHandler:
                [ $id, $method ] = explode('@', $func) + [ null, null ];

                $object = $this->get($id);

                $func = [ $object, $method ];
                $arguments = $this->autowireMethod($object, $method, $params);

                break;

            case $isCallable:
                $arguments = $this->autowireCallable($func, $params);

                break;
        }

        ksort($arguments);

        $result = call_user_func_array($func, $arguments);

        return $result;
    }


    /**
     * @param string|object|\ReflectionClass $newthis
     * @param callable                       $func
     * @param array                          $arguments
     *
     * @return mixed
     * @throws NotFoundException
     */
    public function call($newthis, $func, ...$arguments)
    {
        /** @var \Closure $closure */

        if (! is_object($newthis)) {
            throw new InvalidArgumentException('NewThis should be object');
        }

        $isClosure = false;
        $isCallableString = false;
        $isCallableArray = false;
        if (! ( 0
            || ( $isClosure = $this->type->isClosure($func) )
            || ( $isCallableString = $this->type->isCallableString($func) )
            || ( $isCallableArray = $this->type->isCallableArray($func) )
        )) {
            throw new InvalidArgumentException(
                'Func should be \Closure, callable string or callable array of public method',
                func_get_args()
            );
        }

        if ($isCallableArray) {
            if (! is_object($func[ 0 ])) {
                throw new InvalidArgumentException(
                    'Callable should contain object instance',
                    func_get_args()
                );
            }

            if (! is_a($newthis, get_class($func[ 0 ]))) {
                throw new InvalidArgumentException(
                    'Callable should contain object that extends original one',
                    func_get_args()
                );
            }
        }

        [ $kwargs, $args ] = $this->php->kwparams(...$arguments);

        $params = array_merge($args, $kwargs)
            + [ get_class($newthis) => $newthis ];

        $arguments = [];
        switch ( true ) {
            case $isClosure:
                $arguments = $this->autowireClosure($func, $params);
                break;

            case $isCallableString:
                $arguments = $this->autowireCallableString($func, $params);
                break;

            case $isCallableArray:
                $arguments = $this->autowireCallableMethodNonStatic($func, $params);
                break;
        }

        switch ( true ) {
            case $isClosure:
                $closure = $func;
                break;

            case $isCallableString:
            case $isCallableArray:
                $closure = \Closure::fromCallable($func);
                break;
        }

        ksort($arguments);

        $closure = $closure->bindTo($newthis, $newthis);

        $result = call_user_func_array($closure, $arguments);

        return $result;
    }


    /**
     * @param string $id
     *
     * @return static
     */
    protected function validateLoop()
    {
        $registry = [ $this->id ];

        $parent = $this;
        while ( $parent = $parent->parent ) {
            $registry[] = $parent->id;

            if ($parent->id === $this->id) {
                throw new AutowireLoopException(
                    'Autowire loop detected: ' . implode(' -> ', $registry),
                    [ $this->id, $registry ]
                );
            }
        }

        return $this;
    }


    /**
     * @param string $bind
     *
     * @return array
     * @throws NotFoundException
     */
    protected function resolveBind(string $bind) : array
    {
        $this->providerManager->bootDeferable($bind);

        if ($this->itemRegistry->hasItem($bind)) {
            $result = [ $bound = $bind ];

        } elseif ($this->bindRegistry->hasBind($bind)) {
            $result = [ $bound = $this->bindRegistry->getBind($bind) ];

            $this->providerManager->bootDeferable($bound);

        } else {
            $result = [];

        }

        return $result;
    }


    /**
     * @param string $class
     * @param mixed  ...$arguments
     *
     * @return object
     * @throws NotFoundException
     */
    protected function resolveClass(string $class, ...$arguments)
    {
        if ('' === $class) {
            throw new InvalidArgumentException('Class should be not empty');
        }

        if (! $this->type->isClass($class)) {
            throw new InvalidArgumentException('Class should be existing class: ' . $class);
        }

        [ $kwargs, $args ] = $this->php->kwparams(...$arguments);

        $arguments = $this->autowireConstructor($class, array_merge($args, $kwargs));

        ksort($arguments);

        return new $class(...$arguments);
    }


    /**
     * @param string $id
     * @param array  $arguments
     *
     * @return null|mixed
     * @throws NotFoundException
     */
    protected function resolveNew(string $id, ...$arguments)
    {
        if ('' === $id) {
            throw new InvalidArgumentException('Id should be not empty');
        }

        $binds[] = $last = $id;

        $result = null
            ?? ( $this->tryResolveClass($last, ...$arguments) ?: null )
            ?? [];

        if (! $result) {
            throw new AutowireException('Unable to resolve id: ' . $id, func_get_args());
        }

        $result = reset($result);

        if ($this->extendRegistry->hasExtend($last)) {
            foreach ( $this->extendRegistry->getExtends($last) as $func ) {
                $result = $this->handle($func, $result, [
                    Node::class => $this,
                ]);
            }
        }

        foreach ( $binds as $bind ) {
            if ($this->sharedRegistry->hasShared($bind)) {
                $this->itemRegistry->setItem($bind, $result);
            }
        }

        return $result;
    }

    /**
     * @param string $id
     * @param array  $arguments
     *
     * @return null|mixed
     * @throws NotFoundException
     */
    protected function resolveCreate(string $id, ...$arguments)
    {
        if ('' === $id) {
            throw new InvalidArgumentException('Id should be not empty');
        }

        $binds[] = $last = $id;
        if ($resolved = $this->resolveBind($last)) {
            $last = $resolved[ 0 ];

            if (0
                || ( $this->type->isClosure($last) )
            ) {
                $binds[] = $last;
            }
        }

        $result = null
            ?? ( $this->tryResolveClosure($last, ...$arguments) ?: null )
            ?? ( $this->tryResolveClass($last, ...$arguments) ?: null )
            ?? [];

        if (! $result) {
            throw new AutowireException('Unable to resolve id: ' . $id, func_get_args());
        }

        $result = reset($result);

        if ($this->extendRegistry->hasExtend($last)) {
            foreach ( $this->extendRegistry->getExtends($last) as $func ) {
                $result = $this->handle($func, $result, [
                    Node::class => $this,
                ]);
            }
        }

        foreach ( $binds as $bind ) {
            if ($this->sharedRegistry->hasShared($bind)) {
                $this->itemRegistry->setItem($bind, $result);
            }
        }

        return $result;
    }

    /**
     * @param string $id
     * @param array  $arguments
     *
     * @return mixed
     * @throws NotFoundException
     */
    protected function resolveGet(string $id, ...$arguments)
    {
        if ('' === $id) {
            throw new InvalidArgumentException('Id should be not empty');
        }

        $binds[] = $last = $id;
        if ($resolved = $this->resolveBind($last)) {
            $last = $resolved[ 0 ];

            if (0
                || ( $this->itemRegistry->hasItem($last) )
                || ( $this->type->isClosure($last) )
            ) {
                $binds[] = $last;
            }
        }

        $result = null
            ?? ( $this->tryResolveItem($last) ?: null )
            ?? ( $this->tryResolveClosure($last, ...$arguments) ?: null )
            ?? ( $this->tryResolveClass($last, ...$arguments) ?: null )
            ?? [];

        if (! $result) {
            throw new AutowireException('Unable to resolve id: ' . $id, func_get_args());
        }

        $result = reset($result);

        if ($this->extendRegistry->hasExtend($last)) {
            foreach ( $this->extendRegistry->getExtends($last) as $func ) {
                $result = $this->handle($func, $result, [
                    Node::class => $this,
                ]);
            }
        }

        foreach ( $binds as $bind ) {
            if ($this->sharedRegistry->hasShared($bind)) {
                $this->itemRegistry->setItem($bind, $result);
            }
        }

        return $result;
    }


    /**
     * @param string|object|\ReflectionClass $object
     * @param array                          $params
     *
     * @return array
     * @throws NotFoundException
     */
    protected function autowireConstructor($object, array $params = []) : array
    {
        if (! $this->type->isReflectableClass($object, $class)) {
            throw new InvalidArgumentException('Class is not reflectable: ' . $class, func_get_args());
        }

        $rm = $this->reflection
            ->reflectClass($class)
            ->getConstructor();

        $result = isset($rm)
            ? $this->autowireParams($rm->getParameters(), $params)
            : [];

        return $result;
    }

    /**
     * @param string|object|\ReflectionClass $object
     * @param string                         $method
     * @param array                          $params
     *
     * @return array
     * @throws NotFoundException
     */
    protected function autowireMethod($object, string $method, array $params = []) : array
    {
        if (! $this->type->isReflectableClass($object, $class)) {
            throw new InvalidArgumentException('Class is not reflectable: ' . $class, func_get_args());
        }

        $rm = $this->reflection
            ->reflectMethod($this->reflection->reflectClass($object), $method);

        $result = $this->autowireParams($rm->getParameters(), $params);

        return $result;
    }

    /**
     * @param \Closure $closure
     * @param array    $params
     *
     * @return array
     * @throws NotFoundException
     */
    protected function autowireClosure(\Closure $closure, array $params = []) : array
    {
        $rf = $this->reflection->reflectClosure($closure);

        $result = $this->autowireParams($rf->getParameters(), $params);

        return $result;
    }


    /**
     * @param mixed $callable
     * @param array $params
     *
     * @return array
     * @throws NotFoundException
     */
    protected function autowireCallable($callable, array $params = []) : array
    {
        $result = null
            ?? $this->tryAutowireCallableString($callable, $params)
            ?? $this->tryAutowireCallableArray($callable, $params)
            ?? $this->tryAutowireCallableClosure($callable, $params);

        if (! isset($result)) {
            throw new InvalidArgumentException('Unable to autowire callable', func_get_args());
        }

        return $result;
    }

    /**
     * @param mixed $callable
     * @param array $params
     *
     * @return array
     * @throws NotFoundException
     */
    protected function autowireCallableString($callable, array $params = []) : array
    {
        $result = null
            ?? $this->tryAutowireCallableString($callable, $params);

        if (! isset($result)) {
            throw new InvalidArgumentException('Unable to autowire callable string', func_get_args());
        }

        return $result;
    }

    /**
     * @param mixed $callable
     * @param array $params
     *
     * @return array
     * @throws NotFoundException
     */
    protected function autowireCallableMethodNonStatic($callable, array $params = []) : array
    {
        $result = null
            ?? $this->tryAutowireCallableArrayMethodNonStatic($callable, $params);

        if (! isset($result)) {
            throw new InvalidArgumentException('Unable to autowire callable public method', func_get_args());
        }

        return $result;
    }


    /**
     * @param \ReflectionParameter[] $reflectionParameters
     * @param array                  $params
     *
     * @return array
     * @throws NotFoundException
     */
    protected function autowireParams(array $reflectionParameters, array $params = []) : array
    {
        $int = [];
        $str = [];
        foreach ( $params as $key => $val ) {
            if (is_int($key)) {
                $int[ $key ] = $val;
            } else {
                $str[ $key ] = $val;
            }
        }

        $args = [];

        if ($reflectionParameters) {
            foreach ( $reflectionParameters as $rp ) {
                $result = $this->autowireParam($rp, $int, $str);

                if (count($result)) {
                    $args[ $rp->getPosition() ] = reset($result);

                    continue;
                }

                if ($rp->isVariadic()) {
                    continue;
                }

                throw new AutowireException(
                    sprintf('Unable to autowire parameter %d (%s)', $rp->getPosition(), $rp->getName())
                );
            }
        }

        $keys = array_keys($args);
        sort($keys);

        $result = [];
        $idx = 0;
        foreach ( $keys as $key ) {
            if (! is_int($key)) {
                $key = $idx;
            }

            $result[ $key ] = $args[ $key ];
            $idx++;
        }

        return $result;
    }

    /**
     * @param \ReflectionParameter $rp
     * @param array                $int
     * @param array                $str
     *
     * @return array
     * @throws NotFoundException
     */
    protected function autowireParam(\ReflectionParameter $rp, array &$int = [], array &$str = []) : array
    {
        $autowireResult = null
            ?? ( $this->tryAutowireParamNamedType($rp, $int, $str) ?: null )
            ?? ( $this->tryAutowireParamName($rp, $int, $str) ?: null )
            ?? ( $this->tryAutowireParamPosition($rp, $int, $str) ?: null )
            ?? ( $this->tryAutowireParamDefault($rp, $int, $str) ?: null )
            ?? [];

        return $autowireResult;
    }


    /**
     * @param mixed $item
     *
     * @return array
     * @throws NotFoundException
     */
    protected function tryResolveItem($item) : array
    {
        if (! $this->itemRegistry->hasItem($item)) {
            return [];
        }

        $result = $this->itemRegistry->getItem($item);

        return [ $result ];
    }

    /**
     * @param mixed $closure
     * @param array ...$arguments
     *
     * @return array
     * @throws NotFoundException
     */
    protected function tryResolveClosure($closure, ...$arguments) : array
    {
        if (! $this->type->isClosure($closure)) {
            return [];
        }

        $result = $this->handle($closure, $this, ...$arguments);

        return [ $result ];
    }

    /**
     * @param mixed $class
     * @param array ...$arguments
     *
     * @return array
     * @throws NotFoundException
     */
    protected function tryResolveClass($class, ...$arguments) : array
    {
        if (! $this->type->isClass($class)) {
            return [];
        }

        $result = $this->resolveClass($class, ...$arguments);

        return [ $result ];
    }


    /**
     * @param mixed $callable
     * @param array $params
     *
     * @return array
     * @throws NotFoundException
     */
    protected function tryAutowireCallableString($callable, array $params = []) : ?array
    {
        if (! $this->type->isCallableString($callable)) {
            return null;
        }

        $rf = $this->reflection->reflectCallable($callable);

        $result = $this->autowireParams($rf->getParameters(), $params);

        return $result;
    }

    /**
     * @param mixed $callable
     * @param array $params
     *
     * @return array
     * @throws NotFoundException
     */
    protected function tryAutowireCallableArray($callable, array $params = []) : ?array
    {
        if (! $this->type->isCallableArray($callable)) {
            return null;
        }

        $rm = $this->reflection->reflectMethod($callable[ 0 ], $callable[ 1 ]);

        $a = $rm->isStatic();
        $b = is_object($callable[ 0 ]);
        $xor = ( ( $a != $b ) && ( $a || $b ) );

        $result = $xor
            ? $this->autowireParams($rm->getParameters(), $params)
            : null;

        return $result;
    }

    /**
     * @param mixed $callable
     * @param array $params
     *
     * @return array
     * @throws NotFoundException
     */
    protected function tryAutowireCallableArrayMethodNonStatic($callable, array $params = []) : ?array
    {
        if (! $this->type->isCallableArray($callable)) {
            return null;
        }

        $rm = $this->reflection->reflectMethod($callable[ 0 ], $callable[ 1 ]);

        if ($rm->isStatic() || ! is_object($callable[ 0 ])) {
            return null;
        }

        $result = $this->autowireParams($rm->getParameters(), $params);

        return $result;
    }

    /**
     * @param mixed $callable
     * @param array $params
     *
     * @return array
     * @throws NotFoundException
     */
    protected function tryAutowireCallableArrayMethodStatic($callable, array $params = []) : ?array
    {
        if (! $this->type->isCallableArray($callable)) {
            return null;
        }

        $rm = $this->reflection->reflectMethod($callable[ 0 ], $callable[ 1 ]);

        if (! $rm->isStatic()) {
            return null;
        }

        $result = $this->autowireParams($rm->getParameters(), $params);

        return $result;
    }

    /**
     * @param mixed $closure
     * @param array $params
     *
     * @return array
     * @throws NotFoundException
     */
    protected function tryAutowireCallableClosure($closure, array $params = []) : ?array
    {
        if (! $this->type->isClosure($closure)) {
            return null;
        }

        $result = $this->autowireClosure($closure, $params);

        return $result;
    }


    /**
     * @param \ReflectionParameter $rp
     * @param array                $int
     * @param array                $str
     *
     * @return array
     * @throws NotFoundException
     */
    protected function tryAutowireParamNamedType(\ReflectionParameter $rp, array &$int = [], array &$str = []) : array
    {
        if (! $rpType = $rp->getType()) {
            return [];
        }
        if (! is_a($rpType, \ReflectionNamedType::class)) {
            return [];
        }

        $rpTypeName = $rpType->getName();

        $rpKey = '$' . $rp->getName();

        if (array_key_exists($pos = $rp->getPosition(), $int)
            && is_object($int[ $pos ])
            && is_a($int[ $pos ], $rpTypeName)
        ) {
            // check key [ 0 => Object ]

            $value = $int[ $pos ];

            return [ $value ];

        } elseif (array_key_exists($rpTypeName, $str)
            && is_object($str[ $rpTypeName ])
            && is_a($str[ $rpTypeName ], $rpTypeName)
        ) {
            // check key [ static::class => Object ]

            $value = $str[ $rpTypeName ];

            $int = $this->arr->expand($int, $rp->getPosition(), $value);

            return [ $value ];

        } elseif (array_key_exists($rpKey, $str)
            && is_object($str[ $rpKey ])
            && is_a($str[ $rpKey ], $rpTypeName)
        ) {
            // check key [ '$var' => Object ]

            $value = $str[ $rpKey ];

            $int = $this->arr->expand($int, $rp->getPosition(), $value);

            return [ $value ];

        } elseif (interface_exists($rpTypeName) || class_exists($rpTypeName)) {
            // autowire class or interface

            $isNull = false;
            try {
                $value = $rp->getDefaultValue();
                $isNull = is_null($value);
            }
            catch ( \ReflectionException $exception ) {
            }

            if (! $isNull) {
                $value = $this->get($rpTypeName);

            } else {
                if (! is_a($rpTypeName, DelegateInterface::class, true)) {
                    return [];
                }

                if (! $this->delegateManager->hasDelegateClass()) {
                    throw new MissingDelegateClassException('You must define DelegateClass to use delayed delegation');
                }

                $class = $this->delegateManager->getDelegateClass();
                $value = new $class($this, $rpTypeName);
            }

            $int = $this->arr->expand($int, $rp->getPosition(), $value);

            return [ $value ];
        }

        return [];
    }

    /**
     * @param \ReflectionParameter $rp
     * @param array                $int
     * @param array                $str
     *
     * @return array
     */
    protected function tryAutowireParamName(\ReflectionParameter $rp, array &$int = [], array &$str = [])
    {
        $rpKey = '$' . $rp->getName();
        if (! array_key_exists($rpKey, $str)) {
            return [];
        }

        if ($rp->isVariadic()) {
            if (is_null($str[ $rpKey ]) || ( [] === $str[ $rpKey ] )) {
                return [];
            }
        }

        $value = $str[ $rpKey ];

        $int = $this->arr->expand($int, $rp->getPosition(), $value);

        return [ $value ];
    }

    /**
     * @param \ReflectionParameter $rp
     * @param array                $int
     * @param array                $str
     *
     * @return array
     */
    protected function tryAutowireParamPosition(\ReflectionParameter $rp, array &$int = [], array &$str = []) : array
    {
        $rpPos = $rp->getPosition();

        if (! array_key_exists($rpPos, $int)) {
            return [];
        }

        if ($rp->isVariadic()) {
            if (is_null($int[ $rpPos ]) || ( [] === $int[ $rpPos ] )) {
                return [];
            }
        }

        $value = $int[ $rpPos ];

        return [ $value ];
    }

    /**
     * @param \ReflectionParameter $rp
     * @param array                $int
     * @param array                $str
     *
     * @return array
     */
    protected function tryAutowireParamDefault(\ReflectionParameter $rp, array &$int = [], array &$str = []) : array
    {
        try {
            $value = $rp->getDefaultValue();
        }
        catch ( \ReflectionException $exception ) {
            return [];
        }

        return [ $value ];
    }
}
