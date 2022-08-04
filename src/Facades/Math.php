<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 * @noinspection RedundantSuppression
 */

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Domain\Math\ValueObject\Bcval;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Exceptions\Runtime\OutOfBoundsException;
use Gzhegow\Support\IMath;
use Gzhegow\Support\SupportFactory;
use Gzhegow\Support\ZMath;

class Math
{
    /**
     * @return ZMath
     */
    public static function reset()
    {
        return static::getInstance()->reset();
    }

    /**
     * @param null|int $scale
     * @param null|int $scaleMax
     *
     * @return ZMath
     */
    public static function clone(?int $scale, ?int $scaleMax)
    {
        return static::getInstance()->clone($scale, $scaleMax);
    }

    /**
     * @param null|int $scale
     * @param null|int $scaleMax
     *
     * @return ZMath
     */
    public static function with(?int $scale, ?int $scaleMax)
    {
        return static::getInstance()->with($scale, $scaleMax);
    }

    /**
     * @param int $scale
     *
     * @return ZMath
     */
    public static function withScale(int $scale)
    {
        return static::getInstance()->withScale($scale);
    }

    /**
     * @param int $scaleMax
     *
     * @return ZMath
     */
    public static function withScaleMax(int $scaleMax)
    {
        return static::getInstance()->withScaleMax($scaleMax);
    }

    /**
     * @param string $value
     *
     * @return Bcval
     */
    public static function newBcval(string $value): Bcval
    {
        return static::getInstance()->newBcval($value);
    }

    /**
     * @return null|int
     */
    public static function getScale(): ?int
    {
        return static::getInstance()->getScale();
    }

    /**
     * @return int
     */
    public static function getScaleMax(): int
    {
        return static::getInstance()->getScaleMax();
    }

    /**
     * @param int|float|string|Bcval|mixed $value
     *
     * @return null|Bcval
     */
    public static function bcPositiveVal($value): ?Bcval
    {
        return static::getInstance()->bcPositiveVal($value);
    }

    /**
     * @param int|float|string|Bcval|mixed $value
     *
     * @return null|Bcval
     */
    public static function bcNonNegativeVal($value): ?Bcval
    {
        return static::getInstance()->bcNonNegativeVal($value);
    }

    /**
     * @param int|float|string|Bcval|mixed $value
     *
     * @return null|Bcval
     */
    public static function bcNegativeVal($value): ?Bcval
    {
        return static::getInstance()->bcNegativeVal($value);
    }

    /**
     * @param int|float|string|Bcval|mixed $value
     *
     * @return null|Bcval
     */
    public static function bcNonPositiveVal($value): ?Bcval
    {
        return static::getInstance()->bcNonPositiveVal($value);
    }

    /**
     * @param int|float|string|Bcval|mixed $value
     *
     * @return Bcval
     */
    public static function theBcPositiveVal($value): Bcval
    {
        return static::getInstance()->theBcPositiveVal($value);
    }

    /**
     * @param int|float|string|Bcval|mixed $value
     *
     * @return Bcval
     */
    public static function theBcNonNegativeVal($value): Bcval
    {
        return static::getInstance()->theBcNonNegativeVal($value);
    }

    /**
     * @param int|float|string|Bcval|mixed $value
     *
     * @return Bcval
     */
    public static function theBcNegativeVal($value): Bcval
    {
        return static::getInstance()->theBcNegativeVal($value);
    }

    /**
     * @param int|float|string|Bcval|mixed $value
     *
     * @return Bcval
     */
    public static function theBcNonPositiveVal($value): Bcval
    {
        return static::getInstance()->theBcNonPositiveVal($value);
    }

    /**
     * @param int|mixed                    $scale
     * @param int|float|string|Bcval|mixed ...$numbers
     *
     * @return null|int
     */
    public static function scaleVal($scale, ...$numbers): ?int
    {
        return static::getInstance()->scaleVal($scale, ...$numbers);
    }

    /**
     * @param int|mixed                    $scale
     * @param int|float|string|Bcval|mixed ...$numbers
     *
     * @return int
     */
    public static function theScaleVal($scale, ...$numbers): int
    {
        return static::getInstance()->theScaleVal($scale, ...$numbers);
    }

