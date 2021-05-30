<?php

namespace Gzhegow\Support\Tests;

use PHPUnit\Framework\TestCase;
use Gzhegow\Support\Domain\Debug\TestCaseTrait;


/**
 * AbstractTestCase
 */
abstract class AbstractTestCase extends TestCase
{
    use TestCaseTrait;
}
