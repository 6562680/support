<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * Bcmath
 */
class Bcmath
{
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
    public function bcfrac($number, int $decimals = 0, &$int = null) : string
    {
        if ($decimals && ( $decimals < 0 )) {
            throw new \InvalidArgumentException('Decimals should begins from 0');
        }

        $number = $this->bcnum($number);
        $decimals = ( 2 <= func_num_args() )
            ? $decimals
            : $this->bcdecimals($number);

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
    public function bcround($number, int $decimals = 0)
    {
        $number = $this->bcnum($number);

        $e = bcpow(10, $decimals + 1);
        $const = 5;

        $result = bcdiv(bcadd(bcmul($number, $e), $this->bcnegative($number)
            ? -1 * $const
            : $const), $e, $decimals);

        return $result;
    }

    /**
     * @param int|float|string $number
     *
     * @return string
     */
    public function bcceil(string $number)
    {
        $number = $this->bcnum($number);

        $result = $this->bcnegative($number)
            ? ( ( $v = $this->bcfloor(substr($number, 1)) )
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
    public function bcfloor($number)
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
    public function bcnegative($number) : bool
    {
        $number = $this->bcnum($number);

        $result = strpos($number, '-') === 0; // Is the number less than 0?

        return $result;
    }


    /**
     * @param int|float|string $number
     *
     * @return bool
     */
    public function bcabs(string $number)
    {
        $number = $this->bcnum($number);

        $result = $this->bcnegative($number)
            ? strpos($number, 1)
            : $number;

        return $result;
    }


    /**
     * определяет количество десятичных знаков в числе
     *
     * @param int|float|string $number
     *
     * @return int
     */
    public function bcdecimals($number) : int
    {
        $number = $this->bcnum($number);

        $decimals = strlen(substr(strstr($number, '.'), 1));

        return $decimals;
    }


    /**
     * number
     * приводит число из текстовой формы в математическую
     *
     * @param int|float|string $number
     *
     * @return string
     */
    public function bcnum($number) : string
    {
        if (! ( is_string($number) || is_float($number) || is_int($number) )) {
            throw new InvalidArgumentException('Number should be int, float or string');
        }

        if ('' === $number) {
            throw new InvalidArgumentException('Number should be not empty');
        }

        $converted = implode('.', explode(',', $number, 2));
        $converted = str_replace(' ', '', $converted);

        if (! ctype_digit(str_replace('.', '', $converted))) {
            throw new InvalidArgumentException('Invalid number passed: ' . $number);
        }

        return $converted;
    }
}
