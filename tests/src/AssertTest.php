<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\Assert;
use Gzhegow\Support\IAssert;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


class AssertTest extends AbstractTestCase
{
    protected function getAssert() : IAssert
    {
        return Assert::getInstance();
    }


    public function testAssertMessage()
    {
        $this->assertException(InvalidArgumentException::class,
            $try = function () {
                $this->getAssert()
                    ->assert('Hello %s')
                    ->assertNum('world');
            },
            $catch = function (InvalidArgumentException $e) {
                $this->assertEquals('Hello world', $e->getMessage());
            }
        );

        $this->assertException(InvalidArgumentException::class,
            $try = function () {
                $this->getAssert()
                    ->assert([ 'Hello %s', 'world' ])
                    ->assertNum('world');
            },
            $catch = function (InvalidArgumentException $e) {
                $this->assertEquals('Hello world', $e->getMessage());
            }
        );

        $this->assertException(InvalidArgumentException::class,
            $try = function () {
                $this->getAssert()
                    ->assert('Hello %s', 'world')
                    ->assertNum('world');
            },
            $catch = function (InvalidArgumentException $e) {
                $this->assertEquals('Hello world', $e->getMessage());
            }
        );
    }

    public function testAssertThrowable()
    {
        $this->assertException(InvalidArgumentException::class,
            $try = function () {
                $this->getAssert()
                    ->assert(new InvalidArgumentException([ 'Hello %s', 'world' ]))
                    ->assertNum('world');
            },
            $catch = function (InvalidArgumentException $e) {
                $this->assertEquals('Hello world', $e->getMessage());
            }
        );
    }
}
