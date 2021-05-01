<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\Runtime\OutOfBoundsException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;

/**
 * Math
 */
class Math
{
    /**
     * @var Php
     */
    protected $php;
    /**
     * @var Type
     */
    protected $type;


    /**
     * Constructor
     *
     * @param Php  $php
     * @param Type $type
     */
    public function __construct(
        Php $php,
        Type $type
    )
    {
        $this->php = $php;
        $this->type = $type;
    }


    /**
     * @param           $src
     * @param null|bool $coalesce
     *
     * @return bool
     */
    public function isPositive($src, bool $coalesce = null) : bool
    {
        $coalesce = $coalesce ?? false;

        $srcNum = null
            ?? ( $this->type->isNumber($src) ? $src : null )
            ?? ( $coalesce ? floatval($src) : null )
            ?? null;

        if (null !== $srcNum) {
            return $srcNum > 0;
        }

        return false;
    }

    /**
     * @param           $src
     * @param null|bool $coalesce
     *
     * @return bool
     */
    public function isNegative($src, bool $coalesce = null) : bool
    {
        $coalesce = $coalesce ?? false;

        $srcNum = null
            ?? ( $this->type->isNumber($src) ? $src : null )
            ?? ( $coalesce ? floatval($src) : null )
            ?? null;

        if (null !== $srcNum) {
            return $srcNum < 0;
        }

        return false;
    }


    /**
     * @param           $src
     * @param null|bool $coalesce
     *
     * @return bool
     */
    public function isNonPositive($src, bool $coalesce = null) : bool
    {
        $coalesce = $coalesce ?? false;

        $srcNum = null
            ?? ( $this->type->isNumber($src) ? $src : null )
            ?? ( $coalesce ? floatval($src) : null )
            ?? null;

        if (null !== $srcNum) {
            return $srcNum <= 0;
        }

        return false;
    }

    /**
     * @param           $src
     * @param null|bool $coalesce
     *
     * @return bool
     */
    public function isNonNegative($src, bool $coalesce = null) : bool
    {
        $coalesce = $coalesce ?? false;

        $srcNum = null
            ?? ( $this->type->isNumber($src) ? $src : null )
            ?? ( $coalesce ? floatval($src) : null )
            ?? null;

        if (null !== $srcNum) {
            return $srcNum >= 0;
        }

        return false;
    }


    /**
     * @param int|float      $value
     * @param null|int|float $sum
     *
     * @return float
     */
    public function ratio($value, $sum = null) : float
    {
        if (! $this->type->isNumber($value)) {
            throw new InvalidArgumentException('Value should be number');
        }

        if (isset($sum) && ! $this->type->isNumber($sum)) {
            throw new InvalidArgumentException('Sum should be number');
        }

        $sum = $sum ?? 1;

        $result = min(1, max(-1, $value / $sum));

        return $result;
    }

    /**
     * @param int|float      $value
     * @param null|int|float $sum
     *
     * @return int
     */
    public function percent($value, $sum = null) : int
    {
        if (! $this->type->isNumber($value)) {
            throw new InvalidArgumentException('Value should be number');
        }

        if (isset($sum) && ! $this->type->isNumber($sum)) {
            throw new InvalidArgumentException('Sum should be number');
        }

        $sum = $sum ?? 1;

        $result = (int) round(( $value / $sum ) * 100);

        return $result;
    }


    /**
     * @param int|float $value
     *
     * @return null|int|float
     */
    public function positive($value)
    {
        if (! $this->type->isNumber($value)) {
            throw new InvalidArgumentException('Value should be number');
        }

        $result = $value > 0
            ? $value
            : null;

        return $result;
    }

    /**
     * @param int|float $value
     *
     * @return null|int|float
     */
    public function negative($value)
    {
        if (! $this->type->isNumber($value)) {
            throw new InvalidArgumentException('Value should be number');
        }

        $result = $value < 0
            ? $value
            : null;

        return $result;
    }


