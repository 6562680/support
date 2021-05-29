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
     * @param int|array         $integers
     * @param null|bool         $uniq
     * @param null|string|array $message
     * @param mixed             ...$arguments
     *
     * @return int[]
     */
    public static function intvals($integers, $uniq = null, $message = null, ...$arguments): array
    {
        return static::getInstance()->intvals($integers, $uniq, $message, ...$arguments);
    }

    /**
     * @param int|array         $integers
     * @param null|bool         $uniq
     * @param null|string|array $message
     * @param mixed             ...$arguments
     *
     * @return int[]
     */
    public static function theIntvals($integers, $uniq = null, $message = null, array ...$arguments): array
    {
        return static::getInstance()->theIntvals($integers, $uniq, $message, ...$arguments);
    }

    /**
     * @param int|array $integers
     * @param null|bool $uniq
     *
     * @return int[]
     */
    public static function intvalsSkip($integers, $uniq = null): array
    {
        return static::getInstance()->intvalsSkip($integers, $uniq);
    }

    /**
     * @param int|array $integers
     * @param null|bool $uniq
     *
     * @return int[]
     */
    public static function theIntvalsSkip($integers, $uniq = null): array
    {
        return static::getInstance()->theIntvalsSkip($integers, $uniq);
    }

    /**
     * @param float|array       $floats
     * @param null|bool         $uniq
     * @param null|string|array $message
     * @param mixed             ...$arguments
     *
     * @return float[]
     */
    public static function floatvals($floats, $uniq = null, $message = null, ...$arguments): array
    {
        return static::getInstance()->floatvals($floats, $uniq, $message, ...$arguments);
    }

    /**
     * @param float|array       $floats
     * @param null|bool         $uniq
     * @param null|string|array $message
     * @param mixed             ...$arguments
     *
     * @return float[]
     */
    public static function theFloatvals($floats, $uniq = null, $message = null, array ...$arguments): array
    {
        return static::getInstance()->theFloatvals($floats, $uniq, $message, ...$arguments);
    }

    /**
     * @param float|array $floats
     * @param null|bool   $uniq
     *
     * @return float[]
     */
    public static function floatvalsSkip($floats, $uniq = null): array
    {
        return static::getInstance()->floatvalsSkip($floats, $uniq);
    }

    /**
     * @param float|array $floats
     * @param null|bool   $uniq
     *
     * @return float[]
     */
    public static function theFloatvalsSkip($floats, $uniq = null): array
    {
        return static::getInstance()->theFloatvalsSkip($floats, $uniq);
    }

    /**
     * @param int|float|string|array $numbers
     * @param null|bool              $uniq
     * @param null|string|array      $message
     * @param mixed                  ...$arguments
     *
     * @return int[]|float[]|string[]
     */
    public static function numvals($numbers, $uniq = null, $message = null, ...$arguments): array
    {
        return static::getInstance()->numvals($numbers, $uniq, $message, ...$arguments);
    }

    /**
     * @param int|float|string|array $numbers
     * @param null|bool              $uniq
     * @param null|string|array      $message
     * @param mixed                  ...$arguments
     *
     * @return int[]|float[]|string[]
     */
    public static function theNumvals($numbers, $uniq = null, $message = null, array ...$arguments): array
    {
        return static::getInstance()->theNumvals($numbers, $uniq, $message, ...$arguments);
    }

    /**
     * @param int|float|string|array $numbers
     * @param null|bool              $uniq
     *
     * @return int[]|float[]|string[]
     */
    public static function numvalsSkip($numbers, $uniq = null): array
    {
        return static::getInstance()->numvalsSkip($numbers, $uniq);
    }

    /**
     * @param int|float|string|array $numbers
     * @param null|bool              $uniq
     *
     * @return int[]|float[]|string[]
     */
    public static function theNumvalsSkip($numbers, $uniq = null): array
    {
        return static::getInstance()->theNumvalsSkip($numbers, $uniq);
    }

    /**
     * @return Num
     */
    abstract public static function getInstance(): Num;
}
