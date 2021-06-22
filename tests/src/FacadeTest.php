<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\Str;
use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Exceptions\RuntimeException;


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
                $class = 'Gzhegow\\Support\\' . $className;
                $facadeClass = 'Gzhegow\\Support\\Facades\\' . $className;

                $objReflection = new \ReflectionClass($class);
                $facadeReflection = new \ReflectionClass($facadeClass);
            }
            catch ( \ReflectionException $e ) {
                throw new RuntimeException(
                    [ 'Unable to reflect: [`%s`, `%s`]', $class, $facadeClass ]
                );
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
            unset($facadeMethods[ '__construct' ]);
            unset($facadeMethods[ '__callStatic' ]);
            unset($facadeMethods[ 'getInstance' ]);
            unset($facadeMethods[ 'withInstance' ]);

            $this->assertEquals($objMethods, $facadeMethods);

            $method = 'getInstance';
            $instance1 = $facadeClass::{$method}();
            $instance2 = $facadeClass::{$method}();
            $this->assertEquals($instance1, $instance2);
        }
    }
}
