<?php

namespace Gzhegow\Di\Domain\Container;

use Psr\Container\ContainerInterface;
use Gzhegow\Di\Exceptions\Exception\Domain\NotFoundException;

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
    public function __construct(
        ContainerInterface $container
    )
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
