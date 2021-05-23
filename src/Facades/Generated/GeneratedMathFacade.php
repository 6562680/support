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
use Gzhegow\Support\Exceptions\Runtime\OutOfBoundsException;
use Gzhegow\Support\Math;

abstract class GeneratedMathFacade
{
    /**
     * @param           $src
     * @param null|bool $coalesce
     *
     * @return bool
     */
    public static function isPositive($src, bool $coalesce = null): bool
    {
        return static::getInstance()->isPositive($src, $coalesce);
    }

    /**
     * @param           $src
     * @param null|bool $coalesce
     *
     * @return bool
     */
    public static function isNegative($src, bool $coalesce = null): bool
    {
        return static::getInstance()->isNegative($src, $coalesce);
    }

    /**
     * @param           $src
     * @param null|bool $coalesce
     *
     * @return bool
     */
    public static function isNonPositive($src, bool $coalesce = null): bool
    {
        return static::getInstance()->isNonPositive($src, $coalesce);
    }

    /**
     * @param           $src
     * @param null|bool $coalesce
     *
     * @return bool
     */
    public static function isNonNegative($src, bool $coalesce = null): bool
    {
        return static::getInstance()->isNonNegative($src, $coalesce);
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
     * @return int
     */
    public static function percent($value, $sum = null): int
    {
        return static::getInstance()->percent($value, $sum);
    }

    /**
     * @param int|float $value
     *
     * @return null|int|float
     */
    public static function positive($value)
    {
        return static::getInstance()->positive($value);
    }

    /**
     * @param int|float $value
     *
     * @return null|int|float
     */
    public static function negative($value)
    {
        return static::getInstance()->negative($value);
    }

    /**
     * @param int|float $value
     * @param null|int  $decimals
     *
     * @return int|float
     */
    public static function moneyround($value, int $decimals = null)
    {
        return static::getInstance()->moneyround($value, $decimals);
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
     * @return int|float
     */
    public static function avg(...$values): float
    {
        return static::getInstance()->avg(...$values);
    }

    /**
     * @param int|float     $sum
     * @param int[]|float[] $rates
     * @param null|int      $decimals
     *
     * @return int[]|float[]
     */
    public static function share($sum, array $rates, int $decimals = null): array
    {
        return static::getInstance()->share($sum, $rates, $decimals);
    }

    /**
     * Balances $sum between given $rates regarding $freezes values
     *
     * [ 5, 10, 50 ] -> [ , , 20 ]
     * 5x + 10x + 50x = ((5 + 10 + 50) - 20) = 45
     * [ 3, 7, 35 ] + [ , , 20 ]
     * 3x + 7x = 35
     * [ 13.5, 31.5, 20 ] -> round to decimals...
     * [ 14, 31, 20 ]
     *
     * @param int|float $sum
     * @param array     $rates
     * @param array     $freezes
     * @param null|int  $decimals
     *
     * @return array
     */
    public static function balance($sum, array $rates, array $freezes = [], int $decimals = null): array
    {
        return static::getInstance()->balance($sum, $rates, $freezes, $decimals);
    }

    /**
     * @param array $rates
     *
     * @return array
     */
    public static function balanceRatios(array $rates): array
    {
        return static::getInstance()->balanceRatios($rates);
    }

    /**
     * @return Math
     */
    abstract public static function getInstance(): Math;
}
