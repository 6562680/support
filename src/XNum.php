<?php
/**
 * @noinspection RedundantSuppression
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support;

use Gzhegow\Support\Traits\Load\StrLoadTrait;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * XNum
 */
class XNum implements INum
{
    use StrLoadTrait;


    /**
     * @param int|mixed $value
     *
     * @return null|int
     */
    public function filterInt($value) : ?int
    {
        if (is_int($value)) {
            return $value;
        }

        return null;
    }

    /**
     * @param float|mixed $value
     *
     * @return null|float
     */
    public function filterFloat($value) : ?float
    {
        if (is_float($value) && ! is_nan($value)) {
            return $value;
        }

        return null;
    }

    /**
     * @param float|mixed $value
     *
     * @return null|float
     */
    public function filterNan($value) : ?float
    {
        if (is_float($value) && is_nan($value)) {
            return $value;
        }

        return null;
    }

    /**
     * @param int|float|mixed $value
     *
     * @return null|int|float
     */
    public function filterNum($value) // : ?null|int|float
    {
        if (is_int($value)
            || ( is_float($value) && ! is_nan($value) )
        ) {
            return $value;
        }

        return null;
    }


    /**
     * @param int|string|mixed $value
     *
     * @return null|int|string
     */
    public function filterIntval($value) : ?int
    {
        if (is_int($value)) {
            return $value;
        }

        if (is_float($value)) {
            return intval($value) == $value
                ? $value
                : null;
        }

        if (false !== filter_var($value, FILTER_VALIDATE_INT)) {
            return $value;
        }

        if (false !== filter_var($value, FILTER_VALIDATE_FLOAT)) {
            return intval($value) == $value
                ? $value
                : null;
        }

        return null;
    }

    /**
     * @param float|string|mixed $value
     *
     * @return null|float|string
     */
    public function filterFloatval($value) : ?float
    {
        if (is_float($value) && ! is_nan($value)) {
            return $value;
        }

        if (is_int($value)) {
            return floatval($value) == $value
                ? $value
                : null;
        }

        if (false !== filter_var($value, FILTER_VALIDATE_FLOAT)) {
            return is_nan($value)
                ? null
                : $value;
        }

        if (false !== filter_var($value, FILTER_VALIDATE_INT)) {
            return floatval($value) == $value
                ? $value
                : null;
        }

        return null;
    }

