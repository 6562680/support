<?php

namespace Gzhegow\Di\Tests\Services\Delegate;

use Gzhegow\Di\Delegate;

/**
 * Class MyDelegate
 */
class MyDelegate extends Delegate implements
	MyDelegateServiceBInterface,
	MyDelegateServiceCInterface,
	MyDelegateServiceDInterface
{
}