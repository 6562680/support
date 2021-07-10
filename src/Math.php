<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Domain\Math\Bcval;
use Gzhegow\Support\SupportFactory;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;
use Gzhegow\Support\Exceptions\Runtime\OutOfBoundsException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * Math
 */
class Math implements IMath
{
    /**
     * @var IFilter
     */
    protected $filter;
    /**
     * @var INum
     */
    protected $num;
    /**
     * @var IStr
     */
    protected $str;


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
     * @param IFilter $filter
     * @param INum    $num
     * @param IStr    $str
     */
    public function __construct(
        IFilter $filter,
        INum $num,
        IStr $str
    )
    {
        $this->filter = $filter;
        $this->num = $num;
        $this->str = $str;
    }


    /**
     * @return static
     */
    public function reset()
    {
        $this->scale = null;
        $this->scaleMax = 20;

        // bcscale(0);

        return $this;
    }


    /**
     * @param null|int $scale
     * @param null|int $scaleMax
     *
     * @return static
     */
    public function clone(?int $scale, ?int $scaleMax)
    {
        $instance = clone $this;

        if (isset($scale)) $this->withScale($scale);
        if (isset($scaleMax)) $this->withScaleMax($scaleMax);

        return $instance;
    }


    /**
     * @param null|int $scale
     * @param null|int $scaleMax
     *
     * @return static
     */
    public function with(?int $scale, ?int $scaleMax)
    {
        $this->reset();

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
        $this->num->theNonNegativeIntval($scale);

        $this->scale = $scale;

        // bcscale($scale);

        return $this;
    }

    /**
     * @param int $scaleMax
     *
     * @return static
     */
    public function withScaleMax(int $scaleMax)
    {
        $this->num->theNonNegativeIntval($scaleMax);

        $this->scaleMax = $scaleMax;

        return $this;
    }


    /**
     * @param string $value
     *
     * @return Bcval
     */
    public function newBcval(string $value) : Bcval
    {
        $bcval = new Bcval($value);

        return $bcval;
    }


    /**
     * @return null|int
     */
    public function getScale() : ?int
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
     * @param int|float|string|Bcval|mixed $value
     *
     * @return null|Bcval
     */
    public function bcPositiveVal($value) : ?Bcval
    {
        if (null === ( $bcval = $this->bcval($value) )) {
            return null;
        }

        // scale will be calculated
        if (1 === $this->bccomp($bcval, 0)) {
            return $bcval;
        }

        return null;
    }

    /**
     * @param int|float|string|Bcval|mixed $value
     *
     * @return null|Bcval
     */
    public function bcNonNegativeVal($value) : ?Bcval
    {
        if (null === ( $bcval = $this->bcval($value) )) {
            return null;
        }

        // scale will be calculated
        if (-1 !== $this->bccomp($bcval, 0)) {
            return $bcval;
        }

        return null;
    }

    /**
     * @param int|float|string|Bcval|mixed $value
     *
     * @return null|Bcval
     */
    public function bcNegativeVal($value) : ?Bcval
    {
        if (null === ( $bcval = $this->bcval($value) )) {
            return null;
        }

        // scale will be calculated
        if (-1 === $this->bccomp($bcval, 0)) {
            return $bcval;
        }

        return null;
    }

    /**
     * @param int|float|string|Bcval|mixed $value
     *
     * @return null|Bcval
     */
    public function bcNonPositiveVal($value) : ?Bcval
    {
        if (null === ( $bcval = $this->bcval($value) )) {
            return null;
        }

        // scale will be calculated
        if (1 !== $this->bccomp($bcval, 0)) {
            return $bcval;
        }

        return null;
    }


    /**
     * @param int|float|string|Bcval|mixed $value
     *
     * @return Bcval
     */
    public function theBcPositiveVal($value) : Bcval
    {
        if (null === ( $bcPositiveVal = $this->bcPositiveVal($value) )) {
            throw new InvalidArgumentException(
                [ 'Value should be positive bcval: %s', $value ],
            );
        }

        return $bcPositiveVal;
    }

