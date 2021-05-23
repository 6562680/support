<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\Str;
use Gzhegow\Support\Php;
use Gzhegow\Support\Filter;

class SupportTest extends AbstractTestCase
{
    protected function getFilter() : Filter
    {
        return new Filter();
    }

    protected function getPhp() : Php
    {
        return new Php(
            $this->getFilter()
        );
    }

    protected function getStr() : Str
    {
        return new Str(
            $this->getFilter()
        );
    }


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
            'Func',
            'Loader',
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

    public function testFilterMethods()
    {
        $str = $this->getStr();

        $assertReflection = new \ReflectionClass('Gzhegow\\Support\\Assert');
        $filterReflection = new \ReflectionClass('Gzhegow\\Support\\Filter');
        $typeReflection = new \ReflectionClass('Gzhegow\\Support\\Type');


        $assertMethods = [];
        foreach ( $assertReflection->getMethods() as $m ) {
            if (! $m->isPublic()) {
                continue;
            }

            if (null === ( $method = $str->starts($m->getName(), 'assert') )) {
                continue;
            }

            $assertMethods[ $method ] = true;
        }
        unset($assertMethods[ '__construct' ]);


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


        $this->assertEquals($filterMethods, $assertMethods);
        $this->assertEquals($filterMethods, $typeMethods);
    }
}
