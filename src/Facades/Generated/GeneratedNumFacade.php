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
     * @return int[]|float[]|string[]
     */
    public static function numvals($numbers, $uniq = null): array
    {
        return static::getInstance()->numvals($numbers, $uniq);
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
     * @param int|float|string|array $numvals
     * @param null|bool              $uniq
     *
     * @return int[]|float[]|string[]
     */
    public static function theNumvals($numvals, $uniq = null): array
    {
        return static::getInstance()->theNumvals($numvals, $uniq);
    }

    /**
     * @return Num
     */
    abstract public static function getInstance(): Num;
}
