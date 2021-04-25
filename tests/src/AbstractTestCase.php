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
        $trace = [];

        set_error_handler(function ($code, $string, $file, $line) use (&$trace) {
            $trace = debug_backtrace();

            throw new \ErrorException($string, null, $code, $file, $line);
        });

        register_shutdown_function(function () use (&$trace) {
            print_r($trace);
        });
    }


    /**
     * @var bool
     */
    protected static $boot = false;
}
