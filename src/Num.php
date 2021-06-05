<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * Num
 */
class Num
{
    /**
     * @var Filter
     */
    protected $filter;


    /**
     * Constructor
     *
     * @param Filter $filter
     */
    public function __construct(
        Filter $filter
    )
    {
        $this->filter = $filter;
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
        if (null === ( $numval = $this->numval($value) )) {
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
     * @return int[]|float[]|string[]
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
     * @param int|float|string|array $numvals
     * @param null|bool              $uniq
     *
     * @return int[]|float[]|string[]
     */
    public function theNumvals($numvals, $uniq = null) : array
    {
        $result = [];

        $numvals = is_array($numvals)
            ? $numvals
            : [ $numvals ];

        array_walk_recursive($numvals, function ($number) use (&$result) {
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
}
