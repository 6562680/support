<?php

namespace Gzhegow\Di\Core\Registry;

use Gzhegow\Di\Core\AssertInterface;
use Gzhegow\Di\App\Exceptions\Logic\OutOfRangeException;

/**
 * ExtendRegistry
 */
class ExtendRegistry
{
    /**
     * @var AssertInterface
     */
    protected $assert;


    /**
     * @var \Closure[][]
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
     * @return \Closure[]
     */
    public function getExtends(string $bindName) : array
    {
        if (! $this->hasExtend($bindName)) {
            throw new OutOfRangeException('No extends found by key: ' . $bindName, func_get_args());
        }

        $result = $this->items[ $bindName ];

        return $result;
    }


    /**
     * @param string $bindName
     *
     * @return bool
     */
    public function hasExtend($bindName) : bool
    {
        return $this->assert->isBindName($bindName)
            && isset($this->items[ $bindName ]);
    }


    /**
     * @param array $extends
     *
     * @return ExtendRegistry
     */
    public function addExtends(array $extends = [])
    {
        foreach ( $extends as $bindName => $extend ) {
            $this->addExtend($bindName, $extend);
        }

        return $this;
    }

    /**
     * @param string          $bindName
     * @param \Closure|string $extend
     *
     * @return ExtendRegistry
     */
    public function addExtend(string $bindName, $extend)
    {
        $this->assert->isBindNameOrFail($bindName);
        $this->assert->isExtendOrFail($extend);

        $this->items[ $bindName ][] = $extend;

        return $this;
    }


    /**
     * @param array $extends
     *
     * @return ExtendRegistry
     */
    public function setExtends(array $extends = [])
    {
        $this->items = [];

        $this->addExtends($extends);

        return $this;
    }
}
