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

use Gzhegow\Support\Domain\Math\Bcval;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Exceptions\Runtime\OutOfBoundsException;

interface IMath
{
    /**
     * @return ZMath
     */
    public function reset();

    /**
     * @param null|int $scale
     * @param null|int $scaleMax
     *
     * @return ZMath
     */
    public function clone(?int $scale, ?int $scaleMax);

    /**
     * @param null|int $scale
     * @param null|int $scaleMax
     *
     * @return ZMath
     */
    public function with(?int $scale, ?int $scaleMax);

    /**
     * @param int $scale
     *
     * @return ZMath
     */
    public function withScale(int $scale);

    /**
     * @param int $scaleMax
     *
     * @return ZMath
     */
    public function withScaleMax(int $scaleMax);

    /**
     * @param string $value
     *
     * @return Bcval
     */
    public function newBcval(string $value): Bcval;

    /**
     * @return null|int
     */
    public function getScale(): ?int;

    /**
     * @return int
     */
    public function getScaleMax(): int;

    /**
     * @param int|float|string|Bcval|mixed $value
     *
     * @return null|Bcval
     */
    public function bcPositiveVal($value): ?Bcval;

    /**
     * @param int|float|string|Bcval|mixed $value
     *
     * @return null|Bcval
     */
    public function bcNonNegativeVal($value): ?Bcval;

    /**
     * @param int|float|string|Bcval|mixed $value
     *
     * @return null|Bcval
     */
    public function bcNegativeVal($value): ?Bcval;

    /**
     * @param int|float|string|Bcval|mixed $value
     *
     * @return null|Bcval
     */
    public function bcNonPositiveVal($value): ?Bcval;

    /**
     * @param int|float|string|Bcval|mixed $value
     *
     * @return Bcval
     */
    public function theBcPositiveVal($value): Bcval;

    /**
     * @param int|float|string|Bcval|mixed $value
     *
     * @return Bcval
     */
    public function theBcNonNegativeVal($value): Bcval;

    /**
     * @param int|float|string|Bcval|mixed $value
     *
     * @return Bcval
     */
    public function theBcNegativeVal($value): Bcval;

    /**
     * @param int|float|string|Bcval|mixed $value
     *
     * @return Bcval
     */
    public function theBcNonPositiveVal($value): Bcval;

    /**
     * @param int|mixed                    $scale
     * @param int|float|string|Bcval|mixed ...$numbers
     *
     * @return null|int
     */
    public function scaleVal($scale, ...$numbers): ?int;

    /**
     * @param int|mixed                    $scale
     * @param int|float|string|Bcval|mixed ...$numbers
     *
     * @return int
     */
    public function theScaleVal($scale, ...$numbers): int;

    /**
     * @param int|float|string|Bcval|mixed $number
     *
     * @return null|Bcval
     */
    public function bcval($number): ?Bcval;

    /**
     * @param int|float|string|Bcval|mixed $value
     *
     * @return Bcval
     */
    public function theBcval($value): Bcval;

    /**
     * @param string|array $numerics
     * @param null|bool    $uniq
     * @param null|bool    $recursive
     *
     * @return Bcval[]
     */
    public function bcvals($numerics, bool $uniq = null, bool $recursive = null): array;

    /**
     * @param string|array $numerics
     * @param null|bool    $uniq
     * @param null|bool    $recursive
     *
     * @return Bcval[]
     */
    public function theBcvals($numerics, bool $uniq = null, bool $recursive = null): array;

    /**
     * @param int|float|string|Bcval|mixed $number
     * @param null|int                     $decimals
     * @param null|string                  $decimalSeparator
     * @param null|string                  $thousandSeparator
     *
     * @return string
     */
    public function numberFormat(
        $number,
        int $decimals = null,
        string $decimalSeparator = null,
        string $thousandSeparator = null
    );

    /**
     * @param string|mixed $number
     * @param string|array $decimalsSeparators
     * @param string|array $thousandsSeparators
     *
     * @return string
     */
    public function numberParse($number, $decimalsSeparators = null, $thousandsSeparators = null): string;