    /**
     * @param int|float|string|Bcval|mixed $value
     *
     * @return Bcval
     */
    public function theBcNonNegativeVal($value) : Bcval
    {
        if (null === ( $bcNonNegativeVal = $this->bcNonNegativeVal($value) )) {
            throw new InvalidArgumentException(
                [ 'Value should be non-negative bcval: %s', $value ],
            );
        }

        return $bcNonNegativeVal;
    }

    /**
     * @param int|float|string|Bcval|mixed $value
     *
     * @return Bcval
     */
    public function theBcNegativeVal($value) : Bcval
    {
        if (null === ( $bcNegativeVal = $this->bcNegativeVal($value) )) {
            throw new InvalidArgumentException(
                [ 'Value should be negative bcval: %s', $value ],
            );
        }

        return $bcNegativeVal;
    }

    /**
     * @param int|float|string|Bcval|mixed $value
     *
     * @return Bcval
     */
    public function theBcNonPositiveVal($value) : Bcval
    {
        if (null === ( $bcNonPositiveVal = $this->bcNonPositiveVal($value) )) {
            throw new InvalidArgumentException(
                [ 'Value should be non-positive bcval: %s', $value ],
            );
        }

        return $bcNonPositiveVal;
    }


    /**
     * @param int|mixed                    $scale
     * @param int|float|string|Bcval|mixed ...$numbers
     *
     * @return null|int
     */
    public function scaleVal($scale, ...$numbers) : ?int
    {
        if (null === ( $scaleVal = $this->num->intval($scale ?? $this->scale) )) {
            $scaleVal = $this->fraclen($numbers);
        }

        if (null === $this->num->nonNegativeIntval($scaleVal)) {
            return null;
        }

        return $scaleVal;
    }

    /**
     * @param int|mixed                    $scale
     * @param int|float|string|Bcval|mixed ...$numbers
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
     * @param int|float|string|Bcval|mixed $number
     *
     * @return null|Bcval
     */
    public function bcval($number) : ?Bcval
    {
        if (is_a($number, Bcval::class)) {
            return $number;
        }

        if (is_int($number)) {
            return $this->newBcval($number);
        }

        if ('' === $number) {
            return null;
        }

        if (! ( is_string($number) || is_float($number) )) {
            return null;
        }

        $bcval = null
            ?? $this->bcvalInt($number)
            ?? $this->bcvalNumeric($number);

        if (is_null($bcval)) {
            try {
                $number = $this->numberParse($number);

                $bcval = null
                    ?? $this->bcvalInt($number)
                    ?? $this->bcvalNumeric($number);
            }
            catch ( InvalidArgumentException $e ) {
                return null;
            }
        }

        if (false !== strpos($bcval, '.')) {
            $bcval = rtrim($bcval, '0');
            $bcval = rtrim($bcval, '.');
        }

        $bcval = $this->newBcval($bcval);

        return $bcval;
    }

    /**
     * @param int|float|string|Bcval|mixed $value
     *
     * @return Bcval
     */
    public function theBcval($value) : Bcval
    {
        if (null === ( $bcval = $this->bcval($value) )) {
            throw new InvalidArgumentException(
                [ 'Value should be convertable to bcnumval: %s', $value ],
            );
        }

        return $bcval;
    }


    /**
     * @param string|array $strings
     * @param null|bool    $uniq
     *
     * @return Bcval[]
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
                $arr[ strval($i) ] = true;
            }
            $result = array_keys($arr);
        }

        return $result;
    }

    /**
     * @param string|array $strings
     * @param null|bool    $uniq
     *
     * @return Bcval[]
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
                $arr[ strval($i) ] = true;
            }
            $result = array_keys($arr);
        }

        return $result;
    }


    /**
     * @param int|float|string|Bcval|mixed $number
     * @param null|int                     $decimals
     * @param null|string                  $decimalSeparator
     * @param null|string                  $thousandSeparator
     *
     * @return string
     */
    public function numberFormat($number, int $decimals = null, string $decimalSeparator = null, string $thousandSeparator = null)
    {
        if (null === $this->filter->filterNumericval($number)) {
            throw new InvalidArgumentException([ 'Value should be numeric: %s', $number ]);
        }

        $decimals = $decimals ?? 0;
        $decimalSeparator = $decimalSeparator ?? '.';
        $thousandSeparator = $thousandSeparator ?? '';

        $numberFormat = number_format($number, $decimals, $decimalSeparator, $thousandSeparator);

        return $numberFormat;
    }

