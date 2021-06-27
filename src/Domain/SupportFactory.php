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
class SupportFactory implements
    SupportFactoryInterface
{
    /**
     * @var null|ContainerInterface
     */
    protected $container;


    /**
     * @var array
     */
    protected $items = [];


    /**
     * Constructor
     *
     * @param null|ContainerInterface $container
     */
    public function __construct(
        ContainerInterface $container = null
    )
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
        return $this->items[ Arr::class ] = null
            ?? $this->containerGet(ArrInterface::class)
            ?? $this->get(Arr::class)
            ?? $this->newArr();
    }

    /**
     * @return Calendar
     */
    public function getCalendar() : Calendar
    {
        return $this->items[ Calendar::class ] = null
            ?? $this->containerGet(CalendarInterface::class)
            ?? $this->get(Calendar::class)
            ?? $this->newCalendar();
    }

    /**
     * @return Cli
     */
    public function getCli() : Cli
    {
        return $this->items[ Cli::class ] = null
            ?? $this->containerGet(CliInterface::class)
            ?? $this->get(Cli::class)
            ?? $this->newCli();
    }

    /**
     * @return Cmp
     */
    public function getCmp() : Cmp
    {
        return $this->items[ Cmp::class ] = null
            ?? $this->containerGet(CmpInterface::class)
            ?? $this->get(Cmp::class)
            ?? $this->newCmp();
    }

    /**
     * @return Criteria
     */
    public function getCriteria() : Criteria
    {
        return $this->items[ Criteria::class ] = null
            ?? $this->get(CriteriaInterface::class)
            ?? $this->get(Criteria::class)
            ?? $this->newCriteria();
    }

    /**
     * @return Curl
     */
    public function getCurl() : Curl
    {
        return $this->items[ Curl::class ] = null
            ?? $this->containerGet(CurlInterface::class)
            ?? $this->get(Curl::class)
            ?? $this->newCurl();
    }

    /**
     * @return Debug
     */
    public function getDebug() : Debug
    {
        return $this->items[ Debug::class ] = null
            ?? $this->containerGet(DebugInterface::class)
            ?? $this->get(Debug::class)
            ?? $this->newDebug();
    }

    /**
     * @return Env
     */
    public function getEnv() : Env
    {
        return $this->items[ Env::class ] = null
            ?? $this->containerGet(EnvInterface::class)
            ?? $this->get(Env::class)
            ?? $this->newEnv();
    }

    /**
     * @return Filter
     */
    public function getFilter() : Filter
    {
        return $this->items[ Filter::class ] = null
            ?? $this->containerGet(FilterInterface::class)
            ?? $this->get(Filter::class)
            ?? $this->newFilter();
    }

    /**
     * @return Format
     */
    public function getFormat() : Format
    {
        return $this->items[ Format::class ] = null
            ?? $this->containerGet(FormatInterface::class)
            ?? $this->get(Format::class)
            ?? $this->newFormat();
    }

    /**
     * @return Fs
     */
    public function getFs() : Fs
    {
        return $this->items[ Fs::class ] = null
            ?? $this->containerGet(FsInterface::class)
            ?? $this->get(Fs::class)
            ?? $this->newFs();
    }

    /**
     * @return Loader
     */
    public function getLoader() : Loader
    {
        return $this->items[ Loader::class ] = null
            ?? $this->containerGet(LoaderInterface::class)
            ?? $this->get(Loader::class)
            ?? $this->newLoader();
    }

    /**
     * @return Math
     */
    public function getMath() : Math
    {
        return $this->items[ Math::class ] = null
            ?? $this->containerGet(MathInterface::class)
            ?? $this->get(Math::class)
            ?? $this->newMath();
    }

    /**
     * @return Net
     */
    public function getNet() : Net
    {
        return $this->items[ Net::class ] = null
            ?? $this->containerGet(NetInterface::class)
            ?? $this->get(Net::class)
            ?? $this->newNet();
    }

    /**
     * @return Num
     */
    public function getNum() : Num
    {
        return $this->items[ Num::class ] = null
            ?? $this->containerGet(NumInterface::class)
            ?? $this->get(Num::class)
            ?? $this->newNum();
    }

    /**
     * @return Path
     */
    public function getPath() : Path
    {
        return $this->items[ Path::class ] = null
            ?? $this->containerGet(PathInterface::class)
            ?? $this->get(Path::class)
            ?? $this->newPath();
    }

    /**
     * @return Php
     */
    public function getPhp() : Php
    {
        return $this->items[ Php::class ] = null
            ?? $this->containerGet(PhpInterface::class)
            ?? $this->get(Php::class)
            ?? $this->newPhp();
    }

    /**
     * @return Preg
     */
    public function getPreg() : Preg
    {
        return $this->items[ Preg::class ] = null
            ?? $this->containerGet(PregInterface::class)
            ?? $this->get(Preg::class)
            ?? $this->newPreg();
    }

    /**
     * @return Profiler
     */
    public function getProfiler() : Profiler
    {
        return $this->items[ Profiler::class ] = null
            ?? $this->containerGet(ProfilerInterface::class)
            ?? $this->get(Profiler::class)
            ?? $this->newProfiler();
    }

    /**
     * @return Str
     */
    public function getStr() : Str
    {
        return $this->items[ Str::class ] = null
            ?? $this->containerGet(StrInterface::class)
            ?? $this->get(Str::class)
            ?? $this->newStr();
    }

    /**
     * @return Uri
     */
    public function getUri() : Uri
    {
        return $this->items[ Uri::class ] = null
            ?? $this->containerGet(UriInterface::class)
            ?? $this->get(Uri::class)
            ?? $this->newUri();
    }


    /**
     * @return Assert
     */
    public function getAssert() : Assert
    {
        return $this->items[ Assert::class ] = null
            ?? $this->get(Assert::class)
            ?? $this->newAssert();
    }

    /**
     * @return Type
     */
    public function getType() : Type
    {
        return $this->items[ Type::class ] = null
            ?? $this->get(Type::class)
            ?? $this->newType();
    }


    /**
     * @param string $id
     *
     * @return null|mixed
     */
    public function get(string $id)
    {
        return $this->has($id)
            ? $this->items[ $id ]
            : null;
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    public function has(string $id)
    {
        return isset($this->items[ $id ]);
    }

    /**
     * @param mixed $value
     *
     * @return $this
     */
    public function set($value)
    {
        $this->items[ get_class($value) ] = $value;

        return $this;
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
            ?? new SupportFactory();
    }


    /**
     * @var static[]
     */
    protected static $instance = [];
}
