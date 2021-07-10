# Support

Библиотека вспомогательных функций


## Todo

```php
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
    //         throw new \InvalidArgumentException('MathF minus `-` should not be used as delimiter');
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
    //         $nonNumeric = ArrF::first($breakpoints, function ($val) {
    //             return ! ZType::is_numerable($val);
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
