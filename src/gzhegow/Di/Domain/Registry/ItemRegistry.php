<?php

namespace Gzhegow\Di\Domain\Registry;

use Gzhegow\Di\Core\AssertInterface;
use Gzhegow\Di\Exceptions\Logic\OutOfRangeException;
use Gzhegow\Di\Exceptions\Runtime\OverflowException;

/**
 * ItemRegistry
 */
class ItemRegistry
{
    /**
     * @var AssertInterface
     */
    protected $assert;


    /**
     * @var mixed
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
     * @return mixed
     */
    public function getItem(string $bindName)
    {
        if (! $this->hasItem($bindName)) {
            throw new OutOfRangeException('No bind found by key: ' . $bindName, func_get_args());
        }

        $result = $this->items[ $bindName ];

        return $result;
    }


    /**
     * @param string $bindName
     *
     * @return bool
     */
    public function hasItem($bindName) : bool
    {
        return $this->assert->isBindName($bindName)
            && isset($this->items[ $bindName ]);
    }


    /**
     * @param string          $bindName
     * @param \Closure|string $item
     *
     * @return ItemRegistry
     */
    public function addItem(string $bindName, $item)
    {
        if ($this->hasItem($bindName)) {
            throw new OverflowException('Item is already registered: ' . $bindName, func_get_args());
        }

        $this->setItem($bindName, $item);

        return $this;
    }


    /**
     * @param string $bindName
     * @param mixed  $item
     *
     * @return ItemRegistry
     */
    public function setItem(string $bindName, $item)
    {
        $this->assert->isBindNameOrFail($bindName);

        $this->items[ $bindName ] = $item;

        return $this;
    }
}
