<?php

namespace Gzhegow\Di\Domain\Injector;

use Gzhegow\Di\Domain\Node\NodeFactoryInterface;
use Gzhegow\Di\Exceptions\Exception\Domain\NotFoundException;

/**
 * Injector
 */
class Injector implements InjectorInterface
{
    /**
     * @var NodeFactoryInterface
     */
    protected $nodeFactory;


    /**
     * Constructor
     *
     * @param NodeFactoryInterface $nodeFactory
     */
    public function __construct(
        NodeFactoryInterface $nodeFactory
    )
    {
        $this->nodeFactory = $nodeFactory;
    }


    /**
     * @param string $id
     *
     * @param array  $arguments
     *
     * @return mixed
     * @throws NotFoundException
     */
    public function new($id, ...$arguments)
    {
        $result = $this->nodeFactory
            ->newRootNode($id)
            ->newAsRoot($id, ...$arguments);

        return $result;
    }


    /**
     * @param string $id
     * @param array  $arguments
     *
     * @return mixed
     * @throws NotFoundException
     */
    public function create($id, ...$arguments)
    {
        $result = $this->nodeFactory
            ->newRootNode($id)
            ->createAsRoot($id, ...$arguments);

        return $result;
    }


    /**
     * @param callable $func
     * @param array    $arguments
     *
     * @return mixed
     * @throws NotFoundException
     */
    public function handle($func, ...$arguments)
    {
        $result = $this->nodeFactory
            ->newRootNode($func)
            ->handle($func, ...$arguments);

        return $result;
    }


    /**
     * @param mixed    $newthis
     * @param callable $func
     * @param array    $arguments
     *
     * @return mixed
     * @throws NotFoundException
     */
    public function call($newthis, $func, ...$arguments)
    {
        $result = $this->nodeFactory
            ->newRootNode($func)
            ->call($newthis, $func, ...$arguments);

        return $result;
    }
}
