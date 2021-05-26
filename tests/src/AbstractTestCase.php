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


    /**
     * @return void
     */
    protected function setUp() : void
    {
        if (! static::$boot) {
            static::boot();

            static::$boot = true;
        }
    }


    /**
     * @return void
     */
    protected static function boot() : void
    {
    }

    /**
     * @var bool
     */
    protected static $boot = false;
}
