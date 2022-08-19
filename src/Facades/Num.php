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
use Gzhegow\Support\Traits\Load\StrLoadTrait;
use Gzhegow\Support\XNum;

class Num
{
    /**
     * @param int|mixed $value
     *
     * @return null|int
     */
    public static function filterInt($value): ?int
    {
        return static::getInstance()->filterInt($value);
    }

    /**
     * @param float|mixed $value
     *
     * @return null|float
     */
    public static function filterFloat($value): ?float
    {
        return static::getInstance()->filterFloat($value);
    }

    /**
     * @param float|mixed $value
     *
     * @return null|float
     */
    public static function filterNan($value): ?float
    {
        return static::getInstance()->filterNan($value);
    }

    /**
     * @param int|float|mixed $value
     *
     * @return null|int|float
     */
    public static function filterNum($value)
    {
        return static::getInstance()->filterNum($value);
    }

    /**
     * @param int|string|mixed $value
     *
     * @return null|int|string
     */
    public static function filterIntval($value): ?int
    {
        return static::getInstance()->filterIntval($value);
    }

    /**
     * @param float|string|mixed $value
     *
     * @return null|float|string
     */
    public static function filterFloatval($value): ?float
    {
        return static::getInstance()->filterFloatval($value);
    }

    /**
     * @param int|float|mixed $value
     *
     * @return null|int|float|string
     */
    public static function filterNumval($value)
    {
        return static::getInstance()->filterNumval($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public static function filterNumericval($value)
    {
        return static::getInstance()->filterNumericval($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float
     */
    public static function filterNumGt0($value)
    {
        return static::getInstance()->filterNumGt0($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float
     */
    public static function filterNumGte0($value)
    {
        return static::getInstance()->filterNumGte0($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float
     */
    public static function filterNumLt0($value)
    {
        return static::getInstance()->filterNumLt0($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float
     */
    public static function filterNumLte0($value)
    {
        return static::getInstance()->filterNumLte0($value);
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
     * @param int|float|string|array $numerics
     * @param null|bool              $uniq
     * @param null|bool              $recursive
     *
     * @return string[]
     */
    public static function numericvals($numerics, bool $uniq = null, bool $recursive = null): array
    {
        return static::getInstance()->numericvals($numerics, $uniq, $recursive);
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
     * @param int|float|string|array $numerics
     * @param null|bool              $uniq
     * @param null|bool              $recursive
     *
     * @return string[]
     */
    public static function theNumericvals($numerics, bool $uniq = null, bool $recursive = null): array
    {
        return static::getInstance()->theNumericvals($numerics, $uniq, $recursive);
    }

    /**
     * @param string|mixed $number
     * @param string|array $decimalsSeparators
     * @param string|array $thousandsSeparators
     *
     * @return string
     */
    public static function numberParse($number, $decimalsSeparators = null, $thousandsSeparators = null): string
    {
        return static::getInstance()->numberParse($number, $decimalsSeparators, $thousandsSeparators);
    }

    /**
     * @param int|float|string|mixed $number
     * @param null|int               $decimals
     * @param null|string            $decimalSeparator
     * @param null|string            $thousandSeparator
     *
     * @return string
     */
    public static function numberFormat(
        $number,
        int $decimals = null,
        string $decimalSeparator = null,
        string $thousandSeparator = null
    ) {
        return static::getInstance()->numberFormat($number, $decimals, $decimalSeparator, $thousandSeparator);
    }

    /**
     * @return INum
     */
    public static function getInstance(): INum
    {
        return SupportFactory::getInstance()->getNum();
    }
}