    /**
     * @param string|mixed $number
     * @param string|array $decimalsSeparators
     * @param string|array $thousandsSeparators
     *
     * @return string
     */
    public function numberParse($number, $decimalsSeparators = null, $thousandsSeparators = null) : string
    {
        $number = $this->str->theTrimval($number);

        $decimalsSeparators = $this->str->theStrvals($decimalsSeparators ?? '.');
        $thousandsSeparators = $this->str->theStrvals($thousandsSeparators ?? ',');

        $trims = $this->str->getTrims();

        $parsed = str_replace($this->str->split($trims), '', $number);
        $parsed = str_replace($thousandsSeparators, '', $parsed);

        $array = $this->str->explode($decimalsSeparators, $parsed);
        if (count($array) > 2) {
            throw new InvalidArgumentException(
                [ 'NAN: contains two or more decimal separators: %s', $number ]
            );
        }
        $parsed = implode('.', $array);

        if (strrpos($parsed, '-')) {
            throw new InvalidArgumentException(
                [ 'NAN: contains minus not at first position: %s', $number ]
            );
        }

        $ctype = str_replace([ '-', '.' ], '', $parsed);
        if (! ctype_digit($ctype)) {
            [ 'NAN: contains something except numbers and symbols `-`,`.`: %s', $number ];
        }

        return $parsed;
    }


