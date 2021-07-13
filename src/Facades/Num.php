<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 * @noinspection RedundantSuppression
 */

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\INum;
use Gzhegow\Support\SupportFactory;
use Gzhegow\Support\ZNum;

class Num
{
    /**
     * @param int|float|mixed $value
     *
     * @return null|int|float
     */
    public static function positiveVal($value)
    {
        return static::getInstance()->positiveVal($value);
    }

    /**
     * @param int|float|mixed $value
     *
     * @return null|int|float
     */
    public static function nonNegativeVal($value)
    {
        return static::getInstance()->nonNegativeVal($value);
    }

    /**
     * @param int|float|mixed $value
     *
     * @return null|int|float
     */
    public static function negativeVal($value)
    {
        return static::getInstance()->negativeVal($value);
    }

    /**
     * @param int|float|mixed $value
     *
     * @return null|int|float
     */
    public static function nonPositiveVal($value)
    {
        return static::getInstance()->nonPositiveVal($value);
    }

    /**
     * @param int|float|mixed $value
     *
     * @return int|float
     */
    public static function thePositiveVal($value)
    {
        return static::getInstance()->thePositiveVal($value);
    }

    /**
     * @param int|float|mixed $value
     *
     * @return int|float
     */
    public static function theNonNegativeVal($value)
    {
        return static::getInstance()->theNonNegativeVal($value);
    }

    /**
     * @param int|float|mixed $value
     *
     * @return int|float
     */
    public static function theNegativeVal($value)
    {
        return static::getInstance()->theNegativeVal($value);
    }

    /**
     * @param int|float|mixed $value
     *
     * @return int|float
     */
    public static function theNonPositiveVal($value)
    {
        return static::getInstance()->theNonPositiveVal($value);
    }

    /**
     * @param int|mixed $value
     *
     * @return null|int
     */
    public static function positiveIntval($value): ?int
    {
        return static::getInstance()->positiveIntval($value);
    }

    /**
     * @param int|mixed $value
     *
     * @return null|int
     */
    public static function nonNegativeIntval($value): ?int
    {
        return static::getInstance()->nonNegativeIntval($value);
    }

    /**
     * @param int|mixed $value
     *
     * @return null|int
     */
    public static function negativeIntval($value): ?int
    {
        return static::getInstance()->negativeIntval($value);
    }

    /**
     * @param int|mixed $value
     *
     * @return null|int
     */
    public static function nonPositiveIntval($value): ?int
    {
        return static::getInstance()->nonPositiveIntval($value);
    }

    /**
     * @param int|mixed $value
     *
     * @return int
     */
    public static function thePositiveIntval($value): int
    {
        return static::getInstance()->thePositiveIntval($value);
    }

    /**
     * @param int|mixed $value
     *
     * @return int
     */
    public static function theNonNegativeIntval($value): int
    {
        return static::getInstance()->theNonNegativeIntval($value);
    }

    /**
     * @param int|mixed $value
     *
     * @return int
     */
    public static function theNegativeIntval($value): int
    {
        return static::getInstance()->theNegativeIntval($value);
    }

    /**
     * @param int|mixed $value
     *
     * @return int
     */
    public static function theNonPositiveIntval($value): int
    {
        return static::getInstance()->theNonPositiveIntval($value);
    }

    /**
     * @param int|mixed $value
     *
     * @return null|int
     */
    public static function intval($value): ?int
    {
        return static::getInstance()->intval($value);
    }

    /**
     * @param float|mixed $value
     *
     * @return null|float
     */
    public static function floatval($value): ?float
    {
        return static::getInstance()->floatval($value);
    }

    /**
     * @param int|float|mixed $value
     *
     * @return null|int|float
     */
    public static function numval($value)
    {
        return static::getInstance()->numval($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|string
     */
    public static function numericval($value): ?string
    {
        return static::getInstance()->numericval($value);
    }

    /**
     * @param int|mixed $value
     *
     * @return int
     */
    public static function theIntval($value): int
    {
        return static::getInstance()->theIntval($value);
    }

    /**
     * @param float|mixed $value
     *
     * @return float
     */
    public static function theFloatval($value): float
    {
        return static::getInstance()->theFloatval($value);
    }

    /**
     * @param int|float|mixed $value
     *
     * @return int|float
     */
    public static function theNumval($value)
    {
        return static::getInstance()->theNumval($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return string
     */
    public static function theNumericval($value): string
    {
        return static::getInstance()->theNumericval($value);
    }

    /**
     * @param int|array $integers
     * @param null|bool $uniq
     * @param null|bool $recursive
     *
     * @return int[]
     */
    public static function intvals($integers, bool $uniq = null, bool $recursive = null): array
    {
        return static::getInstance()->intvals($integers, $uniq, $recursive);
    }

    /**
     * @param float|array $floats
     * @param null|bool   $uniq
     * @param null|bool   $recursive
     *
     * @return float[]
     */
    public static function floatvals($floats, bool $uniq = null, bool $recursive = null): array
    {
        return static::getInstance()->floatvals($floats, $uniq, $recursive);
    }

    /**
     * @param int|float|array $numbers
     * @param null|bool       $uniq
     * @param null|bool       $recursive
     *
     * @return int[]|float[]
     */
    public static function numvals($numbers, bool $uniq = null, bool $recursive = null): array
    {
        return static::getInstance()->numvals($numbers, $uniq, $recursive);
    }

    /**
     * @param int|float|string|array $numbers
     * @param null|bool              $uniq
     * @param null|bool              $recursive
     *
     * @return string[]
     */
    public static function numericvals($numbers, bool $uniq = null, bool $recursive = null): array
    {
        return static::getInstance()->numericvals($numbers, $uniq, $recursive);
    }

    /**
     * @param int|array $integers
     * @param null|bool $uniq
     * @param null|bool $recursive
     *
     * @return int[]
     */
    public static function theIntvals($integers, bool $uniq = null, bool $recursive = null): array
    {
        return static::getInstance()->theIntvals($integers, $uniq, $recursive);
    }

    /**
     * @param float|array $floats
     * @param null|bool   $uniq
     * @param null|bool   $recursive
     *
     * @return float[]
     */
    public static function theFloatvals($floats, bool $uniq = null, bool $recursive = null): array
    {
        return static::getInstance()->theFloatvals($floats, $uniq, $recursive);
    }

    /**
     * @param int|float|array $numbers
     * @param null|bool       $uniq
     * @param null|bool       $recursive
     *
     * @return int[]|float[]
     */
    public static function theNumvals($numbers, bool $uniq = null, bool $recursive = null): array
    {
        return static::getInstance()->theNumvals($numbers, $uniq, $recursive);
    }

    /**
     * @param int|float|string|array $numbers
     * @param null|bool              $uniq
     * @param null|bool              $recursive
     *
     * @return string[]
     */
    public static function theNumericvals($numbers, bool $uniq = null, bool $recursive = null): array
    {
        return static::getInstance()->theNumericvals($numbers, $uniq, $recursive);
    }

    /**
     * @return INum
     */
    public static function getInstance(): INum
    {
        return SupportFactory::getInstance()->getNum();
    }
}
