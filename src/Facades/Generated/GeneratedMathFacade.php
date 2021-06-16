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
     * @return int|float|string
     */
    public static function median(...$values)
    {
        return static::getInstance()->median(...$values);
    }

    /**
     * Дробная часть числа
     *
     * @param int|float|string $number
     *
     * @return string
     */
    public static function bcfrac($number): string
    {
        return static::getInstance()->bcfrac($number);
    }

    /**
     * Получает значение по модулю от числа
     *
     * @param int|float|string $number
     * @param string           $minus
     *
     * @return string
     */
    public static function bcabs($number, &$minus = null): string
    {
        return static::getInstance()->bcabs($number, $minus);
    }

    /**
     * Округление
     *
     * @param int|float|string|mixed $number
     * @param int                    $precision
     *
     * @return string
     */
    public static function bcround($number, $precision = 0): string
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
     * Дробная часть числа
     *
     * @param int|float|string|array $numbers
     *
     * @return int
     */
    public static function bcdecimals(...$numbers): int
    {
        return static::getInstance()->bcdecimals(...$numbers);
    }

    /**
     * @param int|float ...$numbers
     *
     * @return string
     */
    public static function bcsum(...$numbers): string
    {
        return static::getInstance()->bcsum(...$numbers);
    }

    /**
     * @param int|float ...$numbers
     *
     * @return string
     */
    public static function bcavg(...$numbers): string
    {
        return static::getInstance()->bcavg(...$numbers);
    }

    /**
     * @param int|float ...$numbers
     *
     * @return string
     */
    public static function bcmedian(...$numbers): string
    {
        return static::getInstance()->bcmedian(...$numbers);
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
