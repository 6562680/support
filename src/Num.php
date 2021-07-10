<?php
/**
 * @noinspection RedundantSuppression
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * Num
 */
class Num implements INum
{
    /**
     * @var IFilter
     */
    protected $filter;


    /**
     * Constructor
     *
     * @param IFilter $filter
     */
    public function __construct(
        IFilter $filter
    )
    {
        $this->filter = $filter;
    }


    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float
     */
    public function positiveVal($value) // : ?int|float
    {
        if (null === ( $numval = $this->numval($value) )) {
            return null;
        }

        if ($numval > 0) {
            return $numval;
        }

        return null;
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float
     */
    public function nonNegativeVal($value) // : ?int|float
    {
        if (null === ( $numval = $this->numval($value) )) {
            return null;
        }

        if ($numval >= 0) {
            return $numval;
        }

        return null;
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float
     */
    public function negativeVal($value) // : ?int|float
    {
        if (null === ( $numval = $this->numval($value) )) {
            return null;
        }

        if ($numval < 0) {
            return $numval;
        }

        return null;
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float
     */
    public function nonPositiveVal($value) // : ?int|float
    {
        if (null === ( $numval = $this->numval($value) )) {
            return null;
        }

        if ($numval <= 0) {
            return $numval;
        }

        return null;
    }


    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float
     */
    public function thePositiveVal($value) // : int|float
    {
        if (null === ( $positiveVal = $this->positiveVal($value) )) {
            throw new InvalidArgumentException(
                [ 'Value should be positive: %s', $value ],
            );
        }

        return $positiveVal;
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float
     */
    public function theNonNegativeVal($value) // : int|float
    {
        if (null === ( $nonNegativeVal = $this->nonNegativeVal($value) )) {
            throw new InvalidArgumentException(
                [ 'Value should be non-negative: %s', $value ],
            );
        }

        return $nonNegativeVal;
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float
     */
    public function theNegativeVal($value) // : int|float
    {
        if (null === ( $negativeVal = $this->negativeVal($value) )) {
            throw new InvalidArgumentException(
                [ 'Value should be negative: %s', $value ],
            );
        }

        return $negativeVal;
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float
     */
    public function theNonPositiveVal($value) // : int|float
    {
        if (null === ( $nonPositiveVal = $this->nonPositiveVal($value) )) {
            throw new InvalidArgumentException(
                [ 'Value should be non-positive: %s', $value ],
            );
        }

        return $nonPositiveVal;
    }


    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int
     */
    public function positiveIntval($value) : ?int
    {
        if (null === ( $intval = $this->intval($value) )) {
            return null;
        }

        if ($intval > 0) {
            return $intval;
        }

        return null;
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int
     */
    public function nonNegativeIntval($value) : ?int
    {
        if (null === ( $intval = $this->intval($value) )) {
            return null;
        }

        if ($intval >= 0) {
            return $intval;
        }

        return null;
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int
     */
    public function negativeIntval($value) : ?int
    {
        if (null === ( $intval = $this->intval($value) )) {
            return null;
        }

        if ($intval < 0) {
            return $intval;
        }

        return null;
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int
     */
    public function nonPositiveIntval($value) : ?int
    {
        if (null === ( $intval = $this->intval($value) )) {
            return null;
        }

        if ($intval <= 0) {
            return $intval;
        }

        return null;
    }


    /**
     * @param int|float|string|mixed $value
     *
     * @return int
     */
    public function thePositiveIntval($value) : int
    {
        if (null === ( $positiveIntval = $this->positiveIntval($value) )) {
            throw new InvalidArgumentException(
                [ 'Value should be positive intval: %s', $value ],
            );
        }

        return $positiveIntval;
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return int
     */
    public function theNonNegativeIntval($value) : int
    {
        if (null === ( $nonNegativeIntval = $this->nonNegativeIntval($value) )) {
            throw new InvalidArgumentException(
                [ 'Value should be non-negative intval: %s', $value ],
            );
        }

        return $nonNegativeIntval;
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return int
     */
    public function theNegativeIntval($value) : int
    {
        if (null === ( $negativeIntval = $this->negativeIntval($value) )) {
            throw new InvalidArgumentException(
                [ 'Value should be negative intval: %s', $value ],
            );
        }

        return $negativeIntval;
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return int
     */
    public function theNonPositiveIntval($value) : int
    {
        if (null === ( $nonPositiveIntval = $this->nonPositiveIntval($value) )) {
            throw new InvalidArgumentException(
                [ 'Value should be non-positive intval: %s', $value ],
            );
        }

        return $nonPositiveIntval;
    }


    /**
     * @param mixed $value
     *
     * @return null|int
     */
    public function intval($value) : ?int
    {
        if (null === $this->filter->filterIntval($value)) {
            return null;
        }

        $result = intval($value);

        return $result;
    }

    /**
     * @param mixed $value
     *
     * @return null|float
     */
    public function floatval($value) : ?float
    {
        if (null === $this->filter->filterFloatval($value)) {
            return null;
        }

        $result = floatval($value);

        return $result;
    }

    /**
     * @param mixed $value
     *
     * @return null|int|float
     */
    public function numval($value) // : ?int|float
    {
        if (null === $this->filter->filterNumval($value)) {
            return null;
        }

        return null
            ?? $this->intval($value)
            ?? $this->floatval($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|string
     */
    public function numericval($value) : ?string
    {
        if (null === $this->filter->filterNumericval($value)) {
            return null;
        }

        return strval($value);
    }


    /**
     * @param mixed $value
     *
     * @return int
     */
    public function theIntval($value) : int
    {
        if (null === ( $intval = $this->intval($value) )) {
            throw new InvalidArgumentException(
                [ 'Value should be convertable to intval: %s', $value ],
            );
        }

        return $intval;
    }

    /**
     * @param mixed $value
     *
     * @return float
     */
    public function theFloatval($value) : float
    {
        if (null === ( $floatval = $this->floatval($value) )) {
            throw new InvalidArgumentException(
                [ 'Value should be convertable to floatval: %s', $value ],
            );
        }

        return $floatval;
    }

    /**
     * @param mixed $value
     *
     * @return int|float
     */
    public function theNumval($value) // : int|float
    {
        if (null === ( $numberval = $this->numval($value) )) {
            throw new InvalidArgumentException(
                [ 'Value should be convertable to int or float: %s', $value ],
            );
        }

        return $numberval;
    }

    /**
     * @param mixed $value
     *
     * @return string
     */
    public function theNumericval($value) : string
    {
        if (null === ( $numval = $this->numericval($value) )) {
            throw new InvalidArgumentException(
                [ 'Value should be convertable to numval: %s', $value ],
            );
        }

        return $numval;
    }


    /**
     * @param int|array $integers
     * @param null|bool $uniq
     *
     * @return int[]
     */
    public function intvals($integers, $uniq = null) : array
    {
        $result = [];

        $integers = is_array($integers)
            ? $integers
            : [ $integers ];

        array_walk_recursive($integers, function ($integer) use (&$result) {
            if (null !== ( $intval = $this->intval($integer) )) {
                $result[] = $intval;
            }
        });

        if ($uniq ?? false) {
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
     *
     * @return float[]
     */
    public function floatvals($floats, $uniq = null) : array
    {
        $result = [];

        $floats = is_array($floats)
            ? $floats
            : [ $floats ];

        array_walk_recursive($floats, function ($float) use (&$result) {
            if (null !== ( $floatval = $this->floatval($float) )) {
                $result[] = $floatval;
            }
        });

        if ($uniq ?? false) {
            $arr = [];
            foreach ( $result as $i ) {
                $arr[ $i ] = true;
            }
            $result = array_keys($arr);
        }

        return $result;
    }

    /**
     * @param int|float|string|array $numbers
     * @param null|bool              $uniq
     *
     * @return int[]|float[]
     */
    public function numvals($numbers, $uniq = null) : array
    {
        $result = [];

        $numbers = is_array($numbers)
            ? $numbers
            : [ $numbers ];

        array_walk_recursive($numbers, function ($number) use (&$result) {
            if (null !== ( $numval = $this->numval($number) )) {
                $result[] = $numval;
            }
        });

        if ($uniq ?? false) {
            $arr = [];
            foreach ( $result as $i ) {
                $arr[ $i ] = true;
            }
            $result = array_keys($arr);
        }

        return $result;
    }

    /**
     * @param int|float|string|array $numbers
     * @param null|bool              $uniq
     *
     * @return string[]
     */
    public function numericvals($numbers, $uniq = null) : array
    {
        $result = [];

        $numbers = is_array($numbers)
            ? $numbers
            : [ $numbers ];

        array_walk_recursive($numbers, function ($number) use (&$result) {
            if (null !== ( $numval = $this->numericval($number) )) {
                $result[] = $numval;
            }
        });

        if ($uniq ?? false) {
            $arr = [];
            foreach ( $result as $i ) {
                $arr[ $i ] = true;
            }
            $result = array_keys($arr);
        }

        return $result;
    }


    /**
     * @param int|array $intvals
     * @param null|bool $uniq
     *
     * @return int[]
     */
    public function theIntvals($intvals, $uniq = null) : array
    {
        $result = [];

        $intvals = is_array($intvals)
            ? $intvals
            : [ $intvals ];

        array_walk_recursive($intvals, function ($integer) use (&$result) {
            $result[] = $this->theIntval($integer);
        });

        if ($uniq ?? false) {
            $arr = [];
            foreach ( $result as $i ) {
                $arr[ $i ] = true;
            }
            $result = array_keys($arr);
        }

        return $result;
    }

    /**
     * @param float|array $floatvals
     * @param null|bool   $uniq
     *
     * @return float[]
     */
    public function theFloatvals($floatvals, $uniq = null) : array
    {
        $result = [];

        $floatvals = is_array($floatvals)
            ? $floatvals
            : [ $floatvals ];

        array_walk_recursive($floatvals, function ($float) use (&$result) {
            $result[] = $this->theFloatval($float);
        });

        if ($uniq ?? false) {
            $arr = [];
            foreach ( $result as $i ) {
                $arr[ $i ] = true;
            }
            $result = array_keys($arr);
        }

        return $result;
    }

    /**
     * @param float|array $numbervals
     * @param null|bool   $uniq
     *
     * @return int[]|float[]
     */
    public function theNumvals($numbervals, $uniq = null) : array
    {
        $result = [];

        $numbervals = is_array($numbervals)
            ? $numbervals
            : [ $numbervals ];

        array_walk_recursive($numbervals, function ($number) use (&$result) {
            $result[] = $this->theNumval($number);
        });

        if ($uniq ?? false) {
            $arr = [];
            foreach ( $result as $i ) {
                $arr[ $i ] = true;
            }
            $result = array_keys($arr);
        }

        return $result;
    }

    /**
     * @param int|float|string|array $numvals
     * @param null|bool              $uniq
     *
     * @return string[]
     */
    public function theNumericvals($numvals, $uniq = null) : array
    {
        $result = [];

        $numvals = is_array($numvals)
            ? $numvals
            : [ $numvals ];

        array_walk_recursive($numvals, function ($number) use (&$result) {
            $result[] = $this->theNumericval($number);
        });

        if ($uniq ?? false) {
            $arr = [];
            foreach ( $result as $i ) {
                $arr[ $i ] = true;
            }
            $result = array_keys($arr);
        }

        return $result;
    }


    /**
     * @return INum
     */
    public static function getInstance()
    {
        return SupportFactory::getInstance()->getNum();
    }
}
