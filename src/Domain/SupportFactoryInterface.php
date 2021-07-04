<?php

namespace Gzhegow\Support\Domain;

use Gzhegow\Support\Fs;
use Gzhegow\Support\Arr;
use Gzhegow\Support\Net;
use Gzhegow\Support\Cmp;
use Gzhegow\Support\Cli;
use Gzhegow\Support\Env;
use Gzhegow\Support\Num;
use Gzhegow\Support\Str;
use Gzhegow\Support\Uri;
use Gzhegow\Support\Php;
use Gzhegow\Support\Math;
use Gzhegow\Support\Path;
use Gzhegow\Support\Preg;
use Gzhegow\Support\Curl;
use Gzhegow\Support\Debug;
use Gzhegow\Support\Loader;
use Gzhegow\Support\Filter;
use Gzhegow\Support\Format;
use Gzhegow\Support\Calendar;
use Gzhegow\Support\Profiler;
use Gzhegow\Support\Criteria;
use Gzhegow\Support\Domain\Filter\Type;
use Gzhegow\Support\Domain\Filter\Assert;


/**
 * SupportFactoryInterface
 */
interface SupportFactoryInterface
{
    /**
     * @return Arr
     */
    public function getArr() : Arr;

    /**
     * @return Calendar
     */
    public function getCalendar() : Calendar;

    /**
     * @return Cli
     */
    public function getCli() : Cli;

    /**
     * @return Cmp
     */
    public function getCmp() : Cmp;

    /**
     * @return Criteria
     */
    public function getCriteria() : Criteria;

    /**
     * @return Curl
     */
    public function getCurl() : Curl;

    /**
     * @return Debug
     */
    public function getDebug() : Debug;

    /**
     * @return Env
     */
    public function getEnv() : Env;

    /**
     * @return Filter
     */
    public function getFilter() : Filter;

    /**
     * @return Format
     */
    public function getFormat() : Format;

    /**
     * @return Fs
     */
    public function getFs() : Fs;

    /**
     * @return Loader
     */
    public function getLoader() : Loader;

    /**
     * @return Math
     */
    public function getMath() : Math;

    /**
     * @return Net
     */
    public function getNet() : Net;

    /**
     * @return Num
     */
    public function getNum() : Num;

    /**
     * @return Path
     */
    public function getPath() : Path;

    /**
     * @return Php
     */
    public function getPhp() : Php;

    /**
     * @return Preg
     */
    public function getPreg() : Preg;

    /**
     * @return Profiler
     */
    public function getProfiler() : Profiler;

    /**
     * @return Str
     */
    public function getStr() : Str;

    /**
     * @return Uri
     */
    public function getUri() : Uri;


    /**
     * @return Arr
     */
    public function newArr() : Arr;

    /**
     * @return Calendar
     */
    public function newCalendar() : Calendar;

    /**
     * @return Cli
     */
    public function newCli() : Cli;

    /**
     * @return Cmp
     */
    public function newCmp() : Cmp;

    /**
     * @return Criteria
     */
    public function newCriteria() : Criteria;

    /**
     * @return Curl
     */
    public function newCurl() : Curl;

    /**
     * @return Debug
     */
    public function newDebug() : Debug;

    /**
     * @return Env
     */
    public function newEnv() : Env;

    /**
     * @return Filter
     */
    public function newFilter() : Filter;

    /**
     * @return Format
     */
    public function newFormat() : Format;

    /**
     * @return Fs
     */
    public function newFs() : Fs;

    /**
     * @return Loader
     */
    public function newLoader() : Loader;

    /**
     * @return Math
     */
    public function newMath() : Math;

    /**
     * @return Net
     */
    public function newNet() : Net;

    /**
     * @return Num
     */
    public function newNum() : Num;

    /**
     * @return Path
     */
    public function newPath() : Path;

    /**
     * @return Php
     */
    public function newPhp() : Php;

    /**
     * @return Preg
     */
    public function newPreg() : Preg;

    /**
     * @return Profiler
     */
    public function newProfiler() : Profiler;

    /**
     * @return Str
     */
    public function newStr() : Str;

    /**
     * @return Uri
     */
    public function newUri() : Uri;
}
