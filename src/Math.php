<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


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
     * @param int|float ...$values
     *
     * @return null|int|float
     */
    public function max(...$values) // : ?int|float
    {
        $list = $this->num->theNumvals(...$values);

        $result = $list
            ? max($list)
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
        $list = $this->num->theNumvals(...$values);

        $result = $list
            ? min($list)
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
        $list = $this->num->theNumvals(...$values);

        $result = $list
            ? array_sum($list)
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
        $list = $this->num->theNumvals(...$values);

        $avg = null;

        if ($list) {
            $sum = $this->sum($list);

            $avg = $sum / count($list);
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
        $list = $this->num->theNumvals(...$values);

        $median = null;

        if ($list) {
            sort($list);

            $list = array_values($list);

            $idx = count($list) / 2;

            $median = is_int($idx)
                ? ( ( $list[ $idx ] + $list[ $idx + 1 ] ) / 2 )
                : ( $list[ round($idx) - 1 ] );
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

        $scaleMax = $this->scaleMax($from, $to);

        $pow = pow(10, $scaleMax);

        $result = mt_rand(
            $from * $pow,
            $to * $pow
        );

        $result = $result / $pow;

        return $result;
    }


    /**
     * Дробная часть числа
     *
     * @param int|float|string $number
     *
     * @return string
     */
    public function frac($number) : string
    {
        $number = $this->theBcnumval($number);

        $result = substr(strrchr($number, '.'), 1);

        return false !== $result
            ? $result
            : '';
    }

    /**
     * Дробная часть числа
     *
     * @param int|float|string|array $numbers
     *
     * @return int
     */
    public function scaleMax(...$numbers) : int
    {
        $list = $this->theBcnumvals(...$numbers);

        $scaleMax = 0;
        foreach ( $list as $l ) {
            $scaleMax = max($scaleMax, strlen($this->frac($l)));
        }

        return $scaleMax;
    }


    /**
     * Получает минуса или пустой строки если число отрицательное
     *
     * @param int|float|string $number
     *
     * @return string
     */
    public function bcminus($number) : string
    {
        $result = $this->theBcnumval($number);

        $minus = strpos($result, '-') === 0
            ? '-'
            : '';

        return $minus;
    }

    /**
     * Получает значение по модулю от числа
     *
     * @param int|float|string $number
     *
     * @return string
     */
    public function bcabs($number) : string
    {
        $result = $this->theBcnumval($number);

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
     * @param null|int               $precision
     *
     * @return string
     */
    public function bcround($number, int $precision = null) : string
    {
        $precision = $precision ?? 0;

        $bcnumval = $this->theBcnumval($number);

        $hasDecimals = false !== strpos($bcnumval, '.');

        $result = $bcnumval;

        if ($hasDecimals) {
            $precision = $this->theScaleval($precision);

            $result = $this->bcminus($bcnumval)
                ? bcsub($bcnumval,
                    '0.' . str_repeat('0', $precision) . '5',
                    $precision
                )
                : bcadd($bcnumval,
                    '0.' . str_repeat('0', $precision) . '5',
                    $precision
                );
        }

        return $result;
    }

    /**
     * Округляет в меньшую сторону
     *
     * @param int|float|string $number
     *
     * @return string
     */
    public function bcfloor($number) : string
    {
        $bcnumval = $this->theBcnumval($number);

        $hasDecimals = false !== strpos($bcnumval, '.');
        $hasDecimalsOnlyZeros = $hasDecimals && preg_match('~\.[0]+$~', $bcnumval);

        $result = $bcnumval;

        if ($hasDecimals) {
            if ($hasDecimalsOnlyZeros) {
                $result = $this->bcround($bcnumval);

            } else {
                // force for floor
                $scaleMax = 0;

                $result = $this->bcminus($bcnumval)
                    ? bcsub($bcnumval, 1, $scaleMax)
                    : bcadd($bcnumval, 0, $scaleMax);
            }
        }

        return $result;
    }

    /**
     * Округляет в большую сторону
     *
     * @param int|float|string $number
     *
     * @return string
     */
    public function bcceil($number) : string
    {
        $bcnumval = $this->theBcnumval($number);

        $hasDecimals = false !== strpos($bcnumval, '.');
        $hasDecimalsOnlyZeros = $hasDecimals && preg_match('~\.[0]+$~', $bcnumval);

        $result = $bcnumval;

        if ($hasDecimals) {
            if ($hasDecimalsOnlyZeros) {
                $result = $this->bcround($bcnumval);

            } else {
                // force for ceil
                $scaleMax = 0;

                $result = $this->bcminus($bcnumval)
                    ? bcsub($bcnumval, 0, $scaleMax)
                    : bcadd($bcnumval, 1, $scaleMax);
            }
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
        $list = $this->theBcnumvals($numbers);

        $result = null;

        if ($list) {
            natsort($list);

            $result = end($list);

            $scale = $this->theScaleval($scale,
                $scaleMax = $this->scaleMax($result)
            );

            $result = bcadd($result, 0, $scale);
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
        $list = $this->theBcnumvals($numbers);

        $result = null;

        if ($list) {
            natsort($list);

            $result = reset($list);

            $scale = $this->theScaleval($scale,
                $scaleMax = $this->scaleMax($result)
            );

            $result = bcadd($result, 0, $scale);
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
        $list = $this->theBcnumvals($numbers);

        $result = '0';

        if ($list) {
            $scale = $this->theScaleval($scale,
                $scaleMax = $this->scaleMax($list)
            );

            foreach ( $list as $l ) {
                $result = bcadd($result, $l, $scaleMax);
            }

            $result = bcadd($result, 0, $scale);
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
        $list = $this->theBcnumvals($numbers);

        $avg = '0.0';

        if ($list) {
            $scale = $this->theScaleval($scale,
                $scaleMax = $this->scaleMax($list)
            );

            $sum = $this->bcsum($list, $scaleMax);

            $avg = bcdiv($sum, count($list), $scale);
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
        $list = $this->theBcnumvals($numbers);

        $median = null;

        if ($list) {
            $scale = $this->theScaleval($scale,
                $scaleMax = $this->scaleMax($list)
            );

            natsort($list);

            $list = array_values($list);

            $index = count($list) / 2;

            $median = ! is_float($index)
                ? bcdiv(
                    bcadd($list[ $index ], $list[ $index + 1 ], $scaleMax),
                    2, $scale
                )
                : $list[ round($index) - 1 ];
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

        $value = $this->theBcnumval($value);
        $sum = $this->theBcnumval($sum);

        $scale = $this->theScaleval($scale,
            $scaleMax = $this->scaleMax($value, $sum)
        );

        $sumCmp = bccomp($sum, 0, $scaleMax);
        $sumNegative = -1 === $sumCmp;
        $sumZero = 0 === $sumCmp;

        if ($sumZero) {
            throw new InvalidArgumentException(
                [ 'Sum should be not zero: %s', $sum ]
            );
        }

        $valueCmp = bccomp($value, 0, $scaleMax);
        $valueNegative = -1 === $valueCmp;

        if ($valueNegative !== $sumNegative) {
            throw new InvalidArgumentException(
                [ 'Both sum and value should be greater or less than zero: %s', $sum ]
            );
        }

        $result = bcdiv($value, $this->bcabs($sum), $scale);

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
        $scale = $this->theScaleval($scale,
            $scaleMax = $this->scaleMax($value, $sum)
        );

        $ratio = $this->bcratio($value, $sum, $scale);

        $result = bcmul($ratio, '100', $scale);

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

        $from = $this->theBcnumval($from);
        $to = $this->theBcnumval($to);

        $scale = $this->theScaleval($scale,
            $scaleMax = $this->scaleMax($from, $to)
        );

        $pow = pow(10, $scaleMax);

        $result = mt_rand(
            bcmul($from, $pow, $scaleMax),
            bcmul($to, $pow, $scaleMax)
        );

        $result = bcdiv($result, $pow, $scale);

        return $result;
    }


    /**
     * Округление по "правилу денег" (проверка потерянной копейки)
     * Округлит 1.00000001 до 1.01 (если нужно два знака после запятой)
     * Как правило, клиенту выставляется цена на копейку больше, а со счета компании списывается на копейку меньше
     *
     * @param int|float|string $number
     * @param null|int         $scale
     *
     * @return string
     */
    public function bcmoneyfloor($number, int $scale = null) : string
    {
        $scale = $scale ?? 0;

        $result = $bcnumval = $this->theBcnumval($number);

        $hasDecimals = false !== strpos($bcnumval, '.');
        $hasDecimalsOnlyZeros = $hasDecimals && preg_match('~\.[0]+$~', $bcnumval);

        if ($hasDecimals) {
            if ($hasDecimalsOnlyZeros) {
                $result = $this->bcround($bcnumval);

            } else {
                $scale = $this->theScaleval($scale);

                $result = $this->bcminus($bcnumval)
                    ? bcadd($bcnumval, 0, $scale)
                    : bcsub($bcnumval, 0, $scale);
            }
        }

        return $result;
    }

    /**
     * Округление по "правилу денег" (проверка потерянной копейки)
     * Округлит 1.00000001 до 1.01 (если нужно два знака после запятой)
     * Как правило, клиенту выставляется цена на копейку больше, а со счета компании списывается на копейку меньше
     *
     * @param int|float|string $number
     * @param null|int         $scale
     *
     * @return string
     */
    public function bcmoneyceil($number, int $scale = null) : string
    {
        $scale = $scale ?? 0;

        $result = $bcnumval = $this->num->theNumericval($number);

        $hasDecimals = false !== strpos($bcnumval, '.');
        $hasDecimalsOnlyZeros = $hasDecimals && preg_match('~\.[0]+$~', $bcnumval);

        if ($hasDecimals) {
            if ($hasDecimalsOnlyZeros) {
                $result = $this->bcround($bcnumval);

            } else {
                $scale = $this->theScaleval($scale,
                    $scaleMax = $this->scaleMax($bcnumval)
                );

                $bonus = bccomp($bcnumval, bcadd($bcnumval, 0, $scale), $scaleMax)
                    ? 1 / pow(10, $scale)
                    : 0;

                $result = $this->bcminus($bcnumval)
                    ? bcsub($bcnumval, $bonus, $scale)
                    : bcadd($bcnumval, $bonus, $scale);
            }
        }

        return $result;
    }


    /**
     * @param int|float|string $scale
     * @param null|int         $default
     *
     * @return null|string
     */
    public function scaleval($scale, int $default = null) : ?string
    {
        if (null === ( $scaleval = $this->num->intval($scale ?? $default) )) {
            return null;
        }

        if (null === $this->filter->filterNonNegative($scaleval)) {
            return null;
        }

        return $scaleval;
    }

    /**
     * @param mixed    $scale
     * @param null|int $default
     *
     * @return string
     */
    public function theScaleval($scale, int $default = null) : string
    {
        if (null === ( $scaleval = $this->scaleval($scale, $default) )) {
            throw new InvalidArgumentException(
                [ 'Value should be convertable to scale: %s', $scale ],
            );
        }

        return $scaleval;
    }


    /**
     * @param int|float|string $number
     *
     * @return null|string
     */
    public function bcnumval($number) : ?string
    {
        if (! ( is_string($number) || is_float($number) || is_int($number) )) {
            return null;
        }

        if ('' === $number) {
            return null;
        }

        $result = $number;

        if (! is_numeric($number)) {
            $number = str_replace([ ' ', ',' ], '.', $number);

            if (! is_numeric($number)) {
                return null;
            }

            $ctype = str_replace([ '-', '.' ], '', $number);
            if (! ctype_digit($ctype)) {
                return null;
            }

            $result = $number;
        }

        return $result;
    }

    /**
     * @param mixed $value
     *
     * @return string
     */
    public function theBcnumval($value) : string
    {
        if (null === ( $bcnumval = $this->bcnumval($value) )) {
            throw new InvalidArgumentException(
                [ 'Value should be convertable to bcnumval: %s', $value ],
            );
        }

        return $bcnumval;
    }


    /**
     * @param string|string[]|array $strings
     * @param null|bool             $uniq
     *
     * @return string[]
     */
    public function bcnumvals($strings, $uniq = null) : array
    {
        $result = [];

        $strings = is_array($strings)
            ? $strings
            : [ $strings ];

        array_walk_recursive($strings, function ($string) use (&$result) {
            $result[] = $this->bcnumval($string);
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
    public function theBcnumvals($strings, $uniq = null) : array
    {
        $result = [];

        $strings = is_array($strings)
            ? $strings
            : [ $strings ];

        array_walk_recursive($strings, function ($string) use (&$result) {
            $result[] = $this->theBcnumval($string);
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
}
