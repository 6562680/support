<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * Cmp
 */
class Cmp
{
    /**
     * @var Calendar
     */
    protected $calendar;
    /**
     * @var Type
     */
    protected $type;


    /**
     * Constructor
     *
     * @param Type     $type
     * @param Calendar $calendar
     */
    public function __construct(
        Calendar $calendar,
        Type $type
    )
    {
        $this->calendar = $calendar;
        $this->type = $type;
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
     * @param null|int|float $a
     * @param mixed          $b
     * @param null|bool      $coalesce
     *
     * @return int
     */
    public function cmpnum($a, $b, bool $coalesce = null) : int
    {
        if (! ( ( $a === null ) || $this->type->isNumber($a) )) {
            throw new InvalidArgumentException('A should be number');
        }

        $result = 0;

        $coalesce = $coalesce ?? false;

        $bNumber = null
            ?? ( ( null === $b ) ? $b : null )
            ?? ( $this->type->isNumber($b) ? $b : null )
            ?? ( $coalesce ? floatval($b) : null );

        $isA = false;
        $isB = false;
        if (1
            && ( $isA = $this->type->isNumber($a) )
            && ( $isB = $this->type->isNumber($bNumber) )
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
            ?? ( ( null !== ( $dt = $this->calendar->detectDate($b) ) ) ? $dt : null )
            ?? ( $coalesce ? $this->calendar->date($b) : null );

        $isA = false;
        $isB = false;
        if (1
            && ( $isA = $this->calendar->isDate($aDate) )
            && ( $isB = $this->calendar->isDate($bDate) )
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
}