    /**
     * @param int|float|mixed $value
     *
     * @return null|int|float|string
     */
    public function filterNumval($value) // : ?int|float
    {
        $test = null
            ?? $this->filterIntval($value)
            ?? $this->filterFloatval($value);

        if (null !== $test) {
            return $value;
        }

        return null;
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public function filterNumericval($value) // : ?int|float|string
    {
        if (is_int($value)
            || ( is_float($value) && ! is_nan($value) )
            || ( is_string($value) && is_numeric($value) )
        ) {
            return $value;
        }

        return null;
    }


    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float
     */
    public function filterNumGt0($value) // : ?int|float
    {
        if (null === ( $val = $this->numval($value) )) {
            return null;
        }

        if ($val > 0) {
            return $value;
        }

        return null;
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float
     */
    public function filterNumGte0($value) // : ?int|float
    {
        if (null === ( $val = $this->numval($value) )) {
            return null;
        }

        if ($val >= 0) {
            return $value;
        }

        return null;
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float
     */
    public function filterNumLt0($value) // : ?int|float
    {
        if (null === ( $val = $this->numval($value) )) {
            return null;
        }

        if ($val < 0) {
            return $value;
        }

        return null;
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float
     */
    public function filterNumLte0($value) // : ?int|float
    {
        if (null === ( $val = $this->numval($value) )) {
            return null;
        }

        if ($val <= 0) {
            return $value;
        }

        return null;
    }


    /**
     * @param int|mixed $value
     *
     * @return null|int
     */
    public function intval($value) : ?int
    {
        if (null === $this->filterIntval($value)) {
            return null;
        }

        $result = intval($value);

        return $result;
    }

    /**
     * @param float|mixed $value
     *
     * @return null|float
     */
    public function floatval($value) : ?float
    {
        if (null === $this->filterFloatval($value)) {
            return null;
        }

        $result = floatval($value);

        return $result;
    }

    /**
     * @param int|float|mixed $value
     *
     * @return null|int|float
     */
    public function numval($value) // : ?int|float
    {
        if (null === $this->filterNumval($value)) {
            return null;
        }

        return null
            ?? $this->intval($value)
            ?? $this->floatval($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|string
     */
    public function numericval($value) : ?string
    {
        if (null === $this->filterNumericval($value)) {
            return null;
        }

        // @gzhegow
        // use numval or numericval directly
        // hope, we don't have numeric values that cannot be converted to int or float
        return strval($value);
    }


    /**
     * @param int|mixed $value
     *
     * @return int
     */
    public function theIntval($value) : int
    {
        if (null === ( $val = $this->intval($value) )) {
            throw new InvalidArgumentException(
                [ 'Value should be convertable to intval: %s', $value ],
            );
        }

        return $val;
    }

    /**
     * @param float|mixed $value
     *
     * @return float
     */
    public function theFloatval($value) : float
    {
        if (null === ( $val = $this->floatval($value) )) {
            throw new InvalidArgumentException(
                [ 'Value should be convertable to floatval: %s', $value ],
            );
        }

        return $val;
    }

    /**
     * @param int|float|mixed $value
     *
     * @return int|float
     */
    public function theNumval($value) // : int|float
    {
        if (null === ( $val = $this->numval($value) )) {
            throw new InvalidArgumentException(
                [ 'Value should be convertable to numval: %s', $value ],
            );
        }

        return $val;
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return string
     */
    public function theNumericval($value) : string
    {
        if (null === ( $val = $this->numericval($value) )) {
            throw new InvalidArgumentException(
                [ 'Value should be convertable to numericval: %s', $value ],
            );
        }

        return $val;
    }


    /**
     * @param int|array $integers
     * @param null|bool $uniq
     * @param null|bool $recursive
     *
     * @return int[]
     */
    public function intvals($integers, bool $uniq = null, bool $recursive = null) : array
    {
        $result = [];

        $integers = is_array($integers)
            ? $integers
            : [ $integers ];

        if ($recursive) {
            array_walk_recursive($integers, function ($item) use (&$result) {
                if (null !== ( $val = $this->intval($item) )) {
                    $result[] = $val;
                }
            });

        } else {
            foreach ( $integers as $item ) {
                if (null !== ( $val = $this->intval($item) )) {
                    $result[] = $val;
                }
            }
        }

        if ($uniq) {
            $arr = [];
            foreach ( $result as $i ) {
                $arr[ $i ] = true;
            }
            $result = array_keys($arr);
        }

        return $result;
    }

    /**
     * @param float|array $floats
     * @param null|bool   $uniq
     * @param null|bool   $recursive
     *
     * @return float[]
     */
    public function floatvals($floats, bool $uniq = null, bool $recursive = null) : array
    {
        $result = [];

        $floats = is_array($floats)
            ? $floats
            : [ $floats ];

        if ($recursive) {
            array_walk_recursive($floats, function ($item) use (&$result) {
                if (null !== ( $val = $this->floatval($item) )) {
                    $result[] = $val;
                }
            });

        } else {
            foreach ( $floats as $item ) {
                if (null !== ( $val = $this->floatval($item) )) {
                    $result[] = $val;
                }
            }
        }

        if ($uniq) {
            $arr = [];
            foreach ( $result as $i ) {
                $arr[ $i ] = true;
            }
            $result = array_keys($arr);
        }

        return $result;
    }

    /**
     * @param int|float|array $numbers
     * @param null|bool       $uniq
     * @param null|bool       $recursive
     *
     * @return int[]|float[]
     */
    public function numvals($numbers, bool $uniq = null, bool $recursive = null) : array
    {
        $result = [];

        $numbers = is_array($numbers)
            ? $numbers
            : [ $numbers ];

        if ($recursive) {
            array_walk_recursive($numbers, function ($item) use (&$result) {
                if (null !== ( $val = $this->numval($item) )) {
                    $result[] = $val;
                }
            });

        } else {
            foreach ( $numbers as $item ) {
                if (null !== ( $val = $this->numval($item) )) {
                    $result[] = $val;
                }
            }
        }

        if ($uniq) {
            $arr = [];
            foreach ( $result as $i ) {
                $arr[ $i ] = true;
            }
            $result = array_keys($arr);
        }

        return $result;
    }

    /**
     * @param int|float|string|array $numerics
     * @param null|bool              $uniq
     * @param null|bool              $recursive
     *
     * @return string[]
     */
    public function numericvals($numerics, bool $uniq = null, bool $recursive = null) : array
    {
        $result = [];

        $numerics = is_array($numerics)
            ? $numerics
            : [ $numerics ];

        if ($recursive) {
            array_walk_recursive($numerics, function ($item) use (&$result) {
                if (null !== ( $val = $this->numericval($item) )) {
                    $result[] = $val;
                }
            });

        } else {
            foreach ( $numerics as $item ) {
                if (null !== ( $val = $this->numericval($item) )) {
                    $result[] = $val;
                }
            }
        }

        if ($uniq) {
            $arr = [];
            foreach ( $result as $i ) {
                $arr[ $i ] = true;
            }
            $result = array_keys($arr);
        }

        return $result;
    }


    /**
     * @param int|array $integers
     * @param null|bool $uniq
     * @param null|bool $recursive
     *
     * @return int[]
     */
    public function theIntvals($integers, bool $uniq = null, bool $recursive = null) : array
    {
        $result = [];

        $integers = is_array($integers)
            ? $integers
            : [ $integers ];

        if ($recursive) {
            array_walk_recursive($integers, function ($item) use (&$result) {
                $result[] = $this->theIntval($item);
            });

        } else {
            foreach ( $integers as $item ) {
                $result[] = $this->theIntval($item);
            }
        }

        if ($uniq) {
            $arr = [];
            foreach ( $result as $i ) {
                $arr[ $i ] = true;
            }
            $result = array_keys($arr);
        }

        return $result;
    }

    /**
     * @param float|array $floats
     * @param null|bool   $uniq
     * @param null|bool   $recursive
     *
     * @return float[]
     */
    public function theFloatvals($floats, bool $uniq = null, bool $recursive = null) : array
    {
        $result = [];

        $floats = is_array($floats)
            ? $floats
            : [ $floats ];

        if ($recursive) {
            array_walk_recursive($floats, function ($item) use (&$result) {
                $result[] = $this->theFloatval($item);
            });

        } else {
            foreach ( $floats as $item ) {
                $result[] = $this->theFloatval($item);
            }
        }

        if ($uniq) {
            $arr = [];
            foreach ( $result as $i ) {
                $arr[ $i ] = true;
            }
            $result = array_keys($arr);
        }

        return $result;
    }

    /**
     * @param int|float|array $numbers
     * @param null|bool       $uniq
     * @param null|bool       $recursive
     *
     * @return int[]|float[]
     */
    public function theNumvals($numbers, bool $uniq = null, bool $recursive = null) : array
    {
        $result = [];

        $numbers = is_array($numbers)
            ? $numbers
            : [ $numbers ];

        if ($recursive) {
            array_walk_recursive($numbers, function ($item) use (&$result) {
                $result[] = $this->theNumval($item);
            });

        } else {
            foreach ( $numbers as $item ) {
                $result[] = $this->theNumval($item);
            }
        }

        if ($uniq) {
            $arr = [];
            foreach ( $result as $i ) {
                $arr[ $i ] = true;
            }
            $result = array_keys($arr);
        }

        return $result;
    }

    /**
     * @param int|float|string|array $numerics
     * @param null|bool              $uniq
     * @param null|bool              $recursive
     *
     * @return string[]
     */
    public function theNumericvals($numerics, bool $uniq = null, bool $recursive = null) : array
    {
        $result = [];

        $numerics = is_array($numerics)
            ? $numerics
            : [ $numerics ];

        if ($recursive) {
            array_walk_recursive($numerics, function ($item) use (&$result) {
                $result[] = $this->theNumericval($item);
            });

        } else {
            foreach ( $numerics as $item ) {
                $result[] = $this->theNumericval($item);
            }
        }

        if ($uniq) {
            $arr = [];
            foreach ( $result as $i ) {
                $arr[ $i ] = true;
            }
            $result = array_keys($arr);
        }

        return $result;
    }


    /**
     * @param string|mixed $number
     * @param string|array $decimalsSeparators
     * @param string|array $thousandsSeparators
     *
     * @return string
     */
    public function numberParse($number, $decimalsSeparators = null, $thousandsSeparators = null) : string
    {
        $theStr = $this->getStr();

        $number = $theStr->theTrimval($number);

        $decimalsSeparators = $theStr->theStrvals($decimalsSeparators ?? '.');
        $thousandsSeparators = $theStr->theStrvals($thousandsSeparators ?? ',');

        $trims = $theStr->loadTrims();

        $parsed = str_replace($theStr->mb('str_split')($trims), '', $number);
        $parsed = str_replace($thousandsSeparators, '', $parsed);

        $array = $theStr->explode($decimalsSeparators, $parsed);
        if (count($array) > 2) {
            throw new InvalidArgumentException(
                [ 'NAN: contains two or more decimal separators: %s', $number ]
            );
        }
        $parsed = implode('.', $array);

        if ($theStr->mb('strrpos')($parsed, '-')) {
            throw new InvalidArgumentException(
                [ 'NAN: contains minus not at first position: %s', $number ]
            );
        }

        $ctype = str_replace([ '-', '.' ], '', $parsed);
        if (! ctype_digit($ctype)) {
            throw new InvalidArgumentException(
                [ 'NAN: contains something except numbers and symbols `-`,`.`: %s', $number ]
            );
        }

        return $parsed;
    }

    /**
     * @param int|float|string|mixed $number
     * @param null|int               $decimals
     * @param null|string            $decimalSeparator
     * @param null|string            $thousandSeparator
     *
     * @return string
     */
    public function numberFormat($number, int $decimals = null, string $decimalSeparator = null, string $thousandSeparator = null)
    {
        if (null === $this->filterNumericval($number)) {
            throw new InvalidArgumentException([ 'Value should be numeric: %s', $number ]);
        }

        $decimals = $decimals ?? 0;
        $decimalSeparator = $decimalSeparator ?? '.';
        $thousandSeparator = $thousandSeparator ?? '';

        $numberFormat = number_format($number, $decimals, $decimalSeparator, $thousandSeparator);

        return $numberFormat;
    }


    /**
     * @return INum
     */
    public static function getInstance() : INum
    {
        return SupportFactory::getInstance()->getNum();
    }
}