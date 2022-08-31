<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\IEnv;
use Gzhegow\Support\XEnv;


class EnvTest extends AbstractTestCase
{
    protected function getEnv() : IEnv
    {
        return XEnv::getInstance();
    }


    public function testSetenv()
    {
        $env = $this->getEnv();

        $env->resetEnv();

        $envLocal = $env->env('Test', null, true, true);
        $envLocalCase = $env->env('Test', null, false, true);
        $envLocalUpper = $env->env('TEST', null, true, true);
        $envLocalCaseUpper = $env->env('TEST', null, false, true);
        $envRuntime = $env->env('Test', null, true, null);
        $envRuntimeCase = $env->env('Test', null, false, null);
        $envRuntimeUpper = $env->env('TEST', null, true, null);
        $envRuntimeCaseUpper = $env->env('TEST', null, false, null);

        $this->assertEquals(null, $envLocal);
        $this->assertEquals(null, $envLocalCase);
        $this->assertEquals(null, $envLocalUpper);
        $this->assertEquals(null, $envLocalCaseUpper);
        $this->assertEquals(null, $envRuntime);
        $this->assertEquals(null, $envRuntimeCase);
        $this->assertEquals(null, $envRuntimeUpper);
        $this->assertEquals(null, $envRuntimeCaseUpper);

        $env->setenv('Test', '1', false);

        $envLocalNew = $env->env('Test', null, true, true);
        $envLocalCaseNew = $env->env('Test', null, false, true);
        $envLocalNewUpper = $env->env('TEST', null, true, true);
        $envLocalCaseNewUpper = $env->env('TEST', null, false, true);
        $envRuntimeNew = $env->env('Test', null, true, null);
        $envRuntimeCaseNew = $env->env('Test', null, false, null);
        $envRuntimeNewUpper = $env->env('TEST', null, true, null);
        $envRuntimeCaseNewUpper = $env->env('TEST', null, false, null);

        $this->assertNotEquals($envLocalNew, $envRuntimeNew);
        $this->assertNotEquals($envLocalCaseNew, $envRuntimeCaseNew);

        $this->assertEquals(null, $envLocalNew);
        $this->assertEquals(null, $envLocalCaseNew);
        $this->assertEquals(null, $envLocalNewUpper);
        $this->assertEquals(null, $envLocalCaseNewUpper);
        $this->assertEquals('1', $envRuntimeNew);
        $this->assertEquals('1', $envRuntimeCaseNew);
        $this->assertEquals('1', $envRuntimeNewUpper);
        $this->assertEquals(null, $envRuntimeCaseNewUpper);

        // @gzhegow > setenv() doesnt use putenv() so getenv() returns nothing

        $envLocalNew = $env->getenv('Test', null, true, true);
        $envLocalCaseNew = $env->getenv('Test', null, false, true);
        $envRuntimeNew = $env->getenv('Test', null, true, null);
        $envRuntimeCaseNew = $env->getenv('Test', null, false, null);
        $envLocalNewUpper = $env->getenv('TEST', null, true, true);
        $envLocalCaseNewUpper = $env->getenv('TEST', null, false, true);
        $envRuntimeNewUpper = $env->getenv('TEST', null, true, null);
        $envRuntimeCaseNewUpper = $env->getenv('TEST', null, false, null);

        $this->assertEquals(null, $envLocalNew);
        $this->assertEquals(null, $envLocalCaseNew);
        $this->assertEquals(null, $envLocalNewUpper);
        $this->assertEquals(null, $envLocalCaseNewUpper);
        $this->assertEquals(null, $envRuntimeNew);
        $this->assertEquals(null, $envRuntimeCaseNew);
        $this->assertEquals(null, $envRuntimeNewUpper);
        $this->assertEquals(null, $envRuntimeCaseNewUpper);

        $env->resetEnv();
    }

    public function testPutenv()
    {
        $env = $this->getEnv();

        $env->resetEnv();

        $envLocal = $env->getenv(null, true, true);
        $envLocalCase = $env->getenv(null, false, true);
        $envRuntime = $env->getenv(null, true, null);
        $envRuntimeCase = $env->getenv(null, false, null);

        $this->assertEquals($envLocal, $envRuntime);
        $this->assertEquals($envLocalCase, $envRuntimeCase);
        $this->assertArrayNotHasKey('Test', $envLocal);
        $this->assertArrayNotHasKey('Test', $envLocalCase);
        $this->assertArrayNotHasKey('TEST', $envLocal);
        $this->assertArrayNotHasKey('TEST', $envLocalCase);
        $this->assertArrayNotHasKey('Test', $envRuntime);
        $this->assertArrayNotHasKey('Test', $envRuntimeCase);
        $this->assertArrayNotHasKey('TEST', $envRuntime);
        $this->assertArrayNotHasKey('TEST', $envRuntimeCase);

        $env->putenv('Test', '1', false);

        $envLocalNew = $env->getenv(null, true, true);
        $envLocalCaseNew = $env->getenv(null, false, true);
        $envRuntimeNew = $env->getenv(null, true, null);
        $envRuntimeCaseNew = $env->getenv(null, false, null);

        $this->assertNotEquals($envLocalNew, $envRuntimeNew);
        $this->assertNotEquals($envLocalCaseNew, $envRuntimeCaseNew);

        $this->assertArrayNotHasKey('Test', $envLocalNew);
        $this->assertArrayNotHasKey('Test', $envLocalCaseNew);
        $this->assertArrayNotHasKey('TEST', $envLocalNew);
        $this->assertArrayNotHasKey('TEST', $envLocalCaseNew);
        $this->assertArrayHasKey('TEST', $envRuntimeNew);
        $this->assertArrayNotHasKey('Test', $envRuntimeNew);
        $this->assertArrayNotHasKey('TEST', $envRuntimeCaseNew);
        $this->assertArrayHasKey('Test', $envRuntimeCaseNew);

        // @gzhegow > putenv() set runtime values too so env() returns actual value

        $envLocalNew = $env->env('Test', null, true, true);
        $envLocalCaseNew = $env->env('Test', null, false, true);
        $envRuntimeNew = $env->env('Test', null, true, null);
        $envRuntimeCaseNew = $env->env('Test', null, false, null);
        $envLocalNewUpper = $env->env('TEST', null, true, true);
        $envLocalCaseNewUpper = $env->env('TEST', null, false, true);
        $envRuntimeNewUpper = $env->env('TEST', null, true, null);
        $envRuntimeCaseNewUpper = $env->env('TEST', null, false, null);

        $this->assertEquals(null, $envLocalNew);
        $this->assertEquals(null, $envLocalCaseNew);
        $this->assertEquals(null, $envLocalNewUpper);
        $this->assertEquals(null, $envLocalCaseNewUpper);
        $this->assertEquals('1', $envRuntimeNew);
        $this->assertEquals('1', $envRuntimeCaseNew);
        $this->assertEquals('1', $envRuntimeNewUpper);
        $this->assertEquals(null, $envRuntimeCaseNewUpper);

        $env->resetEnv();
    }

