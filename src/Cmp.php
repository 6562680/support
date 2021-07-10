<?php

namespace Gzhegow\Support;

use Gzhegow\Support\SupportFactory;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * Cmp
 */
class Cmp implements ICmp
{
    /**
     * @var ICalendar
     */
    protected $calendar;
    /**
     * @var IFilter
     */
    protected $filter;


    /**
     * Constructor
     *
     * @param ICalendar $calendar
     * @param IFilter   $filter
     */
    public function __construct(
        ICalendar $calendar,
        IFilter $filter
    )
    {
        $this->calendar = $calendar;
        $this->filter = $filter;
    }


    /**
     * @param mixed $a
     * @param mixed $b
     *
     * @return int
     */
    public function cmp($a, $b) : int
    {
        $result = null
            ?? ( $a < $b ? -1 : null )
            ?? ( $a > $b ? 1 : null )
            ?? 0;

        return $result;
    }


    /**
     * @param null|int|float|string $a
     * @param mixed                 $b
     * @param null|bool             $coalesce
     *
     * @return int
     */
    public function cmpnum($a, $b, bool $coalesce = null) : int
    {
        if (! ( ( $a === null )
            || ( null !== $this->filter->filterNum($a) )
        )) {
            throw new InvalidArgumentException('A should be number');
        }

        $result = 0;

        $coalesce = $coalesce ?? false;

        $bNumber = null
            ?? ( ( null === $b ) ? $b : null )
            ?? ( ( null !== $this->filter->filterNum($b) ) ? $b : null )
            ?? ( $coalesce ? floatval($b) : null );

        $isA = false;
        $isB = false;
        if (1
            && ( $isA = ( null !== $this->filter->filterNum($a) ) )
            && ( $isB = ( null !== $this->filter->filterNum($bNumber) ) )
        ) {
            $result = null
                ?? ( $a < $b ? -1 : null )
                ?? ( $a > $b ? 1 : null )
                ?? 0;
        }

        $result = $result ?? ( $isA - $isB );

        return $result;
    }


    /**
     * @param null|string $a
     * @param mixed       $b
     * @param null|bool   $natural
     * @param null|bool   $coalesce
     *
     * @return int
     */
    public function cmpstr($a, $b, bool $natural = null, bool $coalesce = null) : int
    {
        if (! ( ( $a === null ) || is_string($a) )) {
            throw new InvalidArgumentException('A should be string');
        }

        $result = 0;

        $natural = $natural ?? true;
        $coalesce = $coalesce ?? false;

        $bString = null
            ?? ( ( null === $b ) ? $b : null )
            ?? ( is_string($b) ? $b : null )
            ?? ( $coalesce ? strval($b) : null );

        $isA = false;
        $isB = false;
        if (1
            && ( $isA = is_string($a) )
            && ( $isB = is_string($bString) )
        ) {
            $result = $natural
                ? strnatcmp($a, $b)
                : strcmp($a, $b);
        }

        $result = $result ?? ( $isA - $isB );

        return $result;
    }

    /**
     * @param null|string $a
     * @param mixed       $b
     * @param null|bool   $natural
     * @param null|bool   $coalesce
     *
     * @return int
     */
    public function cmpstrCase($a, $b, bool $natural = null, bool $coalesce = null) : int
    {
        if (! ( ( $a === null ) || is_string($a) )) {
            throw new InvalidArgumentException('A should be string');
        }

        $result = 0;

        $natural = $natural ?? true;
        $coalesce = $coalesce ?? false;

        $bString = null
            ?? ( ( null === $b ) ? $b : null )
            ?? ( is_string($b) ? $b : null )
            ?? ( $coalesce ? strval($b) : null );

        $isA = false;
        $isB = false;
        if (1
            && ( $isA = is_string($a) )
            && ( $isB = is_string($bString) )
        ) {
            $result = $natural
                ? strnatcasecmp($a, $b)
                : strcasecmp($a, $b);
        }

        $result = $result ?? ( $isA - $isB );

        return $result;
    }


    /**
     * @param null|\DateTime $aDate
     * @param mixed          $b
     * @param null|bool      $coalesce
     *
     * @return int
     */
    public function cmpdate(\DateTime $aDate = null, $b = null, bool $coalesce = null) : int
    {
        $result = 0;

        $coalesce = $coalesce ?? false;

        $bDate = null
            ?? ( ( null === $b ) ? $b : null )
            ?? ( ( null !== ( $dt = $this->calendar->filterDate($b) ) ) ? $dt : null )
            ?? ( $coalesce ? $this->calendar->theDateVal($b) : null );

        $isA = false;
        $isB = false;
        if (1
            && ( $isA = $this->calendar->isDateTime($aDate) )
            && ( $isB = $this->calendar->isDateTime($bDate) )
        ) {
            $diff = $this->calendar->diff($aDate, $bDate);

            $result = null
                ?? ( ( $diff < 0 ) ? -1 : null )
                ?? ( ( $diff > 0 ) ? 1 : null )
                ?? 0;
        }

        $result = $result ?? ( $isA - $isB );

        return $result;
    }


    /**
     * @return static
     */
    public static function me()
    {
        return SupportFactory::getInstance()->getCmp();
    }
}
