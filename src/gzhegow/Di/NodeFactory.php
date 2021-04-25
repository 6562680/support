<?php

namespace Gzhegow\Di;

use Gzhegow\Support\Arr;
use Gzhegow\Support\Php;
use Gzhegow\Support\Type;
use Gzhegow\Reflection\ReflectionInterface;
use Gzhegow\Di\Registry\BindRegistryInterface;
use Gzhegow\Di\Registry\ItemRegistryInterface;
use Gzhegow\Di\Registry\SharedRegistryInterface;
use Gzhegow\Di\Registry\ExtendRegistryInterface;
use Gzhegow\Di\Provider\ProviderManagerInterface;
use Gzhegow\Di\Delegate\DelegateManagerInterface;

/**
 * Class NodeFactory
 */
class NodeFactory implements NodeFactoryInterface
{
	/**
	 * @var ReflectionInterface
	 */
	protected $reflection;

	/**
	 * @var BindRegistryInterface
	 */
	protected $bindRegistry;
	/**
	 * @var ItemRegistryInterface
	 */
	protected $itemRegistry;
	/**
	 * @var SharedRegistryInterface
	 */
	protected $sharedRegistry;
	/**
	 * @var ExtendRegistryInterface
	 */
	protected $extendRegistry;

	/**
	 * @var DelegateManagerInterface
	 */
	protected $delegateManager;
	/**
	 * @var ProviderManagerInterface
	 */
	protected $providerManager;

	/**
	 * @var Node
	 */
	protected $rootNode;


	/**
	 * Constructor
	 *
	 * @param ReflectionInterface      $reflection
	 * @param BindRegistryInterface    $bindRegistry
	 * @param ItemRegistryInterface    $itemRegistry
	 * @param SharedRegistryInterface  $sharedRegistry
	 * @param ExtendRegistryInterface  $extendRegistry
	 * @param DelegateManagerInterface $delegateManager
	 * @param ProviderManagerInterface $providerManager
	 */
	public function __construct(
		ReflectionInterface $reflection,

		BindRegistryInterface $bindRegistry,
		ItemRegistryInterface $itemRegistry,
		SharedRegistryInterface $sharedRegistry,
		ExtendRegistryInterface $extendRegistry,

		DelegateManagerInterface $delegateManager,
		ProviderManagerInterface $providerManager
	)
	{
		$this->reflection = $reflection;

		$this->bindRegistry = $bindRegistry;
		$this->itemRegistry = $itemRegistry;
		$this->sharedRegistry = $sharedRegistry;
		$this->extendRegistry = $extendRegistry;

		$this->providerManager = $providerManager;
		$this->delegateManager = $delegateManager;

		$this->rootNode = $this->newNode(Node::class);
	}


	/**
	 * @param string $id
	 *
	 * @param Node   $parent
	 *
	 * @return Node
	 */
	public function newNode(string $id, Node $parent = null) : Node
	{
		$php = new Php();
		$type = new Type();

		$arr = new Arr($php, $type);

		$node = new Node(
			$arr, $php, $type,

			$this->reflection,

			$this,

			$this->bindRegistry, $this->itemRegistry, $this->sharedRegistry, $this->extendRegistry,

			$this->delegateManager, $this->providerManager,

			$id, $parent
		);

		return $node;
	}
}