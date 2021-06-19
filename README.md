# Support

Библиотека вспомогательных функций


## Todo

* Math, переписать на `bc_`

```php
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
```
