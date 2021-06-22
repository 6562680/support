<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support\Facades\Generated;

use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Exceptions\Runtime\OutOfBoundsException;
use Gzhegow\Support\Exceptions\Runtime\UnexpectedValueException;
use Gzhegow\Support\Math;

abstract class GeneratedMathFacade
{
    /**
     * @param null|int $scale
     * @param null|int $scaleMax
     *
     * @return Math
     */
    public static function clone(int $scale = null, int $scaleMax = null)
    {
        return static::getInstance()->clone($scale, $scaleMax);
    }

    /**
     * @param null|int $scale
     * @param null|int $scaleMax
     *
     * @return Math
     */
    public static function with(int $scale = null, int $scaleMax = null)
    {
        return static::getInstance()->with($scale, $scaleMax);
    }

    /**
     * @param int $scale
     *
     * @return Math
     */
    public static function withScale(int $scale)
    {
        return static::getInstance()->withScale($scale);
    }

    /**
     * @param int $scaleMax
     *
     * @return Math
     */
    public static function withScaleMax(int $scaleMax)
    {
        return static::getInstance()->withScaleMax($scaleMax);
    }

    /**
     * @return Math
     */
    public static function withoutScale()
    {
        return static::getInstance()->withoutScale();
    }

    /**
     * @return int
     */
    public static function getScale(): int
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
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public static function isPositive($value): bool
    {
        return static::getInstance()->isPositive($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public static function isNonNegative($value): bool
    {
        return static::getInstance()->isNonNegative($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public static function isNegative($value): bool
    {
        return static::getInstance()->isNegative($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public static function isNonPositive($value): bool
    {
        return static::getInstance()->isNonPositive($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public static function filterPositive($value)
    {
        return static::getInstance()->filterPositive($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public static function filterNonNegative($value)
    {
        return static::getInstance()->filterNonNegative($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public static function filterNegative($value)
    {
        return static::getInstance()->filterNegative($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public static function filterNonPositive($value)
    {
        return static::getInstance()->filterNonPositive($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public static function assertPositive($value)
    {
        return static::getInstance()->assertPositive($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public static function assertNonNegative($value)
    {
        return static::getInstance()->assertNonNegative($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public static function assertNegative($value)
    {
        return static::getInstance()->assertNegative($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public static function assertNonPositive($value)
    {
        return static::getInstance()->assertNonPositive($value);
    }

    /**
     * @param int|mixed              $scale
     * @param int|float|string|mixed ...$numbers
     *
     * @return null|int
     */
    public static function scaleVal($scale, ...$numbers): ?int
    {
        return static::getInstance()->scaleVal($scale, ...$numbers);
    }

    /**
     * @param int|mixed              $scale
     * @param int|float|string|mixed ...$numbers
     *
     * @return int
     */
    public static function theScaleVal($scale, ...$numbers): int
    {
        return static::getInstance()->theScaleVal($scale, ...$numbers);
    }

    /**
     * @param int|float|string|mixed $number
     *
     * @return null|string
     */
    public static function bcval($number): ?string
    {
        return static::getInstance()->bcval($number);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return string
     */
    public static function theBcval($value): string
    {
        return static::getInstance()->theBcval($value);
    }

    /**
     * Возвращает дробную часть числа
     *
     * @param int|float|string|mixed $number
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
     * @param int|float|string|array $numbers
     * @param null|int               $scaleMax
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
     * @param int|float|string|mixed $number
     * @param null|int               $scale
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
     * @param int|float|string|mixed $number
     * @param null|int               $scale
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
     * @param int|float|string $a
     * @param int|float|string $b
     * @param null|int         $scale
     *
     * @return string
     */
    public static function bccomp($a, $b, int $scale = null)
    {
        return static::getInstance()->bccomp($a, $b, $scale);
    }

    /**
     * @param int|float|string $a
     * @param int|float|string $b
     * @param null|int         $scale
     *
     * @return string
     */
    public static function bcadd($a, $b, int $scale = null)
    {
        return static::getInstance()->bcadd($a, $b, $scale);
    }

    /**
     * @param int|float|string $a
     * @param int|float|string $b
     * @param null|int         $scale
     *
     * @return string
     */
    public static function bcsub($a, $b, int $scale = null)
    {
        return static::getInstance()->bcsub($a, $b, $scale);
    }

    /**
     * @param int|float|string $a
     * @param int|float|string $b
     * @param null|int         $scale
     *
     * @return string
     */
    public static function bcmul($a, $b, int $scale = null)
    {
        return static::getInstance()->bcmul($a, $b, $scale);
    }

    /**
     * @param int|float|string $a
     * @param int|float|string $b
     * @param null|int         $scale
     *
     * @return string
     */
    public static function bcdiv($a, $b, int $scale = null)
    {
        return static::getInstance()->bcdiv($a, $b, $scale);
    }

    /**
     * @param int|float|string $val
     * @param int|float|string $exp
     * @param null|int         $scale
     *
     * @return string
     */
    public static function bcpow($val, $exp, int $scale = null)
    {
        return static::getInstance()->bcpow($val, $exp, $scale);
    }

    /**
     * Получает минуса или пустой строки если число отрицательное
     *
     * @param int|float|string|mixed $number
     *
     * @return string
     */
    public static function bcminus($number): string
    {
        return static::getInstance()->bcminus($number);
    }

    /**
     * Получает значение по модулю от числа
     *
     * @param int|float|string|mixed $number
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
     * @param int|float|string|mixed $number
     * @param null|int               $scale
     *
     * @return string
     */
    public static function bcround($number, int $scale = null): string
    {
        return static::getInstance()->bcround($number, $scale);
    }

    /**
     * Округляет в меньшую сторону
     *
     * @param int|float|string|mixed $number
     * @param null|int               $scale
     *
     * @return string
     */
    public static function bcfloor($number, int $scale = null): string
    {
        return static::getInstance()->bcfloor($number, $scale);
    }

    /**
     * Округляет в большую сторону
     *
     * @param int|float|string|mixed $number
     * @param null|int               $scale
     *
     * @return string
     */
    public static function bcceil($number, int $scale = null): string
    {
        return static::getInstance()->bcceil($number, $scale);
    }

    /**
     * @param int|float|string|array $numbers
     * @param null|int               $scale
     *
     * @return null|string
     */
    public static function bcmax($numbers, int $scale = null): ?string
    {
        return static::getInstance()->bcmax($numbers, $scale);
    }

    /**
     * @param int|float|string|array $numbers
     * @param null|int               $scale
     *
     * @return null|string
     */
    public static function bcmin($numbers, int $scale = null): ?string
    {
        return static::getInstance()->bcmin($numbers, $scale);
    }

    /**
     * @param int|float|string|array $numbers
     * @param null|int               $scale
     *
     * @return string
     */
    public static function bcsum($numbers, int $scale = null): string
    {
        return static::getInstance()->bcsum($numbers, $scale);
    }

    /**
     * @param int|float|string|array $numbers
     * @param null|int               $scale
     *
     * @return string
     */
    public static function bcavg($numbers, int $scale = null): string
    {
        return static::getInstance()->bcavg($numbers, $scale);
    }

    /**
     * @param int|float|string|array $numbers
     * @param null|int               $scale
     *
     * @return null|string
     */
    public static function bcmedian($numbers, int $scale = null): ?string
    {
        return static::getInstance()->bcmedian($numbers, $scale);
    }

    /**
     * @param int|float      $value
     * @param null|int|float $sum
     * @param null|int       $scale
     *
     * @return float
     */
    public static function bcratio($value, $sum = null, int $scale = null): float
    {
        return static::getInstance()->bcratio($value, $sum, $scale);
    }

    /**
     * @param int|float|string      $value
     * @param null|int|float|string $sum
     * @param null|int              $scale
     *
     * @return float
     */
    public static function bcpercent($value, $sum = null, int $scale = null): float
    {
        return static::getInstance()->bcpercent($value, $sum, $scale);
    }

    /**
     * @param int|float|string      $from
     * @param null|int|float|string $to
     * @param null|int              $scale
     *
     * @return string
     */
    public static function bcrand($from, $to = null, int $scale = null): string
    {
        return static::getInstance()->bcrand($from, $to, $scale);
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
    public static function bcmoneyfloor($number, int $scale = null): string
    {
        return static::getInstance()->bcmoneyfloor($number, $scale);
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
    public static function bcmoneyceil($number, int $scale = null): string
    {
        return static::getInstance()->bcmoneyceil($number, $scale);
    }

    /**
     * @param string|string[]|array $strings
     * @param null|bool             $uniq
     *
     * @return string[]
     */
    public static function bcvals($strings, $uniq = null): array
    {
        return static::getInstance()->bcvals($strings, $uniq);
    }

    /**
     * @param string|string[]|array $strings
     * @param null|bool             $uniq
     *
     * @return string[]
     */
    public static function theBcvals($strings, $uniq = null): array
    {
        return static::getInstance()->theBcvals($strings, $uniq);
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
    public static function bcmoneyshare($sum, $rates, int $scale = null): array
    {
        return static::getInstance()->bcmoneyshare($sum, $rates, $scale);
    }

    /**
     * @return Math
     */
    abstract public static function getInstance(): Math;
}
