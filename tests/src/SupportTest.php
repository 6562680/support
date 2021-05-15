<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\Str;
use Gzhegow\Support\Filter;

class SupportTest extends AbstractTestCase
{
    protected function getFilter() : Filter
    {
        return new Filter();
    }

    protected function getStr() : Str
    {
        return new Str(
            $this->getFilter(),
        );
    }


    public function testFacadesMethods()
    {
        $list = [
            'Arr',
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
            'Func',
            'Loader',
            'Math',
            'Net',
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

    public function testFilterTypeMethods()
    {
        $str = $this->getStr();

        $filterReflection = new \ReflectionClass('Gzhegow\\Support\\Filter');
        $typeReflection = new \ReflectionClass('Gzhegow\\Support\\Type');

        $filterMethods = [];
        foreach ( $filterReflection->getMethods() as $m ) {
            if (! $m->isPublic()) {
                continue;
            }

            if (null === ( $method = $str->starts($m->getName(), 'filter') )) {
                continue;
            }

            $filterMethods[ $method ] = true;
        }
        unset($filterMethods[ '__construct' ]);

        $typeMethods = [];
        foreach ( $typeReflection->getMethods() as $m ) {
            if (! $m->isPublic()) {
                continue;
            }

            if (null === ( $method = $str->starts($m->getName(), 'is') )) {
                continue;
            }

            $typeMethods[ $method ] = true;
        }
        unset($typeMethods[ '__construct' ]);
        unset($typeMethods[ 'Empty' ]); // has no filter match, only isEmpty is possible

        $this->assertEquals($filterMethods, $typeMethods);
    }
}
