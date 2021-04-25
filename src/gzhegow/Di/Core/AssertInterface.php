<?php

namespace Gzhegow\Di\Core;


/**
 * AssertInterface
 */
interface AssertInterface
{
    /**
     * @param mixed $bindName
     *
     * @return bool
     */
    public function isBindName($bindName) : bool;

    /**
     * @param mixed $bindName
     *
     * @return static
     */
    public function isBindNameOrFail($bindName);



    /**
     * @param mixed $bind
     *
     * @return bool
     */
    public function isBind($bind) : bool;

    /**
     * @param mixed $bind
     *
     * @return static
     */
    public function isBindOrFail($bind);


    /**
     * @param mixed $extend
     *
     * @return bool
     */
    public function isExtend($extend) : bool;

    /**
     * @param mixed $extend
     *
     * @return static
     */
    public function isExtendOrFail($extend);


    /**
     * @param mixed $delegateClass
     *
     * @return bool
     */
    public function isDelegateClass($delegateClass) : bool;

    /**
     * @param mixed $delegateClass
     *
     * @return static
     */
    public function isDelegateClassOrFail($delegateClass);


    /**
     * @param mixed $provider
     *
     * @return bool
     */
    public function isProvider($provider) : bool;

    /**
     * @param mixed $provider
     *
     * @return static
     */
    public function isProviderOrFail($provider);


    /**
     * @param mixed $provider
     *
     * @return bool
     */
    public function isProviderObject($provider) : bool;

    /**
     * @param mixed $provider
     *
     * @return static
     */
    public function isProviderObjectOrFail($provider);


    /**
     * @param mixed $provider
     *
     * @return bool
     */
    public function isProviderClass($provider) : bool;

    /**
     * @param mixed $provider
     *
     * @return static
     */
    public function isProviderClassOrFail($provider);
}