    /**
     * Возвращает дробную часть числа
     *
     * @param int|float|string|Bcval|mixed $number
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
     * @param int|float|string|Bcval|array $numbers
     * @param null|int                     $scaleMax
     *
     * @return int
     */
    public function fraclen($numbers, int $scaleMax = null) : int
    {
        $scaleMax = $this->num->theNonNegativeIntval($scaleMax ?? $this->scaleMax ?? 0);

        $bcvals = $this->theBcvals($numbers);

        $scales[] = 0;
        foreach ( $bcvals as $l ) {
            $scales[] = strlen($this->frac($l));
        }

        $max = max($scales);

        if ($max > $scaleMax) {
            trigger_error(sprintf(
                'Fractional length `%s` is bigger than allowed maximum: %s. '
                . 'Maybe you should change business logic?',
                $max, $scaleMax,
            ));
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
     * @param int|float|mixed $number
     * @param null|int        $scale
     *
     * @return int|float
     */
    public function floor($number, int $scale = null) // : int|float
    {
        $scale = $this->theScaleVal($scale ?? 0);

        $numval = $this->num->theNumval($number);

        $result = $numval;

        if (intval($numval) !== $numval) {
            $fmod = floatval(strval(
                $this->bcadd($numval, 0, $scale)
            ));

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
     * @param int|float|mixed $number
     * @param null|int        $scale
     *
     * @return int|float
     */
    public function ceil($number, int $scale = null) // : int|float
    {
        $scale = $this->theScaleVal($scale ?? 0);

        $numval = $this->num->theNumval($number);

        $result = $numval;

        if (intval($numval) !== $numval) {
            $fmod = floatval(strval(
                $this->bcadd($numval, 0, $scale)
            ));

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
            $this->num->theNonNegativeVal($r);
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
            $this->num->theNonNegativeVal($r);
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

        $this->num->theNonNegativeVal($sum);

        if (! $ratesNeedleNum) {
            throw new InvalidArgumentException(
                [ 'At least one rate should be passed: %s', $ratesNeedle ]
            );
        }

        foreach ( $ratesNeedleNum as $r ) {
            $this->num->theNonNegativeVal($r);
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

        return $result;
    }


    /**
     * @param int|float|string|Bcval|mixed $a
     * @param int|float|string|Bcval|mixed $b
     * @param null|int                     $scale
     *
     * @return int
     */
    public function bccomp($a, $b, int $scale = null) : int
    {
        return bccomp(
            $this->theBcval($a),
            $this->theBcval($b),
            $this->theScaleVal($scale, $a, $b)
        );
    }


    /**
     * @param int|float|string|Bcval|mixed $a
     * @param int|float|string|Bcval|mixed $b
     * @param null|int                     $scale
     *
     * @return Bcval
     */
    public function bcadd($a, $b, int $scale = null) : Bcval
    {
        return $this->newBcval(
            bcadd(
                $this->theBcval($a),
                $this->theBcval($b),
                $this->theScaleVal($scale, $a, $b)
            )
        );
    }

    /**
     * @param int|float|string|Bcval|mixed $a
     * @param int|float|string|Bcval|mixed $b
     * @param null|int                     $scale
     *
     * @return Bcval
     */
    public function bcsub($a, $b, int $scale = null) : Bcval
    {
        return $this->newBcval(
            bcsub(
                $this->theBcval($a),
                $this->theBcval($b),
                $this->theScaleVal($scale, $a, $b)
            )
        );
    }

    /**
     * @param int|float|string|Bcval|mixed $a
     * @param int|float|string|Bcval|mixed $b
     * @param null|int                     $scale
     *
     * @return Bcval
     */
    public function bcmul($a, $b, int $scale = null) : Bcval
    {
        $scale = $scale ?? $this->scale;

        if (is_null($scale)) {
            if ($scaleRequired = $this->fraclen($a) && $this->fraclen($b)) {
                throw new BadMethodCallException(
                    [ 'You should pass `scale` cause of you multiply both fractional numbers: [ %s, %s ]', $a, $b ]
                );
            }
        }

        return $this->newBcval(
            bcmul(
                $this->theBcval($a),
                $this->theBcval($b),
                $this->theScaleVal($scale, $a, $b)
            )
        );
    }


    /**
     * @param int|float|string|Bcval|mixed $a
     * @param int|float|string|Bcval|mixed $b
     * @param null|int                     $scale
     *
     * @return Bcval
     */
    public function bcmod($a, $b, int $scale = null)
    {
        return $this->newBcval(
            bcmod(
                $this->theBcval($a),
                $this->theBcval($b),
                $this->theScaleVal($scale, $a, $b)
            )
        );
    }

    /**
     * @param int|float|string|Bcval|mixed $a
     * @param int|float|string|Bcval|mixed $b
     * @param null|int                     $scale
     *
     * @return Bcval
     */
    public function bcdiv($a, $b, int $scale = null) : Bcval
    {
        $scale = $scale ?? $this->scale;

        if (is_null($scale)) {
            throw new BadMethodCallException(
                [ 'You should pass `scale` cause of you using division: [ %s, %s ]', $a, $b ]
            );
        }

        return $this->newBcval(
            bcdiv(
                $this->theBcval($a),
                $this->theBcval($b),
                $this->theScaleVal($scale, $a, $b)
            )
        );
    }


    /**
     * @param int|float|string|Bcval|mixed $val
     * @param int|float|string|Bcval|mixed $exp
     * @param null|int                     $scale
     *
     * @return Bcval
     */
    public function bcpow($val, $exp, int $scale = null) : Bcval
    {
        $scale = $scale ?? $this->scale;

        if (is_null($scale)) {
            if ($scaleRequired = $this->fraclen($val) || $this->fraclen($exp)) {
                throw new BadMethodCallException(
                    [ 'You should pass `scale` cause of you exponentiate fractionals: [ %s, %s ]', $val, $exp ]
                );
            }
        }

        return $this->newBcval(
            bcpow(
                $this->theBcval($val),
                $this->theBcval($exp),
                $this->theScaleVal($scale, $val, $exp)
            )
        );
    }

    /**
     * @param int|float|string|Bcval|mixed $val
     * @param null|int                     $scale
     *
     * @return Bcval
     */
    public function bcsqrt($val, int $scale = null) : Bcval
    {
        $scale = $scale ?? $this->scale;

        if (is_null($scale)) {
            throw new BadMethodCallException(
                [ 'You should pass `scale` cause of you making square root: [ %s ]', $val ]
            );
        }

        return $this->newBcval(
            bcsqrt(
                $this->theBcval($val),
                $this->scaleVal($scale, $val)
            )
        );
    }


    /**
     * Получает минуса или пустой строки если число отрицательное
     *
     * @param int|float|string|Bcval|mixed $number
     *
     * @return Bcval
     */
    public function bcminus($number) : string
    {
        $bcval = $this->theBcval($number);

        if (! $bcval->hasMinus()) {
            $minus = strpos($bcval, '-') === 0
                ? '-' : '';

            $bcval->withMinus($minus);
        }

        $minus = $bcval->getMinus();

        return $minus;
    }

    /**
     * Получает значение по модулю от числа
     *
     * @param int|float|string|Bcval|mixed $number
     *
     * @return string
     */
    public function bcabs($number) : string
    {
        $bcval = $this->theBcval($number);

        if (! $bcval->hasAbs()) {
            $minus = strpos($bcval, '-') === 0
                ? '-'
                : '';

            $abs = $minus
                ? substr($bcval, 1)
                : $bcval;

            $bcval->withMinus($minus);
            $bcval->withAbs($abs);
        }

        $abs = $bcval->getAbs();

        return $abs;
    }


    /**
     * Округление
     *
     * @param int|float|string|Bcval|mixed $number
     * @param null|int                     $scale
     *
     * @return Bcval
     */
    public function bcround($number, int $scale = null) : Bcval
    {
        $scale = $this->theScaleVal($scale ?? 0);

        $bcval = $this->theBcval($number);

        $bcround = $bcval;

        if ($hasDecimals = false !== strpos($bcval, '.')) {
            $bcround = $this->bcminus($bcval)
                ? $this->bcsub($bcval, '0.' . str_repeat('0', $scale) . '5', $scale)
                : $this->bcadd($bcval, '0.' . str_repeat('0', $scale) . '5', $scale);
        }

        return $bcround;
    }

    /**
     * Округляет в меньшую сторону
     *
     * @param int|float|string|Bcval|mixed $number
     * @param null|int                     $scale
     *
     * @return Bcval
     */
    public function bcfloor($number, int $scale = null) : Bcval
    {
        $scale = $this->theScaleVal($scale ?? 0);

        $bcval = $this->theBcval($number);

        $bcfloor = $bcval;

        if ($hasDecimals = false !== strpos($bcval, '.')) {
            $fmod = $this->bcadd($bcval, 0, $scale);
            $bonus = $this->bccomp($bcval, $fmod) // scale will be calculated
                ? ( 1 / pow(10, $scale) )
                : 0;

            $bcfloor = ( -1 === $this->bccomp($bcval, 0) )
                ? $this->bcsub($fmod, $bonus, $scale)
                : $fmod;
        }

        return $bcfloor;
    }

    /**
     * Округляет в большую сторону
     *
     * @param int|float|string|Bcval|mixed $number
     * @param null|int                     $scale
     *
     * @return Bcval
     */
    public function bcceil($number, int $scale = null) : Bcval
    {
        $scale = $this->theScaleVal($scale ?? 0);

        $bcval = $this->theBcval($number);

        $bcceil = $bcval;

        if ($hasDecimals = false !== strpos($bcval, '.')) {
            $fmod = $this->bcadd($bcval, 0, $scale);
            $bonus = $this->bccomp($bcval, $fmod) // scale will be calculated
                ? ( 1 / pow(10, $scale) )
                : 0;

            $bcceil = ( -1 === $this->bccomp($bcval, 0) )
                ? $fmod
                : $this->bcadd($fmod, $bonus, $scale);
        }

        return $bcceil;
    }


    /**
     * @param int|float|string|Bcval|array $numbers
     * @param null|int                     $scale
     *
     * @return null|Bcval
     */
    public function bcmax($numbers, int $scale = null) : ?Bcval
    {
        $bcvals = $this->theBcvals($numbers);

        $bcmax = null;

        if ($bcvals) {
            natsort($bcvals);

            $bcmax = end($bcvals);

            $bcmax = $this->bcadd($bcmax, 0, $scale);
        }

        return $bcmax;
    }

    /**
     * @param int|float|string|Bcval|array $numbers
     * @param null|int                     $scale
     *
     * @return null|Bcval
     */
    public function bcmin($numbers, int $scale = null) : ?Bcval
    {
        $bcvals = $this->theBcvals($numbers);

        $bcmin = null;

        if ($bcvals) {
            natsort($bcvals);

            $bcmin = reset($bcvals);

            $bcmin = $this->bcadd($bcmin, 0, $scale);
        }

        return $bcmin;
    }


    /**
     * @param int|float|string|Bcval|array $numbers
     * @param null|int                     $scale
     *
     * @return Bcval
     */
    public function bcsum($numbers, int $scale = null) : Bcval
    {
        $bcvals = $this->theBcvals($numbers);

        $bcsum = '0';

        if ($bcvals) {
            foreach ( $bcvals as $l ) {
                $bcsum = $this->bcadd($bcsum, $l); // scale will be calculated
            }

            $bcsum = $this->bcadd($bcsum, 0, $scale);
        }

        $bcsum = $this->theBcval($bcsum);

        return $bcsum;
    }

    /**
     * @param int|float|string|Bcval|array $numbers
     * @param null|int                     $scale
     *
     * @return Bcval
     */
    public function bcavg($numbers, int $scale = null) : Bcval
    {
        $bcvals = $this->theBcvals($numbers);

        $bcavg = '0.0';

        if ($bcvals) {
            $sum = $this->bcsum($bcvals); // scale will be calculated

            $bcavg = $this->bcdiv($sum, count($bcvals), $scale);
        }

        $bcavg = $this->theBcval($bcavg);

        return $bcavg;
    }

    /**
     * @param int|float|string|Bcval|array $numbers
     * @param null|int                     $scale
     *
     * @return null|Bcval
     */
    public function bcmedian($numbers, int $scale = null) : ?Bcval
    {
        $bcvals = $this->theBcvals($numbers);

        $bcmedian = null;

        if ($bcvals) {
            natsort($bcvals);

            $bcvals = array_values($bcvals);

            $medianIndex = count($bcvals) / 2;

            if (is_float($medianIndex)) {
                $bcmedian = $bcvals[ round($medianIndex) - 1 ];

            } else {
                $bcmedian = $this->bcadd($bcvals[ $medianIndex ], $bcvals[ $medianIndex + 1 ]); // scale will be calculated

                $bcmedian = $this->bcdiv($bcmedian, 2, $scale);
            }
        }

        return $bcmedian;
    }


    /**
     * @param int|float      $value
     * @param null|int|float $sum
     * @param null|int       $scale
     *
     * @return Bcval
     */
    public function bcratio($value, $sum = null, int $scale = null) : Bcval
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

        $valueNegative = ( -1 === $this->bccomp($value, 0) );
        $sumNegative = ( -1 === $this->bccomp($sum, 0) );

        if ($valueNegative !== $sumNegative) {
            throw new InvalidArgumentException(
                [ 'Both sum and value should be greater or less than zero: %s', $sum ]
            );
        }

        $result = $this->bcdiv($value, $this->bcabs($sum), $scale);

        return $result;
    }

    /**
     * @param int|float|string|Bcval|mixed      $value
     * @param null|int|float|string|Bcval|mixed $sum
     * @param null|int                          $scale
     *
     * @return Bcval
     */
    public function bcpercent($value, $sum = null, int $scale = null) : Bcval
    {
        $ratio = $this->bcratio($value, $sum, $scale);

        $result = $this->bcmul($ratio, '100', $scale);

        return $result;
    }


    /**
     * @param int|float|string|Bcval|mixed      $from
     * @param null|int|float|string|Bcval|mixed $to
     * @param null|int                          $scale
     *
     * @return Bcval
     */
    public function bcrand($from, $to = null, int $scale = null) : Bcval
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
     * @param int|float|string|Bcval|mixed $number
     * @param null|int                     $scale
     *
     * @return Bcval
     */
    public function bcmoneyfloor($number, int $scale = null) : Bcval
    {
        $scale = $this->theScaleVal($scale ?? 0);

        $result = $this->bcadd($number, 0, $scale);

        return $result;
    }

    /**
     * Увеличение по "правилу денег"
     * Округлит 1.00000001 до 1.01 (если нужно два знака после запятой)
     *
     * @param int|float|string|Bcval|mixed $number
     * @param null|int                     $scale
     *
     * @return Bcval
     */
    public function bcmoneyceil($number, int $scale = null) : Bcval
    {
        $scale = $this->theScaleVal($scale ?? 0);

        $result = $this->bcceil($this->bcabs($number), $scale);

        $result->withMinus($this->bcminus($number));

        return $result;
    }

    /**
     * Разбивает сумму между получателями
     * Если разделить 100 на 3 получается 33.33, 33.33, и 33.33 и 0.01 в периоде
     * Функция позволяет разбить исходное число на три, дробная часть от каждого деления достанется первому
     *
     * @param int|float|string|Bcval|mixed $sum
     * @param int|float|string|Bcval|array $rates
     * @param null|int                     $scale
     *
     * @return Bcval[]
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

        $this->theBcNonNegativeVal($sum);

        foreach ( $rates as $r ) {
            $this->theBcNonNegativeVal($r);
        }

        $result = [];

        $ratesIndexes = array_keys($rates);
        $ratesSum = '0';
        foreach ( $rates as $r ) {
            $ratesSum = $this->bcadd($ratesSum, $r); // scale will be calculated
        }

        $this->theBcPositiveVal($ratesSum);

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


    /**
     * @param float|mixed $number
     *
     * @return null|Bcval
     */
    protected function bcvalInt($number) : ?Bcval
    {
        if (is_int($number)) {
            return $this->newBcval($number);
        }

        if (! is_string($number)) {
            return null;
        }

        $intstr = strval($number);

        if (0
            || ( false !== stripos($intstr, 'e') )
            || ( false !== strpos($intstr, '.') )
        ) {
            return null;
        }

        $bcval = $this->newBcval($intstr);

        return $bcval;
    }

    /**
     * @param int|float|string|Bcval|mixed $number
     *
     * @return null|Bcval
     */
    protected function bcvalNumeric($number) : ?Bcval
    {
        if (is_int($number)) {
            return $this->newBcval($number);
        }

        if (null === ( $number = $this->num->numericval($number) )) {
            return null;
        }

        if (false === strripos($number, 'e')) {
            $trim = ltrim($number, '0');

            $bcval = null
                ?? ( ( '' === $trim ) ? '0' : null )
                ?? ( '.' === $trim[ 0 ] ? '0' . $trim : null )
                ?? $trim;

            $bcval = $this->newBcval($bcval);

            return $bcval;
        }

        [ $floatstr, $exponent ] = preg_split('/e/i', $number) + [ null, null ];

        $fraclen = -1 * intval(ltrim($exponent, '+'));

        if (false !== strpos($floatstr, '.')) {
            [ 1 => $frac ] = explode('.', $floatstr);

            $add = strlen(rtrim($frac, '0'));

            $fraclen = $fraclen + $add;
        }

        $fraclen = max(0, $fraclen);

        $bcval = $fraclen
            ? sprintf('%.' . $fraclen . 'f', $number)
            : sprintf('%.0f', $number);

        $bcval = $this->newBcval($bcval);

        return $bcval;
    }


    /**
     * @return IMath
     */
    public static function me()
    {
        return SupportFactory::getInstance()->getMath();
    }
}
