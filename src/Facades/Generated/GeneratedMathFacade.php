<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support\Facades\Generated;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Math;

abstract class GeneratedMathFacade
{
    /**
     * @param int|float ...$values
     *
     * @return null|int|float
     */
    public static function max(...$values)
    {
        return static::getInstance()->max(...$values);
    }

    /**
     * @param int|float ...$values
     *
     * @return null|int|float
     */
    public static function min(...$values)
    {
        return static::getInstance()->min(...$values);
    }

    /**
     * @param int|float ...$values
     *
     * @return int|float
     */
    public static function sum(...$values)
    {
        return static::getInstance()->sum(...$values);
    }

    /**
     * @param int|float ...$values
     *
     * @return float
     */
    public static function avg(...$values): float
    {
        return static::getInstance()->avg(...$values);
    }

    /**
     * @param int|float ...$values
     *
     * @return null|int|float
     */
    public static function median(...$values)
    {
        return static::getInstance()->median(...$values);
    }

    /**
     * @param int|float      $value
     * @param null|int|float $sum
     *
     * @return float
     */
    public static function ratio($value, $sum = null): float
    {
        return static::getInstance()->ratio($value, $sum);
    }

    /**
     * @param int|float      $value
     * @param null|int|float $sum
     *
     * @return float
     */
    public static function percent($value, $sum = null): float
    {
        return static::getInstance()->percent($value, $sum);
    }

    /**
     * @param int|float      $from
     * @param null|int|float $to
     *
     * @return float
     */
    public static function rand($from, $to = null): float
    {
        return static::getInstance()->rand($from, $to);
    }

    /**
     * Дробная часть числа
     *
     * @param int|float|string $number
     *
     * @return string
     */
    public static function frac($number): string
    {
        return static::getInstance()->frac($number);
    }

    /**
     * Дробная часть числа
     *
     * @param int|float|string|array $numbers
     *
     * @return int
     */
    public static function scaleMax(...$numbers): int
    {
        return static::getInstance()->scaleMax(...$numbers);
    }

    /**
     * Получает минуса или пустой строки если число отрицательное
     *
     * @param int|float|string $number
     *
     * @return string
     */
    public static function bcminus($number): string
    {
        return static::getInstance()->bcminus($number);
    }

    /**
     * Получает значение по модулю от числа
     *
     * @param int|float|string $number
     *
     * @return string
     */
    public static function bcabs($number): string
    {
        return static::getInstance()->bcabs($number);
    }

    /**
     * Округление
     *
     * @param int|float|string|mixed $number
     * @param null|int               $precision
     *
     * @return string
     */
    public static function bcround($number, int $precision = null): string
    {
        return static::getInstance()->bcround($number, $precision);
    }

    /**
     * Округляет в меньшую сторону
     *
     * @param int|float|string $number
     *
     * @return string
     */
    public static function bcfloor($number): string
    {
        return static::getInstance()->bcfloor($number);
    }

    /**
     * Округляет в большую сторону
     *
     * @param int|float|string $number
     *
     * @return string
     */
    public static function bcceil($number): string
    {
        return static::getInstance()->bcceil($number);
    }

    /**
     * @param int|float|string|array $numbers
     * @param null|int               $scale
     *
     * @return null|string
     */
    public static function bcmax($numbers, int $scale = null): ?string
    {
        return static::getInstance()->bcmax($numbers, $scale);
    }

    /**
     * @param int|float|string|array $numbers
     * @param null|int               $scale
     *
     * @return null|string
     */
    public static function bcmin($numbers, int $scale = null): ?string
    {
        return static::getInstance()->bcmin($numbers, $scale);
    }

    /**
     * @param int|float|string|array $numbers
     * @param null|int               $scale
     *
     * @return string
     */
    public static function bcsum($numbers, int $scale = null): string
    {
        return static::getInstance()->bcsum($numbers, $scale);
    }

    /**
     * @param int|float|string|array $numbers
     * @param null|int               $scale
     *
     * @return string
     */
    public static function bcavg($numbers, int $scale = null): string
    {
        return static::getInstance()->bcavg($numbers, $scale);
    }

    /**
     * @param int|float|string|array $numbers
     * @param null|int               $scale
     *
     * @return null|string
     */
    public static function bcmedian($numbers, int $scale = null): ?string
    {
        return static::getInstance()->bcmedian($numbers, $scale);
    }

    /**
     * @param int|float      $value
     * @param null|int|float $sum
     * @param null|int       $scale
     *
     * @return float
     */
    public static function bcratio($value, $sum = null, int $scale = null): float
    {
        return static::getInstance()->bcratio($value, $sum, $scale);
    }

    /**
     * @param int|float|string      $value
     * @param null|int|float|string $sum
     * @param null|int              $scale
     *
     * @return float
     */
    public static function bcpercent($value, $sum = null, int $scale = null): float
    {
        return static::getInstance()->bcpercent($value, $sum, $scale);
    }

    /**
     * @param int|float|string      $from
     * @param null|int|float|string $to
     * @param null|int              $scale
     *
     * @return string
     */
    public static function bcrand($from, $to = null, int $scale = null): string
    {
        return static::getInstance()->bcrand($from, $to, $scale);
    }

    /**
     * Округление по "правилу денег" (проверка потерянной копейки)
     * Округлит 1.00000001 до 1.01 (если нужно два знака после запятой)
     * Как правило, клиенту выставляется цена на копейку больше, а со счета компании списывается на копейку меньше
     *
     * @param int|float|string $number
     * @param null|int         $scale
     *
     * @return string
     */
    public static function bcmoneyfloor($number, int $scale = null): string
    {
        return static::getInstance()->bcmoneyfloor($number, $scale);
    }

    /**
     * Округление по "правилу денег" (проверка потерянной копейки)
     * Округлит 1.00000001 до 1.01 (если нужно два знака после запятой)
     * Как правило, клиенту выставляется цена на копейку больше, а со счета компании списывается на копейку меньше
     *
     * @param int|float|string $number
     * @param null|int         $scale
     *
     * @return string
     */
    public static function bcmoneyceil($number, int $scale = null): string
    {
        return static::getInstance()->bcmoneyceil($number, $scale);
    }

    /**
     * @param int|float|string $scale
     * @param null|int         $default
     *
     * @return null|string
     */
    public static function scaleval($scale, int $default = null): ?string
    {
        return static::getInstance()->scaleval($scale, $default);
    }

    /**
     * @param mixed    $scale
     * @param null|int $default
     *
     * @return string
     */
    public static function theScaleval($scale, int $default = null): string
    {
        return static::getInstance()->theScaleval($scale, $default);
    }

    /**
     * @param int|float|string $number
     *
     * @return null|string
     */
    public static function bcnumval($number): ?string
    {
        return static::getInstance()->bcnumval($number);
    }

    /**
     * @param mixed $value
     *
     * @return string
     */
    public static function theBcnumval($value): string
    {
        return static::getInstance()->theBcnumval($value);
    }

    /**
     * @param string|string[]|array $strings
     * @param null|bool             $uniq
     *
     * @return string[]
     */
    public static function bcnumvals($strings, $uniq = null): array
    {
        return static::getInstance()->bcnumvals($strings, $uniq);
    }

    /**
     * @param string|string[]|array $strings
     * @param null|bool             $uniq
     *
     * @return string[]
     */
    public static function theBcnumvals($strings, $uniq = null): array
    {
        return static::getInstance()->theBcnumvals($strings, $uniq);
    }

    /**
     * @return Math
     */
    abstract public static function getInstance(): Math;
}
