<?php

/**
 * This file is auto-generated.
 *
 * * @noinspection PhpUnhandledExceptionInspection
 * * @noinspection PhpDocMissingThrowsInspection
 */

namespace Gzhegow\Support\Facades\Generated;

use Gzhegow\Support\Bcmath as _Bcmath;

abstract class Bcmath
{
    /**
     * bcfrac
     * получает дробную часть числа в виде строки
     *
     * @param int|float|string $number
     * @param int|null         $decimals
     * @param null             $int
     *
     * @return string
     */
    public static function bcfrac($number, int $decimals = 0, &$int = null) : string
    {
        return static::getInstance()->bcfrac($number, $decimals, $int);
    }

    /**
     * @param int|float|string $number
     * @param int              $decimals
     *
     * @return null|string
     */
    public static function bcround($number, int $decimals = 0)
    {
        return static::getInstance()->bcround($number, $decimals);
    }

    /**
     * @param int|float|string $number
     *
     * @return string
     */
    public static function bcceil(string $number)
    {
        return static::getInstance()->bcceil($number);
    }

    /**
     * @param int|float|string $number
     *
     * @return string
     */
    public static function bcfloor($number)
    {
        return static::getInstance()->bcfloor($number);
    }

    /**
     * @param int|float|string $number
     *
     * @return bool
     */
    public static function bcnegative($number) : bool
    {
        return static::getInstance()->bcnegative($number);
    }

    /**
     * @param int|float|string $number
     *
     * @return bool
     */
    public static function bcabs(string $number)
    {
        return static::getInstance()->bcabs($number);
    }

    /**
     * определяет количество десятичных знаков в числе
     *
     * @param int|float|string $number
     *
     * @return int
     */
    public static function bcdecimals($number) : int
    {
        return static::getInstance()->bcdecimals($number);
    }

    /**
     * number
     * приводит число из текстовой формы в математическую
     *
     * @param int|float|string $number
     *
     * @return string
     */
    public static function bcnum($number) : string
    {
        return static::getInstance()->bcnum($number);
    }


    /**
     * @return _Bcmath
     */
    abstract public static function getInstance() : _Bcmath;
}
