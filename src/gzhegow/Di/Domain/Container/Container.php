<?php

namespace Gzhegow\Di\Domain\Container;

use Gzhegow\Support\Type;
use Psr\Container\ContainerInterface;
use Gzhegow\Di\Core\Registry\BindRegistry;
use Gzhegow\Di\Core\Registry\ItemRegistry;
use Gzhegow\Di\Domain\Node\NodeFactoryInterface;
use Gzhegow\Di\App\Exceptions\Exception\Domain\NotFoundException;

/**
 * Container
 */
class Container implements ContainerInterface
{
    /**
     * @var Type
     */
    protected $type;

    /**
     * @var NodeFactoryInterface
     */
    protected $nodeFactory;

    /**
     * @var BindRegistry
     */
    protected $bindRegistry;
    /**
     * @var ItemRegistry
     */
    protected $itemRegistry;


    /**
     * Constructor
     *
     * @param Type                 $type
     *
     * @param NodeFactoryInterface $nodeFactory
     *
     * @param BindRegistry         $bindRegistry
     * @param ItemRegistry         $itemRegistry
     */
    public function __construct(
        Type $type,

        NodeFactoryInterface $nodeFactory,

        BindRegistry $bindRegistry,
        ItemRegistry $itemRegistry
    )
    {
        $this->type = $type;

        $this->nodeFactory = $nodeFactory;

        $this->bindRegistry = $bindRegistry;
        $this->itemRegistry = $itemRegistry;
    }


    /**
     * @param mixed $id
     *
     * @return mixed
     * @throws NotFoundException
     */
    public function get($id)
    {
        $result = $this->nodeFactory
            ->newRootNode($id)
            ->getAsRoot($id);

        return $result;
    }


    /**
     * @param mixed $id
     *
     * @return bool
     */
    public function has($id)
    {
        return 0
            || $this->bindRegistry->hasBind($id)
            || $this->itemRegistry->hasItem($id)
            || $this->type->isClass($id);
    }
}
