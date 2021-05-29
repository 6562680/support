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
use Gzhegow\Support\Calendar;
use Gzhegow\Support\Criteria;
use Gzhegow\Support\Profiler;


/**
 * SupportFactory
 */
class SupportFactory implements SupportFactoryInterface
{
    /**
     * @return Arr
     */
    public function newArr() : Arr
    {
        return new Arr(
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
     * @return Func
     */
    public function newFunc() : Func
    {
        return new Func();
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
            $this->newNum()
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
            $this->newFilter(),
            $this->newPhp()
        );
    }

    /**
     * @return Path
     */
    public function newPath() : Path
    {
        return new Path(
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
}
