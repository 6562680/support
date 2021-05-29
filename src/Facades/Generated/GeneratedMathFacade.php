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
     * bcfrac
     * получает дробную часть числа в виде строки
     *
     * @param int|float|string $number
     * @param int|null         $decimals
     * @param null             $int
     *
     * @return string
     */
    public static function bcFrac($number, int $decimals = 0, &$int = null): string
    {
        return static::getInstance()->bcFrac($number, $decimals, $int);
    }

    /**
     * @param int|float|string $number
     * @param int              $decimals
     *
     * @return null|string
     */
    public static function bcRound($number, int $decimals = 0)
    {
        return static::getInstance()->bcRound($number, $decimals);
    }

    /**
     * @param int|float|string $number
     *
     * @return string
     */
    public static function bcCeil(string $number)
    {
        return static::getInstance()->bcCeil($number);
    }

    /**
     * @param int|float|string $number
     *
     * @return string
     */
    public static function bcFloor($number)
    {
        return static::getInstance()->bcFloor($number);
    }

    /**
     * @param int|float|string $number
     *
     * @return bool
     */
    public static function bcNegative($number): bool
    {
        return static::getInstance()->bcNegative($number);
    }

    /**
     * @param int|float|string $number
     *
     * @return string
     */
    public static function bcAbs(string $number): string
    {
        return static::getInstance()->bcAbs($number);
    }

    /**
     * @param int|float|string $number
     *
     * @return int
     */
    public static function bcDecimals($number): int
    {
        return static::getInstance()->bcDecimals($number);
    }

    /**
     * @param int|float|string $number
     *
     * @return string
     */
    public static function bcNum($number): string
    {
        return static::getInstance()->bcNum($number);
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
    public static function moneyround($value, int $decimals = null)
    {
        return static::getInstance()->moneyround($value, $decimals);
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
    public static function moneyshare($sum, $rates, int $decimals = null): array
    {
        return static::getInstance()->moneyshare($sum, $rates, $decimals);
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
    public static function balance($sum, array $rates, array $freezes = null, int $decimals = null): array
    {
        return static::getInstance()->balance($sum, $rates, $freezes, $decimals);
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
    public static function balanceRatios(...$rates): array
    {
        return static::getInstance()->balanceRatios(...$rates);
    }

    /**
     * @return Math
     */
    abstract public static function getInstance(): Math;
}
