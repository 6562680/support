<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;

interface INum
{
    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float
     */
    public function positiveVal($value);

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float
     */
    public function nonNegativeVal($value);

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float
     */
    public function negativeVal($value);

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float
     */
    public function nonPositiveVal($value);

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float
     */
    public function thePositiveVal($value);

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float
     */
    public function theNonNegativeVal($value);

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float
     */
    public function theNegativeVal($value);

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float
     */
    public function theNonPositiveVal($value);

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int
     */
    public function positiveIntval($value): ?int;

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int
     */
    public function nonNegativeIntval($value): ?int;

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int
     */
    public function negativeIntval($value): ?int;

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int
     */
    public function nonPositiveIntval($value): ?int;

    /**
     * @param int|float|string|mixed $value
     *
     * @return int
     */
    public function thePositiveIntval($value): int;

    /**
     * @param int|float|string|mixed $value
     *
     * @return int
     */
    public function theNonNegativeIntval($value): int;

    /**
     * @param int|float|string|mixed $value
     *
     * @return int
     */
    public function theNegativeIntval($value): int;

    /**
     * @param int|float|string|mixed $value
     *
     * @return int
     */
    public function theNonPositiveIntval($value): int;

    /**
     * @param mixed $value
     *
     * @return null|int
     */
    public function intval($value): ?int;

    /**
     * @param mixed $value
     *
     * @return null|float
     */
    public function floatval($value): ?float;

    /**
     * @param mixed $value
     *
     * @return null|int|float
     */
    public function numval($value);

    /**
     * @param mixed $value
     *
     * @return null|string
     */
    public function numericval($value): ?string;

    /**
     * @param mixed $value
     *
     * @return int
     */
    public function theIntval($value): int;

    /**
     * @param mixed $value
     *
     * @return float
     */
    public function theFloatval($value): float;

    /**
     * @param mixed $value
     *
     * @return int|float
     */
    public function theNumval($value);

    /**
     * @param mixed $value
     *
     * @return string
     */
    public function theNumericval($value): string;

    /**
     * @param int|array $integers
     * @param null|bool $uniq
     *
     * @return int[]
     */
    public function intvals($integers, $uniq = null): array;

    /**
     * @param float|array $floats
     * @param null|bool   $uniq
     *
     * @return float[]
     */
    public function floatvals($floats, $uniq = null): array;

    /**
     * @param int|float|string|array $numbers
     * @param null|bool              $uniq
     *
     * @return int[]|float[]
     */
    public function numvals($numbers, $uniq = null): array;

    /**
     * @param int|float|string|array $numbers
     * @param null|bool              $uniq
     *
     * @return string[]
     */
    public function numericvals($numbers, $uniq = null): array;

    /**
     * @param int|array $intvals
     * @param null|bool $uniq
     *
     * @return int[]
     */
    public function theIntvals($intvals, $uniq = null): array;

    /**
     * @param float|array $floatvals
     * @param null|bool   $uniq
     *
     * @return float[]
     */
    public function theFloatvals($floatvals, $uniq = null): array;

    /**
     * @param float|array $numbervals
     * @param null|bool   $uniq
     *
     * @return int[]|float[]
     */
    public function theNumvals($numbervals, $uniq = null): array;

    /**
     * @param int|float|string|array $numvals
     * @param null|bool              $uniq
     *
     * @return string[]
     */
    public function theNumericvals($numvals, $uniq = null): array;
}
