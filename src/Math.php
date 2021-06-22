<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;
use Gzhegow\Support\Exceptions\Runtime\OutOfBoundsException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Exceptions\Runtime\UnexpectedValueException;


/**
 * Math
 */
class Math
{
    /**
     * @var Filter
     */
    protected $filter;
    /**
     * @var Num
     */
    protected $num;

    /**
     * @var int
     */
    protected $scale;
    /**
     * @var int
     */
    protected $scaleMax = 20;


    /**
     * Constructor
     *
     * @param Filter $filter
     * @param Num    $num
     */
    public function __construct(
        Filter $filter,
        Num $num
    )
    {
        $this->filter = $filter;
        $this->num = $num;
    }


    /**
     * @param null|int $scale
     * @param null|int $scaleMax
     *
     * @return static
     */
    public function clone(int $scale = null, int $scaleMax = null)
    {
        $instance = clone $this;

        $instance->with($scale, $scaleMax);

        return $instance;
    }

    /**
     * @param null|int $scale
     * @param null|int $scaleMax
     *
     * @return static
     */
    public function with(int $scale = null, int $scaleMax = null)
    {
        if (is_int($scale)) $this->withScale($scale);
        if (is_int($scaleMax)) $this->withScaleMax($scaleMax);

        return $this;
    }


    /**
     * @param int $scale
     *
     * @return static
     */
    public function withScale(int $scale)
    {
        $this->scale = $scale;

        return $this;
    }

    /**
     * @param int $scaleMax
     *
     * @return static
     */
    public function withScaleMax(int $scaleMax)
    {
        $this->scaleMax = $scaleMax;

        return $this;
    }


    /**
     * @return static
     */
    public function withoutScale()
    {
        $this->scale = null;

        return $this;
    }


    /**
     * @return int
     */
    public function getScale() : int
    {
        return $this->scale;
    }

