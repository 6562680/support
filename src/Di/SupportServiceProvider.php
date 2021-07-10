<?php

namespace Gzhegow\Support\Di;

use Gzhegow\Support\ZFs;
use Gzhegow\Support\ZArr;
use Gzhegow\Support\ZCli;
use Gzhegow\Support\ZCmp;
use PHPUnit\Util\Filter;
use Gzhegow\Support\ZEnv;
use Gzhegow\Support\ZNet;
use Gzhegow\Support\ZNum;
use Gzhegow\Support\ZPhp;
use Gzhegow\Support\ZStr;
use Gzhegow\Support\ZUri;
use Gzhegow\Support\IFs;
use Gzhegow\Support\ZCurl;
use Gzhegow\Support\ZMath;
use Gzhegow\Support\ZPath;
use Gzhegow\Support\ZPreg;
use Gzhegow\Support\ZProf;
use Gzhegow\Support\ZType;
use Gzhegow\Support\IArr;
use Gzhegow\Support\ICli;
use Gzhegow\Support\ICmp;
use Gzhegow\Support\IEnv;
use Gzhegow\Support\INet;
use Gzhegow\Support\INum;
use Gzhegow\Support\IPhp;
use Gzhegow\Support\IStr;
use Gzhegow\Support\IUri;
use Gzhegow\Support\ZDebug;
use Gzhegow\Support\IType;
use Gzhegow\Support\ICurl;
use Gzhegow\Support\IMath;
use Gzhegow\Support\IPath;
use Gzhegow\Support\IPreg;
use Gzhegow\Support\IProf;
use Gzhegow\Support\ZLoader;
use Gzhegow\Support\ZFormat;
use Gzhegow\Support\ZAssert;
use Gzhegow\Support\IDebug;
use Gzhegow\Support\IAssert;
use Gzhegow\Support\IFilter;
use Gzhegow\Support\IFormat;
use Gzhegow\Support\ILoader;
use Gzhegow\Support\ZCalendar;
use Gzhegow\Support\ZCriteria;
use Gzhegow\Support\ICalendar;
use Gzhegow\Support\ICriteria;
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
        $fs->withRoot($this->getRootDir());
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

        $this->instance(ZArr::class, [ SupportFactoryInterface::class, 'newArr' ]);
        $this->instance(ZAssert::class, [ SupportFactoryInterface::class, 'newAssert' ]);
        $this->instance(ZCalendar::class, [ SupportFactoryInterface::class, 'newCalendar' ]);
        $this->instance(ZCli::class, [ SupportFactoryInterface::class, 'newCli' ]);
        $this->instance(ZCmp::class, [ SupportFactoryInterface::class, 'newCmp' ]);
        $this->instance(ZCriteria::class, [ SupportFactoryInterface::class, 'newCriteria' ]);
        $this->instance(ZCurl::class, [ SupportFactoryInterface::class, 'newCurl' ]);
        $this->instance(ZDebug::class, [ SupportFactoryInterface::class, 'newDebug' ]);
        $this->instance(ZEnv::class, [ SupportFactoryInterface::class, 'newEnv' ]);
        $this->instance(Filter::class, [ SupportFactoryInterface::class, 'newFilter' ]);
        $this->instance(ZFormat::class, [ SupportFactoryInterface::class, 'newFormat' ]);
        $this->instance(ZFs::class, [ SupportFactoryInterface::class, 'newFs' ]);
        $this->instance(ZLoader::class, [ SupportFactoryInterface::class, 'newLoader' ]);
        $this->instance(ZMath::class, [ SupportFactoryInterface::class, 'newMath' ]);
        $this->instance(ZNet::class, [ SupportFactoryInterface::class, 'newNet' ]);
        $this->instance(ZNum::class, [ SupportFactoryInterface::class, 'newNum' ]);
        $this->instance(ZPath::class, [ SupportFactoryInterface::class, 'newPath' ]);
        $this->instance(ZPhp::class, [ SupportFactoryInterface::class, 'newPhp' ]);
        $this->instance(ZPreg::class, [ SupportFactoryInterface::class, 'newPreg' ]);
        $this->instance(ZProf::class, [ SupportFactoryInterface::class, 'newProf' ]);
        $this->instance(ZStr::class, [ SupportFactoryInterface::class, 'newStr' ]);
        $this->instance(ZType::class, [ SupportFactoryInterface::class, 'newType' ]);
        $this->instance(ZUri::class, [ SupportFactoryInterface::class, 'newUri' ]);

        $this->singleton(IArr::class, [ SupportFactoryInterface::class, 'getArr' ]);
        $this->singleton(IAssert::class, [ SupportFactoryInterface::class, 'getAssert' ]);
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
        $this->singleton(ILoader::class, [ SupportFactoryInterface::class, 'getLoader' ]);
        $this->singleton(IMath::class, [ SupportFactoryInterface::class, 'getMath' ]);
        $this->singleton(INet::class, [ SupportFactoryInterface::class, 'getNet' ]);
        $this->singleton(INum::class, [ SupportFactoryInterface::class, 'getNum' ]);
        $this->singleton(IPath::class, [ SupportFactoryInterface::class, 'getPath' ]);
        $this->singleton(IPhp::class, [ SupportFactoryInterface::class, 'getPhp' ]);
        $this->singleton(IPreg::class, [ SupportFactoryInterface::class, 'getPreg' ]);
        $this->singleton(IProf::class, [ SupportFactoryInterface::class, 'getProf' ]);
        $this->singleton(IStr::class, [ SupportFactoryInterface::class, 'getStr' ]);
        $this->singleton(IType::class, [ SupportFactoryInterface::class, 'getType' ]);
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
