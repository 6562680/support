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
     * @return int|float
     */
    public function sum(...$values) // : int|float
    {
        $list = $this->num->theNumvals(...$values);

        $result = array_sum($list);

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

        $sum = $this->sum($list);
        $len = count($list);

        $avg = $len
            ? ( $sum / $len )
            : 0.0;

        return $avg;
    }

    /**
     * @param int|float ...$values
     *
     * @return int|float|string
     */
    public function median(...$values) // : int|float|string
    {
        $list = $this->num->theNumvals(...$values);

        sort($list);

        $list = array_values($list);

        $idx = count($list) / 2;

        $median = is_int($idx)
            ? ( ( $list[ $idx ] + $list[ $idx + 1 ] ) / 2 )
            : ( $list[ round($idx) - 1 ] );

        return $median;
    }


    /**
     * Дробная часть числа
     *
     * @param int|float|string $number
     *
     * @return string
     */
    public function bcfrac($number) : string
    {
        $number = $this->theBcnumval($number);

        $result = substr(strrchr($number, '.'), 1);

        return false !== $result
            ? $result
            : '';
    }

    /**
     * Получает значение по модулю от числа
     *
     * @param int|float|string $number
     * @param string           $minus
     *
     * @return string
     */
    public function bcabs($number, &$minus = null) : string
    {
        $result = $this->theBcnumval($number);

        $minus = strpos($result, '-') === 0
            ? '-' : '';

        $abs = $minus
            ? substr($result, 1)
            : $result;

        return $abs;
    }


    /**
     * Округление
     *
     * @param int|float|string|mixed $number
     * @param int                    $precision
     *
     * @return string
     */
    public function bcround($number, $precision = 0) : string
    {
        $result = $bcnumval = $this->theBcnumval($number);

        $hasDecimals = false !== strpos($bcnumval, '.');

        if ($hasDecimals) {
            $this->filter
                ->assert('Precision should be non-negative: %s', $precision)
                ->assertNonNegative($precision);

            $this->bcabs($bcnumval, $minus);

            $result = $minus
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
        $result = $bcnumval = $this->theBcnumval($number);

        $scale = 0;

        $hasDecimals = false !== strpos($bcnumval, '.');
        $hasDecimalsOnlyZeros = $hasDecimals && preg_match('~\.[0]+$~', $bcnumval);

        if ($hasDecimals) {
            if ($hasDecimalsOnlyZeros) {
                $result = $this->bcround($bcnumval, $scale);

            } else {
                $this->bcabs($bcnumval, $minus);

                $result = $minus
                    ? bcsub($bcnumval, 1, $scale)
                    : bcadd($bcnumval, 0, $scale);
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
        $result = $bcnumval = $this->theBcnumval($number);

        $scale = 0;

        $hasDecimals = false !== strpos($bcnumval, '.');
        $hasDecimalsOnlyZeros = $hasDecimals && preg_match('~\.[0]+$~', $bcnumval);

        if ($hasDecimals) {
            if ($hasDecimalsOnlyZeros) {
                $result = $this->bcround($bcnumval, $scale);

            } else {
                $this->bcabs($bcnumval, $minus);

                $result = $minus
                    ? bcsub($bcnumval, 0, $scale)
                    : bcadd($bcnumval, 1, $scale);
            }
        }

        return $result;
    }


    /**
     * Дробная часть числа
     *
     * @param int|float|string|array $numbers
     *
     * @return int
     */
    public function bcdecimals(...$numbers) : int
    {
        $list = $this->theBcnumvals(...$numbers);

        $decimals = 0;
        foreach ( $list as $l ) {
            $decimals = max($decimals, strlen($this->bcfrac($l)));
        }

        return $decimals;
    }


    /**
     * @param int|float ...$numbers
     *
     * @return string
     */
    public function bcsum(...$numbers) : string
    {
        $list = $this->theBcnumvals(...$numbers);
        $decimals = $this->bcdecimals($list);

        $result = '0';
        foreach ( $list as $l ) {
            $result = bcadd($result, $l, $decimals);
        }

        return $result;
    }

    /**
     * @param int|float ...$numbers
     *
     * @return string
     */
    public function bcavg(...$numbers) : string
    {
        $list = $this->theBcnumvals(...$numbers);
        $decimals = $this->bcdecimals($list);

        $sum = $this->bcsum($list);
        $len = count($list);

        $avg = $len
            ? bcdiv($sum, $len, $decimals)
            : '0';

        return $avg;
    }

    /**
     * @param int|float ...$numbers
     *
     * @return string
     */
    public function bcmedian(...$numbers) : string
    {
        $list = $this->theBcnumvals(...$numbers);
        $decimals = $this->bcdecimals($list);

        natsort($list);

        $list = array_values($list);

        $index = count($list) / 2;

        $median = ! is_float($index)
            ? bcdiv(bcadd($list[ $index ], $list[ $index + 1 ], $decimals), 2, $decimals)
            : $list[ round($index) - 1 ];

        return $median;
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

        $this->filter
            ->assert('Scale should be non-negative: %s', $scale)
            ->assertNonNegative($scale);

        $result = $bcnumval = $this->theBcnumval($number);

        $hasDecimals = false !== strpos($bcnumval, '.');
        $hasDecimalsOnlyZeros = $hasDecimals && preg_match('~\.[0]+$~', $bcnumval);

        if ($hasDecimals) {
            if ($hasDecimalsOnlyZeros) {
                $result = $this->bcround($bcnumval);

            } else {
                $this->bcabs($bcnumval, $minus);

                $result = $minus
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

        $this->filter
            ->assert('Scale should be non-negative: %s', $scale)
            ->assertNonNegative($scale);

        $result = $bcnumval = $this->num->theNumval($number);

        $hasDecimals = false !== strpos($bcnumval, '.');
        $hasDecimalsOnlyZeros = $hasDecimals && preg_match('~\.[0]+$~', $bcnumval);

        if ($hasDecimals) {
            if ($hasDecimalsOnlyZeros) {
                $result = $this->bcround($bcnumval);

            } else {
                $this->bcabs($bcnumval, $minus);

                $decimals = strlen($this->bcfrac($bcnumval));
                $bonus = bccomp($bcnumval, bcadd($bcnumval, 0, $scale), $decimals)
                    ? 1 / pow(10, $scale)
                    : 0;

                $result = $minus
                    ? bcsub($bcnumval, $bonus, $scale)
                    : bcadd($bcnumval, $bonus, $scale);
            }
        }

        return $result;
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


    // /**
    //  * @param int|float      $value
    //  * @param null|int|float $sum
    //  *
    //  * @return float
    //  */
    // public function ratio($value, $sum = null) : float
    // {
    //     $sum = $sum ?? 1;
    //
    //     $value = $this->num->theNumval($value);
    //     $sum = $this->num->theNumval($sum);
    //
    //     $this->filter
    //         ->assert('Sum should be positive: %s', $sum)
    //         ->assertPositive($sum);
    //
    //     $result = min(1,
    //         max(-1, $value / $sum)
    //     );
    //
    //     return $result;
    // }

    // /**
    //  * @param int|float      $value
    //  * @param null|int|float $sum
    //  *
    //  * @return float
    //  */
    // public function percent($value, $sum = null) : float
    // {
    //     $sum = $sum ?? 1;
    //
    //     $value = $this->num->theNumval($value);
    //     $sum = $this->num->theNumval($sum);
    //
    //     $this->filter
    //         ->assert('Sum should be positive: %s', $sum)
    //         ->assertPositive($sum);
    //
    //     $result = $value / $sum * 100;
    //
    //     return $result;
    // }


    // /**
    //  * Разбивает сумму между получателями
    //  * Если разделить 100 на 3 получается 33.33, 33.33, и 33.33 и 0.01 в периоде
    //  * Функция позволяет разбить исходное число на три, не потеряв дробную часть
    //  *
    //  * @param int|float|string       $sum
    //  * @param int|float|string|array $rates
    //  * @param null|int               $scale
    //  *
    //  * @return int[]|float[]
    //  */
    // public function moneyshare($sum, $rates, int $scale = null) : array
    // {
    //     $sum = $this->num->theNumval($sum);
    //     $rates = $this->num->theNumvals($rates);
    //
    //     $this->filter
    //         ->assert('Sum should be non-negative: %s', $sum)
    //         ->assertNonNegative($sum);
    //
    //     if (! $rates) {
    //         throw new InvalidArgumentException(
    //             [ 'At least one rate should be passed: %s', $rates ]
    //         );
    //     }
    //
    //     foreach ( $rates as $r ) {
    //         $this->filter
    //             ->assert([ 'Each rate should be non-negative: %s', $r ])
    //             ->assertNonNegative($r);
    //     }
    //
    //     $dec = 1;
    //     $safe = false;
    //     if (isset($scale)) {
    //         $safe = true;
    //
    //         $this->filter
    //             ->assert('Scale should be non-negative: %s', $scale)
    //             ->assertNonNegative($scale);
    //
    //         $dec = 1 / pow(10, $scale);
    //     }
    //
    //     $result = [];
    //
    //     $ratesIndexes = array_keys($rates);
    //     $ratesSum = '0';
    //     foreach ( $rates as $r ) {
    //         $ratesSum = bcadd($ratesSum, $r, $scale);
    //     }
    //
    //     $this->filter
    //         ->assert('RatesSum should be positive: %s', $ratesSum)
    //         ->assertPositive($ratesSum);
    //
    //     $quota = bcdiv($sum, $ratesSum, $scale);
    //
    //     $mod = 0;
    //     foreach ( $ratesIndexes as $i ) {
    //         $val = $quota * $ratesNum[ $i ];
    //
    //         if (! $safe) {
    //             $result[ $i ] = $val;
    //
    //         } else {
    //             $floor = floor($val / $dec) * $dec;
    //             $mod += $val - $floor;
    //
    //             $result[ $i ] = $floor;
    //         }
    //     }
    //
    //     if ($safe) {
    //         $result[ 0 ] = round($mod / $dec) * $dec;
    //     }
    //
    //     return $result;
    // }


    // /**
    //  * Балансирует общую сумму между получателями учитывая заранее известные ("замороженные") значения
    //  * Заберет у тех, у кого много, раздаст тем, кому мало, недостающее выдаст из суммы
    //  * Очень социалистическая функция :)
    //  *
    //  * [ 5, 10, 50 ] -> [ , , 20 ]
    //  * 5x + 10x + 50x = ((5 + 10 + 50) - 20) = 45
    //  * [ 3, 7, 35 ] + [ , , 20 ]
    //  * 3x + 7x = 35
    //  * [ 13.5, 31.5, 20 ] -> round...
    //  * [ 14, 31, 20 ]
    //  *
    //  * @param int|float            $sum
    //  * @param int|float|array      $rates
    //  * @param null|int|float|array $freezes
    //  * @param null|int             $scale
    //  *
    //  * @return array
    //  */
    // public function balance($sum, array $rates, array $freezes = null, int $scale = null) : array
    // {
    //     $sum = $this->num->theNumval($sum);
    //
    //     $ratesNum = $this->num->theNumvals($rates);
    //     $freezesNum = $this->num->theNumvals($freezes);
    //
    //     $this->filter
    //         ->assert('Sum should be non-negative: %s', $sum)
    //         ->assertNonNegative($sum);
    //
    //     if (! $ratesNum) {
    //         throw new InvalidArgumentException(
    //             [ 'At least one rate should be passed: %s', $rates ]
    //         );
    //     }
    //
    //     foreach ( $ratesNum as $r ) {
    //         $this->filter
    //             ->assert([ 'Each rate should be non-negative: %s', $r ])
    //             ->assertNonNegative($r);
    //     }
    //
    //     $dec = 1;
    //     $safe = false;
    //     if (isset($scale)) {
    //         $safe = true;
    //
    //         $this->filter
    //             ->assert('Scale should be non-negative: %s', $scale)
    //             ->assertNonNegative($scale);
    //
    //         $dec = 1 / pow(10, $scale);
    //     }
    //
    //     $sumRates = array_sum($ratesNum);
    //     $sumFreezes = array_sum($freezesNum);
    //
    //     if ($sumFreezes > $sum) {
    //         throw new OutOfBoundsException('SumFreezes should be smaller than sum', [ $sumFreezes, $sum ]);
    //     }
    //
    //     $keysRates = array_keys($ratesNum);
    //     $keysFreezes = array_keys($freezesNum);
    //     $keysResult = array_unique($keysRates, $keysFreezes);
    //
    //     $result = array_fill(0, max($keysResult) + 1, 0);
    //
    //     $keysAll = $keysResult;
    //
    //     $src = [];
    //     $diff = [];
    //     foreach ( $keysAll as $k ) {
    //         $rate = $ratesNum[ $k ] ?? 0;
    //         $freeze = $freezesNum[ $k ] ?? 0;
    //
    //         $src[ $k ] = ( $rate / $sumRates ) * $sum;
    //         $diff[ $k ] = $src[ $k ] - $freeze;
    //     }
    //
    //     $keysShare = array_diff($keysResult, $keysFreezes);
    //
    //     foreach ( $keysFreezes as $i ) {
    //         if ($diff[ $i ] > 0) {
    //             $shareRates = [];
    //             foreach ( $keysShare as $k ) {
    //                 $shareRates[ $k ] = $src[ $k ];
    //             }
    //
    //             $ratios = $this->correlation($shareRates);
    //
    //             foreach ( $keysShare as $ii ) {
    //                 $value = $ratios[ $ii ] * $diff[ $i ];
    //
    //                 $src[ $i ] -= $value;
    //                 $src[ $ii ] += $value;
    //             }
    //
    //             $src[ $i ] = $freezesNum[ $i ];
    //         }
    //     }
    //
    //     $shareRates = [];
    //     foreach ( $keysShare as $k ) {
    //         $shareRates[ $k ] = $src[ $k ];
    //     }
    //
    //     $sumShare = array_sum($shareRates);
    //
    //     foreach ( $keysFreezes as $i ) {
    //         if ($diff[ $i ] < 0) {
    //             foreach ( $keysShare as $ii ) {
    //                 $val = $src[ $ii ] - $src[ $ii ] * ( ( $sumShare + $diff[ $i ] ) / $sumShare );
    //
    //                 $src[ $ii ] -= $val;
    //                 $src[ $i ] += $val;
    //             }
    //
    //             $sumShare += $diff[ $i ];
    //         }
    //     }
    //
    //     foreach ( $keysResult as $i ) {
    //         $result[ $i ] = $src[ $i ];
    //     }
    //
    //     $mod = 0;
    //     if ($safe) {
    //         foreach ( $keysResult as $i ) {
    //             $val = $result[ $i ];
    //
    //             $floor = floor($val / $dec) * $dec;
    //             $mod += $val - $floor;
    //
    //             $result[ $i ] = $floor;
    //         }
    //
    //         $result[] = round($mod / $dec) * $dec;
    //     }
    //
    //     return $result;
    // }


    // /**
    //  * Рассчитывает соотношение долей между собой
    //  * Нулевые соотношения получают пропорционально их количества - чем нулей больше, тем меньше каждому
    //  * В то же время нули получают тем больше, чем больше не-нулей
    //  *
    //  * @param int|float|array $rates
    //  * @param null|bool       $zero
    //  *
    //  * @return float[]
    //  */
    // public function correlation($rates, bool $zero = null) : array
    // {
    //     $zero = $zero ?? false;
    //
    //     $ratesNum = $this->num->theNumvals($rates);
    //
    //     if (! $ratesNum) {
    //         throw new InvalidArgumentException(
    //             [ 'At least one rate should be passed: %s', $rates ]
    //         );
    //     }
    //
    //     foreach ( $ratesNum as $r ) {
    //         $this->filter
    //             ->assert([ 'Each rate should be non-negative: %s', $r ])
    //             ->assertNonNegative($r);
    //     }
    //
    //     $result = [];
    //
    //     $ratesIndexes = array_keys($ratesNum);
    //     $ratesSum = array_sum($ratesNum);
    //
    //     $valuesIndexes = [];
    //     $zeroIndexes = [];
    //
    //     $cmp = [];
    //     $cmpLen = 0;
    //     foreach ( $ratesIndexes as $i ) {
    //         if (! $ratesNum[ $i ]) {
    //             $zeroIndexes[ $i ] = true;
    //
    //         } else {
    //             $valuesIndexes[ $i ] = true;
    //
    //             $cmp[] = $ratesNum[ $i ];
    //             $cmpLen++;
    //         }
    //     }
    //
    //     $zeroRate = 1;
    //     if (count($cmp)) {
    //         $minRate = min(...$cmp);
    //         $maxRate = max(...$cmp);
    //
    //         if ($maxRate) {
    //             $zeroRate = $minRate / $maxRate;
    //         }
    //     }
    //
    //     foreach ( $valuesIndexes as $i ) {
    //         $result[ $i ] = $zero
    //             ? ( $ratesNum[ $i ] / $ratesSum ) * ( 1 - ( $zeroRate / $cmpLen ) )
    //             : ( $ratesNum[ $i ] / $ratesSum );
    //     }
    //     $resultSum = array_sum($result);
    //
    //     if ($zero) {
    //         $zeroSum = 1 - $resultSum;
    //
    //         foreach ( $zeroIndexes as $i ) {
    //             $result[ $i ] = $zeroSum / count($zeroIndexes);
    //         }
    //     }
    //
    //     return $result;
    // }


    // /**
    //  * рандомайзер от-до, принимаюший на вход целые или дробные числа
    //  */
    // public function rand($from, $to = null) : string
    // {
    //     if (! isset($to)) $to = $from;
    //
    //     if (! Type::is_numerable($from)) {
    //         throw new \InvalidArgumentException('Argument 1 should be numeric');
    //     }
    //
    //     if (! Type::is_numerable($to)) {
    //         throw new \InvalidArgumentException('Argument 2 should be numeric');
    //     }
    //
    //     $len = max(strlen($this->frac($from)), strlen($this->frac($to)));
    //     $mult = bcpow(10, $len);
    //     $result = mt_rand(bcmul($from, $mult
    //         ?: 1), bcmul($to, $mult
    //         ?: 1));
    //
    //     return bcdiv($result, $mult
    //         ?: 1, $len);
    // }

    // /**
    //  * преобразовывает массив из чисел в массив промежутков между ними
    //  * [5,'6{=delimiter}7',8] => [[$min,5],[5,6],[6,7],[7,8],[8,$max]]
    //  * [5,'6-7',8] => [[$min,5],[5,6],[6,7],[7,8],[8,$max]]
    //  */
    // public function range(array $array, float $min = null, float $max = null, string $delimiter = '...', bool $preserve_keys = null) : array
    // {
    //     $result = [];
    //
    //     if ('-' === $delimiter) {
    //         throw new \InvalidArgumentException('Math minus `-` should not be used as delimiter');
    //     }
    //
    //     $min = $min ?? 0; // you can pass NULL to use -INF
    //     $preserve_keys = $preserve_keys ?? false;
    //
    //     // convert to array of int saving keys
    //     $registry = [];
    //     $ranges = [];
    //     foreach ( $array as $i => $val ) {
    //         $breakpoints = array_filter(explode($delimiter, $val));
    //
    //         $nonNumeric = Arr::first($breakpoints, function ($val) {
    //             return ! Type::is_numerable($val);
    //         });
    //         if ($nonNumeric) {
    //             throw new \InvalidArgumentException('Argument in range should be numerable: ' . $nonNumeric);
    //         }
    //
    //         $breakpoints = array_map('floatval', $breakpoints);
    //
    //         $ii = 0;
    //         foreach ( $breakpoints as $breakpoint ) {
    //             if (isset($registry[ $breakpoint ])) continue;
    //
    //             $registry[ $breakpoint ] = true;
    //             $ranges[] = [ $i, $ii++, $breakpoint ];
    //         }
    //     }
    //
    //     // sort numerically
    //     usort($ranges, function ($a, $b) {
    //         return $a[ 2 ] - $b[ 2 ];
    //     });
    //
    //     // build ranges
    //     $last = $min;
    //     $last_ii = null;
    //     for ( $i = 0, $len = count($ranges); $i <= $len; $i++ ) {
    //         if (! isset($ranges[ $i ])) {
    //             $ii = null;
    //         } elseif (! $preserve_keys) $ii = null;
    //         else {
    //             $ii = implode('.', [ $ranges[ $i ][ 0 ], $ranges[ $i ][ 1 ] ]);
    //             $last_ii = implode('.', [ ++$ranges[ $i ][ 0 ], 0 ]);
    //         }
    //         $ii = $ii ?? $last_ii ?? count($result);
    //
    //         $result[ $ii ] = [ $last, $ranges[ $i ][ 2 ] ?? $max ?? INF ];
    //         $last = $ranges[ $i ][ 2 ] ?? $min ?? -INF;
    //     }
    //
    //     // result
    //     return $result;
    // }
}
