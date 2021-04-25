<?php

namespace Gzhegow\Di;


/**
 * Class NodeFactory
 */
interface NodeFactoryInterface
{
	/**
	 * @param string $id
	 *
	 * @param Node   $parent
	 *
	 * @return Node
	 */
	public function newNode(string $id, Node $parent = null) : Node;
}