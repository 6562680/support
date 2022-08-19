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

use Gzhegow\Support\Domain\Math\ValueObject\MathBcval;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Exceptions\Runtime\OutOfBoundsException;
use Gzhegow\Support\IMath;
use Gzhegow\Support\SupportFactory;
use Gzhegow\Support\Traits\Load\NumLoadTrait;
use Gzhegow\Support\Traits\Load\StrLoadTrait;
use Gzhegow\Support\XMath;

class Math
{
    /**
     * @param null|int $scale
     *
     * @return XMath
     */
    public static function withScale(?int $scale)
    {
        return static::getInstance()->withScale($scale);
    }

    /**
     * @param null|int $scaleMax
     *
     * @return XMath
     */
    public static function withScaleMax(?int $scaleMax)
    {
        return static::getInstance()->withScaleMax($scaleMax);
    }

    /**
     * @return int
     */
    public static function loadScaleMax(): int
    {
        return static::getInstance()->loadScaleMax();
    }

    /**
     * @param string $validValue
     *
     * @return MathBcval
     */
    public static function newBcval(string $validValue): MathBcval
    {
        return static::getInstance()->newBcval($validValue);
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
     * @param string|mixed $value
     *
     * @return null|string
     */
    public static function filterAlgorism($value): ?string
    {
        return static::getInstance()->filterAlgorism($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return null|int|float|string|object
     */
    public static function filterAlgorismval($value)
    {
        return static::getInstance()->filterAlgorismval($value);
    }

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return null|int|float|string|MathBcval
     */
    public static function filterBcGt0($value)
    {
        return static::getInstance()->filterBcGt0($value);
    }

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return null|int|float|string|MathBcval
     */
    public static function filterBcGte0($value)
    {
        return static::getInstance()->filterBcGte0($value);
    }

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return null|int|float|string|MathBcval
     */
    public static function filterBcLt0($value)
    {
        return static::getInstance()->filterBcLt0($value);
    }

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return null|int|float|string|MathBcval
     */
    public static function filterBcLte0($value)
    {
        return static::getInstance()->filterBcLte0($value);
    }

    /**
     * @param int|mixed                        $scale
     * @param int|float|string|MathBcval|mixed ...$numbers
     *
     * @return null|int
     */
    public static function scaleval($scale, ...$numbers): ?int
    {
        return static::getInstance()->scaleval($scale, ...$numbers);
    }

    /**
     * @param int|float|string|MathBcval|mixed $number
     *
     * @return null|MathBcval
     */
    public static function bcval($number): ?MathBcval
    {
        return static::getInstance()->bcval($number);
    }

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public static function algorismval($value): ?string
    {
        return static::getInstance()->algorismval($value);
    }

    /**
     * @param int|mixed                        $scale
     * @param int|float|string|MathBcval|mixed ...$numbers
     *
     * @return int
     */
    public static function theScaleval($scale, ...$numbers): int
    {
        return static::getInstance()->theScaleval($scale, ...$numbers);
    }

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return MathBcval
     */
    public static function theBcval($value): MathBcval
    {
        return static::getInstance()->theBcval($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return string
     */
    public static function theAlgorismval($value): string
    {
        return static::getInstance()->theAlgorismval($value);
    }

    /**
     * @param string|array $numerics
     * @param null|bool    $uniq
     * @param null|bool    $recursive
     *
     * @return MathBcval[]
     */
    public static function bcvals($numerics, bool $uniq = null, bool $recursive = null): array
    {
        return static::getInstance()->bcvals($numerics, $uniq, $recursive);
    }

    /**
     * @param string|array $algorisms
     * @param null|bool    $uniq
     * @param null|bool    $recursive
     *
     * @return string[]
     */
    public static function algorismvals($algorisms, bool $uniq = null, bool $recursive = null): array
    {
        return static::getInstance()->algorismvals($algorisms, $uniq, $recursive);
    }

    /**
     * @param string|array $numerics
     * @param null|bool    $uniq
     * @param null|bool    $recursive
     *
     * @return MathBcval[]
     */
    public static function theBcvals($numerics, bool $uniq = null, bool $recursive = null): array
    {
        return static::getInstance()->theBcvals($numerics, $uniq, $recursive);
    }

    /**
     * @param string|array $algorisms
     * @param null|bool    $uniq
     * @param null|bool    $recursive
     *
     * @return string[]
     */
    public static function theAlgorismvals($algorisms, bool $uniq = null, bool $recursive = null): array
    {
        return static::getInstance()->theAlgorismvals($algorisms, $uniq, $recursive);
    }

    /**
     * Возвращает дробную часть числа
     *
     * @param int|float|string|MathBcval|mixed $number
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
     * @param int|float|string|MathBcval|array $numbers
     * @param null|int                         $scaleMax
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
     * @param int|float|string|MathBcval|mixed $a
     * @param int|float|string|MathBcval|mixed $b
     * @param null|int                         $scale
     *
     * @return int
     */
    public static function bccomp($a, $b, int $scale = null): int
    {
        return static::getInstance()->bccomp($a, $b, $scale);
    }

    /**
     * @param int|float|string|MathBcval|mixed $a
     * @param int|float|string|MathBcval|mixed $b
     * @param null|int                         $scale
     *
     * @return MathBcval
     */
    public static function bcadd($a, $b, int $scale = null): MathBcval
    {
        return static::getInstance()->bcadd($a, $b, $scale);
    }

    /**
     * @param int|float|string|MathBcval|mixed $a
     * @param int|float|string|MathBcval|mixed $b
     * @param null|int                         $scale
     *
     * @return MathBcval
     */
    public static function bcsub($a, $b, int $scale = null): MathBcval
    {
        return static::getInstance()->bcsub($a, $b, $scale);
    }

    /**
     * @param int|float|string|MathBcval|mixed $a
     * @param int|float|string|MathBcval|mixed $b
     * @param null|int                         $scale
     *
     * @return MathBcval
     */
    public static function bcmul($a, $b, int $scale = null): MathBcval
    {
        return static::getInstance()->bcmul($a, $b, $scale);
    }

    /**
     * @param int|float|string|MathBcval|mixed $a
     * @param int|float|string|MathBcval|mixed $b
     * @param null|int                         $scale
     *
     * @return MathBcval
     */
    public static function bcmod($a, $b, int $scale = null): MathBcval
    {
        return static::getInstance()->bcmod($a, $b, $scale);
    }

    /**
     * @param int|float|string|MathBcval|mixed $a
     * @param int|float|string|MathBcval|mixed $b
     * @param null|int                         $scale
     *
     * @return MathBcval
     */
    public static function bcdiv($a, $b, int $scale = null): MathBcval
    {
        return static::getInstance()->bcdiv($a, $b, $scale);
    }

    /**
     * @param int|float|string|MathBcval|mixed $val
     * @param int|float|string|MathBcval|mixed $exp
     * @param null|int                         $scale
     *
     * @return MathBcval
     */
    public static function bcpow($val, $exp, int $scale = null): MathBcval
    {
        return static::getInstance()->bcpow($val, $exp, $scale);
    }

    /**
     * @param int|float|string|MathBcval|mixed $val
     * @param null|int                         $scale
     *
     * @return MathBcval
     */
    public static function bcsqrt($val, int $scale = null): MathBcval
    {
        return static::getInstance()->bcsqrt($val, $scale);
    }

    /**
     * Получает значение по модулю от числа
     *
     * @param int|float|string|MathBcval|mixed $number
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
     * @param int|float|string|MathBcval|mixed $number
     * @param null|int                         $scale
     *
     * @return MathBcval
     */
    public static function bcround($number, int $scale = null): MathBcval
    {
        return static::getInstance()->bcround($number, $scale);
    }

    /**
     * Округляет в меньшую сторону
     *
     * @param int|float|string|MathBcval|mixed $number
     * @param null|int                         $scale
     *
     * @return MathBcval
     */
    public static function bcfloor($number, int $scale = null): MathBcval
    {
        return static::getInstance()->bcfloor($number, $scale);
    }

    /**
     * Округляет в большую сторону
     *
     * @param int|float|string|MathBcval|mixed $number
     * @param null|int                         $scale
     *
     * @return MathBcval
     */
    public static function bcceil($number, int $scale = null): MathBcval
    {
        return static::getInstance()->bcceil($number, $scale);
    }

    /**
     * @param int|float|string|MathBcval|array $numbers
     * @param null|int                         $scale
     *
     * @return null|MathBcval
     */
    public static function bcmax($numbers, int $scale = null): ?MathBcval
    {
        return static::getInstance()->bcmax($numbers, $scale);
    }

    /**
     * @param int|float|string|MathBcval|array $numbers
     * @param null|int                         $scale
     *
     * @return null|MathBcval
     */
    public static function bcmin($numbers, int $scale = null): ?MathBcval
    {
        return static::getInstance()->bcmin($numbers, $scale);
    }

    /**
     * @param int|float|string|MathBcval|array $numbers
     * @param null|int                         $scale
     *
     * @return MathBcval
     */
    public static function bcsum($numbers, int $scale = null): MathBcval
    {
        return static::getInstance()->bcsum($numbers, $scale);
    }

    /**
     * @param int|float|string|MathBcval|array $numbers
     * @param null|int                         $scale
     *
     * @return MathBcval
     */
    public static function bcavg($numbers, int $scale = null): MathBcval
    {
        return static::getInstance()->bcavg($numbers, $scale);
    }

    /**
     * @param int|float|string|MathBcval|array $numbers
     * @param null|int                         $scale
     *
     * @return null|MathBcval
     */
    public static function bcmedian($numbers, int $scale = null): ?MathBcval
    {
        return static::getInstance()->bcmedian($numbers, $scale);
    }

    /**
     * @param int|float      $value
     * @param null|int|float $sum
     * @param null|int       $scale
     *
     * @return MathBcval
     */
    public static function bcratio($value, $sum = null, int $scale = null): MathBcval
    {
        return static::getInstance()->bcratio($value, $sum, $scale);
    }

    /**
     * @param int|float|string|MathBcval|mixed      $value
     * @param null|int|float|string|MathBcval|mixed $sum
     * @param null|int                              $scale
     *
     * @return MathBcval
     */
    public static function bcpercent($value, $sum = null, int $scale = null): MathBcval
    {
        return static::getInstance()->bcpercent($value, $sum, $scale);
    }

    /**
     * @param int|float|string|MathBcval|mixed      $from
     * @param null|int|float|string|MathBcval|mixed $to
     * @param null|int                              $scale
     *
     * @return MathBcval
     */
    public static function bcrand($from, $to = null, int $scale = null): MathBcval
    {
        return static::getInstance()->bcrand($from, $to, $scale);
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
     * Нули получают пропорционально их количества - чем нулей больше, тем меньше каждому не-нулю
     * Нули получают тем больше, чем ближе минимальное и максимальное без учета самих нулей
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
     * Балансирует общую сумму между получателями учитывая заранее известные ("замороженные") значения
     * Создавалась для взаимозависимого эквалайзера - двигаешь один ползунок - остальные равномерно меняются
     * Заберет у тех, у кого много, раздаст тем, кому мало, недостающее выдаст из суммы
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
     * @param int|string  $floor
     * @param string|null $baseCharsTo
     * @param string      $baseCharsFrom
     * @param int         $baseShiftTo
     * @param int         $baseShiftFrom
     *
     * @return string
     */
    public static function baseConvertFloor(
        $floor,
        string $baseCharsTo = null,
        string $baseCharsFrom = '0123456789',
        int $baseShiftTo = 0,
        int $baseShiftFrom = 0
    ): string {
        return static::getInstance()->baseConvertFloor($floor, $baseCharsTo, $baseCharsFrom, $baseShiftTo, $baseShiftFrom);
    }

    /**
     * @param int|string  $frac
     * @param string|null $baseCharsTo
     * @param string      $baseCharsFrom
     * @param int|null    $scale
     *
     * @return string
     */
    public static function baseConvertFrac(
        $frac,
        string $baseCharsTo = null,
        string $baseCharsFrom = '0123456789',
        int $scale = null
    ): string {
        return static::getInstance()->baseConvertFrac($frac, $baseCharsTo, $baseCharsFrom, $scale);
    }

    /**
     * @param int|float|string $num
     * @param string|null      $baseCharsTo
     * @param string           $baseCharsFrom
     * @param int|null         $scale
     * @param int              $baseShiftTo
     * @param int              $baseShiftFrom
     *
     * @return string
     */
    public static function baseConvert(
        $num,
        string $baseCharsTo = null,
        string $baseCharsFrom = '0123456789',
        int $scale = null,
        int $baseShiftTo = 0,
        int $baseShiftFrom = 0
    ) {
        return static::getInstance()->baseConvert($num, $baseCharsTo, $baseCharsFrom, $scale, $baseShiftTo, $baseShiftFrom);
    }

    /**
     * Округление по "правилу денег"
     * Эта функция учитывает "потерянную копейку", 1.0005 будет округлено до 1.01 вместо 1.00 (по математическим правилам)
     *
     * @param int|float|string|MathBcval|mixed $number
     * @param null|int                         $scale
     *
     * @return MathBcval
     */
    public static function bcmoneyround($number, int $scale = null): MathBcval
    {
        return static::getInstance()->bcmoneyround($number, $scale);
    }

    /**
     * Разбивает сумму между получателями
     * Если разделить 100 на 3 получается 33.33, 33.33, и 33.33 и 0.01 в периоде
     * Функция позволяет разбить исходное число на три, дробная часть от каждого деления достанется первому
     *
     * @param int|float|string|MathBcval|mixed $sum
     * @param int|float|string|MathBcval|array $rates
     * @param null|int                         $scale
     *
     * @return MathBcval[]
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
