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
     * @param int|float      $value
     * @param null|int|float $sum
     *
     * @return float
     */
    public function ratio($value, $sum = null) : float
    {
        $value = $this->num->theNumval($value);

        if (null !== $sum) {
            $sum = $this->num->theNumval($sum);
        }

        $sum = $sum ?? 1;

        $result = min(1,
            max(-1, $value / $sum)
        );

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
        $value = $this->num->theNumval($value);

        if (null !== $sum) {
            $sum = $this->num->theNumval($sum);
        }

        $sum = $sum ?? 1;

        $result = $value / $sum * 100;

        return $result;
    }


    /**
     * @param int|float ...$values
     *
     * @return int|float
     */
    public function sum(...$values) // : int|float
    {
        $list = $this->num->theNumvals($values);

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
        $list = $this->num->theNumvals($values);

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
        $list = $this->num->theNumvals($values);

        sort($list);

        $idx = count($list) / 2;

        $median = is_int($idx)
            ? ( ( $list[ $idx ] + $list[ $idx + 1 ] ) / 2 )
            : ( $list[ round($idx) ] );

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
        $result = $this->theBcnumval($number);

        if ($hasDecimals = false !== strpos($number, '.')) {
            [ , $minus ] = $this->bcabs($number);

            $result = $minus
                ? bcsub($number,
                    '0.' . str_repeat('0', $precision) . '5',
                    $precision
                )
                : bcadd($number,
                    '0.' . str_repeat('0', $precision) . '5',
                    $precision
                );
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
    public function bcceil(string $number)
    {
        $result = $this->theBcnumval($number);

        if ($hasDecimals = false !== strpos($number, '.')) {
            if (preg_match('~\.[0]+$~', $number)) {
                $result = $this->bcround($number, 0);

            } else {
                $this->bcabs($number, $minus);

                $result = $minus
                    ? bcsub($number, 0, 0)
                    : bcadd($number, 1, 0);
            }
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
        $result = $this->theBcnumval($number);

        if ($hasDecimals = false !== strpos($number, '.')) {
            if (preg_match('~\.[0]+$~', $number)) {
                $result = $this->bcround($number, 0);

            } else {
                $this->bcabs($number, $minus);

                $result = $minus
                    ? bcsub($number, 1, 0)
                    : bcadd($number, 0, 0);
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
        $isValue = ( '' !== $number );
        $isType = $isValue && ( is_string($number) || is_float($number) || is_int($number) );

        if (! ( $isType && $isValue )) {
            return null;
        }

        $result = implode('.', explode(',', $number, 2));
        $result = str_replace(' ', '', $result);

        if (! ctype_digit(str_replace('.', '', $result))) {
            return null;
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


    /**
     * Округление по "правилу денег" (проверка потерянной копейки)
     * Округлит 1.00000001 до 1.01 (если нужно два знака после запятой)
     * Как правило, клиенту выставляется цена на копейку больше, а со счета компании списывается на копейку меньше
     *
     * @param int|float $value
     * @param null|int  $scale
     *
     * @return int|float
     */
    public function moneyround($value, int $scale = null)
    {
        $value = $this->num->theNumval($value);

        $scale = $scale ?? 0;

        $result = round($value, $scale);
        $sign = null
            ?? ( $value > 0 ? 1 : null )
            ?? ( $value < 0 ? -1 : null );

        $result += $value !== $result
            ? $sign * ( 1 / pow(10, $scale) )
            : 0;

        return $result;
    }

    /**
     * Разбивает сумму между получателями
     * Если разделить 100 на 3 получается 33.33, 33.33, и 33.33 и 0.01 в периоде
     * Функция позволяет разбить исходное число на три, не потеряв дробную часть
     *
     * @param int|float       $sum
     * @param int|float|array $rates
     * @param null|int        $scale
     *
     * @return int[]|float[]
     */
    public function moneyshare($sum, $rates, int $scale = null) : array
    {
        $this->filter->assert('Sum should be number: %s', $sum)
            ->assertNumval($sum);

        $ratesNum = $this->num->theNumvals($rates);
        if (! $ratesNum) {
            throw new InvalidArgumentException(
                [ 'At least one rate should be passed: %s', $rates ]
            );
        }
        foreach ( $ratesNum as $r ) {
            $this->filter->assert([ 'Each rate should be positive: %s', $r ])
                ->assertPositive($r);
        }

        $result = [];

        $ratesIndexes = array_keys($ratesNum);
        $ratesSum = array_sum($ratesNum);

        if ($ratesSum <= 0) {
            throw new OutOfBoundsException('Sum of rates should be positive');
        }

        $dec = 1;
        $safe = false;
        if (isset($scale)) {
            $scale = max($scale, 0);
            $dec = 1 / pow(10, $scale);

            $safe = true;
        }

        $quota = $sum / $ratesSum;

        $mod = 0;
        foreach ( $ratesIndexes as $i ) {
            if (! $safe) {
                $result[ $i ] = $quota * $ratesNum[ $i ];

            } else {
                $val = $quota * $ratesNum[ $i ];
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
     * Рассчитывает соотношение долей между собой
     * Нулевые соотношения получают пропорционально их количества - чем нулей больше, тем меньше каждому
     * В то же время нули получают тем больше, чем больше не-нулей
     *
     * @param int|float|array $rates
     * @param null|bool       $zero
     *
     * @return float[]
     */
    public function correlation($rates, bool $zero = null) : array
    {
        $zero = $zero ?? false;

        $result = [];

        $ratesNum = $this->num->theNumvals($rates);
        if (! $ratesNum) {
            throw new InvalidArgumentException(
                [ 'At least one rate should be passed: %s', $rates ]
            );
        }
        foreach ( $ratesNum as $r ) {
            $this->filter->assert([ 'Each rate should be positive: %s', $r ])
                ->assertPositive($r);
        }

        $ratesIndexes = array_keys($ratesNum);
        $ratesSum = array_sum($ratesNum);

        $valuesIndexes = [];
        $zeroIndexes = [];

        $cmp = [];
        $cmpLen = 0;
        foreach ( $ratesIndexes as $i ) {
            if (! $ratesNum[ $i ]) {
                $zeroIndexes[ $i ] = true;

            } else {
                $valuesIndexes[ $i ] = true;

                $cmp[] = $ratesNum[ $i ];
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
            $result[ $i ] = $zero
                ? ( $ratesNum[ $i ] / $ratesSum ) * ( 1 - ( $zeroRate / $cmpLen ) )
                : ( $ratesNum[ $i ] / $ratesSum );
        }
        $resultSum = array_sum($result);

        if ($zero) {
            $zeroSum = 1 - $resultSum;

            foreach ( $zeroIndexes as $i ) {
                $result[ $i ] = $zeroSum / count($zeroIndexes);
            }
        }

        return $result;
    }


    /**
     * Балансирует общую сумму между получателями учитывая заранее известные ("замороженные") значения
     * Заберет у тех, у кого много, раздаст тем, кому мало, недостающее выдаст из суммы
     * Очень социалистическая функция :)
     *
     * [ 5, 10, 50 ] -> [ , , 20 ]
     * 5x + 10x + 50x = ((5 + 10 + 50) - 20) = 45
     * [ 3, 7, 35 ] + [ , , 20 ]
     * 3x + 7x = 35
     * [ 13.5, 31.5, 20 ] -> round...
     * [ 14, 31, 20 ]
     *
     * @param int|float            $sum
     * @param int|float|array      $rates
     * @param null|int|float|array $freezes
     * @param null|int             $decimals
     *
     * @return array
     */
    public function balance($sum, array $rates, array $freezes = null, int $decimals = null) : array
    {
        $this->filter->assert('Sum should be number: %s', $sum)
            ->assertNumval($sum);

        $this->filter->assert('Sum should be positive: %s', $sum)
            ->assertPositive($sum);

        $ratesNum = $this->num->theNumvals($rates);
        $freezesNum = $this->num->theNumvals($freezes);

        $keysRates = array_keys($ratesNum);
        $keysFreezes = array_keys($freezesNum);

        $sumRates = array_sum($ratesNum);
        $sumFreezes = array_sum($freezesNum);

        $this->filter->assert('SumRates should be positive: %s', $sumRates)
            ->assertPositive($sumRates);

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
            $rate = $ratesNum[ $k ] ?? 0;
            $freeze = $freezesNum[ $k ] ?? 0;

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

                $ratios = $this->correlation($shareRates);

                foreach ( $keysShare as $ii ) {
                    $value = $ratios[ $ii ] * $diff[ $i ];

                    $src[ $i ] -= $value;
                    $src[ $ii ] += $value;
                }

                $src[ $i ] = $freezesNum[ $i ];
            }
        }

        $shareRates = [];
        foreach ( $keysShare as $k ) {
            $shareRates[ $k ] = $src[ $k ];
        }

        $sumShare = array_sum($shareRates);

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
}