    /**
     * @param int|float $value
     * @param null|int  $decimals
     *
     * @return int|float
     */
    public function moneyround($value, int $decimals = null)
    {
        if (! $this->type->isNumber($value)) {
            throw new InvalidArgumentException('Value should be number');
        }

        $decimals = $decimals ?? 0;

        $result = round($value, $decimals);
        $sign = null
            ?? ( $value > 0 ? 1 : null )
            ?? ( $value < 0 ? -1 : null );

        $result += $value !== $result
            ? $sign * ( 1 / pow(10, $decimals) )
            : 0;

        return $result;
    }


    /**
     * @param int|float ...$values
     *
     * @return int|float
     */
    public function sum(...$values)
    {
        [ 1 => $args ] = $this->php->kwargsFlatten(...$values);

        if (! $this->type->isList($args, [ $this->type, 'isNumber' ])) {
            throw new InvalidArgumentException('Each rate should be number');
        }

        $result = array_sum($args);

        return $result;
    }

    /**
     * @param int|float ...$values
     *
     * @return int|float
     */
    public function avg(...$values) : float
    {
        [ 1 => $args ] = $this->php->kwargsFlatten(...$values);

        if (! $this->type->isList($args, [ $this->type, 'isNumber' ])) {
            throw new InvalidArgumentException('Each rate should be number');
        }

        $sum = $this->sum(...$args);
        $len = count($args);

        $avg = $len
            ? ( $sum / $len )
            : 0;

        return $avg;
    }


