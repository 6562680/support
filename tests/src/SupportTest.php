<?php

namespace Gzhegow\Support\Tests;

class SupportTest extends AbstractTestCase
{
    public function testFacadesMethods()
    {
        $list = [
            'Arr',
            'Assert',
            'Bcmath',
            'Calendar',
            'Cli',
            'Cmp',
            'Criteria',
            'Curl',
            'Debug',
            'Env',
            'Filter',
            'Fs',
            'Indexer',
            'Math',
            'Net',
            'Path',
            'Php',
            'Preg',
            'Profiler',
            'Str',
            'Type',
            'Uri',
        ];

        foreach ( $list as $className ) {
            $objReflection = null;
            $facadeReflection = null;
            try {
                $objReflection = new \ReflectionClass('Gzhegow\\Support\\' . $className);
                $facadeReflection = new \ReflectionClass('Gzhegow\\Support\\Facades\\' . $className);
            }
            catch ( \ReflectionException $e ) {
                // never thrown
            }

            $objMethods = [];
            foreach ( $objReflection->getMethods() as $m ) {
                if (! $m->isPublic()) {
                    continue;
                }

                $objMethods[ $m->getName() ] = true;
            }
            unset($objMethods[ '__construct' ]);

            $facadeMethods = [];
            foreach ( $facadeReflection->getMethods() as $m ) {
                if (! $m->isPublic()) {
                    continue;
                }

                $facadeMethods[ $m->getName() ] = true;
            }
            unset($facadeMethods[ 'getInstance' ]);

            $this->assertEquals($objMethods, $facadeMethods);
        }
    }
}
