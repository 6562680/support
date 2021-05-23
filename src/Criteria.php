<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * Criteria
 */
class Criteria
{
    const OPERATOR_BTW     = 'btw';
    const OPERATOR_ENDS    = 'ends';
    const OPERATOR_EQ      = 'eq';
    const OPERATOR_GT      = 'gt';
    const OPERATOR_GTE     = 'gte';
    const OPERATOR_IN      = 'in';
    const OPERATOR_LT      = 'lt';
    const OPERATOR_LTE     = 'lte';
    const OPERATOR_NBTW    = '!btw';
    const OPERATOR_NENDS   = '!ends';
    const OPERATOR_NEQ     = '!eq';
    const OPERATOR_NIN     = '!in';
    const OPERATOR_NSTARTS = '!starts';
    const OPERATOR_STARTS  = 'starts';

    const THE_OPERATOR_LIST = [
        self::OPERATOR_BTW     => true,
        self::OPERATOR_NBTW    => true,
        self::OPERATOR_NENDS   => true,
        self::OPERATOR_NEQ     => true,
        self::OPERATOR_NIN     => true,
        self::OPERATOR_NSTARTS => true,
        self::OPERATOR_ENDS    => true,
        self::OPERATOR_EQ      => true,
        self::OPERATOR_GT      => true,
        self::OPERATOR_GTE     => true,
        self::OPERATOR_IN      => true,
        self::OPERATOR_LT      => true,
        self::OPERATOR_LTE     => true,
        self::OPERATOR_STARTS  => true,
    ];


    /**
     * @var Calendar
     */
    protected $calendar;
    /**
     * @var Cmp
     */
    protected $cmp;
    /**
     * @var Filter
     */
    protected $filter;
    /**
     * @var Str
     */
    protected $str;


    /**
     * Constructor
     *
     * @param Calendar $calendar
     * @param Cmp      $cmp
     * @param Filter   $filter
     * @param Str      $str
     */
    public function __construct(
        Calendar $calendar,
        Cmp $cmp,
        Filter $filter,
        Str $str
    )
    {
        $this->calendar = $calendar;
        $this->cmp = $cmp;
        $this->filter = $filter;
        $this->str = $str;
    }


    /**
     * @param number    $needle
     * @param array     $src
     * @param null|bool $coalesce
     *
     * @return bool
     */
    public function isInNumber($needle, array $src, bool $coalesce = null) : bool
    {
        if (null === $this->filter->filterNumber($needle)) {
            throw new InvalidArgumentException('Needle should be number');
        }

        $coalesce = $coalesce ?? false;

        $res = false;
        foreach ( $src as $i => $val ) {
            $res = ( 0 === $this->cmp->cmpnum($needle, $val, $coalesce) );
            if (! $res) {
                break;
            }
        }

        return $res;
    }


    /**
     * @param string    $needle
     * @param array     $src
     * @param null|bool $natural
     * @param null|bool $coalesce
     *
     * @return bool
     */
    public function isInString($needle, array $src, bool $natural = null, bool $coalesce = null) : bool
    {
        if (! is_string($needle)) {
            throw new InvalidArgumentException('Needle should be string');
        }

        $coalesce = $coalesce ?? false;

        $res = false;
        foreach ( $src as $i => $val ) {
            $res = ( 0 === $this->cmp->cmpstr($needle, $val, $natural, $coalesce) );
            if (! $res) {
                break;
            }
        }

        return $res;
    }

    /**
     * @param string    $needle
     * @param array     $src
     * @param null|bool $natural
     * @param null|bool $coalesce
     *
     * @return bool
     */
    public function isInStringCase($needle, array $src, bool $natural = null, bool $coalesce = null) : bool
    {
        if (! is_string($needle)) {
            throw new InvalidArgumentException('Needle should be string');
        }

        $coalesce = $coalesce ?? false;

        $res = false;
        foreach ( $src as $i => $val ) {
            $res = ( 0 === $this->cmp->cmpstrCase($needle, $val, $natural, $coalesce) );
            if (! $res) {
                break;
            }
        }

        return $res;
    }


    /**
     * @param \DateTime $needle
     * @param array     $src
     * @param null|bool $coalesce
     *
     * @return bool
     */
    public function isInDate(\DateTime $needle, array $src, bool $coalesce = null) : bool
    {
        $coalesce = $coalesce ?? false;

        $res = false;
        foreach ( $src as $i => $val ) {
            $res = $val
                ? ( 0 === $this->cmp->cmpdate($needle, $val, $coalesce) )
                : false;

            if (! $res) {
                break;
            }
        }

        return $res;
    }


    /**
     * @param int|float $needle
     * @param array     $src
     * @param null|bool $coalesce
     *
     * @return bool
     */
    public function isBetweenNumber($needle, array $src, bool $coalesce = null) : bool
    {
        if (null === $this->filter->filterNumber($needle)) {
            throw new InvalidArgumentException('Needle should be number');
        }

        $coalesce = $coalesce ?? false;

        $srcNumbers = [];
        foreach ( $src as $i => $val ) {
            $num = null
                ?? ( ( null !== $this->filter->filterNumber($src[ $i ]) ) ? $src[ $i ] : null )
                ?? ( $coalesce ? floatval($src[ $i ]) : null )
                ?? null;

            if ($num !== null) {
                $srcNumbers[ $i ] = $num;
            }
        }

        if (! $srcNumbers) {
            throw new InvalidArgumentException('Src should contain at least one number');
        }

        $min = min($srcNumbers);
        $max = max($srcNumbers);

        $result = $min <= $needle && $needle <= $max;

        return $result;
    }