    /**
     * Возвращает дробную часть числа
     *
     * @param int|float|string|Bcval|mixed $number
     *
     * @return string
     */
    public function frac($number): string;

    /**
     * Определяет максимальное число знаков после запятой из переданных чисел
     *
     * @param int|float|string|Bcval|array $numbers
     * @param null|int                     $scaleMax
     *
     * @return int
     */
    public function fraclen($numbers, int $scaleMax = null): int;

    /**
     * Округление
     *
     * @param int|float|mixed $number
     * @param null|int        $scale
     *
     * @return int|float
     */
    public function round($number, int $scale = null);

    /**
     * Округляет в меньшую сторону
     *
     * @param int|float|mixed $number
     * @param null|int        $scale
     *
     * @return int|float
     */
    public function floor($number, int $scale = null);

    /**
     * Округляет в большую сторону
     *
     * @param int|float|mixed $number
     * @param null|int        $scale
     *
     * @return int|float
     */
    public function ceil($number, int $scale = null);

    /**
     * @param int|float ...$values
     *
     * @return null|int|float
     */
    public function max(...$values);

    /**
     * @param int|float ...$values
     *
     * @return null|int|float
     */
    public function min(...$values);

    /**
     * @param int|float ...$values
     *
     * @return int|float
     */
    public function sum(...$values);

    /**
     * @param int|float ...$values
     *
     * @return float
     */
    public function avg(...$values): float;

    /**
     * @param int|float ...$values
     *
     * @return null|int|float
     */
    public function median(...$values);

    /**
     * @param int|float      $value
     * @param null|int|float $sum
     *
     * @return float
     */
    public function ratio($value, $sum = null): float;

    /**
     * @param int|float      $value
     * @param null|int|float $sum
     *
     * @return float
     */
    public function percent($value, $sum = null): float;

    /**
     * @param int|float      $from
     * @param null|int|float $to
     *
     * @return float
     */
    public function rand($from, $to = null): float;

    /**
     * Рассчитывает соотношение долей между собой
     *
     * @param int|float|array $rates
     *
     * @return float[]
     */
    public function rates(...$rates): array;

    /**
     * Рассчитывает соотношение долей между собой
     * Нулевые соотношения получают пропорционально их количества - чем нулей больше, тем меньше каждому
     * В то же время нули получают тем больше, чем ближе минимальное и максимальное без учета самих нулей
     *
     * @param int|float|array $rates
     *
     * @return float[]
     */
    public function ratesZero(...$rates): array;

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
    public function balance($sum, $ratesNeedle, $ratesFreezes = null): array;

    /**
     * @param int|float|string|Bcval|mixed $a
     * @param int|float|string|Bcval|mixed $b
     * @param null|int                     $scale
     *
     * @return int
     */
    public function bccomp($a, $b, int $scale = null): int;

    /**
     * @param int|float|string|Bcval|mixed $a
     * @param int|float|string|Bcval|mixed $b
     * @param null|int                     $scale
     *
     * @return Bcval
     */
    public function bcadd($a, $b, int $scale = null): Bcval;

    /**
     * @param int|float|string|Bcval|mixed $a
     * @param int|float|string|Bcval|mixed $b
     * @param null|int                     $scale
     *
     * @return Bcval
     */
    public function bcsub($a, $b, int $scale = null): Bcval;

    /**
     * @param int|float|string|Bcval|mixed $a
     * @param int|float|string|Bcval|mixed $b
     * @param null|int                     $scale
     *
     * @return Bcval
     */
    public function bcmul($a, $b, int $scale = null): Bcval;

    /**
     * @param int|float|string|Bcval|mixed $a
     * @param int|float|string|Bcval|mixed $b
     * @param null|int                     $scale
     *
     * @return Bcval
     */
    public function bcmod($a, $b, int $scale = null);

