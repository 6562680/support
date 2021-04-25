<?php

namespace Gzhegow\Di\Domain\Container;

use Gzhegow\Support\Type;
use Psr\Container\ContainerInterface;
use Gzhegow\Di\Core\Registry\BindRegistry;
use Gzhegow\Di\Core\Registry\ItemRegistry;
use Gzhegow\Di\Domain\Node\NodeFactoryInterface;
use Gzhegow\Di\App\Exceptions\Exception\Domain\NotFoundException;

/**
 * ProxyContainer
 */
class ProxyContainer implements ContainerInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;


    /**
     * Constructor
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }


    /**
     * @param mixed $id
     *
     * @return mixed
     * @throws NotFoundException
     */
    public function get($id)
    {
        return $this->container->get($id);
    }


    /**
     * @param mixed $id
     *
     * @return bool
     */
    public function has($id)
    {
        return $this->container->has($id);
    }
}
