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
     * @param int|float ...$values
     *
     * @return int|float
     */
    public function sum(...$values)
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

        $sum = $this->sum(...$list);
        $len = count($list);

        $avg = $len
            ? ( $sum / $len )
            : 0.0;

        return $avg;
    }


    /**
     * bcfrac
     * получает дробную часть числа в виде строки
     *
     * @param int|float|string $number
     * @param int|null         $decimals
     * @param null             $int
     *
     * @return string
     */
    public function bcFrac($number, int $decimals = 0, &$int = null) : string
    {
        if ($decimals && ( $decimals < 0 )) {
            throw new \InvalidArgumentException('Decimals should begins from 0');
        }

        $number = $this->bcnum($number);
        $decimals = ( 2 <= func_num_args() )
            ? $decimals
            : $this->bcDecimals($number);

        $int = bcadd($number, 0, $decimals);

        $frac = '0';
        if (false !== ( $pos = strrpos($int, '.') )) {
            $frac = sprintf('%d', substr($int, $pos + 1));

            $int = substr($int, 0, $pos);
        }

        return $frac;
    }


    /**
     * @param int|float|string $number
     * @param int              $decimals
     *
     * @return null|string
     */
    public function bcRound($number, int $decimals = 0)
    {
        $number = $this->bcnum($number);

        $pow = bcpow(10, $decimals + 1);
        $const = $this->bcNegative($number)
            ? -5
            : 5;

        $result = bcdiv(
            bcadd(
                bcmul(
                    $number,
                    $pow, $decimals
                ),
                $const, $decimals
            ),
            $pow, $decimals
        );

        return $result;
    }

    /**
     * @param int|float|string $number
     *
     * @return string
     */
    public function bcCeil(string $number)
    {
        $number = $this->bcNum($number);

        $result = $this->bcNegative($number)
            ? ( ( $v = $this->bcFloor(substr($number, 1)) )
                ? "-$v"
                : $v )
            : bcadd(strtok($number, '.'), strtok('.') != 0);

        return $result;
    }

    /**
     * @param int|float|string $number
     *
     * @return string
     */
    public function bcFloor($number)
    {
        $number = $this->bcnum($number);

        $result = $this->bcnegative($number)
            ? '-' . $this->bcceil(substr($number, 1))
            : strtok($number, '.');

        return $result;
    }


    /**
     * @param int|float|string $number
     *
     * @return bool
     */
    public function bcNegative($number) : bool
    {
        $number = $this->bcnum($number);

        $result = strpos($number, '-') === 0; // Is the number less than 0?

        return $result;
    }


    /**
     * @param int|float|string $number
     *
     * @return string
     */
    public function bcAbs(string $number) : string
    {
        $number = $this->bcnum($number);

        $result = $this->bcnegative($number)
            ? strpos($number, 1)
            : $number;

        return $result;
    }


    /**
     * @param int|float|string $number
     *
     * @return int
     */
    public function bcDecimals($number) : int
    {
        $number = $this->bcnum($number);

        $decimals = strlen(substr(strstr($number, '.'), 1));

        return $decimals;
    }


    /**
     * @param int|float|string $number
     *
     * @return string
     */
    public function bcNum($number) : string
    {
        if (! ( is_string($number) || is_float($number) || is_int($number) )) {
            throw new InvalidArgumentException('Num should be int, float or string');
        }

        if ('' === $number) {
            throw new InvalidArgumentException('Num should be not empty');
        }

        $converted = implode('.', explode(',', $number, 2));
        $converted = str_replace(' ', '', $converted);

        if (! ctype_digit(str_replace('.', '', $converted))) {
            throw new InvalidArgumentException('Invalid number passed: ' . $number);
        }

        return $converted;
    }


    /**
     * Округление по "правилу денег" (проверка потерянной копейки)
     * Округлит 1.00000001 до 1.01 (если нужно два знака после запятой)
     * Как правило клиенту выставляется цена на копейку больше, а со счета компании списывается на копейку меньше
     * Когда наоборот - это мое уважение
     *
     * @param int|float $value
     * @param null|int  $decimals
     *
     * @return int|float
     */
    public function moneyround($value, int $decimals = null)
    {
        if (null === $this->filter->filterNumval($value)) {
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
     * Разбивает сумму между получателями
     * Если разделить 100 на 3 получается 33.33, 33.33, и 33.34
     * Функция позволяет разбить исходное число на три, не потеряв дробную часть
     *
     * @param int|float       $sum
     * @param int|float|array $rates
     * @param null|int        $decimals
     *
     * @return int[]|float[]
     */
    public function moneyshare($sum, $rates, int $decimals = null) : array
    {
        $this->filter->assert('Sum should be number: %s')
            ->assertNumval($sum);

        $rates = $this->num->theNumvals($rates, null, 'Each Rate should be number: %s');

        $result = [];

        $ratesIndexes = array_keys($rates);
        $ratesSum = array_sum($rates);

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
     * Балансирует общую сумму между получателями учитывая заранее известные ("замороженные") значения
     * Заберет у тех, у кого много, раздаст тем, кому мало, недостающее выдаст из суммы
     * Очень социалистическая функция :)
     *
     * [ 5, 10, 50 ] -> [ , , 20 ]
     * 5x + 10x + 50x = ((5 + 10 + 50) - 20) = 45
     * [ 3, 7, 35 ] + [ , , 20 ]
     * 3x + 7x = 35
     * [ 13.5, 31.5, 20 ] -> round to decimals...
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
        $freezes = $freezes ?? [];

        if (null === $this->filter->filterNumval($sum)) {
            throw new InvalidArgumentException('Sum should be number');
        }

        $rates = $this->num->theNumvals($rates);
        $freezes = $this->num->numvals($freezes);

        if ($sum <= 0) {
            throw new OutOfBoundsException('Sum should be positive', $sum);
        }

        $keysRates = array_keys($rates);
        $keysFreezes = array_keys($freezes);

        $sumRates = array_sum($rates);
        $sumFreezes = array_sum($freezes);

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

    /**
     * Рассчитывает соотношение балансировки - чем больше у получателя было тем больше ему достанется
     * Учитывает получателей у которых было значение 0, в этом случае им достанется определенный минимум
     * Очень капиталистическая функция :(
     *
     * @param int|float|array $rates
     *
     * @return array
     */
    public function balanceRatios(...$rates) : array
    {
        $rates = $this->num->theNumvals(...$rates);

        $result = [];

        $ratesIndexes = array_keys($rates);
        $ratesSum = array_sum($rates);

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
        $resultSum = array_sum($result);
        $zeroSum = 1 - $resultSum;

        foreach ( $zeroIndexes as $i ) {
            $result[ $i ] = $zeroSum / count($zeroIndexes);
        }

        return $result;
    }
}
