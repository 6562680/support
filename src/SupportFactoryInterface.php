<?php

namespace Gzhegow\Support;


/**
 * SupportFactoryInterface
 */
interface SupportFactoryInterface
{
    /**
     * @return IArr
     */
    public function getArr() : IArr;

    /**
     * @return ICalendar
     */
    public function getCalendar() : ICalendar;

    /**
     * @return ICli
     */
    public function getCli() : ICli;

    /**
     * @return ICmp
     */
    public function getCmp() : ICmp;

    /**
     * @return ICriteria
     */
    public function getCriteria() : ICriteria;

    /**
     * @return ICurl
     */
    public function getCurl() : ICurl;

    /**
     * @return IDebug
     */
    public function getDebug() : IDebug;

    /**
     * @return IEnv
     */
    public function getEnv() : IEnv;

    /**
     * @return IFilter
     */
    public function getFilter() : IFilter;

    /**
     * @return IFormat
     */
    public function getFormat() : IFormat;

    /**
     * @return IFs
     */
    public function getFs() : IFs;

    /**
     * @return ILoader
     */
    public function getLoader() : ILoader;

    /**
     * @return IMath
     */
    public function getMath() : IMath;

    /**
     * @return INet
     */
    public function getNet() : INet;

    /**
     * @return INum
     */
    public function getNum() : INum;

    /**
     * @return IPath
     */
    public function getPath() : IPath;

    /**
     * @return IPhp
     */
    public function getPhp() : IPhp;

    /**
     * @return IPreg
     */
    public function getPreg() : IPreg;

    /**
     * @return IProf
     */
    public function getProf() : IProf;

    /**
     * @return IStr
     */
    public function getStr() : IStr;

    /**
     * @return IUri
     */
    public function getUri() : IUri;


    /**
     * @return IArr
     */
    public function newArr() : IArr;

    /**
     * @return ICalendar
     */
    public function newCalendar() : ICalendar;

    /**
     * @return ICli
     */
    public function newCli() : ICli;

    /**
     * @return ICmp
     */
    public function newCmp() : ICmp;

    /**
     * @return ICriteria
     */
    public function newCriteria() : ICriteria;

    /**
     * @return ICurl
     */
    public function newCurl() : ICurl;

    /**
     * @return IDebug
     */
    public function newDebug() : IDebug;

    /**
     * @return IEnv
     */
    public function newEnv() : IEnv;

    /**
     * @return IFilter
     */
    public function newFilter() : IFilter;

    /**
     * @return IFormat
     */
    public function newFormat() : IFormat;

    /**
     * @return IFs
     */
    public function newFs() : IFs;

    /**
     * @return ILoader
     */
    public function newLoader() : ILoader;

    /**
     * @return IMath
     */
    public function newMath() : IMath;

    /**
     * @return INet
     */
    public function newNet() : INet;

    /**
     * @return INum
     */
    public function newNum() : INum;

    /**
     * @return IPath
     */
    public function newPath() : IPath;

    /**
     * @return IPhp
     */
    public function newPhp() : IPhp;

    /**
     * @return IPreg
     */
    public function newPreg() : IPreg;

    /**
     * @return IProf
     */
    public function newProf() : IProf;

    /**
     * @return IStr
     */
    public function newStr() : IStr;

    /**
     * @return IUri
     */
    public function newUri() : IUri;
}
