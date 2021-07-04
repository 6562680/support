<?php

namespace Gzhegow\Support\Domain;

use Gzhegow\Support\Fs;
use Gzhegow\Support\Arr;
use Gzhegow\Support\Cli;
use Gzhegow\Support\Cmp;
use Gzhegow\Support\Env;
use Gzhegow\Support\Net;
use Gzhegow\Support\Num;
use Gzhegow\Support\Str;
use Gzhegow\Support\Uri;
use Gzhegow\Support\Php;
use Gzhegow\Support\Curl;
use Gzhegow\Support\Math;
use Gzhegow\Support\Path;
use Gzhegow\Support\Preg;
use Gzhegow\Support\Debug;
use Gzhegow\Support\Filter;
use Gzhegow\Support\Loader;
use Gzhegow\Support\Format;
use Gzhegow\Support\Calendar;
use Gzhegow\Support\Criteria;
use Gzhegow\Support\Profiler;
use Psr\Container\ContainerInterface;
use Gzhegow\Support\Domain\Filter\Type;
use Gzhegow\Support\Domain\Filter\Assert;
use Gzhegow\Support\Interfaces\FsInterface;
use Gzhegow\Support\Interfaces\ArrInterface;
use Gzhegow\Support\Interfaces\CliInterface;
use Gzhegow\Support\Interfaces\CmpInterface;
use Gzhegow\Support\Interfaces\EnvInterface;
use Gzhegow\Support\Interfaces\NetInterface;
use Gzhegow\Support\Interfaces\NumInterface;
use Gzhegow\Support\Interfaces\PhpInterface;
use Gzhegow\Support\Interfaces\StrInterface;
use Gzhegow\Support\Interfaces\UriInterface;
use Gzhegow\Support\Interfaces\CurlInterface;
use Gzhegow\Support\Interfaces\MathInterface;
use Gzhegow\Support\Interfaces\PathInterface;
use Gzhegow\Support\Interfaces\PregInterface;
use Gzhegow\Support\Interfaces\DebugInterface;
use Gzhegow\Support\Interfaces\FilterInterface;
use Gzhegow\Support\Interfaces\LoaderInterface;
use Gzhegow\Support\Interfaces\FormatInterface;
use Gzhegow\Support\Interfaces\CalendarInterface;
use Gzhegow\Support\Interfaces\CriteriaInterface;
use Gzhegow\Support\Interfaces\ProfilerInterface;


/**
 * SupportFactory
 */
class SupportFactory implements SupportFactoryInterface
{
    /**
     * @var null|ContainerInterface
     */
    protected $container;


    /**
     * Constructor
     *
     * @param null|ContainerInterface $container
     */
    public function __construct(?ContainerInterface $container)
    {
        $this->container = $container;
    }


    /**
     * @param static $instance
     *
     * @return void
     */
    public static function withInstance(SupportFactory $instance) : void
    {
        static::$instance[ static::class ] = $instance;
    }


    /**
     * @return Arr
     */
    public function newArr() : Arr
    {
        return new Arr(
            $this->newFilter(),
            $this->newPhp(),
            $this->newStr()
        );
    }

    /**
     * @return Calendar
     */
    public function newCalendar() : Calendar
    {
        return new Calendar(
            $this->newFilter(),
            $this->newNum(),
            $this->newPhp(),
            $this->newStr()
        );
    }

    /**
     * @return Cli
     */
    public function newCli() : Cli
    {
        return new Cli(
            $this->newEnv(),
            $this->newFs(),
            $this->newPhp()
        );
    }

    /**
     * @return Cmp
     */
    public function newCmp() : Cmp
    {
        return new Cmp(
            $this->newCalendar(),
            $this->newFilter()
        );
    }

    /**
     * @return Criteria
     */
    public function newCriteria() : Criteria
    {
        return new Criteria(
            $this->newCalendar(),
            $this->newCmp(),
            $this->newFilter(),
            $this->newStr()
        );
    }

    /**
     * @return Curl
     */
    public function newCurl() : Curl
    {
        return new Curl(
            $this->newArr(),
            $this->newFilter(),
            $this->newPhp()
        );
    }

    /**
     * @return Debug
     */
    public function newDebug() : Debug
    {
        return new Debug();
    }

    /**
     * @return Env
     */
    public function newEnv() : Env
    {
        return new Env();
    }

    /**
     * @return Filter
     */
    public function newFilter() : Filter
    {
        return new Filter();
    }

    /**
     * @return Format
     */
    public function newFormat() : Format
    {
        return new Format(
            $this->newNum()
        );
    }

    /**
     * @return Fs
     */
    public function newFs() : Fs
    {
        return new Fs(
            $this->newFilter(),
            $this->newPath(),
            $this->newPhp()
        );
    }

    /**
     * @return Loader
     */
    public function newLoader() : Loader
    {
        return new Loader(
            $this->newFilter(),
            $this->newPath(),
            $this->newStr()
        );
    }

    /**
     * @return Math
     */
    public function newMath() : Math
    {
        return new Math(
            $this->newFilter(),
            $this->newNum(),
            $this->newStr()
        );
    }

    /**
     * @return Net
     */
    public function newNet() : Net
    {
        return new Net(
            $this->newStr()
        );
    }

    /**
     * @return Num
     */
    public function newNum() : Num
    {
        return new Num(
            $this->newFilter()
        );
    }

    /**
     * @return Path
     */
    public function newPath() : Path
    {
        return new Path(
            $this->newFilter(),
            $this->newPhp(),
            $this->newStr()
        );
    }

