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
use Gzhegow\Support\Func;
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
    public function __construct(ContainerInterface $container = null)
    {
        $this->container = $container;
    }


    /**
     * @return Arr
     */
    public function newArr() : Arr
    {
        return $this->containerGet(Arr::class)
            ?? new Arr(
                $this->newFilter(),
                $this->newNum(),
                $this->newPhp(),
                $this->newStr()
            );
    }

    /**
     * @return Calendar
     */
    public function newCalendar() : Calendar
    {
        return $this->containerGet(Calendar::class)
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
        return $this->containerGet(Cli::class)
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
        return $this->containerGet(Cmp::class)
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
        return $this->containerGet(Criteria::class)
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
        return $this->containerGet(Curl::class)
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
        return $this->containerGet(Debug::class)
            ?? new Debug();
    }

    /**
     * @return Env
     */
    public function newEnv() : Env
    {
        return $this->containerGet(Env::class)
            ?? new Env();
    }

    /**
     * @return Filter
     */
    public function newFilter() : Filter
    {
        return $this->containerGet(Filter::class)
            ?? new Filter();
    }

    /**
     * @return Format
     */
    public function newFormat() : Format
    {
        return $this->containerGet(Filter::class)
            ?? new Format(
                $this->newNum()
            );
    }

    /**
     * @return Fs
     */
    public function newFs() : Fs
    {
        return $this->containerGet(Fs::class)
            ?? new Fs(
                $this->newFilter(),
                $this->newPath(),
                $this->newPhp()
            );
    }

    /**
     * @return Func
     */
    public function newFunc() : Func
    {
        return $this->containerGet(Func::class)
            ?? new Func();
    }

    /**
     * @return Loader
     */
    public function newLoader() : Loader
    {
        return $this->containerGet(Loader::class)
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
        return $this->containerGet(Math::class)
            ?? new Math(
                $this->newFilter(),
                $this->newNum()
            );
    }

    /**
     * @return Net
     */
    public function newNet() : Net
    {
        return $this->containerGet(Net::class)
            ?? new Net(
                $this->newStr()
            );
    }

    /**
     * @return Num
     */
    public function newNum() : Num
    {
        return $this->containerGet(Num::class)
            ?? new Num(
                $this->newFilter(),
                $this->newPhp()
            );
    }

    /**
     * @return Path
     */
    public function newPath() : Path
    {
        return $this->containerGet(Path::class)
            ?? new Path(
                $this->newPhp(),
                $this->newStr()
            );
    }

    /**
     * @return Php
     */
    public function newPhp() : Php
    {
        return $this->containerGet(Php::class)
            ?? new Php(
                $this->newFilter()
            );
    }

    /**
     * @return Preg
     */
    public function newPreg() : Preg
    {
        return $this->containerGet(Preg::class)
            ?? new Preg(
                $this->newStr()
            );
    }

    /**
     * @return Profiler
     */
    public function newProfiler() : Profiler
    {
        return $this->containerGet(Profiler::class)
            ?? new Profiler(
                $this->newCalendar()
            );
    }

    /**
     * @return Str
     */
    public function newStr() : Str
    {
        return $this->containerGet(Str::class)
            ?? new Str(
                $this->newFilter()
            );
    }

    /**
     * @return Uri
     */
    public function newUri() : Uri
    {
        return $this->containerGet(Uri::class)
            ?? new Uri(
                $this->newArr(),
                $this->newFilter(),
                $this->newPhp(),
                $this->newStr()
            );
    }


    /**
     * @param string $id
     *
     * @return null|mixed
     */
    protected function containerGet(string $id)
    {
        return $this->container
            ? $this->container->get($id)
            : null;
    }
}
