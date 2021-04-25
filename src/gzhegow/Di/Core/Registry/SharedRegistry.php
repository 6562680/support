<?php

namespace Gzhegow\Di\Core\Registry;

use Gzhegow\Di\Core\AssertInterface;
use Gzhegow\Di\App\Exceptions\Runtime\OverflowException;

/**
 * SharedRegistry
 */
class SharedRegistry
{
    /**
     * @var AssertInterface
     */
    protected $assert;


    /**
     * @var bool[]
     */
    protected $items = [];


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
     * @param string $bindName
     *
     * @return bool
     */
    public function hasLocal($bindName) : bool
    {
        return $this->assert->isBindName($bindName)
            && empty($this->items[ $bindName ]);
    }

    /**
     * @param string $bindName
     *
     * @return bool
     */
    public function hasShared($bindName) : bool
    {
        return $this->assert->isBindName($bindName)
            && ! empty($this->items[ $bindName ]);
    }


    /**
     * @param string $bindName
     *
     * @return SharedRegistry
     */
    public function addLocal(string $bindName)
    {
        if ($this->hasLocal($bindName)) {
            throw new OverflowException('Bind is already shared: ' . $bindName, func_get_args());
        }

        $this->setLocal($bindName);

        return $this;
    }

    /**
     * @param string $bindName
     *
     * @return SharedRegistry
     */
    public function addShared(string $bindName)
    {
        if ($this->hasShared($bindName)) {
            throw new OverflowException('Bind is already shared: ' . $bindName, func_get_args());
        }

        $this->setShared($bindName);

        return $this;
    }


    /**
     * @param string $bindName
     *
     * @return SharedRegistry
     */
    public function setLocal(string $bindName)
    {
        $this->assert->isBindNameOrFail($bindName);

        $this->items[ $bindName ] = false;

        return $this;
    }

    /**
     * @param string $bindName
     *
     * @return SharedRegistry
     */
    public function setShared(string $bindName)
    {
        $this->assert->isBindNameOrFail($bindName);

        $this->items[ $bindName ] = true;

        return $this;
    }


    /**
     * @param string $bindName
     *
     * @return SharedRegistry
     */
    public function removeShared(string $bindName)
    {
        unset($this->items[ $bindName ]);

        return $this;
    }
}
