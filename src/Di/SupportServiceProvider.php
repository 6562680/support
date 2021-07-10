<?php

namespace Gzhegow\Support\Di;

use Gzhegow\Support\Fs;
use Gzhegow\Support\Arr;
use Gzhegow\Support\Cli;
use Gzhegow\Support\Cmp;
use PHPUnit\Util\Filter;
use Gzhegow\Support\Env;
use Gzhegow\Support\Net;
use Gzhegow\Support\Num;
use Gzhegow\Support\Php;
use Gzhegow\Support\Str;
use Gzhegow\Support\Uri;
use Gzhegow\Support\IFs;
use Gzhegow\Support\Curl;
use Gzhegow\Support\Math;
use Gzhegow\Support\Path;
use Gzhegow\Support\Preg;
use Gzhegow\Support\Prof;
use Gzhegow\Support\Type;
use Gzhegow\Support\IArr;
use Gzhegow\Support\ICli;
use Gzhegow\Support\ICmp;
use Gzhegow\Support\IEnv;
use Gzhegow\Support\INet;
use Gzhegow\Support\INum;
use Gzhegow\Support\IPhp;
use Gzhegow\Support\IStr;
use Gzhegow\Support\IUri;
use Gzhegow\Support\Debug;
use Gzhegow\Support\IType;
use Gzhegow\Support\ICurl;
use Gzhegow\Support\IMath;
use Gzhegow\Support\IPath;
use Gzhegow\Support\IPreg;
use Gzhegow\Support\IProf;
use Gzhegow\Support\Loader;
use Gzhegow\Support\Format;
use Gzhegow\Support\Assert;
use Gzhegow\Support\IDebug;
use Gzhegow\Support\IAssert;
use Gzhegow\Support\IFilter;
use Gzhegow\Support\IFormat;
use Gzhegow\Support\ILoader;
use Gzhegow\Support\Calendar;
use Gzhegow\Support\Criteria;
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

        $this->instance(Arr::class, [ SupportFactoryInterface::class, 'newArr' ]);
        $this->instance(Assert::class, [ SupportFactoryInterface::class, 'newAssert' ]);
        $this->instance(Calendar::class, [ SupportFactoryInterface::class, 'newCalendar' ]);
        $this->instance(Cli::class, [ SupportFactoryInterface::class, 'newCli' ]);
        $this->instance(Cmp::class, [ SupportFactoryInterface::class, 'newCmp' ]);
        $this->instance(Criteria::class, [ SupportFactoryInterface::class, 'newCriteria' ]);
        $this->instance(Curl::class, [ SupportFactoryInterface::class, 'newCurl' ]);
        $this->instance(Debug::class, [ SupportFactoryInterface::class, 'newDebug' ]);
        $this->instance(Env::class, [ SupportFactoryInterface::class, 'newEnv' ]);
        $this->instance(Filter::class, [ SupportFactoryInterface::class, 'newFilter' ]);
        $this->instance(Format::class, [ SupportFactoryInterface::class, 'newFormat' ]);
        $this->instance(Fs::class, [ SupportFactoryInterface::class, 'newFs' ]);
        $this->instance(Loader::class, [ SupportFactoryInterface::class, 'newLoader' ]);
        $this->instance(Math::class, [ SupportFactoryInterface::class, 'newMath' ]);
        $this->instance(Net::class, [ SupportFactoryInterface::class, 'newNet' ]);
        $this->instance(Num::class, [ SupportFactoryInterface::class, 'newNum' ]);
        $this->instance(Path::class, [ SupportFactoryInterface::class, 'newPath' ]);
        $this->instance(Php::class, [ SupportFactoryInterface::class, 'newPhp' ]);
        $this->instance(Preg::class, [ SupportFactoryInterface::class, 'newPreg' ]);
        $this->instance(Prof::class, [ SupportFactoryInterface::class, 'newProf' ]);
        $this->instance(Str::class, [ SupportFactoryInterface::class, 'newStr' ]);
        $this->instance(Type::class, [ SupportFactoryInterface::class, 'newType' ]);
        $this->instance(Uri::class, [ SupportFactoryInterface::class, 'newUri' ]);

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
