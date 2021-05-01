<?php

namespace Gzhegow\Di\Core;

use Gzhegow\Support\Type;
use Gzhegow\Di\Domain\Provider\ProviderInterface;
use Gzhegow\Di\Domain\Delegate\DelegateInterface;
use Gzhegow\Di\Exceptions\Logic\InvalidArgumentException;

/**
 * Assert
 */
class Assert implements AssertInterface
{
    /**
     * @var Type
     */
    protected $type;


    /**
     * Constructor
     *
     * @param Type $type
     */
    public function __construct(Type $type)
    {
        $this->type = $type;
    }


    /**
     * @param mixed $bindName
     *
     * @return bool
     */
    public function isBindName($bindName) : bool
    {
        return $this->type->isTheStringOrNumber($bindName);
    }

    /**
     * @param mixed $bindName
     *
     * @return static
     */
    public function isBindNameOrFail($bindName)
    {
        if (! $this->isBindName($bindName)) {
            throw new InvalidArgumentException('BindName should be non-empty string or number', func_get_args());
        }

        return $this;
    }


    /**
     * @param mixed $bind
     *
     * @return bool
     */
    public function isBind($bind) : bool
    {
        return $this->type->isClosure($bind)
            || ( $this->type->isTheString($bind)
                && ( class_exists($bind) || interface_exists($bind) )
            );
    }

    /**
     * @param mixed $bind
     *
     * @return static
     */
    public function isBindOrFail($bind)
    {
        if (! $this->isBind($bind)) {
            throw new InvalidArgumentException('Bind should be \Closure, class name or interface name',
                func_get_args());
        }

        return $this;
    }


    /**
     * @param mixed $extend
     *
     * @return bool
     */
    public function isExtend($extend) : bool
    {
        return $this->type->isClosure($extend);
    }

    /**
     * @param mixed $extend
     *
     * @return static
     */
    public function isExtendOrFail($extend)
    {
        if (! $this->isExtend($extend)) {
            throw new InvalidArgumentException('Extend should be \Closure', func_get_args());
        }

        return $this;
    }


    /**
     * @param mixed $delegateClass
     *
     * @return bool
     */
    public function isDelegateClass($delegateClass) : bool
    {
        return ( ( is_string($delegateClass) || is_object($delegateClass) )
            && is_a($delegateClass, DelegateInterface::class, true) );
    }

    /**
     * @param mixed $delegateClass
     *
     * @return static
     */
    public function isDelegateClassOrFail($delegateClass)
    {
        if (! $this->isDelegateClass($delegateClass)) {
            throw new InvalidArgumentException('DelegateClass should be string or object that implements ' . DelegateInterface::class,
                func_get_args());
        }

        return $this;
    }


    /**
     * @param mixed $provider
     *
     * @return bool
     */
    public function isProvider($provider) : bool
    {
        return $this->isProviderObject($provider)
            || $this->isProviderClass($provider);
    }

    /**
     * @param mixed $provider
     *
     * @return static
     */
    public function isProviderOrFail($provider)
    {
        if (! $this->isProvider($provider)) {
            throw new InvalidArgumentException('Provider should be string or object that implements ' . ProviderInterface::class,
                func_get_args());
        }

        return $this;
    }


    /**
     * @param mixed $provider
     *
     * @return bool
     */
    public function isProviderObject($provider) : bool
    {
        return is_object($provider) && is_a($provider, ProviderInterface::class);
    }

    /**
     * @param mixed $provider
     *
     * @return static
     */
    public function isProviderObjectOrFail($provider)
    {
        if (! $this->isProviderObject($provider)) {
            throw new InvalidArgumentException('Provider should be object that implements ' . ProviderInterface::class,
                func_get_args());
        }

        return $this;
    }


    /**
     * @param mixed $provider
     *
     * @return bool
     */
    public function isProviderClass($provider) : bool
    {
        return is_string($provider) && is_a($provider, ProviderInterface::class, true);
    }

    /**
     * @param mixed $provider
     *
     * @return static
     */
    public function isProviderClassOrFail($provider)
    {
        if (! $this->isProviderClass($provider)) {
            throw new InvalidArgumentException('Provider should be class name that implements ' . ProviderInterface::class,
                func_get_args());
        }

        return $this;
    }
}
