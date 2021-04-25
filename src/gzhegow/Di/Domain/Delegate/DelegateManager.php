<?php

namespace Gzhegow\Di\Domain\Delegate;

use Gzhegow\Di\Core\AssertInterface;

/**
 * DelegateManager
 */
class DelegateManager
{
    /**
     * @var AssertInterface
     */
    protected $assert;


    /**
     * @var string
     */
    protected $delegateClass;


    /**
     * Constructor
     *
     * @param AssertInterface $assert
     */
    public function __construct(AssertInterface $assert)
    {
        $this->assert = $assert;
    }


    /**
     * @return string|DelegateInterface
     */
    public function getDelegateClass() : string
    {
        return $this->delegateClass;
    }


    /**
     * @return bool
     */
    public function hasDelegateClass() : bool
    {
        return ! ! $this->delegateClass;
    }


    /**
     * @param string|DelegateInterface $delegateClass
     *
     * @return static
     */
    public function setDelegateClass($delegateClass)
    {
        $this->assert->isDelegateClassOrFail($delegateClass);

        $this->delegateClass = $delegateClass;

        return $this;
    }
}