    /**
     * @param \DateTime $needle
     * @param array     $src
     * @param null|bool $coalesce
     *
     * @return bool
     */
    public function isBetweenDate(\DateTime $needle, array $src, bool $coalesce = null) : bool
    {
        $coalesce = $coalesce ?? false;

        $srcDates = [];
        foreach ( $src as $i => $val ) {
            $date = null
                ?? ( $this->calendar->isDate($src[ $i ]) ? $src[ $i ] : null )
                ?? ( $coalesce ? $this->calendar->date($src[ $i ]) : null )
                ?? null;

            if (null !== $date) {
                $srcDates[ $i ] = $date;
            }
        }

        if (! $srcDates) {
            throw new InvalidArgumentException('Src should contain at least one number');
        }

        $result = $this->calendar->isBetween($needle, $srcDates);

        return $result;
    }


    /**
     * @param mixed     $needle
     * @param mixed     $src
     * @param string    $operator
     * @param null|bool $coalesce
     *
     * @return bool
     */
    public function satisfy($needle, $src, string $operator, bool $coalesce = null) : bool
    {
        if (! isset(static::THE_OPERATOR_LIST[ $operator ])) {
            throw new InvalidArgumentException('Unknown operator: ' . $operator);
        }

        $coalesce = $coalesce ?? false;

        if (is_array($needle)) {
            return $this->satisfyArray($src, $needle, $operator);

        } elseif (null !== $this->filter->filterNumber($needle)) {
            if ($operator === static::OPERATOR_GT) return 1 === $this->cmp->cmpnum($needle, $src, $coalesce);
            if ($operator === static::OPERATOR_LT) return -1 === $this->cmp->cmpnum($needle, $src, $coalesce);
            if ($operator === static::OPERATOR_GTE) return -1 !== $this->cmp->cmpnum($needle, $src, $coalesce);
            if ($operator === static::OPERATOR_LTE) return 1 !== $this->cmp->cmpnum($needle, $src, $coalesce);

        } else {
            if (is_string($needle)) {
                if ($operator === static::OPERATOR_GT) return 1 === $this->cmp->cmpstr($needle, $src, $coalesce);
                if ($operator === static::OPERATOR_LT) return -1 === $this->cmp->cmpstr($needle, $src, $coalesce);
                if ($operator === static::OPERATOR_GTE) return -1 !== $this->cmp->cmpstr($needle, $src, $coalesce);
                if ($operator === static::OPERATOR_LTE) return 1 !== $this->cmp->cmpstr($needle, $src, $coalesce);

                if ($operator === static::OPERATOR_BTW) {
                    return ! ! $this->str->contains($needle, $src, $coalesce);
                }
                if ($operator === static::OPERATOR_NBTW) {
                    return ! $this->str->contains($needle, $src, $coalesce);
                }

                if ($operator === static::OPERATOR_STARTS) return null !== $this->str->starts($needle, $src, $coalesce);
                if ($operator === static::OPERATOR_ENDS) return null !== $this->str->ends($needle, $src, $coalesce);
                if ($operator === static::OPERATOR_NSTARTS) {
                    return null === $this->str->starts($needle, $src, $coalesce);
                }
                if ($operator === static::OPERATOR_NENDS) {
                    return null === $this->str->ends($needle, $src, $coalesce);
                }

            } elseif ($this->calendar->isDate($needle)) {
                if ($operator === static::OPERATOR_GT) return 1 === $this->cmp->cmpDate($needle, $src);
                if ($operator === static::OPERATOR_LT) return -1 === $this->cmp->cmpDate($needle, $src);
                if ($operator === static::OPERATOR_GTE) return -1 !== $this->cmp->cmpDate($needle, $src);
                if ($operator === static::OPERATOR_LTE) return 1 !== $this->cmp->cmpDate($needle, $src);

            }
        }

        if ($operator === static::OPERATOR_EQ) return $src === $needle;
        if ($operator === static::OPERATOR_NEQ) return $src !== $needle;

        return false;
    }

    /**
     * @param mixed     $needle
     * @param array     $arr
     * @param string    $operator
     * @param null|bool $coalesce
     *
     * @return bool
     */
    public function satisfyArray($needle, array $arr, string $operator, bool $coalesce = null) : bool
    {
        if (! isset(static::THE_OPERATOR_LIST[ $operator ])) {
            throw new InvalidArgumentException('Unknown operator: ' . $operator);
        }

        $coalesce = $coalesce ?? false;

        if (null !== $this->filter->filterNumber($needle)) {
            if ($operator === static::OPERATOR_IN) return $this->isInNumber($needle, $arr, $coalesce);
            if ($operator === static::OPERATOR_NIN) return ! $this->isInNumber($needle, $arr, $coalesce);

            if ($operator === static::OPERATOR_BTW) return $this->isBetweenNumber($needle, $arr, $coalesce);
            if ($operator === static::OPERATOR_NBTW) {
                return ! $this->isBetweenNumber($needle, $arr, $coalesce);
            }

        } elseif (is_string($needle)) {
            if ($operator === static::OPERATOR_IN) return $this->isInString($needle, $arr, $coalesce);
            if ($operator === static::OPERATOR_NIN) {
                return ! $this->isInString($needle, $arr, $coalesce);
            }

        } elseif ($this->calendar->isDate($needle)) {
            if ($operator === static::OPERATOR_IN) return $this->isInDate($needle, $arr, $coalesce);
            if ($operator === static::OPERATOR_NIN) {
                return ! $this->isInDate($needle, $arr, $coalesce);
            }

            if ($operator === static::OPERATOR_BTW) return $this->isBetweenDate($needle, $arr, $coalesce);
            if ($operator === static::OPERATOR_NBTW) {
                return ! $this->isBetweenDate($needle, $arr, $coalesce);
            }
        }

        return false;
    }
}
