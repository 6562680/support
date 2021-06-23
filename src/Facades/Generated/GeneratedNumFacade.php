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
use Gzhegow\Support\Num;

abstract class GeneratedNumFacade
{
    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float
     */
    public static function positiveVal($value)
    {
        return static::getInstance()->positiveVal($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float
     */
    public static function nonNegativeVal($value)
    {
        return static::getInstance()->nonNegativeVal($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float
     */
    public static function negativeVal($value)
    {
        return static::getInstance()->negativeVal($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float
     */
    public static function nonPositiveVal($value)
    {
        return static::getInstance()->nonPositiveVal($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float
     */
    public static function thePositiveVal($value)
    {
        return static::getInstance()->thePositiveVal($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float
     */
    public static function theNonNegativeVal($value)
    {
        return static::getInstance()->theNonNegativeVal($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float
     */
    public static function theNegativeVal($value)
    {
        return static::getInstance()->theNegativeVal($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float
     */
    public static function theNonPositiveVal($value)
    {
        return static::getInstance()->theNonPositiveVal($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int
     */
    public static function positiveIntval($value): ?int
    {
        return static::getInstance()->positiveIntval($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int
     */
    public static function nonNegativeIntval($value): ?int
    {
        return static::getInstance()->nonNegativeIntval($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int
     */
    public static function negativeIntval($value): ?int
    {
        return static::getInstance()->negativeIntval($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int
     */
    public static function nonPositiveIntval($value): ?int
    {
        return static::getInstance()->nonPositiveIntval($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return int
     */
    public static function thePositiveIntval($value): int
    {
        return static::getInstance()->thePositiveIntval($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return int
     */
    public static function theNonNegativeIntval($value): int
    {
        return static::getInstance()->theNonNegativeIntval($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return int
     */
    public static function theNegativeIntval($value): int
    {
        return static::getInstance()->theNegativeIntval($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return int
     */
    public static function theNonPositiveIntval($value): int
    {
        return static::getInstance()->theNonPositiveIntval($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|int
     */
    public static function intval($value): ?int
    {
        return static::getInstance()->intval($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|float
     */
    public static function floatval($value): ?float
    {
        return static::getInstance()->floatval($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|int|float
     */
    public static function numval($value)
    {
        return static::getInstance()->numval($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|string
     */
    public static function numericval($value): ?string
    {
        return static::getInstance()->numericval($value);
    }

    /**
     * @param mixed $value
     *
     * @return int
     */
    public static function theIntval($value): int
    {
        return static::getInstance()->theIntval($value);
    }

    /**
     * @param mixed $value
     *
     * @return float
     */
    public static function theFloatval($value): float
    {
        return static::getInstance()->theFloatval($value);
    }

    /**
     * @param mixed $value
     *
     * @return int|float
     */
    public static function theNumval($value)
    {
        return static::getInstance()->theNumval($value);
    }

    /**
     * @param mixed $value
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
     *
     * @return int[]
     */
    public static function intvals($integers, $uniq = null): array
    {
        return static::getInstance()->intvals($integers, $uniq);
    }

    /**
     * @param float|array $floats
     * @param null|bool   $uniq
     *
     * @return float[]
     */
    public static function floatvals($floats, $uniq = null): array
    {
        return static::getInstance()->floatvals($floats, $uniq);
    }

    /**
     * @param int|float|string|array $numbers
     * @param null|bool              $uniq
     *
     * @return int[]|float[]
     */
    public static function numvals($numbers, $uniq = null): array
    {
        return static::getInstance()->numvals($numbers, $uniq);
    }

    /**
     * @param int|float|string|array $numbers
     * @param null|bool              $uniq
     *
     * @return string[]
     */
    public static function numericvals($numbers, $uniq = null): array
    {
        return static::getInstance()->numericvals($numbers, $uniq);
    }

    /**
     * @param int|array $intvals
     * @param null|bool $uniq
     *
     * @return int[]
     */
    public static function theIntvals($intvals, $uniq = null): array
    {
        return static::getInstance()->theIntvals($intvals, $uniq);
    }

    /**
     * @param float|array $floatvals
     * @param null|bool   $uniq
     *
     * @return float[]
     */
    public static function theFloatvals($floatvals, $uniq = null): array
    {
        return static::getInstance()->theFloatvals($floatvals, $uniq);
    }

    /**
     * @param float|array $numbervals
     * @param null|bool   $uniq
     *
     * @return int[]|float[]
     */
    public static function theNumvals($numbervals, $uniq = null): array
    {
        return static::getInstance()->theNumvals($numbervals, $uniq);
    }

    /**
     * @param int|float|string|array $numvals
     * @param null|bool              $uniq
     *
     * @return string[]
     */
    public static function theNumericvals($numvals, $uniq = null): array
    {
        return static::getInstance()->theNumericvals($numvals, $uniq);
    }

    /**
     * @return Num
     */
    abstract public static function getInstance(): Num;
}