    /**
     * @param int|float|string|Bcval|mixed $a
     * @param int|float|string|Bcval|mixed $b
     * @param null|int                     $scale
     *
     * @return Bcval
     */
    public function bcdiv($a, $b, int $scale = null): Bcval;

    /**
     * @param int|float|string|Bcval|mixed $val
     * @param int|float|string|Bcval|mixed $exp
     * @param null|int                     $scale
     *
     * @return Bcval
     */
    public function bcpow($val, $exp, int $scale = null): Bcval;

    /**
     * @param int|float|string|Bcval|mixed $val
     * @param null|int                     $scale
     *
     * @return Bcval
     */
    public function bcsqrt($val, int $scale = null): Bcval;

    /**
     * Получает символ "минус", если число отрицательное, или пустую строку
     *
     * @param int|float|string|Bcval|mixed $number
     *
     * @return Bcval
     */
    public function bcminus($number): string;

    /**
     * Получает значение по модулю от числа
     *
     * @param int|float|string|Bcval|mixed $number
     *
     * @return string
     */
    public function bcabs($number): string;

    /**
     * Округление
     *
     * @param int|float|string|Bcval|mixed $number
     * @param null|int                     $scale
     *
     * @return Bcval
     */
    public function bcround($number, int $scale = null): Bcval;

    /**
     * Округляет в меньшую сторону
     *
     * @param int|float|string|Bcval|mixed $number
     * @param null|int                     $scale
     *
     * @return Bcval
     */
    public function bcfloor($number, int $scale = null): Bcval;

    /**
     * Округляет в большую сторону
     *
     * @param int|float|string|Bcval|mixed $number
     * @param null|int                     $scale
     *
     * @return Bcval
     */
    public function bcceil($number, int $scale = null): Bcval;

    /**
     * @param int|float|string|Bcval|array $numbers
     * @param null|int                     $scale
     *
     * @return null|Bcval
     */
    public function bcmax($numbers, int $scale = null): ?Bcval;

    /**
     * @param int|float|string|Bcval|array $numbers
     * @param null|int                     $scale
     *
     * @return null|Bcval
     */
    public function bcmin($numbers, int $scale = null): ?Bcval;

    /**
     * @param int|float|string|Bcval|array $numbers
     * @param null|int                     $scale
     *
     * @return Bcval
     */
    public function bcsum($numbers, int $scale = null): Bcval;

    /**
     * @param int|float|string|Bcval|array $numbers
     * @param null|int                     $scale
     *
     * @return Bcval
     */
    public function bcavg($numbers, int $scale = null): Bcval;

    /**
     * @param int|float|string|Bcval|array $numbers
     * @param null|int                     $scale
     *
     * @return null|Bcval
     */
    public function bcmedian($numbers, int $scale = null): ?Bcval;

    /**
     * @param int|float      $value
     * @param null|int|float $sum
     * @param null|int       $scale
     *
     * @return Bcval
     */
    public function bcratio($value, $sum = null, int $scale = null): Bcval;

    /**
     * @param int|float|string|Bcval|mixed      $value
     * @param null|int|float|string|Bcval|mixed $sum
     * @param null|int                          $scale
     *
     * @return Bcval
     */
    public function bcpercent($value, $sum = null, int $scale = null): Bcval;

    /**
     * @param int|float|string|Bcval|mixed      $from
     * @param null|int|float|string|Bcval|mixed $to
     * @param null|int                          $scale
     *
     * @return Bcval
     */
    public function bcrand($from, $to = null, int $scale = null): Bcval;

    /**
     * Округление по "правилу денег"
     * Эта функция учитывает "потерянную копейку", 1.0005 будет округлено до 1.01 вместо 1.00 (по математическим правилам)
     *
     * @param int|float|string|Bcval|mixed $number
     * @param null|int                     $scale
     *
     * @return Bcval
     */
    public function bcmoneyround($number, int $scale = null): Bcval;

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
    public function bcmoneyshare($sum, $rates, int $scale = null): array;
}
