<?php
/**
 * @noinspection RedundantSuppression
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * ZCriteria
 */
class ZCriteria implements ICriteria
{
    const OPERATOR_BTW     = 'btw';
    const OPERATOR_ENDS    = 'ends';
    const OPERATOR_EQ      = 'eq';
    const OPERATOR_GT      = 'gt';
    const OPERATOR_GTE     = 'gte';
    const OPERATOR_IN      = 'in';
    const OPERATOR_LT      = 'lt';
    const OPERATOR_LTE     = 'lte';
    const OPERATOR_NBTW    = 'nbtw';
    const OPERATOR_NENDS   = 'nends';
    const OPERATOR_NEQ     = 'neq';
    const OPERATOR_NIN     = 'nin';
    const OPERATOR_NSTARTS = 'nstarts';
    const OPERATOR_NSUBSTR = 'nsubstr';
    const OPERATOR_STARTS  = 'starts';
    const OPERATOR_SUBSTR  = 'substr';

    const ORDER_ASC      = 'asc';
    const ORDER_ASCNULL  = 'asc,null';
    const ORDER_DEC      = 'dec';
    const ORDER_DECNULL  = 'dec,null';
    const ORDER_DESC     = 'desc';
    const ORDER_DESCNULL = 'desc,null';
    const ORDER_INC      = 'inc';
    const ORDER_INCNULL  = 'inc,null';
    const ORDER_NULLASC  = 'null,asc';
    const ORDER_NULLDEC  = 'null,dec';
    const ORDER_NULLDESC = 'null,desc';
    const ORDER_NULLINC  = 'null,inc';


    const THE_OPERATOR_LIST = [
        self::OPERATOR_BTW     => true,
        self::OPERATOR_ENDS    => true,
        self::OPERATOR_EQ      => true,
        self::OPERATOR_GT      => true,
        self::OPERATOR_GTE     => true,
        self::OPERATOR_IN      => true,
        self::OPERATOR_LT      => true,
        self::OPERATOR_LTE     => true,
        self::OPERATOR_NBTW    => true,
        self::OPERATOR_NENDS   => true,
        self::OPERATOR_NEQ     => true,
        self::OPERATOR_NIN     => true,
        self::OPERATOR_NSTARTS => true,
        self::OPERATOR_NSUBSTR => true,
        self::OPERATOR_STARTS  => true,
        self::OPERATOR_SUBSTR  => true,
    ];

    const THE_ORDER_LIST = [
        self::ORDER_ASC      => true,
        self::ORDER_ASCNULL  => true,
        self::ORDER_DEC      => true,
        self::ORDER_DECNULL  => true,
        self::ORDER_DESC     => true,
        self::ORDER_DESCNULL => true,
        self::ORDER_INC      => true,
        self::ORDER_INCNULL  => true,
        self::ORDER_NULLASC  => true,
        self::ORDER_NULLDEC  => true,
        self::ORDER_NULLDESC => true,
        self::ORDER_NULLINC  => true,
    ];


    /**
     * @var ICalendar
     */
    protected $calendar;
    /**
     * @var ICmp
     */
    protected $cmp;
    /**
     * @var IFilter
     */
    protected $filter;
    /**
     * @var IStr
     */
    protected $str;


    /**
     * Constructor
     *
     * @param ICalendar $calendar
     * @param ICmp      $cmp
     * @param IFilter   $filter
     * @param IStr      $str
     */
    public function __construct(
        ICalendar $calendar,
        ICmp $cmp,
        IFilter $filter,
        IStr $str
    )
    {
        $this->calendar = $calendar;
        $this->cmp = $cmp;
        $this->filter = $filter;
        $this->str = $str;
    }


    /**
     * @param int|float|string $needle
     * @param array            $src
     * @param null|bool        $coalesce
     *
     * @return bool
     */
    public function isInNumber($needle, array $src, bool $coalesce = null) : bool
    {
        if (null === $this->filter->filterNum($needle)) {
            throw new InvalidArgumentException('Needle should be number');
        }

        $coalesce = $coalesce ?? false;

        $res = null;
        foreach ( $src as $val ) {
            if (0 === ( $res = $this->cmp->cmpnum($needle, $val, $coalesce) )) {
                break;
            }
        }

        return 0 === $res;
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

        $res = null;
        foreach ( $src as $val ) {
            if (0 === ( $res = $this->cmp->cmpstr($needle, $val, $natural, $coalesce) )) {
                break;
            }
        }

        return 0 === $res;
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

        $res = null;
        foreach ( $src as $val ) {
            if (0 === ( $res = $this->cmp->cmpstrCase($needle, $val, $natural, $coalesce) )) {
                break;
            }
        }

        return 0 === $res;
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

        $res = null;
        foreach ( $src as $val ) {
            if (0 === ( $res = $this->cmp->cmpdate($needle, $val, $coalesce) )) {
                break;
            }
        }

        return 0 === $res;
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
        if (null === $this->filter->filterNum($needle)) {
            throw new InvalidArgumentException('Needle should be number');
        }

        $coalesce = $coalesce ?? false;

        $srcNumbers = [];
        foreach ( $src as $i => $val ) {
            $num = null
                ?? ( ( null !== $this->filter->filterNum($src[ $i ]) ) ? $src[ $i ] : null )
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
                ?? ( $this->calendar->isDateTime($src[ $i ]) ? $src[ $i ] : null )
                ?? ( $coalesce ? $this->calendar->theDateVal($src[ $i ]) : null )
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

        } elseif (null !== $this->filter->filterNum($needle)) {
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

            } elseif ($this->calendar->isDateTime($needle)) {
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

        if (null !== $this->filter->filterNum($needle)) {
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

        } elseif ($this->calendar->isDateTime($needle)) {
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


    /**
     * @return ICriteria
     */
    public static function getInstance() : ICriteria
    {
        return SupportFactory::getInstance()->getCriteria();
    }
}
