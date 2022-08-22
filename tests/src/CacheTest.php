<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\ICache;
use Gzhegow\Support\XCache;
use Gzhegow\Support\Exceptions\RuntimeException;
use Symfony\Component\Cache\Adapter\NullAdapter;


class CacheTest extends AbstractTestCase
{
    protected function getCache() : ICache
    {
        return XCache::getInstance();
    }


    public function testCache()
    {
        $theCache = $this->getCache();

        $theCache->addPool($poolName1 = 'pool', $pool1 = new NullAdapter());
        $theCache->addPool($poolName2 = 'pool2', $pool2 = function () use ($pool1) {
            return $pool1;
        });
        $theCache->addPool($poolName3 = 'pool3', $pool3 = function () {
            return new \StdClass();
        });

        $this->assertEquals([
            'pool' => $pool1,
        ], $theCache->getPools());

        $this->assertEquals([
            'pool2' => $pool2,
            'pool3' => $pool3,
        ], $theCache->getPoolFactories());

        $this->assertException(RuntimeException::class, function () use ($theCache, $poolName1) {
            $theCache->addPool($poolName1, function () { });
        });

        $this->assertEquals($pool1, $theCache->getPool($poolName2));

        $this->assertException(RuntimeException::class, function () use ($theCache, $poolName3) {
            $theCache->getPool($poolName3);
        });
    }
}