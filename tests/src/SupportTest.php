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
            $obj = new \ReflectionClass('Gzhegow\\Support\\' . $className);
            $facade = new \ReflectionClass('Gzhegow\\Support\\Facades\\' . $className);

            $objMethods = [];
            foreach ( $obj->getMethods() as $m ) {
                if (! $m->isPublic()) {
                    continue;
                }

                $objMethods[ $m->getName() ] = true;
            }
            unset($objMethods[ '__construct' ]);

            $facadeMethods = [];
            foreach ( $facade->getMethods() as $m ) {
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
