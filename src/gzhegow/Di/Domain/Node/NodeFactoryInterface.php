<?php

namespace Gzhegow\Di\Domain\Node;


/**
 * NodeFactory
 */
interface NodeFactoryInterface
{
    /**
     * @param string    $any
     *
     * @param null|Node $parent
     *
     * @return Node
     */
    public function newNode($any, Node $parent) : Node;

    /**
     * @param string $any
     *
     * @return Node
     */
    public function newRootNode($any) : Node;
}