    /**
     * @param int|float|string|Bcval|mixed $number
     *
     * @return null|Bcval
     */
    public static function bcval($number): ?Bcval
    {
        return static::getInstance()->bcval($number);
    }

    /**
     * @param int|float|string|Bcval|mixed $value
     *
     * @return Bcval
     */
    public static function theBcval($value): Bcval
    {
        return static::getInstance()->theBcval($value);
    }

    /**
     * @param string|array $numerics
     * @param null|bool    $uniq
     * @param null|bool    $recursive
     *
     * @return Bcval[]
     */
    public static function bcvals($numerics, bool $uniq = null, bool $recursive = null): array
    {
        return static::getInstance()->bcvals($numerics, $uniq, $recursive);
    }

    /**
     * @param string|array $numerics
     * @param null|bool    $uniq
     * @param null|bool    $recursive
     *
     * @return Bcval[]
     */
    public static function theBcvals($numerics, bool $uniq = null, bool $recursive = null): array
    {
        return static::getInstance()->theBcvals($numerics, $uniq, $recursive);
    }

    /**
     * @param int|float|string|Bcval|mixed $number
     * @param null|int                     $decimals
     * @param null|string                  $decimalSeparator
     * @param null|string                  $thousandSeparator
     *
     * @return string
     */
    public static function numberFormat(
        $number,
        int $decimals = null,
        string $decimalSeparator = null,
        string $thousandSeparator = null
    ) {
        return static::getInstance()->numberFormat($number, $decimals, $decimalSeparator, $thousandSeparator);
    }

    /**
     * @param string|mixed $number
     * @param string|array $decimalsSeparators
     * @param string|array $thousandsSeparators
     *
     * @return string
     */
    public static function numberParse($number, $decimalsSeparators = null, $thousandsSeparators = null): string
    {
        return static::getInstance()->numberParse($number, $decimalsSeparators, $thousandsSeparators);
    }

    /**
     * Возвращает дробную часть числа
     *
     * @param int|float|string|Bcval|mixed $number
     *
     * @return string
     */
    public static function frac($number): string
    {
        return static::getInstance()->frac($number);
    }

    /**
     * Определяет максимальное число знаков после запятой из переданных чисел
     *
     * @param int|float|string|Bcval|array $numbers
     * @param null|int                     $scaleMax
     *
     * @return int
     */
    public static function fraclen($numbers, int $scaleMax = null): int
    {
        return static::getInstance()->fraclen($numbers, $scaleMax);
    }

    /**
     * Округление
     *
     * @param int|float|mixed $number
     * @param null|int        $scale
     *
     * @return int|float
     */
    public static function round($number, int $scale = null)
    {
        return static::getInstance()->round($number, $scale);
    }

    /**
     * Округляет в меньшую сторону
     *
     * @param int|float|mixed $number
     * @param null|int        $scale
     *
     * @return int|float
     */
    public static function floor($number, int $scale = null)
    {
        return static::getInstance()->floor($number, $scale);
    }

    /**
     * Округляет в большую сторону
     *
     * @param int|float|mixed $number
     * @param null|int        $scale
     *
     * @return int|float
     */
    public static function ceil($number, int $scale = null)
    {
        return static::getInstance()->ceil($number, $scale);
    }

    /**
     * @param int|float ...$values
     *
     * @return null|int|float
     */
    public static function max(...$values)
    {
        return static::getInstance()->max(...$values);
    }

    /**
     * @param int|float ...$values
     *
     * @return null|int|float
     */
    public static function min(...$values)
    {
        return static::getInstance()->min(...$values);
    }

    /**
     * @param int|float ...$values
     *
     * @return int|float
     */
    public static function sum(...$values)
    {
        return static::getInstance()->sum(...$values);
    }

    /**
     * @param int|float ...$values
     *
     * @return float
     */
    public static function avg(...$values): float
    {
        return static::getInstance()->avg(...$values);
    }

    /**
     * @param int|float ...$values
     *
     * @return null|int|float
     */
    public static function median(...$values)
    {
        return static::getInstance()->median(...$values);
    }

