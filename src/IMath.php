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

use Gzhegow\Support\Domain\Math\ValueObject\MathBcval;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Exceptions\Runtime\OutOfBoundsException;
use Gzhegow\Support\Traits\Load\NumLoadTrait;
use Gzhegow\Support\Traits\Load\StrLoadTrait;

interface IMath
{
    /**
     * @param null|int $scale
     *
     * @return XMath
     */
    public function withScale(?int $scale);

    /**
     * @param null|int $scaleMax
     *
     * @return XMath
     */
    public function withScaleMax(?int $scaleMax);

    /**
     * @return int
     */
    public function loadScaleMax(): int;

    /**
     * @param string $validValue
     *
     * @return MathBcval
     */
    public function newBcval(string $validValue): MathBcval;

    /**
     * @return null|int
     */
    public function getScale(): ?int;

    /**
     * @return int
     */
    public function getScaleMax(): int;

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function filterAlgorism($value): ?string;

    /**
     * @param string|mixed $value
     *
     * @return null|int|float|string|object
     */
    public function filterAlgorismval($value);

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return null|int|float|string|MathBcval
     */
    public function filterBcGt0($value);

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return null|int|float|string|MathBcval
     */
    public function filterBcGte0($value);

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return null|int|float|string|MathBcval
     */
    public function filterBcLt0($value);

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return null|int|float|string|MathBcval
     */
    public function filterBcLte0($value);

    /**
     * @param int|mixed                        $scale
     * @param int|float|string|MathBcval|mixed ...$numbers
     *
     * @return null|int
     */
    public function scaleval($scale, ...$numbers): ?int;

    /**
     * @param int|float|string|MathBcval|mixed $number
     *
     * @return null|MathBcval
     */
    public function bcval($number): ?MathBcval;

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function algorismval($value): ?string;

    /**
     * @param int|mixed                        $scale
     * @param int|float|string|MathBcval|mixed ...$numbers
     *
     * @return int
     */
    public function theScaleval($scale, ...$numbers): int;

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return MathBcval
     */
    public function theBcval($value): MathBcval;

    /**
     * @param string|mixed $value
     *
     * @return string
     */
    public function theAlgorismval($value): string;

    /**
     * @param string|array $numerics
     * @param null|bool    $uniq
     * @param null|bool    $recursive
     *
     * @return MathBcval[]
     */
    public function bcvals($numerics, bool $uniq = null, bool $recursive = null): array;

    /**
     * @param string|array $algorisms
     * @param null|bool    $uniq
     * @param null|bool    $recursive
     *
     * @return string[]
     */
    public function algorismvals($algorisms, bool $uniq = null, bool $recursive = null): array;

    /**
     * @param string|array $numerics
     * @param null|bool    $uniq
     * @param null|bool    $recursive
     *
     * @return MathBcval[]
     */
    public function theBcvals($numerics, bool $uniq = null, bool $recursive = null): array;

    /**
     * @param string|array $algorisms
     * @param null|bool    $uniq
     * @param null|bool    $recursive
     *
     * @return string[]
     */
    public function theAlgorismvals($algorisms, bool $uniq = null, bool $recursive = null): array;

    /**
     * Возвращает дробную часть числа
     *
     * @param int|float|string|MathBcval|mixed $number
     *
     * @return string
     */
    public function frac($number): string;

    /**
     * Определяет максимальное число знаков после запятой из переданных чисел
     *
     * @param int|float|string|MathBcval|array $numbers
     * @param null|int                         $scaleMax
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
     * @param int|float|string|MathBcval|mixed $a
     * @param int|float|string|MathBcval|mixed $b
     * @param null|int                         $scale
     *
     * @return int
     */
    public function bccomp($a, $b, int $scale = null): int;

    /**
     * @param int|float|string|MathBcval|mixed $a
     * @param int|float|string|MathBcval|mixed $b
     * @param null|int                         $scale
     *
     * @return MathBcval
     */
    public function bcadd($a, $b, int $scale = null): MathBcval;

    /**
     * @param int|float|string|MathBcval|mixed $a
     * @param int|float|string|MathBcval|mixed $b
     * @param null|int                         $scale
     *
     * @return MathBcval
     */
    public function bcsub($a, $b, int $scale = null): MathBcval;

    /**
     * @param int|float|string|MathBcval|mixed $a
     * @param int|float|string|MathBcval|mixed $b
     * @param null|int                         $scale
     *
     * @return MathBcval
     */
    public function bcmul($a, $b, int $scale = null): MathBcval;

    /**
     * @param int|float|string|MathBcval|mixed $a
     * @param int|float|string|MathBcval|mixed $b
     * @param null|int                         $scale
     *
     * @return MathBcval
     */
    public function bcmod($a, $b, int $scale = null): MathBcval;

    /**
     * @param int|float|string|MathBcval|mixed $a
     * @param int|float|string|MathBcval|mixed $b
     * @param null|int                         $scale
     *
     * @return MathBcval
     */
    public function bcdiv($a, $b, int $scale = null): MathBcval;

