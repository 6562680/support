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

        $this->singleton(IArr::class, Arr::class);
        $this->singleton(IAssert::class, Assert::class);
        $this->singleton(ICalendar::class, Calendar::class);
        $this->singleton(ICli::class, Cli::class);
        $this->singleton(ICmp::class, Cmp::class);
        $this->singleton(ICriteria::class, Criteria::class);
        $this->singleton(ICurl::class, Curl::class);
        $this->singleton(IDebug::class, Debug::class);
        $this->singleton(IEnv::class, Env::class);
        $this->singleton(IFilter::class, Filter::class);
        $this->singleton(IFormat::class, Format::class);
        $this->singleton(IFs::class, Fs::class);
        $this->singleton(ILoader::class, Loader::class);
        $this->singleton(IMath::class, Math::class);
        $this->singleton(INet::class, Net::class);
        $this->singleton(INum::class, Num::class);
        $this->singleton(IPath::class, Path::class);
        $this->singleton(IPhp::class, Php::class);
        $this->singleton(IPreg::class, Preg::class);
        $this->singleton(IProf::class, Prof::class);
        $this->singleton(IStr::class, Str::class);
        $this->singleton(IType::class, Type::class);
        $this->singleton(IUri::class, Uri::class);
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
