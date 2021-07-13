<?php
/**
 * @noinspection RedundantSuppression
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * ZNum
 */
class ZNum implements INum
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
     * @param int|float|mixed $value
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
     * @param int|float|mixed $value
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
     * @param int|float|mixed $value
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
     * @param int|float|mixed $value
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
     * @param int|float|mixed $value
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
     * @param int|float|mixed $value
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
     * @param int|float|mixed $value
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
     * @param int|float|mixed $value
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
     * @param int|mixed $value
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
     * @param int|mixed $value
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
     * @param int|mixed $value
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
     * @param int|mixed $value
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
     * @param int|mixed $value
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
     * @param int|mixed $value
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
     * @param int|mixed $value
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
     * @param int|mixed $value
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
     * @param int|mixed $value
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
     * @param float|mixed $value
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
     * @param int|float|mixed $value
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
     * @param int|float|string|mixed $value
     *
     * @return null|string
     */
    public function numericval($value) : ?string
    {
        if (null === $this->filter->filterNumericval($value)) {
            return null;
        }

        // @gzhegow
        // use numval or numericval directly
        // hope, we dont have numeric values that cannot be converted to int or float
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
     * @param int|float|string|array $numbers
     * @param null|bool              $uniq
     * @param null|bool              $recursive
     *
     * @return string[]
     */
    public function numericvals($numbers, bool $uniq = null, bool $recursive = null) : array
    {
        $result = [];

        $numbers = is_array($numbers)
            ? $numbers
            : [ $numbers ];

        if ($recursive) {
            array_walk_recursive($numbers, function ($item) use (&$result) {
                if (null !== ( $val = $this->numericval($item) )) {
                    $result[] = $val;
                }
            });
        } else {
            foreach ( $numbers as $item ) {
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
     * @param int|float|string|array $numbers
     * @param null|bool              $uniq
     * @param null|bool              $recursive
     *
     * @return string[]
     */
    public function theNumericvals($numbers, bool $uniq = null, bool $recursive = null) : array
    {
        $result = [];

        $numbers = is_array($numbers)
            ? $numbers
            : [ $numbers ];

        if ($recursive) {
            array_walk_recursive($numbers, function ($item) use (&$result) {
                $result[] = $this->theNumericval($item);
            });
        } else {
            foreach ( $numbers as $item ) {
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
     * @return INum
     */
    public static function getInstance() : INum
    {
        return SupportFactory::getInstance()->getNum();
    }
}
