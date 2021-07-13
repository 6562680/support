<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 * @noinspection RedundantSuppression
 */

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;

interface INum
{
    /**
     * @param int|float|mixed $value
     *
     * @return null|int|float
     */
    public function positiveVal($value);

    /**
     * @param int|float|mixed $value
     *
     * @return null|int|float
     */
    public function nonNegativeVal($value);

    /**
     * @param int|float|mixed $value
     *
     * @return null|int|float
     */
    public function negativeVal($value);

    /**
     * @param int|float|mixed $value
     *
     * @return null|int|float
     */
    public function nonPositiveVal($value);

    /**
     * @param int|float|mixed $value
     *
     * @return int|float
     */
    public function thePositiveVal($value);

    /**
     * @param int|float|mixed $value
     *
     * @return int|float
     */
    public function theNonNegativeVal($value);

    /**
     * @param int|float|mixed $value
     *
     * @return int|float
     */
    public function theNegativeVal($value);

    /**
     * @param int|float|mixed $value
     *
     * @return int|float
     */
    public function theNonPositiveVal($value);

    /**
     * @param int|mixed $value
     *
     * @return null|int
     */
    public function positiveIntval($value): ?int;

    /**
     * @param int|mixed $value
     *
     * @return null|int
     */
    public function nonNegativeIntval($value): ?int;

    /**
     * @param int|mixed $value
     *
     * @return null|int
     */
    public function negativeIntval($value): ?int;

    /**
     * @param int|mixed $value
     *
     * @return null|int
     */
    public function nonPositiveIntval($value): ?int;

    /**
     * @param int|mixed $value
     *
     * @return int
     */
    public function thePositiveIntval($value): int;

    /**
     * @param int|mixed $value
     *
     * @return int
     */
    public function theNonNegativeIntval($value): int;

    /**
     * @param int|mixed $value
     *
     * @return int
     */
    public function theNegativeIntval($value): int;

    /**
     * @param int|mixed $value
     *
     * @return int
     */
    public function theNonPositiveIntval($value): int;

    /**
     * @param int|mixed $value
     *
     * @return null|int
     */
    public function intval($value): ?int;

    /**
     * @param float|mixed $value
     *
     * @return null|float
     */
    public function floatval($value): ?float;

    /**
     * @param int|float|mixed $value
     *
     * @return null|int|float
     */
    public function numval($value);

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|string
     */
    public function numericval($value): ?string;

    /**
     * @param int|mixed $value
     *
     * @return int
     */
    public function theIntval($value): int;

    /**
     * @param float|mixed $value
     *
     * @return float
     */
    public function theFloatval($value): float;

    /**
     * @param int|float|mixed $value
     *
     * @return int|float
     */
    public function theNumval($value);

    /**
     * @param int|float|string|mixed $value
     *
     * @return string
     */
    public function theNumericval($value): string;

    /**
     * @param int|array $integers
     * @param null|bool $uniq
     * @param null|bool $recursive
     *
     * @return int[]
     */
    public function intvals($integers, bool $uniq = null, bool $recursive = null): array;

    /**
     * @param float|array $floats
     * @param null|bool   $uniq
     * @param null|bool   $recursive
     *
     * @return float[]
     */
    public function floatvals($floats, bool $uniq = null, bool $recursive = null): array;

    /**
     * @param int|float|array $numbers
     * @param null|bool       $uniq
     * @param null|bool       $recursive
     *
     * @return int[]|float[]
     */
    public function numvals($numbers, bool $uniq = null, bool $recursive = null): array;

    /**
     * @param int|float|string|array $numbers
     * @param null|bool              $uniq
     * @param null|bool              $recursive
     *
     * @return string[]
     */
    public function numericvals($numbers, bool $uniq = null, bool $recursive = null): array;

    /**
     * @param int|array $integers
     * @param null|bool $uniq
     * @param null|bool $recursive
     *
     * @return int[]
     */
    public function theIntvals($integers, bool $uniq = null, bool $recursive = null): array;

    /**
     * @param float|array $floats
     * @param null|bool   $uniq
     * @param null|bool   $recursive
     *
     * @return float[]
     */
    public function theFloatvals($floats, bool $uniq = null, bool $recursive = null): array;

    /**
     * @param int|float|array $numbers
     * @param null|bool       $uniq
     * @param null|bool       $recursive
     *
     * @return int[]|float[]
     */
    public function theNumvals($numbers, bool $uniq = null, bool $recursive = null): array;

    /**
     * @param int|float|string|array $numbers
     * @param null|bool              $uniq
     * @param null|bool              $recursive
     *
     * @return string[]
     */
    public function theNumericvals($numbers, bool $uniq = null, bool $recursive = null): array;
}