    /**
     * @param int|float|string|MathBcval|mixed $val
     * @param int|float|string|MathBcval|mixed $exp
     * @param null|int                         $scale
     *
     * @return MathBcval
     */
    public function bcpow($val, $exp, int $scale = null): MathBcval;

    /**
     * @param int|float|string|MathBcval|mixed $val
     * @param null|int                         $scale
     *
     * @return MathBcval
     */
    public function bcsqrt($val, int $scale = null): MathBcval;

    /**
     * Получает значение по модулю от числа
     *
     * @param int|float|string|MathBcval|mixed $number
     *
     * @return string
     */
    public function bcabs($number): string;

    /**
     * Округление
     *
     * @param int|float|string|MathBcval|mixed $number
     * @param null|int                         $scale
     *
     * @return MathBcval
     */
    public function bcround($number, int $scale = null): MathBcval;

    /**
     * Округляет в меньшую сторону
     *
     * @param int|float|string|MathBcval|mixed $number
     * @param null|int                         $scale
     *
     * @return MathBcval
     */
    public function bcfloor($number, int $scale = null): MathBcval;

    /**
     * Округляет в большую сторону
     *
     * @param int|float|string|MathBcval|mixed $number
     * @param null|int                         $scale
     *
     * @return MathBcval
     */
    public function bcceil($number, int $scale = null): MathBcval;

    /**
     * @param int|float|string|MathBcval|array $numbers
     * @param null|int                         $scale
     *
     * @return null|MathBcval
     */
    public function bcmax($numbers, int $scale = null): ?MathBcval;

    /**
     * @param int|float|string|MathBcval|array $numbers
     * @param null|int                         $scale
     *
     * @return null|MathBcval
     */
    public function bcmin($numbers, int $scale = null): ?MathBcval;

    /**
     * @param int|float|string|MathBcval|array $numbers
     * @param null|int                         $scale
     *
     * @return MathBcval
     */
    public function bcsum($numbers, int $scale = null): MathBcval;

    /**
     * @param int|float|string|MathBcval|array $numbers
     * @param null|int                         $scale
     *
     * @return MathBcval
     */
    public function bcavg($numbers, int $scale = null): MathBcval;

    /**
     * @param int|float|string|MathBcval|array $numbers
     * @param null|int                         $scale
     *
     * @return null|MathBcval
     */
    public function bcmedian($numbers, int $scale = null): ?MathBcval;

    /**
     * @param int|float      $value
     * @param null|int|float $sum
     * @param null|int       $scale
     *
     * @return MathBcval
     */
    public function bcratio($value, $sum = null, int $scale = null): MathBcval;

    /**
     * @param int|float|string|MathBcval|mixed      $value
     * @param null|int|float|string|MathBcval|mixed $sum
     * @param null|int                              $scale
     *
     * @return MathBcval
     */
    public function bcpercent($value, $sum = null, int $scale = null): MathBcval;

    /**
     * @param int|float|string|MathBcval|mixed      $from
     * @param null|int|float|string|MathBcval|mixed $to
     * @param null|int                              $scale
     *
     * @return MathBcval
     */
    public function bcrand($from, $to = null, int $scale = null): MathBcval;

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
     * Нули получают пропорционально их количества - чем нулей больше, тем меньше каждому не-нулю
     * Нули получают тем больше, чем ближе минимальное и максимальное без учета самих нулей
     *
     * @param int|float|array $rates
     *
     * @return float[]
     */
    public function ratesZero(...$rates): array;

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
    public function balance($sum, $ratesNeedle, $ratesFreezes = null): array;

    /**
     * @param int|string  $floor
     * @param string|null $baseCharsTo
     * @param string      $baseCharsFrom
     * @param int         $baseShiftTo
     * @param int         $baseShiftFrom
     *
     * @return string
     */
    public function baseConvertFloor(
        $floor,
        string $baseCharsTo = null,
        string $baseCharsFrom = '0123456789',
        int $baseShiftTo = 0,
        int $baseShiftFrom = 0
    ): string;

    /**
     * @param int|string  $frac
     * @param string|null $baseCharsTo
     * @param string      $baseCharsFrom
     * @param int|null    $scale
     *
     * @return string
     */
    public function baseConvertFrac(
        $frac,
        string $baseCharsTo = null,
        string $baseCharsFrom = '0123456789',
        int $scale = null
    ): string;

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
    public function baseConvert(
        $num,
        string $baseCharsTo = null,
        string $baseCharsFrom = '0123456789',
        int $scale = null,
        int $baseShiftTo = 0,
        int $baseShiftFrom = 0
    );

    /**
     * Округление по "правилу денег"
     * Эта функция учитывает "потерянную копейку", 1.0005 будет округлено до 1.01 вместо 1.00 (по математическим правилам)
     *
     * @param int|float|string|MathBcval|mixed $number
     * @param null|int                         $scale
     *
     * @return MathBcval
     */
    public function bcmoneyround($number, int $scale = null): MathBcval;

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
    public function bcmoneyshare($sum, $rates, int $scale = null): array;
}
