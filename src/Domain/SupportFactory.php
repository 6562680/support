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


/**
 * SupportFactory
 */
class SupportFactory implements
    SupportFactoryInterface,
    ContainerInterface
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
    public function __construct(ContainerInterface $container = null)
    {
        $this->container = $container;
    }


    /**
     * @return Arr
     */
    public function newArr() : Arr
    {
        return $this->get(Arr::class)
            ?? new Arr(
                $this->newFilter(),
                $this->newStr()
            );
    }

    /**
     * @return Calendar
     */
    public function newCalendar() : Calendar
    {
        return $this->get(Calendar::class)
            ?? new Calendar(
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
        return $this->get(Cli::class)
            ?? new Cli(
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
        return $this->get(Cmp::class)
            ?? new Cmp(
                $this->newCalendar(),
                $this->newFilter()
            );
    }

    /**
     * @return Criteria
     */
    public function newCriteria() : Criteria
    {
        return $this->get(Criteria::class)
            ?? new Criteria(
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
        return $this->get(Curl::class)
            ?? new Curl(
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
        return $this->get(Debug::class)
            ?? new Debug();
    }

    /**
     * @return Env
     */
    public function newEnv() : Env
    {
        return $this->get(Env::class)
            ?? new Env();
    }

    /**
     * @return Filter
     */
    public function newFilter() : Filter
    {
        return $this->get(Filter::class)
            ?? new Filter();
    }

    /**
     * @return Format
     */
    public function newFormat() : Format
    {
        return $this->get(Filter::class)
            ?? new Format(
                $this->newNum()
            );
    }

    /**
     * @return Fs
     */
    public function newFs() : Fs
    {
        return $this->get(Fs::class)
            ?? new Fs(
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
        return $this->get(Loader::class)
            ?? new Loader(
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
        return $this->get(Math::class)
            ?? new Math(
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
        return $this->get(Net::class)
            ?? new Net(
                $this->newStr()
            );
    }

    /**
     * @return Num
     */
    public function newNum() : Num
    {
        return $this->get(Num::class)
            ?? new Num(
                $this->newFilter()
            );
    }

    /**
     * @return Path
     */
    public function newPath() : Path
    {
        return $this->get(Path::class)
            ?? new Path(
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
        return $this->get(Php::class)
            ?? new Php(
                $this->newFilter()
            );
    }

    /**
     * @return Preg
     */
    public function newPreg() : Preg
    {
        return $this->get(Preg::class)
            ?? new Preg(
                $this->newStr()
            );
    }

    /**
     * @return Profiler
     */
    public function newProfiler() : Profiler
    {
        return $this->get(Profiler::class)
            ?? new Profiler(
                $this->newCalendar()
            );
    }

    /**
     * @return Str
     */
    public function newStr() : Str
    {
        return $this->get(Str::class)
            ?? new Str(
                $this->newFilter()
            );
    }

    /**
     * @return Uri
     */
    public function newUri() : Uri
    {
        return $this->get(Uri::class)
            ?? new Uri(
                $this->newArr(),
                $this->newFilter(),
                $this->newPhp(),
                $this->newStr()
            );
    }


    /**
     * @param null|Filter $filter
     *
     * @return Assert
     */
    public function newAssert(Filter $filter = null) : Assert
    {
        return $this->get(Assert::class)
            ?? new Assert(
                $debug = $this->newDebug(),
                $filter = $filter ?? $this->newFilter()
            );
    }

    /**
     * @param null|Filter $filter
     *
     * @return Type
     */
    public function newType(Filter $filter = null) : Type
    {
        return $this->get(Type::class)
            ?? new Type(
                $filter = $filter ?? $this->newFilter()
            );
    }


    /**
     * @param string $id
     *
     * @return null|mixed
     */
    public function get(string $id)
    {
        return $this->has($id)
            ? $this->container->get($id)
            : null;
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    public function has(string $id)
    {
        return $this->container && $this->container->has($id);
    }
}