    /**
     * @param int|float     $sum
     * @param int[]|float[] $rates
     * @param null|int      $decimals
     *
     * @return int[]|float[]
     */
    public function share($sum, array $rates, int $decimals = null) : array
    {
        if (! $this->type->isNumber($sum)) {
            throw new InvalidArgumentException('Sum should be number');
        }

        if (! $this->type->isList($rates, [ $this->type, 'isNumber' ])) {
            throw new InvalidArgumentException('Each rate should be number');
        }

        $result = [];

        $ratesIndexes = array_keys($rates);
        $ratesSum = $this->sum($rates);

        if ($ratesSum <= 0) {
            throw new OutOfBoundsException('Sum of rates should be positive');
        }

        $mod = 0;
        $dec = 1;
        $safe = false;
        if (null === $decimals) {
            $decimals = max($decimals, 0);
            $dec = 1 / pow(10, $decimals);

            $safe = true;
        }

        $quota = $sum / $ratesSum;

        foreach ( $ratesIndexes as $i ) {
            if (! $safe) {
                $result[ $i ] = $quota * $rates[ $i ];

            } else {
                $val = $quota * $rates[ $i ];
                $floor = floor($val / $dec) * $dec;

                $result[ $i ] = $floor;
                $mod += $val - $floor;
            }
        }

        if ($safe) {
            $result[] = round($mod / $dec) * $dec;
        }

        return $result;
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
    public function balance($sum, array $rates, array $freezes = [], int $decimals = null) : array
    {
        if (! $this->type->isNumber($sum)) {
            throw new InvalidArgumentException('Sum should be number', $sum);
        }

        if (! $this->type->isList($rates, [ $this->type, 'isNumber' ])) {
            throw new InvalidArgumentException('Each rate should be number', $rates);
        }

        if (! $this->type->isList($freezes, [ $this->type, 'isNumber' ])) {
            throw new InvalidArgumentException('Each rate should be number', $freezes);
        }

        if ($sum <= 0) {
            throw new OutOfBoundsException('Sum should be positive', $sum);
        }

        $keysRates = array_keys($rates);
        $keysFreezes = array_keys($freezes);

        $sumRates = $this->sum($rates);
        $sumFreezes = $this->sum($freezes);

        if ($sumRates <= 0) {
            throw new OutOfBoundsException('SumRates should be positive', $sumRates);
        }

        if ($sumFreezes > $sum) {
            throw new OutOfBoundsException('SumFreezes should be smaller than sum', [ $sumFreezes, $sum ]);
        }

        $mod = 0;
        $dec = 1;
        $safe = false;
        if (null === $decimals) {
            $decimals = max($decimals, 0);
            $dec = 1 / pow(10, $decimals);

            $safe = true;
        }

        $keysResult = array_unique($keysRates, $keysFreezes);

        $result = array_fill(0, max($keysResult) + 1, 0);

        $keysAll = $keysResult;

        $src = [];
        $diff = [];
        foreach ( $keysAll as $k ) {
            $rate = $rates[ $k ] ?? 0;
            $freeze = $freezes[ $k ] ?? 0;

            $src[ $k ] = ( $rate / $sumRates ) * $sum;
            $diff[ $k ] = $src[ $k ] - $freeze;
        }

        $keysShare = array_diff($keysResult, $keysFreezes);

        foreach ( $keysFreezes as $i ) {
            if ($diff[ $i ] > 0) {
                $shareRates = [];
                foreach ( $keysShare as $k ) {
                    $shareRates[ $k ] = $src[ $k ];
                }

                $ratios = $this->balanceRatios($shareRates);

                foreach ( $keysShare as $ii ) {
                    $value = $ratios[ $ii ] * $diff[ $i ];

                    $src[ $i ] -= $value;
                    $src[ $ii ] += $value;
                }

                $src[ $i ] = $freezes[ $i ];
            }
        }

        $shareRates = [];
        foreach ( $keysShare as $k ) {
            $shareRates[ $k ] = $src[ $k ];
        }

        $sumShare = $this->sum($shareRates);

        foreach ( $keysFreezes as $i ) {
            if ($diff[ $i ] < 0) {
                foreach ( $keysShare as $ii ) {
                    $val = $src[ $ii ] - $src[ $ii ] * ( ( $sumShare + $diff[ $i ] ) / $sumShare );

                    $src[ $ii ] -= $val;
                    $src[ $i ] += $val;
                }

                $sumShare += $diff[ $i ];
            }
        }

        foreach ( $keysResult as $i ) {
            $result[ $i ] = $src[ $i ];
        }

        if ($safe) {
            foreach ( $keysResult as $i ) {
                $value = $result[ $i ];
                $floor = floor($value / $dec) * $dec;

                $mod += $value - $floor;

                $result[ $i ] = $floor;
            }

            $result[] = round($mod / $dec) * $dec;
        }

        return $result;
    }

    /**
     * @param array $rates
     *
     * @return array
     */
    public function balanceRatios(array $rates) : array
    {
        if (! $this->type->isList($rates, [ $this->type, 'isNumber' ])) {
            throw new InvalidArgumentException('Each rate should be number');
        }

        $result = [];

        $ratesSum = $this->sum($rates);
        $ratesIndexes = array_keys($rates);

        $valuesIndexes = [];
        $zeroIndexes = [];

        $cmp = [];
        $cmpLen = 0;
        foreach ( $ratesIndexes as $i ) {
            if (! $rates[ $i ]) {
                $zeroIndexes[ $i ] = true;

            } else {
                $valuesIndexes[ $i ] = true;

                $cmp[] = $rates[ $i ];
                $cmpLen++;
            }
        }

        $zeroRate = 1;
        if (count($cmp)) {
            $minRate = min(...$cmp);
            $maxRate = max(...$cmp);

            if ($maxRate) {
                $zeroRate = $minRate / $maxRate;
            }
        }

        foreach ( $valuesIndexes as $i ) {
            $result[ $i ] = ( $rates[ $i ] / $ratesSum ) * ( 1 - ( $zeroRate / $cmpLen ) );
        }
        $resultSum = $this->sum($result);
        $zeroSum = 1 - $resultSum;

        foreach ( $zeroIndexes as $i ) {
            $result[ $i ] = $zeroSum / count($zeroIndexes);
        }

        return $result;
    }
}
