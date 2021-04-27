<?php

namespace Gzhegow\Di;

use Gzhegow\Support\Type;
use Psr\Container\ContainerInterface;
use Gzhegow\Reflection\ReflectionInterface;
use Gzhegow\Di\Domain\Delegate\DelegateManager;
use Gzhegow\Di\Domain\Provider\ProviderManager;
use Gzhegow\Di\Domain\Node\NodeFactoryInterface;
use Gzhegow\Di\Domain\Injector\InjectorInterface;
use Gzhegow\Di\App\Exceptions\Runtime\Domain\NotFoundException;

/**
 * Di
 */
class Di implements DiInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

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
     * @var DiManager
     */
    protected $diManager;
    /**
     * @var ProviderManager
     */
    protected $providerManager;
    /**
     * @var DelegateManager
     */
    protected $delegateManager;

    /**
     * @var InjectorInterface
     */
    protected $injector;


    /**
     * Constructor
     *
     * @param ContainerInterface   $container
     *
     * @param Type                 $type
     *
     * @param ReflectionInterface  $reflection
     *
     * @param NodeFactoryInterface $nodeFactory
     *
     * @param DiManager            $diManager
     * @param ProviderManager      $providerManager
     * @param DelegateManager      $delegateManager
     *
     * @param InjectorInterface    $injector
     */
    public function __construct(
        Type $type,

        ReflectionInterface $reflection,

        NodeFactoryInterface $nodeFactory,

        ContainerInterface $container,
        InjectorInterface $injector,

        DiManager $diManager,
        ProviderManager $providerManager,
        DelegateManager $delegateManager
    )
    {
        $this->type = $type;

        $this->reflection = $reflection;

        $this->nodeFactory = $nodeFactory;

        $this->container = $container;
        $this->injector = $injector;

        $this->diManager = $diManager;
        $this->providerManager = $providerManager;
        $this->delegateManager = $delegateManager;

        $binds = [
            ContainerInterface::class,
            InjectorInterface::class,
            DiInterface::class,

            static::class,
        ];
        foreach ( $binds as $key ) {
            $this->set($key, $this);
        }

        static::$root = static::$root ?? $this;
    }


    /**
     * @param string $id
     * @param array  $arguments
     *
     * @return mixed
     * @throws NotFoundException
     */
    public static function build(string $id, ...$arguments)
    {
        return static::getRoot()->create($id, ...$arguments);
    }


    /**
     * @param string $id
     *
     * @param array  $arguments
     *
     * @return mixed
     * @throws NotFoundException
     */
    public function new($id, ...$arguments)
    {
        return $this->injector->new($id, ...$arguments);
    }


    /**
     * @return DiManager
     */
    public function getDiManager() : DiManager
    {
        return $this->diManager;
    }

    /**
     * @return ProviderManager
     */
    public function getProviderManager() : ProviderManager
    {
        return $this->providerManager;
    }

    /**
     * @return DelegateManager
     */
    public function getDelegateManager() : DelegateManager
    {
        return $this->delegateManager;
    }


    /**
     * @param string $id
     *
     * @return mixed
     * @throws NotFoundException
     */
    public function get($id)
    {
        return $this->container->get($id);
    }


    /**
     * @param string $id
     *
     * @return bool
     */
    public function has($id)
    {
        return $this->container->has($id);
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    public function hasBind($id)
    {
        return $this->diManager->hasBind($id);
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    public function hasItem($id)
    {
        return $this->diManager->hasItem($id);
    }


    /**
     * @param string $id
     * @param mixed  $item
     *
     * @return static
     */
    public function set(string $id, $item)
    {
        $this->diManager->set($id, $item);

        return $this;
    }

    /**
     * @param string          $id
     * @param string|\Closure $item
     *
     * @return static
     */
    public function replace(string $id, $item)
    {
        $this->diManager->replace($id, $item);

        return $this;
    }


    /**
     * @param string $id
     * @param array  $arguments
     *
     * @return mixed
     * @throws NotFoundException
     */
    public function create($id, ...$arguments)
    {
        return $this->injector->create($id, ...$arguments);
    }


    /**
     * @param string $delegateClass
     *
     * @return static
     */
    public function setDelegateClass(string $delegateClass)
    {
        $this->delegateManager->setDelegateClass($delegateClass);

        return $this;
    }


    /**
     * @param string          $id
     * @param string|\Closure $bind
     * @param bool            $shared
     *
     * @return static
     */
    public function bind(string $id, $bind, bool $shared = false)
    {
        $this->diManager->bind($id, $bind, $shared);

        return $this;
    }

    /**
     * @param string          $id
     * @param string|\Closure $bind
     *
     * @return static
     */
    public function bindShared(string $id, $bind)
    {
        $this->diManager->bindShared($id, $bind);

        return $this;
    }


    /**
     * @param string          $id
     * @param string|\Closure $bind
     * @param bool            $shared
     *
     * @return static
     */
    public function rebind(string $id, $bind, bool $shared = false)
    {
        $this->diManager->rebind($id, $bind, $shared);

        return $this;
    }

    /**
     * @param string $id
     * @param mixed  $bind
     *
     * @return static
     */
    public function rebindShared(string $id, $bind)
    {
        $this->diManager->rebindShared($id, $bind);

        return $this;
    }


    /**
     * @param string                   $id
     * @param string|callable|\Closure $func
     *
     * @return static
     */
    public function extend(string $id, $func)
    {
        $this->diManager->extend($id, $func);

        return $this;
    }


    /**
     * @param mixed $provider
     *
     * @return static
     */
    public function registerProvider($provider)
    {
        $this->providerManager->addProvider($provider);

        return $this;
    }


    /**
     * @return static
     */
    public function boot()
    {
        $this->providerManager->boot();

        return $this;
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
        $result = $this->injector->handle($func, ...$arguments);

        return $result;
    }

    /**
     * @param mixed    $newthis
     * @param callable $func
     * @param array    $arguments
     *
     * @return mixed
     * @throws NotFoundException
     */
    public function call($newthis, $func, ...$arguments)
    {
        $result = $this->injector->call($newthis, $func, ...$arguments);

        return $result;
    }


    /**
     * @return static
     */
    public static function getRoot() : DiInterface
    {
        return static::$root;
    }

    /**
     * @param DiInterface $di
     *
     * @return DiInterface
     */
    public static function setRoot(DiInterface $di)
    {
        return static::$root = $di;
    }


    /**
     * @param string $id
     * @param array  $arguments
     *
     * @return mixed
     * @throws NotFoundException
     */
    public static function make(string $id, ...$arguments)
    {
        return static::getRoot()->new($id, ...$arguments);
    }

    /**
     * @param string $id
     *
     * @return mixed
     * @throws NotFoundException
     */
    public static function find(string $id)
    {
        return static::getRoot()->get($id);
    }

    /**
     * @param string $id
     *
     * @return mixed
     * @throws NotFoundException
     */
    public static function exists(string $id)
    {
        return static::getRoot()->has($id);
    }


    /**
     * @var static
     */
    protected static $root;
}
