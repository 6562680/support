<?php

namespace Gzhegow\Di\Tests;

use PHPUnit\Framework\TestCase;

/**
 * Class AbstractTestCase
 */
abstract class AbstractTestCase extends TestCase
{
    /**
     * @return void
     * @throws \ErrorException
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
     * @throws \ErrorException
     */
    protected static function boot() : void
    {
    }


    /**
     * @var bool
     */
    protected static $boot = false;
}
