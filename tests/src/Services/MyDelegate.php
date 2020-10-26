<?php

namespace Gzhegow\Di\Tests\Services;

use Gzhegow\Di\Delegate;

/**
 * Class MyDelegate
 */
class MyDelegate extends Delegate implements
	MyServiceBDelegateInterface,
	MyServiceCDelegateInterface
{
}