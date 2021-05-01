<?php

namespace Gzhegow\Di\Domain\Registry;

use Gzhegow\Di\Core\AssertInterface;
use Gzhegow\Di\Exceptions\Logic\OutOfRangeException;
use Gzhegow\Di\Exceptions\Runtime\OverflowException;

/**
 * BindRegistry
 */
class BindRegistry
{
    /**
     * @var AssertInterface
     */
    protected $assert;


    /**
     * @var string[]|\Closure[]
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
     * @return \Closure|string
     */
    public function getBind(string $bindName)
    {
        if (! $this->hasBind($bindName)) {
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
    public function hasBind($bindName) : bool
    {
        return $this->assert->isBindName($bindName)
            && isset($this->items[ $bindName ]);
    }


    /**
     * @param string          $bindName
     * @param \Closure|string $bind
     *
     * @return BindRegistry
     */
    public function addBind(string $bindName, $bind)
    {
        if ($this->hasBind($bindName)) {
            throw new OverflowException('Bind is already registered: ' . $bindName, func_get_args());
        }

        $this->setBind($bindName, $bind);

        return $this;
    }


    /**
     * @param string          $bindName
     * @param \Closure|string $bind
     *
     * @return BindRegistry
     */
    public function setBind(string $bindName, $bind)
    {
        $this->assert->isBindNameOrFail($bindName);
        $this->assert->isBindOrFail($bind);

        $this->items[ $bindName ] = $bind;

        return $this;
    }
}
