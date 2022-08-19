<?php

namespace Gzhegow\Support\Di;

use Gzhegow\Support\XFs;
use Gzhegow\Support\IFs;
use Gzhegow\Support\XArr;
use Gzhegow\Support\XCli;
use Gzhegow\Support\XCmp;
use Gzhegow\Support\XEnv;
use Gzhegow\Support\XNet;
use Gzhegow\Support\XNum;
use Gzhegow\Support\XPhp;
use Gzhegow\Support\XStr;
use Gzhegow\Support\XUri;
use Gzhegow\Support\IArr;
use Gzhegow\Support\ICli;
use Gzhegow\Support\ICmp;
use Gzhegow\Support\IEnv;
use Gzhegow\Support\INet;
use Gzhegow\Support\INum;
use Gzhegow\Support\IPhp;
use Gzhegow\Support\IStr;
use Gzhegow\Support\IUri;
use Gzhegow\Support\XCurl;
use Gzhegow\Support\XMath;
use Gzhegow\Support\XPath;
use Gzhegow\Support\XProf;
use Gzhegow\Support\ICurl;
use Gzhegow\Support\IMath;
use Gzhegow\Support\IPath;
use Gzhegow\Support\IProf;
use Gzhegow\Support\XDebug;
use Gzhegow\Support\IDebug;
use Gzhegow\Support\XCache;
use Gzhegow\Support\XLoader;
use Gzhegow\Support\XFormat;
use Gzhegow\Support\IFilter;
use Gzhegow\Support\IFormat;
use Gzhegow\Support\ILoader;
use Gzhegow\Support\XFilter;
use Gzhegow\Support\XCalendar;
use Gzhegow\Support\XCriteria;
use Gzhegow\Support\ICalendar;
use Gzhegow\Support\ICriteria;
use Gzhegow\Support\XItertools;
use Gzhegow\Support\IItertools;
use Gzhegow\Support\SupportFactory;
use Psr\Container\ContainerInterface;
use Gzhegow\Support\SupportFactoryInterface;


/**
 * SupportServiceProvider
 */
abstract class SupportServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        $supportFactory = $this->getSupportFactory();
        $supportFactory->withInstance($supportFactory);

        $calendar = $supportFactory->getCalendar();
        $calendar->now();
        $calendar->iNow();

        $fs = $supportFactory->getFs();
        $fs->withRootPath($this->getRootDir());
    }


    /**
     * @return SupportFactoryInterface
     */
    public function getSupportFactory() : SupportFactoryInterface
    {
        return $this->getContainer()->get(SupportFactoryInterface::class);
    }


    /**
     * @return void
     */
    public function register()
    {
        $this->singleton(SupportFactoryInterface::class, SupportFactory::class);

        $this->instance(XArr::class, [ SupportFactoryInterface::class, 'newArr' ]);
        $this->instance(XCache::class, [ SupportFactoryInterface::class, 'newCache' ]);
        $this->instance(XCalendar::class, [ SupportFactoryInterface::class, 'newCalendar' ]);
        $this->instance(XCli::class, [ SupportFactoryInterface::class, 'newCli' ]);
        $this->instance(XCmp::class, [ SupportFactoryInterface::class, 'newCmp' ]);
        $this->instance(XCriteria::class, [ SupportFactoryInterface::class, 'newCriteria' ]);
        $this->instance(XCurl::class, [ SupportFactoryInterface::class, 'newCurl' ]);
        $this->instance(XDebug::class, [ SupportFactoryInterface::class, 'newDebug' ]);
        $this->instance(XEnv::class, [ SupportFactoryInterface::class, 'newEnv' ]);
        $this->instance(XFilter::class, [ SupportFactoryInterface::class, 'newFilter' ]);
        $this->instance(XFormat::class, [ SupportFactoryInterface::class, 'newFormat' ]);
        $this->instance(XFs::class, [ SupportFactoryInterface::class, 'newFs' ]);
        $this->instance(XItertools::class, [ SupportFactoryInterface::class, 'newItertools' ]);
        $this->instance(XLoader::class, [ SupportFactoryInterface::class, 'newLoader' ]);
        $this->instance(XMath::class, [ SupportFactoryInterface::class, 'newMath' ]);
        $this->instance(XNet::class, [ SupportFactoryInterface::class, 'newNet' ]);
        $this->instance(XNum::class, [ SupportFactoryInterface::class, 'newNum' ]);
        $this->instance(XPath::class, [ SupportFactoryInterface::class, 'newPath' ]);
        $this->instance(XPhp::class, [ SupportFactoryInterface::class, 'newPhp' ]);
        $this->instance(XProf::class, [ SupportFactoryInterface::class, 'newProf' ]);
        $this->instance(XStr::class, [ SupportFactoryInterface::class, 'newStr' ]);
        $this->instance(XUri::class, [ SupportFactoryInterface::class, 'newUri' ]);

        $this->singleton(IArr::class, [ SupportFactoryInterface::class, 'getArr' ]);
        // $this->singleton(ICache::class, [ SupportFactoryInterface::class, 'getCache' ]); // @todo
        $this->singleton(ICalendar::class, [ SupportFactoryInterface::class, 'getCalendar' ]);
        $this->singleton(ICli::class, [ SupportFactoryInterface::class, 'getCli' ]);
        $this->singleton(ICmp::class, [ SupportFactoryInterface::class, 'getCmp' ]);
        $this->singleton(ICriteria::class, [ SupportFactoryInterface::class, 'getCriteria' ]);
        $this->singleton(ICurl::class, [ SupportFactoryInterface::class, 'getCurl' ]);
        $this->singleton(IDebug::class, [ SupportFactoryInterface::class, 'getDebug' ]);
        $this->singleton(IEnv::class, [ SupportFactoryInterface::class, 'getEnv' ]);
        $this->singleton(IFilter::class, [ SupportFactoryInterface::class, 'getFilter' ]);
        $this->singleton(IFormat::class, [ SupportFactoryInterface::class, 'getFormat' ]);
        $this->singleton(IFs::class, [ SupportFactoryInterface::class, 'getFs' ]);
        $this->singleton(IItertools::class, [ SupportFactoryInterface::class, 'getItertools' ]);
        $this->singleton(ILoader::class, [ SupportFactoryInterface::class, 'getLoader' ]);
        $this->singleton(IMath::class, [ SupportFactoryInterface::class, 'getMath' ]);
        $this->singleton(INet::class, [ SupportFactoryInterface::class, 'getNet' ]);
        $this->singleton(INum::class, [ SupportFactoryInterface::class, 'getNum' ]);
        $this->singleton(IPath::class, [ SupportFactoryInterface::class, 'getPath' ]);
        $this->singleton(IPhp::class, [ SupportFactoryInterface::class, 'getPhp' ]);
        $this->singleton(IProf::class, [ SupportFactoryInterface::class, 'getProf' ]);
        $this->singleton(IStr::class, [ SupportFactoryInterface::class, 'getStr' ]);
        $this->singleton(IUri::class, [ SupportFactoryInterface::class, 'getUri' ]);
    }


    /**
     * @return ContainerInterface
     */
    abstract public function getContainer() : ContainerInterface;

    /**
     * @return string
     */
    abstract public function getRootDir() : string;


    /**
     * @param string $abstract
     * @param mixed  $factory
     *
     * @return mixed
     */
    abstract public function instance(string $abstract, $factory);

    /**
     * @param string $abstract
     * @param mixed  $factory
     *
     * @return mixed
     */
    abstract public function singleton(string $abstract, $factory);
}