    /**
     * @return Php
     */
    public function newPhp() : Php
    {
        return new Php(
            $this->newFilter()
        );
    }

    /**
     * @return Preg
     */
    public function newPreg() : Preg
    {
        return new Preg(
            $this->newStr()
        );
    }

    /**
     * @return Profiler
     */
    public function newProfiler() : Profiler
    {
        return new Profiler(
            $this->newCalendar()
        );
    }

    /**
     * @return Str
     */
    public function newStr() : Str
    {
        return new Str(
            $this->newFilter()
        );
    }

    /**
     * @return Uri
     */
    public function newUri() : Uri
    {
        return new Uri(
            $this->newArr(),
            $this->newFilter(),
            $this->newPhp(),
            $this->newStr()
        );
    }


    /**
     * @return Assert
     */
    public function newAssert() : Assert
    {
        return new Assert(
            $this->newDebug(),
            $this->newFilter()
        );
    }

    /**
     * @return Type
     */
    public function newType() : Type
    {
        return new Type(
            $this->newFilter()
        );
    }


    /**
     * @return Arr
     */
    public function getArr() : Arr
    {
        return null
            ?? $this->containerGet(ArrInterface::class)
            ?? $this->newArr();
    }

    /**
     * @return Calendar
     */
    public function getCalendar() : Calendar
    {
        return null
            ?? $this->containerGet(CalendarInterface::class)
            ?? $this->newCalendar();
    }

    /**
     * @return Cli
     */
    public function getCli() : Cli
    {
        return null
            ?? $this->containerGet(CliInterface::class)
            ?? $this->newCli();
    }

    /**
     * @return Cmp
     */
    public function getCmp() : Cmp
    {
        return null
            ?? $this->containerGet(CmpInterface::class)
            ?? $this->newCmp();
    }

    /**
     * @return Criteria
     */
    public function getCriteria() : Criteria
    {
        return null
            ?? $this->containerGet(CriteriaInterface::class)
            ?? $this->newCriteria();
    }

    /**
     * @return Curl
     */
    public function getCurl() : Curl
    {
        return null
            ?? $this->containerGet(CurlInterface::class)
            ?? $this->newCurl();
    }

    /**
     * @return Debug
     */
    public function getDebug() : Debug
    {
        return null
            ?? $this->containerGet(DebugInterface::class)
            ?? $this->newDebug();
    }

    /**
     * @return Env
     */
    public function getEnv() : Env
    {
        return null
            ?? $this->containerGet(EnvInterface::class)
            ?? $this->newEnv();
    }

    /**
     * @return Filter
     */
    public function getFilter() : Filter
    {
        return null
            ?? $this->containerGet(FilterInterface::class)
            ?? $this->newFilter();
    }

    /**
     * @return Format
     */
    public function getFormat() : Format
    {
        return null
            ?? $this->containerGet(FormatInterface::class)
            ?? $this->newFormat();
    }

    /**
     * @return Fs
     */
    public function getFs() : Fs
    {
        return null
            ?? $this->containerGet(FsInterface::class)
            ?? $this->newFs();
    }

    /**
     * @return Loader
     */
    public function getLoader() : Loader
    {
        return null
            ?? $this->containerGet(LoaderInterface::class)
            ?? $this->newLoader();
    }

    /**
     * @return Math
     */
    public function getMath() : Math
    {
        return null
            ?? $this->containerGet(MathInterface::class)
            ?? $this->newMath();
    }

    /**
     * @return Net
     */
    public function getNet() : Net
    {
        return null
            ?? $this->containerGet(NetInterface::class)
            ?? $this->newNet();
    }

    /**
     * @return Num
     */
    public function getNum() : Num
    {
        return null
            ?? $this->containerGet(NumInterface::class)
            ?? $this->newNum();
    }

    /**
     * @return Path
     */
    public function getPath() : Path
    {
        return null
            ?? $this->containerGet(PathInterface::class)
            ?? $this->newPath();
    }

    /**
     * @return Php
     */
    public function getPhp() : Php
    {
        return null
            ?? $this->containerGet(PhpInterface::class)
            ?? $this->newPhp();
    }

    /**
     * @return Preg
     */
    public function getPreg() : Preg
    {
        return null
            ?? $this->containerGet(PregInterface::class)
            ?? $this->newPreg();
    }

    /**
     * @return Profiler
     */
    public function getProfiler() : Profiler
    {
        return null
            ?? $this->containerGet(ProfilerInterface::class)
            ?? $this->newProfiler();
    }

    /**
     * @return Str
     */
    public function getStr() : Str
    {
        return null
            ?? $this->containerGet(StrInterface::class)
            ?? $this->newStr();
    }

    /**
     * @return Uri
     */
    public function getUri() : Uri
    {
        return null
            ?? $this->containerGet(UriInterface::class)
            ?? $this->newUri();
    }


    /**
     * @param string $id
     *
     * @return null|mixed
     */
    protected function containerGet(string $id)
    {
        return $this->containerHas($id)
            ? $this->container->get($id)
            : null;
    }

    /**
     * @param string $id
     *
     * @return null|mixed
     */
    protected function containerHas(string $id)
    {
        return $this->container
            ? $this->container->has($id)
            : null;
    }


    /**
     * @return static
     */
    public static function getInstance() : SupportFactory
    {
        return static::$instance[ static::class ] = null
            ?? static::$instance[ static::class ]
            ?? new SupportFactory(null);
    }


    /**
     * @var static[]
     */
    protected static $instance = [];
}
