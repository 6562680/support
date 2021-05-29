<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\Str;
use Gzhegow\Support\Domain\SupportFactory;


class FacadeTest extends AbstractTestCase
{
    protected function getStr() : Str
    {
        return ( new SupportFactory() )->newStr();
    }


    public function testFacadesMethods()
    {
        $list = [
            'Arr',
            'Calendar',
            'Cli',
            'Cmp',
            'Criteria',
            'Curl',
            'Debug',
            'Env',
            'Filter',
            'Fs',
            'Func',
            'Loader',
            'Math',
            'Net',
            'Num',
            'Path',
            'Php',
            'Preg',
            'Profiler',
            'Str',
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
            unset($objMethods[ '__call' ]);

            $facadeMethods = [];
            foreach ( $facadeReflection->getMethods() as $m ) {
                if (! $m->isPublic()) {
                    continue;
                }

                $facadeMethods[ $m->getName() ] = true;
            }
            unset($facadeMethods[ 'getInstance' ]);
            unset($facadeMethods[ '__callStatic' ]);

            $this->assertEquals($objMethods, $facadeMethods);
        }
    }
}
