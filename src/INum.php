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
use Gzhegow\Support\Traits\Load\StrLoadTrait;

interface INum
{
    /**
     * @param int|mixed $value
     *
     * @return null|int
     */
    public function filterInt($value): ?int;

    /**
     * @param float|mixed $value
     *
     * @return null|float
     */
    public function filterFloat($value): ?float;

    /**
     * @param float|mixed $value
     *
     * @return null|float
     */
    public function filterNan($value): ?float;

    /**
     * @param int|float|mixed $value
     *
     * @return null|int|float
     */
    public function filterNum($value);

    /**
     * @param int|string|mixed $value
     *
     * @return null|int|string
     */
    public function filterIntval($value): ?int;

    /**
     * @param float|string|mixed $value
     *
     * @return null|float|string
     */
    public function filterFloatval($value): ?float;

    /**
     * @param int|float|mixed $value
     *
     * @return null|int|float|string
     */
    public function filterNumval($value);

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public function filterNumericval($value);

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float
     */
    public function filterNumGt0($value);

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float
     */
    public function filterNumGte0($value);

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float
     */
    public function filterNumLt0($value);

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float
     */
    public function filterNumLte0($value);

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
     * @param int|float|string|array $numerics
     * @param null|bool              $uniq
     * @param null|bool              $recursive
     *
     * @return string[]
     */
    public function numericvals($numerics, bool $uniq = null, bool $recursive = null): array;

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
     * @param int|float|string|array $numerics
     * @param null|bool              $uniq
     * @param null|bool              $recursive
     *
     * @return string[]
     */
    public function theNumericvals($numerics, bool $uniq = null, bool $recursive = null): array;

    /**
     * @param string|mixed $number
     * @param string|array $decimalsSeparators
     * @param string|array $thousandsSeparators
     *
     * @return string
     */
    public function numberParse($number, $decimalsSeparators = null, $thousandsSeparators = null): string;

    /**
     * @param int|float|string|mixed $number
     * @param null|int               $decimals
     * @param null|string            $decimalSeparator
     * @param null|string            $thousandSeparator
     *
     * @return string
     */
    public function numberFormat(
        $number,
        int $decimals = null,
        string $decimalSeparator = null,
        string $thousandSeparator = null
    );
}
