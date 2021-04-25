<?php

namespace Gzhegow\Di\Core\Registry;

use Gzhegow\Di\Core\AssertInterface;
use Gzhegow\Di\App\Exceptions\Logic\OutOfRangeException;

/**
 * DeferableRegistry
 */
class DeferableRegistry
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
    public function getDeferable(string $bindName)
    {
        if (! $this->hasDeferable($bindName)) {
            throw new OutOfRangeException('No deferable bind found by key: ' . $bindName, func_get_args());
        }

        $result = $this->items[ $bindName ];

        return $result;
    }


    /**
     * @param string $bindName
     *
     * @return bool
     */
    public function hasDeferable($bindName) : bool
    {
        return $this->assert->isBindName($bindName)
            && isset($this->items[ $bindName ]);
    }


    /**
     * @param array $deferables
     *
     * @return DeferableRegistry
     */
    public function addDeferables(array $deferables)
    {
        foreach ( $deferables as $bindName => $provider ) {
            $this->addDeferable($bindName, $provider);
        }

        return $this;
    }

    /**
     * @param string          $bindName
     * @param \Closure|string $provider
     *
     * @return DeferableRegistry
     */
    public function addDeferable(string $bindName, $provider)
    {
        $this->assert->isBindNameOrFail($bindName);
        $this->assert->isProviderClassOrFail($provider);

        $this->items[ $bindName ][] = $provider;

        return $this;
    }


    /**
     * @param array $deferables
     *
     * @return DeferableRegistry
     */
    public function setDeferables(array $deferables)
    {
        $this->items = [];

        $this->addDeferables($deferables);

        return $this;
    }
}