    /**
     * @param int|float      $value
     * @param null|int|float $sum
     *
     * @return float
     */
    public static function ratio($value, $sum = null): float
    {
        return static::getInstance()->ratio($value, $sum);
    }

    /**
     * @param int|float      $value
     * @param null|int|float $sum
     *
     * @return float
     */
    public static function percent($value, $sum = null): float
    {
        return static::getInstance()->percent($value, $sum);
    }

    /**
     * @param int|float      $from
     * @param null|int|float $to
     *
     * @return float
     */
    public static function rand($from, $to = null): float
    {
        return static::getInstance()->rand($from, $to);
    }

    /**
     * Рассчитывает соотношение долей между собой
     *
     * @param int|float|array $rates
     *
     * @return float[]
     */
    public static function rates(...$rates): array
    {
        return static::getInstance()->rates(...$rates);
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
    public static function ratesZero(...$rates): array
    {
        return static::getInstance()->ratesZero(...$rates);
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
    public static function balance($sum, $ratesNeedle, $ratesFreezes = null): array
    {
        return static::getInstance()->balance($sum, $ratesNeedle, $ratesFreezes);
    }

    /**
     * @param int|float|string|Bcval|mixed $a
     * @param int|float|string|Bcval|mixed $b
     * @param null|int                     $scale
     *
     * @return int
     */
    public static function bccomp($a, $b, int $scale = null): int
    {
        return static::getInstance()->bccomp($a, $b, $scale);
    }

    /**
     * @param int|float|string|Bcval|mixed $a
     * @param int|float|string|Bcval|mixed $b
     * @param null|int                     $scale
     *
     * @return Bcval
     */
    public static function bcadd($a, $b, int $scale = null): Bcval
    {
        return static::getInstance()->bcadd($a, $b, $scale);
    }

    /**
     * @param int|float|string|Bcval|mixed $a
     * @param int|float|string|Bcval|mixed $b
     * @param null|int                     $scale
     *
     * @return Bcval
     */
    public static function bcsub($a, $b, int $scale = null): Bcval
    {
        return static::getInstance()->bcsub($a, $b, $scale);
    }

    /**
     * @param int|float|string|Bcval|mixed $a
     * @param int|float|string|Bcval|mixed $b
     * @param null|int                     $scale
     *
     * @return Bcval
     */
    public static function bcmul($a, $b, int $scale = null): Bcval
    {
        return static::getInstance()->bcmul($a, $b, $scale);
    }

    /**
     * @param int|float|string|Bcval|mixed $a
     * @param int|float|string|Bcval|mixed $b
     * @param null|int                     $scale
     *
     * @return Bcval
     */
    public static function bcmod($a, $b, int $scale = null)
    {
        return static::getInstance()->bcmod($a, $b, $scale);
    }

    /**
     * @param int|float|string|Bcval|mixed $a
     * @param int|float|string|Bcval|mixed $b
     * @param null|int                     $scale
     *
     * @return Bcval
     */
    public static function bcdiv($a, $b, int $scale = null): Bcval
    {
        return static::getInstance()->bcdiv($a, $b, $scale);
    }

    /**
     * @param int|float|string|Bcval|mixed $val
     * @param int|float|string|Bcval|mixed $exp
     * @param null|int                     $scale
     *
     * @return Bcval
     */
    public static function bcpow($val, $exp, int $scale = null): Bcval
    {
        return static::getInstance()->bcpow($val, $exp, $scale);
    }

    /**
     * @param int|float|string|Bcval|mixed $val
     * @param null|int                     $scale
     *
     * @return Bcval
     */
    public static function bcsqrt($val, int $scale = null): Bcval
    {
        return static::getInstance()->bcsqrt($val, $scale);
    }

    /**
     * Получает символ "минус", если число отрицательное, или пустую строку
     *
     * @param int|float|string|Bcval|mixed $number
     *
     * @return Bcval
     */
    public static function bcminus($number): string
    {
        return static::getInstance()->bcminus($number);
    }

    /**
     * Получает значение по модулю от числа
     *
     * @param int|float|string|Bcval|mixed $number
     *
     * @return string
     */
    public static function bcabs($number): string
    {
        return static::getInstance()->bcabs($number);
    }

    /**
     * Округление
     *
     * @param int|float|string|Bcval|mixed $number
     * @param null|int                     $scale
     *
     * @return Bcval
     */
    public static function bcround($number, int $scale = null): Bcval
    {
        return static::getInstance()->bcround($number, $scale);
    }

    /**
     * Округляет в меньшую сторону
     *
     * @param int|float|string|Bcval|mixed $number
     * @param null|int                     $scale
     *
     * @return Bcval
     */
    public static function bcfloor($number, int $scale = null): Bcval
    {
        return static::getInstance()->bcfloor($number, $scale);
    }

    /**
     * Округляет в большую сторону
     *
     * @param int|float|string|Bcval|mixed $number
     * @param null|int                     $scale
     *
     * @return Bcval
     */
    public static function bcceil($number, int $scale = null): Bcval
    {
        return static::getInstance()->bcceil($number, $scale);
    }

    /**
     * @param int|float|string|Bcval|array $numbers
     * @param null|int                     $scale
     *
     * @return null|Bcval
     */
    public static function bcmax($numbers, int $scale = null): ?Bcval
    {
        return static::getInstance()->bcmax($numbers, $scale);
    }

    /**
     * @param int|float|string|Bcval|array $numbers
     * @param null|int                     $scale
     *
     * @return null|Bcval
     */
    public static function bcmin($numbers, int $scale = null): ?Bcval
    {
        return static::getInstance()->bcmin($numbers, $scale);
    }

    /**
     * @param int|float|string|Bcval|array $numbers
     * @param null|int                     $scale
     *
     * @return Bcval
     */
    public static function bcsum($numbers, int $scale = null): Bcval
    {
        return static::getInstance()->bcsum($numbers, $scale);
    }

    /**
     * @param int|float|string|Bcval|array $numbers
     * @param null|int                     $scale
     *
     * @return Bcval
     */
    public static function bcavg($numbers, int $scale = null): Bcval
    {
        return static::getInstance()->bcavg($numbers, $scale);
    }

    /**
     * @param int|float|string|Bcval|array $numbers
     * @param null|int                     $scale
     *
     * @return null|Bcval
     */
    public static function bcmedian($numbers, int $scale = null): ?Bcval
    {
        return static::getInstance()->bcmedian($numbers, $scale);
    }

    /**
     * @param int|float      $value
     * @param null|int|float $sum
     * @param null|int       $scale
     *
     * @return Bcval
     */
    public static function bcratio($value, $sum = null, int $scale = null): Bcval
    {
        return static::getInstance()->bcratio($value, $sum, $scale);
    }

    /**
     * @param int|float|string|Bcval|mixed      $value
     * @param null|int|float|string|Bcval|mixed $sum
     * @param null|int                          $scale
     *
     * @return Bcval
     */
    public static function bcpercent($value, $sum = null, int $scale = null): Bcval
    {
        return static::getInstance()->bcpercent($value, $sum, $scale);
    }

    /**
     * @param int|float|string|Bcval|mixed      $from
     * @param null|int|float|string|Bcval|mixed $to
     * @param null|int                          $scale
     *
     * @return Bcval
     */
    public static function bcrand($from, $to = null, int $scale = null): Bcval
    {
        return static::getInstance()->bcrand($from, $to, $scale);
    }

    /**
     * Округление по "правилу денег"
     * Эта функция учитывает "потерянную копейку", 1.0005 будет округлено до 1.01 вместо 1.00 (по математическим правилам)
     *
     * @param int|float|string|Bcval|mixed $number
     * @param null|int                     $scale
     *
     * @return Bcval
     */
    public static function bcmoneyround($number, int $scale = null): Bcval
    {
        return static::getInstance()->bcmoneyround($number, $scale);
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
    public static function bcmoneyshare($sum, $rates, int $scale = null): array
    {
        return static::getInstance()->bcmoneyshare($sum, $rates, $scale);
    }

    /**
     * @return IMath
     */
    public static function getInstance(): IMath
    {
        return SupportFactory::getInstance()->getMath();
    }
}