    public function testIgnoreCase()
    {
        $env = $this->getEnv();

        $env->resetEnv();

        $envLocal = $env->getenv(null, true, true);
        $envLocalCase = $env->getenv(null, false, true);
        $envRuntime = $env->getenv(null, true, null);
        $envRuntimeCase = $env->getenv(null, false, null);

        $this->assertEquals($envLocal, $envRuntime);
        $this->assertEquals($envLocalCase, $envRuntimeCase);
        $this->assertArrayNotHasKey('Test', $envLocal);
        $this->assertArrayNotHasKey('Test', $envLocalCase);
        $this->assertArrayNotHasKey('TEST', $envLocal);
        $this->assertArrayNotHasKey('TEST', $envLocalCase);
        $this->assertArrayNotHasKey('Test', $envRuntime);
        $this->assertArrayNotHasKey('Test', $envRuntimeCase);
        $this->assertArrayNotHasKey('TEST', $envRuntime);
        $this->assertArrayNotHasKey('TEST', $envRuntimeCase);

        $env->putenv('TEST', '1', false);

        $envLocalNew = $env->getenv(null, true, true);
        $envLocalCaseNew = $env->getenv(null, false, true);
        $envRuntimeNew = $env->getenv(null, true, null);
        $envRuntimeCaseNew = $env->getenv(null, false, null);

        $this->assertArrayNotHasKey('Test', $envLocalNew);
        $this->assertArrayNotHasKey('Test', $envLocalCaseNew);
        $this->assertArrayNotHasKey('TEST', $envLocalNew);
        $this->assertArrayNotHasKey('TEST', $envLocalCaseNew);
        $this->assertArrayHasKey('TEST', $envRuntimeNew);
        $this->assertArrayHasKey('TEST', $envRuntimeCaseNew);
        $this->assertArrayNotHasKey('Test', $envRuntimeNew);
        $this->assertArrayNotHasKey('Test', $envRuntimeCaseNew);


        $env->resetEnv();
        $env->putenv('TEST', '1', true);

        $envLocalNew = $env->getenv(null, true, true);
        $envLocalCaseNew = $env->getenv(null, false, true);
        $envRuntimeNew = $env->getenv(null, true, null);
        $envRuntimeCaseNew = $env->getenv(null, false, null);

        $this->assertArrayNotHasKey('Test', $envLocalNew);
        $this->assertArrayNotHasKey('Test', $envLocalCaseNew);
        $this->assertArrayNotHasKey('TEST', $envLocalNew);
        $this->assertArrayNotHasKey('TEST', $envLocalCaseNew);
        $this->assertArrayHasKey('TEST', $envRuntimeNew);
        $this->assertArrayHasKey('TEST', $envRuntimeCaseNew);
        $this->assertArrayNotHasKey('Test', $envRuntimeNew);
        $this->assertArrayNotHasKey('Test', $envRuntimeCaseNew);


        $env->resetEnv();
        $env->putenv('Test', '1', true);
        $env->putenv('TEST', '1', true); // this will update `Test` cus of `ignoreCase` is set

        $envLocalNew = $env->getenv(null, true, true);
        $envLocalCaseNew = $env->getenv(null, false, true);
        $envRuntimeNew = $env->getenv(null, true, null);
        $envRuntimeCaseNew = $env->getenv(null, false, null);

        $this->assertArrayNotHasKey('Test', $envLocalNew);
        $this->assertArrayNotHasKey('Test', $envLocalCaseNew);
        $this->assertArrayNotHasKey('TEST', $envLocalNew);
        $this->assertArrayNotHasKey('TEST', $envLocalCaseNew);
        $this->assertArrayHasKey('TEST', $envRuntimeNew);
        $this->assertArrayNotHasKey('TEST', $envRuntimeCaseNew);
        $this->assertArrayNotHasKey('Test', $envRuntimeNew);
        $this->assertArrayHasKey('Test', $envRuntimeCaseNew);

        $env->resetEnv();
    }
}