    /**
     * @return int
     */
    public function getScaleMax() : int
    {
        return $this->scaleMax;
    }


    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public function isPositive($value) : bool
    {
        return null !== $this->filterPositive($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public function isNonNegative($value) : bool
    {
        return null !== $this->filterNonNegative($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public function isNegative($value) : bool
    {
        return null !== $this->filterNegative($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public function isNonPositive($value) : bool
    {
        return null !== $this->filterNonPositive($value);
    }


    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public function filterPositive($value) // : ?int|float|string
    {
        if (null === ( $bcval = $this->bcval($value) )) {
            return null;
        }

        // scale will be calculated
        if (1 === $this->bccomp($bcval, 0)) {
            return $value;
        }

        return null;
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public function filterNonNegative($value) // : ?int|float|string
    {
        if (null === ( $bcval = $this->bcval($value) )) {
            return null;
        }

        // scale will be calculated
        if (-1 !== $this->bccomp($bcval, 0)) {
            return $value;
        }

        return null;
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public function filterNegative($value) // : ?int|float|string
    {
        if (null === ( $bcval = $this->bcval($value) )) {
            return null;
        }

        // scale will be calculated
        if (-1 === $this->bccomp($bcval, 0)) {
            return $value;
        }

        return null;
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public function filterNonPositive($value) // : ?int|float|string
    {
        if (null === ( $bcval = $this->bcval($value) )) {
            return null;
        }

        // scale will be calculated
        if (1 !== $this->bccomp($bcval, 0)) {
            return $value;
        }

        return null;
    }


    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public function assertPositive($value) // : int|float|string
    {
        if (null === $this->filterPositive($value)) {
            throw new InvalidArgumentException(
                [ 'Invalid Positive passed: %s', $value ]
            );
        }

        return $value;
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public function assertNonNegative($value) // : int|float|string
    {
        if (null === $this->filterNonNegative($value)) {
            throw new InvalidArgumentException(
                [ 'Invalid NonNegative passed: %s', $value ]
            );
        }

        return $value;
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public function assertNegative($value) // : int|float|string
    {
        if (null === $this->filterNegative($value)) {
            throw new InvalidArgumentException(
                [ 'Invalid Negative passed: %s', $value ]
            );
        }

        return $value;
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public function assertNonPositive($value) // : int|float|string
    {
        if (null === $this->filterNonPositive($value)) {
            throw new InvalidArgumentException(
                [ 'Invalid NonPositive passed: %s', $value ]
            );
        }

        return $value;
    }


    /**
     * @param int|mixed              $scale
     * @param int|float|string|mixed ...$numbers
     *
     * @return null|int
     */
    public function scaleVal($scale, ...$numbers) : ?int
    {
        if (null === ( $scaleVal = $this->num->intval($scale ?? $this->scale) )) {
            $scaleVal = $this->fraclen($numbers);
        }

        if (null === $this->filter->filterNonNegative($scaleVal)) {
            return null;
        }

        return $scaleVal;
    }

    /**
     * @param int|mixed              $scale
     * @param int|float|string|mixed ...$numbers
     *
     * @return int
     */
    public function theScaleVal($scale, ...$numbers) : int
    {
        if (null === ( $scaleVal = $this->scaleVal($scale, ...$numbers) )) {
            throw new InvalidArgumentException(
                [ 'Value should be convertable to scale: %s', $scale ],
            );
        }

        return $scaleVal;
    }


    /**
     * @param int|float|string|mixed $number
     *
     * @return null|string
     */
    public function bcval($number) : ?string
    {
        if (! ( is_string($number) || is_float($number) || is_int($number) )) {
            return null;
        }

        if ('' === $number) {
            return null;

        } elseif (is_int($number)) {
            $bcval = $number;

        } else {
            if (is_float($number)) {
                $frac = '';

                if (false !== ( $pos = strchr($number, '.') )) {
                    $frac = substr($pos, 1);
                }

                $bcval = sprintf('%.' . strlen($frac) . 'f', $number);

            } elseif (is_numeric($number)) {
                $bcval = $number;

            } else {
                $bcval = str_replace(' ', '', $number);
                $bcval = str_replace([ '.', ',' ], '.', $bcval, $cnt);

                if ($cnt > 1) {
                    return null;
                }

                if (strrpos($bcval, '-')) {
                    return null;
                }

                $ctype = str_replace([ '-', '.' ], '', $bcval);
                if (! ctype_digit($ctype)) {
                    return null;
                }
            }

            if (false !== strpos($bcval, '.')) {
                $bcval = rtrim($bcval, '0');
                $bcval = rtrim($bcval, '.');
            }
        }

        return $bcval;
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return string
     */
    public function theBcval($value) : string
    {
        if (null === ( $bcval = $this->bcval($value) )) {
            throw new InvalidArgumentException(
                [ 'Value should be convertable to bcnumval: %s', $value ],
            );
        }

        return $bcval;
    }


    /**
     * Возвращает дробную часть числа
     *
     * @param int|float|string|mixed $number
     *
     * @return string
     */
    public function frac($number) : string
    {
        $bcval = $this->theBcval($number);

        $result = '';

        if (false !== ( $pos = strrchr($bcval, '.') )) {
            $result = substr($pos, 1);
        }

        return $result;
    }

    /**
     * Определяет максимальное число знаков после запятой из переданных чисел
     *
     * @param int|float|string|array $numbers
     * @param null|int               $scaleMax
     *
     * @return int
     */
    public function fraclen($numbers, int $scaleMax = null) : int
    {
        $scaleMax = $scaleMax ?? $this->scaleMax ?? 0;

        $bcvals = $this->theBcvals($numbers);

        $scales[] = 0;
        foreach ( $bcvals as $l ) {
            $scales[] = strlen($this->frac($l));
        }

        $max = max($scales);

        if ($max > $scaleMax) {
            throw new UnexpectedValueException(
                [
                    'Fractional length `%s` is bigger than allowed maximum %s'
                    . ' - '
                    . 'Change business logic (possible periodic float passed)',
                    $max,
                    $scaleMax,
                ]
            );
        }

        return $max;
    }


    /**
     * Округление
     *
     * @param int|float|mixed $number
     * @param null|int        $scale
     *
     * @return int|float
     */
    public function round($number, int $scale = null) // : int|float
    {
        $scale = $this->theScaleVal($scale ?? 0);

        $numval = $this->num->theNumval($number);

        $result = round($numval, $scale);

        return $result;
    }

    /**
     * Округляет в меньшую сторону
     *
     * @param int|float|string|mixed $number
     * @param null|int               $scale
     *
     * @return int|float
     */
    public function floor($number, int $scale = null) // : int|float
    {
        $scale = $this->theScaleVal($scale ?? 0);

        $numval = $this->num->theNumval($number);

        $result = $numval;

        if (intval($numval) !== $numval) {
            $fmod = floatval($this->bcadd($numval, 0, $scale));
            $bonus = $numval != $fmod
                ? ( 1 / pow(10, $scale) )
                : 0;

            $result = $numval < 0
                ? $fmod - $bonus
                : $fmod;
        }

        return $result;
    }

    /**
     * Округляет в большую сторону
     *
     * @param int|float|string|mixed $number
     * @param null|int               $scale
     *
     * @return int|float
     */
    public function ceil($number, int $scale = null) // : int|float
    {
        $scale = $this->theScaleVal($scale ?? 0);

        $numval = $this->num->theNumval($number);

        $result = $numval;

        if (intval($numval) !== $numval) {
            $fmod = floatval($this->bcadd($numval, 0, $scale));
            $bonus = $numval != $fmod
                ? ( 1 / pow(10, $scale) )
                : 0;

            $result = $numval > 0
                ? $fmod + $bonus
                : $fmod;
        }

        return $result;
    }


    /**
     * @param int|float ...$values
     *
     * @return null|int|float
     */
    public function max(...$values) // : ?int|float
    {
        $numvals = $this->num->theNumvals(...$values);

        $result = $numvals
            ? max($numvals)
            : null;

        return $result;
    }

    /**
     * @param int|float ...$values
     *
     * @return null|int|float
     */
    public function min(...$values) // : int|float
    {
        $numvals = $this->num->theNumvals(...$values);

        $result = $numvals
            ? min($numvals)
            : null;

        return $result;
    }


    /**
     * @param int|float ...$values
     *
     * @return int|float
     */
    public function sum(...$values) // : int|float
    {
        $numvals = $this->num->theNumvals(...$values);

        $result = $numvals
            ? array_sum($numvals)
            : 0;

        return $result;
    }

    /**
     * @param int|float ...$values
     *
     * @return float
     */
    public function avg(...$values) : float
    {
        $numvals = $this->num->theNumvals(...$values);

        $avg = null;

        if ($numvals) {
            $sum = array_sum($numvals);

            $avg = $sum / count($numvals);
        }

        return $avg;
    }

    /**
     * @param int|float ...$values
     *
     * @return null|int|float
     */
    public function median(...$values) // : ?int|float
    {
        $numvals = $this->num->theNumvals(...$values);

        $median = null;

        if ($numvals) {
            sort($numvals);

            $numvals = array_values($numvals);

            $idx = count($numvals) / 2;

            $median = is_int($idx)
                ? ( ( $numvals[ $idx ] + $numvals[ $idx + 1 ] ) / 2 )
                : ( $numvals[ round($idx) - 1 ] );
        }

        return $median;
    }


    /**
     * @param int|float      $value
     * @param null|int|float $sum
     *
     * @return float
     */
    public function ratio($value, $sum = null) : float
    {
        $sum = $sum ?? 1;

        $value = $this->num->theNumval($value);
        $sum = $this->num->theNumval($sum);

        $valueNegative = $value < 0;
        $sumNegative = $sum < 0;

        if ($sum == 0) {
            throw new InvalidArgumentException(
                [ 'Sum should be not zero: %s', $sum ]
            );
        }

        if ($valueNegative !== $sumNegative) {
            throw new InvalidArgumentException(
                [ 'Both sum and value should be greater or less than zero: %s', $sum ]
            );
        }

        $result = $value / abs($sum);

        return $result;
    }

    /**
     * @param int|float      $value
     * @param null|int|float $sum
     *
     * @return float
     */
    public function percent($value, $sum = null) : float
    {
        $result = $this->ratio($value, $sum) * 100;

        return $result;
    }


    /**
     * @param int|float      $from
     * @param null|int|float $to
     *
     * @return float
     */
    public function rand($from, $to = null) : float
    {
        $to = $to ?? $from;

        $from = $this->num->theNumval($from);
        $to = $this->num->theNumval($to);

        $scaleMax = $this->fraclen([ $from, $to ]);

        $pow = pow(10, $scaleMax);

        $result = mt_rand(
            $from * $pow,
            $to * $pow
        );

        $result = $result / $pow;

        return $result;
    }


    /**
     * Рассчитывает соотношение долей между собой
     *
     * @param int|float|array $rates
     *
     * @return float[]
     */
    public function rates(...$rates) : array
    {
        $ratesNum = $this->num->theNumvals(...$rates);

        if (! $ratesNum) {
            throw new InvalidArgumentException(
                [ 'At least one rate should be passed: %s', $rates ]
            );
        }

        foreach ( $ratesNum as $r ) {
            $this->filter
                ->assert([ 'Each rate should be non-negative: %s', $r ])
                ->assertNonNegative($r);
        }

        $ratesIndexes = array_keys($ratesNum);
        $ratesSum = array_sum($ratesNum);

        $result = [];

        foreach ( $ratesIndexes as $i => $bool ) {
            $result[ $i ] = $ratesNum[ $i ] / $ratesSum;
        }

        return $result;
    }

    /**
     * Рассчитывает соотношение долей между собой
     * Нулевые соотношения получают пропорционально их количества - чем нулей больше, тем меньше каждому
     * В то же время нули получают тем больше, чем ближе минимальное и максимальное без учета самих нулей
     *
     * @param int|float|array $rates
     *
     * @return float[]
     */
    public function ratesZero(...$rates) : array
    {
        $ratesNum = $this->num->theNumvals(...$rates);

        if (! $ratesNum) {
            throw new InvalidArgumentException(
                [ 'At least one rate should be passed: %s', $rates ]
            );
        }

        foreach ( $ratesNum as $r ) {
            $this->filter
                ->assert([ 'Each rate should be non-negative: %s', $r ])
                ->assertNonNegative($r);
        }

        $ratesIndexes = array_keys($ratesNum);
        $ratesSum = array_sum($ratesNum);

        $zeros = [];
        $values = [];
        foreach ( $ratesIndexes as $i ) {
            ( 0 == $ratesNum[ $i ] )
                ? ( $zeros[ $i ] = $ratesNum[ $i ] )
                : ( $values[ $i ] = $ratesNum[ $i ] );
        }

        $countValues = count($values);

        $zeroRatio = 0;
        if (count($zeros)) {
            $minRate = min($values);
            $maxRate = max($values);

            if ($maxRate) {
                $zeroRatio = $minRate / $maxRate;
            }
        }

        $result = [];
        foreach ( $values as $i => $bool ) {
            $result[ $i ] = 1
                * ( $ratesNum[ $i ] / $ratesSum )
                * ( 1 - ( $zeroRatio / $countValues ) );
        }

        $zeroSum = 1 - array_sum($result);

        foreach ( $zeros as $i => $bool ) {
            $result[ $i ] = $zeroSum / count($zeros);
        }

        return $result;
    }


    /**
     * Очень социалистическая функция :)
     * Балансирует общую сумму между получателями учитывая заранее известные ("замороженные") значения
     * Заберет у тех, у кого много, раздаст тем, кому мало, недостающее выдаст из суммы
     * Создавалась для взаимозависимого эквалайзера - двигаешь один ползунок - остальные равномерно меняются
     *
     * 65; [ 5,10,50 ]; [ ,,20 ]
     * 5x + 10x + 50x = 65
     * ((5 + 10 + 50) - 20) = 45
     * [ 3, 7, 35 ] + [ , , 20 ]
     * 3x + 7x = 35
     * [ 13.5, 31.5, 20 ] -> round...
     * [ 14, 31, 20 ]
     *
     * @param int|float            $sum
     * @param int|float|array      $ratesNeedle
     * @param null|int|float|array $ratesFreezes
     *
     * @return array
     */
    public function balance($sum, $ratesNeedle, $ratesFreezes = null) : array
    {
        $sum = $this->num->theNumval($sum);

        $ratesNeedleNum = is_array($ratesNeedle)
            ? $ratesNeedle
            : [ $ratesNeedle ];

        $ratesFreezesNum = is_array($ratesFreezes)
            ? $ratesFreezes
            : [ $ratesFreezes ];

        $ratesNeedleNum = array_filter($ratesNeedleNum, 'strlen');
        $ratesFreezesNum = array_filter($ratesFreezesNum, 'strlen');

        $this->filter
            ->assert('Sum should be non-negative: %s', $sum)
            ->assertNonNegative($sum);

        if (! $ratesNeedleNum) {
            throw new InvalidArgumentException(
                [ 'At least one rate should be passed: %s', $ratesNeedle ]
            );
        }

        foreach ( $ratesNeedleNum as $r ) {
            $this->filter
                ->assert('Each rate should be non-negative: %s', $r)
                ->assertNonNegative($r);
        }

        $sumRates = array_sum($ratesNeedleNum);
        $sumFreezes = array_sum($ratesFreezesNum);

        if ($sumFreezes > $sum) {
            throw new OutOfBoundsException(
                [ 'SumFreezes should be less than or equal to sum: [%s, %s]', [ $sumFreezes, $sum ] ]
            );
        }

        $keysRates = array_keys($ratesNeedleNum);
        $keysFreezes = array_keys($ratesFreezesNum);
        $keysAll = array_values(
            array_unique(array_merge(
                $keysRates,
                $keysFreezes
            ))
        );
        $keysShare = array_diff($keysAll, $keysFreezes);

        $result = array_fill(0, max($keysAll) + 1, 0);

        $src = [];
        $diff = [];
        foreach ( $keysAll as $k ) {
            $rate = $ratesNeedleNum[ $k ] ?? 0;
            $freeze = $ratesFreezesNum[ $k ] ?? 0;

            $src[ $k ] = ( $rate / $sumRates ) * $sum;
            $diff[ $k ] = $src[ $k ] - $freeze;
        }

        foreach ( $keysFreezes as $i ) {
            if ($diff[ $i ] > 0) {
                $ratesShare = [];
                foreach ( $keysShare as $k ) {
                    $ratesShare[ $k ] = $src[ $k ];
                }

                $ratesShare = $this->ratesZero($ratesShare);

                foreach ( $keysShare as $ii ) {
                    $value = $ratesShare[ $ii ] * $diff[ $i ];

                    $src[ $i ] -= $value;
                    $src[ $ii ] += $value;
                }

                $src[ $i ] = $ratesFreezesNum[ $i ];
            }
        }

        $ratesShare = [];
        foreach ( $keysShare as $k ) {
            $ratesShare[ $k ] = $src[ $k ];
        }

        $sumShare = array_sum($ratesShare);

        foreach ( $keysFreezes as $i ) {
            if ($diff[ $i ] < 0) {
                foreach ( $keysShare as $ii ) {
                    $ratio = ( $sumShare + $diff[ $i ] ) / $sumShare;
                    $val = $src[ $ii ] - ( $ratio * $src[ $ii ] );

                    $src[ $ii ] -= $val;
                    $src[ $i ] += $val;
                }

                $sumShare += $diff[ $i ];
            }
        }

        foreach ( $keysAll as $i ) {
            $result[ $i ] = $src[ $i ];
        }

        // $mod = 0;
        // if ($safe) {
        //     foreach ( $keysResult as $i ) {
        //         $val = $result[ $i ];
        //
        //         $floor = floor($val / $dec) * $dec;
        //         $mod += $val - $floor;
        //
        //         $result[ $i ] = $floor;
        //     }
        //
        //     $result[] = round($mod / $dec) * $dec;
        // }

        return $result;
    }


    /**
     * @param int|float|string $a
     * @param int|float|string $b
     * @param null|int         $scale
     *
     * @return string
     */
    public function bccomp($a, $b, int $scale = null)
    {
        return bccomp(
            $this->theBcval($a),
            $this->theBcval($b),
            $this->theScaleVal($scale, $a, $b)
        );
    }


    /**
     * @param int|float|string $a
     * @param int|float|string $b
     * @param null|int         $scale
     *
     * @return string
     */
    public function bcadd($a, $b, int $scale = null)
    {
        return bcadd(
            $this->theBcval($a),
            $this->theBcval($b),
            $this->theScaleVal($scale, $a, $b)
        );
    }

    /**
     * @param int|float|string $a
     * @param int|float|string $b
     * @param null|int         $scale
     *
     * @return string
     */
    public function bcsub($a, $b, int $scale = null)
    {
        return bcsub(
            $this->theBcval($a),
            $this->theBcval($b),
            $this->theScaleVal($scale, $a, $b)
        );
    }

    /**
     * @param int|float|string $a
     * @param int|float|string $b
     * @param null|int         $scale
     *
     * @return string
     */
    public function bcmul($a, $b, int $scale = null)
    {
        $scale = $scale ?? $this->scale;

        if (is_null($scale)) {
            if ($scaleRequired = $this->fraclen($a) && $this->fraclen($b)) {
                throw new BadMethodCallException(
                    [ 'You should pass `scale` cause of you multiply both fractional numbers: [ %s, %s ]', $a, $b ]
                );
            }
        }

        return bcmul(
            $this->theBcval($a),
            $this->theBcval($b),
            $this->theScaleVal($scale, $a, $b)
        );
    }

    /**
     * @param int|float|string $a
     * @param int|float|string $b
     * @param null|int         $scale
     *
     * @return string
     */
    public function bcdiv($a, $b, int $scale = null)
    {
        $scale = $scale ?? $this->scale;

        if (is_null($scale)) {
            throw new BadMethodCallException(
                [ 'You should pass `scale` cause of you using division: [ %s, %s ]', $a, $b ]
            );
        }

        return bcdiv(
            $this->theBcval($a),
            $this->theBcval($b),
            $this->theScaleVal($scale, $a, $b)
        );
    }


    /**
     * @param int|float|string $val
     * @param int|float|string $exp
     * @param null|int         $scale
     *
     * @return string
     */
    public function bcpow($val, $exp, int $scale = null)
    {
        $scale = $scale ?? $this->scale;

        if (is_null($scale)) {
            if ($scaleRequired = $this->fraclen($val) || $this->fraclen($exp)) {
                throw new BadMethodCallException(
                    [ 'You should pass `scale` cause of you exponentiate fractional number: [ %s, %s ]', $val, $exp ]
                );
            }
        }

        return bcpow(
            $this->theBcval($val),
            $this->theBcval($exp),
            $this->theScaleVal($scale, $val, $exp)
        );
    }


    /**
     * Получает минуса или пустой строки если число отрицательное
     *
     * @param int|float|string|mixed $number
     *
     * @return string
     */
    public function bcminus($number) : string
    {
        $result = $this->theBcval($number);

        $minus = strpos($result, '-') === 0
            ? '-'
            : '';

        return $minus;
    }

    /**
     * Получает значение по модулю от числа
     *
     * @param int|float|string|mixed $number
     *
     * @return string
     */
    public function bcabs($number) : string
    {
        $result = $this->theBcval($number);

        $minus = strpos($result, '-') === 0
            ? '-'
            : '';

        $abs = $minus
            ? substr($result, 1)
            : $result;

        return $abs;
    }


    /**
     * Округление
     *
     * @param int|float|string|mixed $number
     * @param null|int               $scale
     *
     * @return string
     */
    public function bcround($number, int $scale = null) : string
    {
        $scale = $this->theScaleVal($scale ?? 0);

        $bcval = $this->theBcval($number);

        $result = $bcval;

        if ($hasDecimals = false !== strpos($bcval, '.')) {
            $result = $this->bcminus($bcval)
                ? $this->bcsub($bcval, '0.' . str_repeat('0', $scale) . '5', $scale)
                : $this->bcadd($bcval, '0.' . str_repeat('0', $scale) . '5', $scale);
        }

        return $result;
    }

    /**
     * Округляет в меньшую сторону
     *
     * @param int|float|string|mixed $number
     * @param null|int               $scale
     *
     * @return string
     */
    public function bcfloor($number, int $scale = null) : string
    {
        $scale = $this->theScaleVal($scale ?? 0);

        $bcval = $this->theBcval($number);

        $result = $bcval;

        if ($hasDecimals = false !== strpos($bcval, '.')) {
            $fmod = $this->bcadd($bcval, 0, $scale);
            $bonus = $this->bccomp($bcval, $fmod) // scale will be calculated
                ? ( 1 / pow(10, $scale) )
                : 0;

            $result = $this->isNegative($bcval)
                ? $this->bcsub($fmod, $bonus, $scale)
                : $fmod;
        }

        return $result;
    }

    /**
     * Округляет в большую сторону
     *
     * @param int|float|string|mixed $number
     * @param null|int               $scale
     *
     * @return string
     */
    public function bcceil($number, int $scale = null) : string
    {
        $scale = $this->theScaleVal($scale ?? 0);

        $bcval = $this->theBcval($number);

        $result = $bcval;

        if ($hasDecimals = false !== strpos($bcval, '.')) {
            $fmod = $this->bcadd($bcval, 0, $scale);
            $bonus = $this->bccomp($bcval, $fmod) // scale will be calculated
                ? ( 1 / pow(10, $scale) )
                : 0;

            $result = $this->isNegative($bcval)
                ? $fmod
                : $this->bcadd($fmod, $bonus, $scale);
        }

        return $result;
    }


    /**
     * @param int|float|string|array $numbers
     * @param null|int               $scale
     *
     * @return null|string
     */
    public function bcmax($numbers, int $scale = null) : ?string
    {
        $bcvals = $this->theBcvals($numbers);

        $result = null;

        if ($bcvals) {
            natsort($bcvals);

            $result = end($bcvals);

            $result = $this->bcadd($result, 0, $scale);
        }

        return $result;
    }

    /**
     * @param int|float|string|array $numbers
     * @param null|int               $scale
     *
     * @return null|string
     */
    public function bcmin($numbers, int $scale = null) : ?string
    {
        $bcvals = $this->theBcvals($numbers);

        $result = null;

        if ($bcvals) {
            natsort($bcvals);

            $result = reset($bcvals);

            $result = $this->bcadd($result, 0, $scale);
        }

        return $result;
    }


    /**
     * @param int|float|string|array $numbers
     * @param null|int               $scale
     *
     * @return string
     */
    public function bcsum($numbers, int $scale = null) : string
    {
        $bcvals = $this->theBcvals($numbers);

        $result = '0';

        if ($bcvals) {
            foreach ( $bcvals as $l ) {
                $result = $this->bcadd($result, $l); // scale will be calculated
            }

            $result = $this->bcadd($result, 0, $scale);
        }

        return $result;
    }

    /**
     * @param int|float|string|array $numbers
     * @param null|int               $scale
     *
     * @return string
     */
    public function bcavg($numbers, int $scale = null) : string
    {
        $bcvals = $this->theBcvals($numbers);

        $avg = '0.0';

        if ($bcvals) {
            $sum = $this->bcsum($bcvals); // scale will be calculated

            $avg = $this->bcdiv($sum, count($bcvals), $scale);
        }

        return $avg;
    }

    /**
     * @param int|float|string|array $numbers
     * @param null|int               $scale
     *
     * @return null|string
     */
    public function bcmedian($numbers, int $scale = null) : ?string
    {
        $bcvals = $this->theBcvals($numbers);

        $median = null;

        if ($bcvals) {
            natsort($bcvals);

            $bcvals = array_values($bcvals);

            $medianIndex = count($bcvals) / 2;

            if (is_float($medianIndex)) {
                $median = $bcvals[ round($medianIndex) - 1 ];

            } else {
                $median = $this->bcadd($bcvals[ $medianIndex ], $bcvals[ $medianIndex + 1 ]); // scale will be calculated

                $median = $this->bcdiv($median, 2, $scale);
            }
        }

        return $median;
    }


    /**
     * @param int|float      $value
     * @param null|int|float $sum
     * @param null|int       $scale
     *
     * @return float
     */
    public function bcratio($value, $sum = null, int $scale = null) : float
    {
        $sum = $sum ?? '1';

        $value = $this->theBcval($value);
        $sum = $this->theBcval($sum);

        $sumZero = 0 === $this->bccomp($sum, 0); // scale will be calculated

        if ($sumZero) {
            throw new InvalidArgumentException(
                [ 'Sum should be non-zero: %s', $sum ]
            );
        }

        if ($this->isNegative($value) !== $this->isNegative($sum)) {
            throw new InvalidArgumentException(
                [ 'Both sum and value should be greater or less than zero: %s', $sum ]
            );
        }

        $result = $this->bcdiv($value, $this->bcabs($sum), $scale);

        return $result;
    }

    /**
     * @param int|float|string      $value
     * @param null|int|float|string $sum
     * @param null|int              $scale
     *
     * @return float
     */
    public function bcpercent($value, $sum = null, int $scale = null) : float
    {
        $ratio = $this->bcratio($value, $sum, $scale);

        $result = $this->bcmul($ratio, '100', $scale);

        return $result;
    }


    /**
     * @param int|float|string      $from
     * @param null|int|float|string $to
     * @param null|int              $scale
     *
     * @return string
     */
    public function bcrand($from, $to = null, int $scale = null) : string
    {
        $to = $to ?? $from;

        $from = $this->theBcval($from);
        $to = $this->theBcval($to);

        if ($from === $to) {
            return $from;
        }

        $pow = pow(10, $this->fraclen([ $from, $to ]));

        $fromto = [
            $this->bcmul($from, $pow),
            $this->bcmul($to, $pow),
        ];

        natsort($fromto);

        $result = mt_rand($fromto);

        $result = $this->bcdiv($result, $pow, $scale);

        return $result;
    }


    /**
     * Уменьшение по "правилу денег"
     * Урежет дробную часть
     * Обычный floor отбрасывает всю и уменьшает число на единицу даже если отрицательное
     *
     * @param int|float|string|mixed $number
     * @param null|int               $scale
     *
     * @return string
     */
    public function bcmoneyfloor($number, int $scale = null) : string
    {
        $scale = $this->theScaleVal($scale ?? 0);

        $result = $this->bcadd($number, 0, $scale);

        return $result;
    }

    /**
     * Увеличение по "правилу денег"
     * Округлит 1.00000001 до 1.01 (если нужно два знака после запятой)
     *
     * @param int|float|string|mixed $number
     * @param null|int               $scale
     *
     * @return string
     */
    public function bcmoneyceil($number, int $scale = null) : string
    {
        $scale = $this->theScaleVal($scale ?? 0);

        $result = $this->bcminus($number)
            . $this->bcceil($this->bcabs($number), $scale);

        return $result;
    }


    /**
     * @param string|string[]|array $strings
     * @param null|bool             $uniq
     *
     * @return string[]
     */
    public function bcvals($strings, $uniq = null) : array
    {
        $result = [];

        $strings = is_array($strings)
            ? $strings
            : [ $strings ];

        array_walk_recursive($strings, function ($string) use (&$result) {
            $result[] = $this->bcval($string);
        });

        if ($uniq ?? false) {
            $arr = [];
            foreach ( $result as $i ) {
                $arr[ $i ] = true;
            }
            $result = array_keys($arr);
        }

        return $result;
    }

    /**
     * @param string|string[]|array $strings
     * @param null|bool             $uniq
     *
     * @return string[]
     */
    public function theBcvals($strings, $uniq = null) : array
    {
        $result = [];

        $strings = is_array($strings)
            ? $strings
            : [ $strings ];

        array_walk_recursive($strings, function ($string) use (&$result) {
            $result[] = $this->theBcval($string);
        });

        if ($uniq ?? false) {
            $arr = [];
            foreach ( $result as $i ) {
                $arr[ $i ] = true;
            }
            $result = array_keys($arr);
        }

        return $result;
    }


    /**
     * Разбивает сумму между получателями
     * Если разделить 100 на 3 получается 33.33, 33.33, и 33.33 и 0.01 в периоде
     * Функция позволяет разбить исходное число на три, дробная часть от каждого деления достанется первому
     *
     * @param int|float|string       $sum
     * @param int|float|string|array $rates
     * @param null|int               $scale
     *
     * @return int[]|float[]
     */
    public function bcmoneyshare($sum, $rates, int $scale = null) : array
    {
        $sum = $this->theBcval($sum);
        $rates = $this->theBcvals($rates);

        if (! $rates) {
            throw new InvalidArgumentException(
                [ 'At least one rate should be passed: %s', $rates ]
            );
        }

        $this->assertNonNegative($sum);

        foreach ( $rates as $r ) {
            $this->assertNonNegative($r);
        }

        $result = [];

        $ratesIndexes = array_keys($rates);
        $ratesSum = '0';
        foreach ( $rates as $r ) {
            $ratesSum = $this->bcadd($ratesSum, $r); // scale will be calculated
        }

        $this->assertPositive($ratesSum);

        foreach ( $ratesIndexes as $i ) {
            $val = $rates[ $i ];

            $val = $this->bcmul($val, $sum, $scale);
            $val = $this->bcdiv($val, $ratesSum, $scale);

            $floor = $this->bcmoneyfloor($val, $scale);

            $result[ $i ] = $floor;
        }

        $resultSum = $this->bcsum($result); // scale will be calculated

        $mod = $this->bcsub($sum, $resultSum); // scale will be calculated

        $result[ 0 ] = $this->bcadd($result[ 0 ], $mod); // scale will be calculated

        return $result;
    }
}
