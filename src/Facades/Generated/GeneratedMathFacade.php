<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support\Facades\Generated;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Exceptions\Runtime\OutOfBoundsException;
use Gzhegow\Support\Math;

abstract class GeneratedMathFacade
{
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
     * @return int|float|string
     */
    public static function median(...$values)
    {
        return static::getInstance()->median(...$values);
    }

    /**
     * Дробная часть числа
     *
     * @param int|float|string $number
     *
     * @return string
     */
    public static function bcfrac($number): string
    {
        return static::getInstance()->bcfrac($number);
    }

    /**
     * Получает значение по модулю от числа
     *
     * @param int|float|string $number
     * @param string           $minus
     *
     * @return string
     */
    public static function bcabs($number, &$minus = null): string
    {
        return static::getInstance()->bcabs($number, $minus);
    }

    /**
     * Округление
     *
     * @param int|float|string|mixed $number
     * @param int                    $precision
     *
     * @return string
     */
    public static function bcround($number, $precision = 0): string
    {
        return static::getInstance()->bcround($number, $precision);
    }

    /**
     * Округляет в большую сторону
     *
     * @param int|float|string $number
     *
     * @return string
     */
    public static function bcceil(string $number)
    {
        return static::getInstance()->bcceil($number);
    }

    /**
     * Округляет в меньшую сторону
     *
     * @param int|float|string $number
     *
     * @return string
     */
    public static function bcfloor($number): string
    {
        return static::getInstance()->bcfloor($number);
    }

    /**
     * рандомайзер от-до, принимаюший на вход целые или дробные числа
     */
    public static function rand($from, $to = null): string
    {
        return static::getInstance()->rand($from, $to);
    }

    /**
     * преобразовывает массив из чисел в массив промежутков между ними
     * [5,'6{=delimiter}7',8] => [[$min,5],[5,6],[6,7],[7,8],[8,$max]]
     * [5,'6-7',8] => [[$min,5],[5,6],[6,7],[7,8],[8,$max]]
     */
    public static function range(
        array $array,
        float $min = null,
        float $max = null,
        string $delimiter = '...',
        bool $preserve_keys = null
    ): array {
        return static::getInstance()->range($array, $min, $max, $delimiter, $preserve_keys);
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
    public static function moneyround($value, int $scale = null)
    {
        return static::getInstance()->moneyround($value, $scale);
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
    public static function moneyshare($sum, $rates, int $scale = null): array
    {
        return static::getInstance()->moneyshare($sum, $rates, $scale);
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
     * @param null|int             $scale
     *
     * @return array
     */
    public static function balance($sum, array $rates, array $freezes = null, int $scale = null): array
    {
        return static::getInstance()->balance($sum, $rates, $freezes, $scale);
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
    public static function correlation($rates, bool $zero = null): array
    {
        return static::getInstance()->correlation($rates, $zero);
    }

    /**
     * @param int|float|string $number
     *
     * @return null|string
     */
    public static function bcnumval($number): ?string
    {
        return static::getInstance()->bcnumval($number);
    }

    /**
     * @param mixed $value
     *
     * @return string
     */
    public static function theBcnumval($value): string
    {
        return static::getInstance()->theBcnumval($value);
    }

    /**
     * @param string|string[]|array $strings
     * @param null|bool             $uniq
     *
     * @return string[]
     */
    public static function bcnumvals($strings, $uniq = null): array
    {
        return static::getInstance()->bcnumvals($strings, $uniq);
    }

    /**
     * @param string|string[]|array $strings
     * @param null|bool             $uniq
     *
     * @return string[]
     */
    public static function theBcnumvals($strings, $uniq = null): array
    {
        return static::getInstance()->theBcnumvals($strings, $uniq);
    }

    /**
     * @return Math
     */
    abstract public static function getInstance(): Math;
}
