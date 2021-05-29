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
     * @var Php
     */
    protected $php;


    /**
     * Constructor
     *
     * @param Filter $filter
     * @param Php    $php
     */
    public function __construct(
        Filter $filter,
        Php $php
    )
    {
        $this->filter = $filter;
        $this->php = $php;
    }


    /**
     * @param int|float      $value
     * @param null|int|float $sum
     *
     * @return float
     */
    public function ratio($value, $sum = null) : float
    {
        $this->filter->assert()->assertNumval($value);

        if (isset($sum)) {
            $this->filter->assert('Sum should be number: %s', $sum)
                ->assertNumval($sum);
        }

        $sum = $sum ?? 1;

        $result = min(1, max(-1, $value / $sum));

        return $result;
    }

    /**
     * @param int|float      $value
     * @param null|int|float $sum
     *
     * @return float
     */
    public function percent($value, $sum = null) : float
    {
        $this->filter->assert()->assertNumval($value);

        if (isset($sum)) {
            $this->filter->assert('Sum should be number: %s', $sum)
                ->assertNumval($sum);
        }

        $sum = $sum ?? 1;

        $result = $value / $sum * 100;

        return $result;
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
     * @param int|array         $integers
     * @param null|bool         $uniq
     * @param null|string|array $message
     * @param mixed             ...$arguments
     *
     * @return int[]
     */
    public function intvals($integers, $uniq = null, $message = null, ...$arguments) : array
    {
        $result = [];

        $integers = is_array($integers)
            ? $integers
            : [ $integers ];

        if ($hasMessage = (null !== $message)) {
            $this->filter->assert($message, $arguments);
        }

        array_walk_recursive($integers, function ($integer) use (&$result) {
            if (null === ( $intval = $this->intval($integer) )) {
                throw new InvalidArgumentException($this->filter->assert()->flushMessage($integer)
                    ?? [ 'Each item should be convertable to integer: %s', $integer ],
                );
            }

            $result[] = $intval;
        });

        if ($hasMessage) {
            $this->filter->assert()->flushMessage();
        }

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
     * @param int|array         $integers
     * @param null|bool         $uniq
     * @param null|string|array $message
     * @param mixed             ...$arguments
     *
     * @return int[]
     */
    public function theIntvals($integers, $uniq = null, $message = null, array ...$arguments) : array
    {
        $result = $this->intvals($integers, $uniq, $message, ...$arguments);

        if (! count($result)) {
            throw new InvalidArgumentException(
                [ 'At least one integer should be provided: %s', $integers ],
            );
        }

        return $result;
    }

    /**
     * @param int|array $integers
     * @param null|bool $uniq
     *
     * @return int[]
     */
    public function intvalsSkip($integers, $uniq = null) : array
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
     * @param int|array $integers
     * @param null|bool $uniq
     *
     * @return int[]
     */
    public function theIntvalsSkip($integers, $uniq = null) : array
    {
        $result = $this->intvalsSkip($integers, $uniq);

        if (! count($result)) {
            throw new InvalidArgumentException(
                [ 'At least one integer should be provided: %s', $integers ],
            );
        }

        return $result;
    }


    /**
     * @param float|array       $floats
     * @param null|bool         $uniq
     * @param null|string|array $message
     * @param mixed             ...$arguments
     *
     * @return float[]
     */
    public function floatvals($floats, $uniq = null, $message = null, ...$arguments) : array
    {
        $result = [];

        $floats = is_array($floats)
            ? $floats
            : [ $floats ];

        if ($hasMessage = (null !== $message)) {
            $this->filter->assert($message, ...$arguments);
        }

        array_walk_recursive($floats, function ($float) use (&$result) {
            if (null === ( $floatval = $this->floatval($float) )) {
                throw new InvalidArgumentException($this->filter->assert()->flushMessage($float)
                    ?? [ 'Each item should be floatable: %s', $float ],
                );
            }

            $result[] = $floatval;
        });

        if ($hasMessage) {
            $this->filter->assert()->flushMessage();
        }

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
     * @param float|array       $floats
     * @param null|bool         $uniq
     * @param null|string|array $message
     * @param mixed             ...$arguments
     *
     * @return float[]
     */
    public function theFloatvals($floats, $uniq = null, $message = null, array ...$arguments) : array
    {
        $result = $this->floatvals($floats, $uniq, $message, ...$arguments);

        if (! count($result)) {
            throw new InvalidArgumentException(
                [ 'At least one float should be provided: %s', $floats ],
            );
        }

        return $result;
    }

    /**
     * @param float|array $floats
     * @param null|bool   $uniq
     *
     * @return float[]
     */
    public function floatvalsSkip($floats, $uniq = null) : array
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
     * @param float|array $floats
     * @param null|bool   $uniq
     *
     * @return float[]
     */
    public function theFloatvalsSkip($floats, $uniq = null) : array
    {
        $result = $this->floatvalsSkip($floats, $uniq);

        if (! count($result)) {
            throw new InvalidArgumentException(
                [ 'At least one float should be provided: %s', $floats ],
            );
        }

        return $result;
    }


    /**
     * @param int|float|string|array $numbers
     * @param null|bool              $uniq
     * @param null|string|array      $message
     * @param mixed                  ...$arguments
     *
     * @return int[]|float[]|string[]
     */
    public function numvals($numbers, $uniq = null, $message = null, ...$arguments) : array
    {
        $result = [];

        $numbers = is_array($numbers)
            ? $numbers
            : [ $numbers ];

        if ($hasMessage = (null !== $message)) {
            $this->filter->assert($message, ...$arguments);
        }

        array_walk_recursive($numbers, function ($number) use (&$result) {
            if (null === ( $numval = $this->numval($number) )) {
                throw new InvalidArgumentException($this->filter->assert()->flushMessage($number)
                    ?? [ 'Each item should be numerable: %s', $number ],
                );
            }

            $result[] = $numval;
        });

        if ($hasMessage) {
            $this->filter->assert()->flushMessage();
        }

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
     * @param null|string|array      $message
     * @param mixed                  ...$arguments
     *
     * @return int[]|float[]|string[]
     */
    public function theNumvals($numbers, $uniq = null, $message = null, array ...$arguments) : array
    {
        $result = $this->numvals($numbers, $uniq, $message, ...$arguments);

        if (! count($result)) {
            throw new InvalidArgumentException(
                [ 'At least one number should be provided: %s', $numbers ],
            );
        }

        return $result;
    }

    /**
     * @param int|float|string|array $numbers
     * @param null|bool              $uniq
     *
     * @return int[]|float[]|string[]
     */
    public function numvalsSkip($numbers, $uniq = null) : array
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
     * @return int[]|float[]|string[]
     */
    public function theNumvalsSkip($numbers, $uniq = null) : array
    {
        $result = $this->numvalsSkip($numbers, $uniq);

        if (! count($result)) {
            throw new InvalidArgumentException(
                [ 'At least one number should be provided: %s', $numbers ],
            );
        }

        return $result;
    }
}
