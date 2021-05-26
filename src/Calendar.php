<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * Calendar
 */
class Calendar
{
    const FORMAT_SQL_DATE     = 'Y-m-d';
    const FORMAT_SQL_DATETIME = 'Y-m-d H:i:s';
    const FORMAT_SQL_TIME     = 'H:i:s';

    const UNIT_DAY    = 'day';
    const UNIT_HOUR   = 'hour';
    const UNIT_MINUTE = 'minute';
    const UNIT_MONTH  = 'month';
    const UNIT_SECOND = 'second';
    const UNIT_WEEK   = 'week';
    const UNIT_YEAR   = 'year';

    const THE_FORMAT_LIST = [
        self::FORMAT_SQL_DATE     => true,
        self::FORMAT_SQL_DATETIME => true,
        self::FORMAT_SQL_TIME     => true,
    ];

    const THE_UNIT_LIST = [
        self::UNIT_YEAR   => true,
        self::UNIT_MONTH  => true,
        self::UNIT_WEEK   => true,
        self::UNIT_DAY    => true,
        self::UNIT_HOUR   => true,
        self::UNIT_MINUTE => true,
        self::UNIT_SECOND => true,
    ];


    /**
     * @var Filter
     */
    protected $filter;
    /**
     * @var Php
     */
    protected $php;
    /**
     * @var Str
     */
    protected $str;

    /**
     * @var \DateTime
     */
    protected $today;

    /**
     * @var \DateTimeZone
     */
    protected $defaultTimezone;


    /**
     * Constructor
     *
     * @param Filter $filter
     * @param Php    $php
     * @param Str    $str
     */
    public function __construct(
        Filter $filter,
        Php $php,
        Str $str
    )
    {
        $this->filter = $filter;
        $this->php = $php;
        $this->str = $str;

        $this->defaultTimezone = new \DateTimeZone('UTC');
    }


    /**
     * @return \DateTimeZone
     */
    public function getDefaultTimezone() : \DateTimeZone
    {
        return $this->defaultTimezone;
    }


    /**
     * @param int|float|string|\DateTime $a
     * @param int|float|string|\DateTime $b
     *
     * @return bool
     */
    public function isSame($a, $b) : bool
    {
        if ($a === $b) return true;

        $parsedA = $this->dateval($a);
        $parsedB = $this->dateval($b);

        $isDateA = is_object($parsedA) && is_a($parsedA, \DateTime::class);
        $isDateB = is_object($parsedB) && is_a($parsedB, \DateTime::class);

        if ($isDateB - $isDateA) {
            $result = false;

        } else {
            $interval = $parsedB->diff($parsedA);

            $result = ! $interval->invert
                && ( ! ( 0
                    || $interval->y // years
                    || $interval->m // months
                    || $interval->d // days
                    || $interval->h // hours
                    || $interval->i // minutes
                    || $interval->s // seconds
                    || $interval->f // microseconds
                ) );
        }

        return $result;
    }


    /**
     * @param int|float|string|\DateTime $a
     * @param int|float|string|\DateTime $b
     *
     * @return bool
     */
    public function isBefore($a, $b) : bool
    {
        if ($a === $b) return false;

        $parsedA = $this->dateval($a);
        $parsedB = $this->dateval($b);

        $isDateA = is_object($parsedA) && is_a($parsedA, \DateTime::class);
        $isDateB = is_object($parsedB) && is_a($parsedB, \DateTime::class);

        if ($cmp = ( $isDateB - $isDateA )) {
            $result = $cmp < 0;

        } else {
            $interval = $parsedB->diff($parsedA);

            $result = ( $interval->invert )
                && ( 0
                    || $interval->y // years
                    || $interval->m // months
                    || $interval->d // days
                    || $interval->h // hours
                    || $interval->i // minutes
                    || $interval->s // seconds
                    || $interval->f // microseconds
                );
        }

        return $result;
    }

    /**
     * @param int|float|string|\DateTime $a
     * @param int|float|string|\DateTime $b
     *
     * @return bool
     */
    public function isBeforeOrSame($a, $b) : bool
    {
        if ($a === $b) return true;

        $parsedA = $this->dateval($a);
        $parsedB = $this->dateval($b);

        $isDateA = is_object($parsedA) && is_a($parsedA, \DateTime::class);
        $isDateB = is_object($parsedB) && is_a($parsedB, \DateTime::class);

        if ($cmp = ( $isDateB - $isDateA )) {
            $result = $cmp < 0;

        } else {
            $interval = $parsedB->diff($parsedA);

            $result = ( 0
                || ( $interval->invert )
                || ( ! $interval->invert
                    && ! ( 0
                        || $interval->y // years
                        || $interval->m // months
                        || $interval->d // days
                        || $interval->h // hours
                        || $interval->i // minutes
                        || $interval->s // seconds
                        || $interval->f // microseconds
                    ) )
            );
        }

        return $result;
    }


    /**
     * @param int|float|string|\DateTime $a
     * @param int|float|string|\DateTime $b
     *
     * @return bool
     */
    public function isAfter($a, $b) : bool
    {
        if ($a === $b) return false;

        $parsedA = $this->dateval($a);
        $parsedB = $this->dateval($b);

        $isDateA = is_object($parsedA) && is_a($parsedA, \DateTime::class);
        $isDateB = is_object($parsedB) && is_a($parsedB, \DateTime::class);

        if ($cmp = ( $isDateB - $isDateA )) {
            $result = $cmp > 0;

        } else {
            $interval = $parsedB->diff($parsedA);

            $result = ( ! $interval->invert )
                && ( 0
                    || $interval->y // years
                    || $interval->m // months
                    || $interval->d // days
                    || $interval->h // hours
                    || $interval->i // minutes
                    || $interval->s // seconds
                    || $interval->f // microseconds
                );
        }

        return $result;
    }

    /**
     * @param int|float|string|\DateTime $a
     * @param int|float|string|\DateTime $b
     *
     * @return bool
     */
    public function isAfterOrSame($a, $b) : bool
    {
        if ($a === $b) return true;

        $parsedA = $this->dateval($a);
        $parsedB = $this->dateval($b);

        $isDateA = $this->isDateTime($parsedA);
        $isDateB = $this->isDateTime($parsedB);

        if ($cmp = ( $isDateB - $isDateA )) {
            $result = $cmp > 0;

        } else {
            $interval = $parsedB->diff($parsedA);

            $result = ( 0
                || ( ! $interval->invert )
                || ( $interval->invert
                    && ! ( 0
                        || $interval->y // years
                        || $interval->m // months
                        || $interval->d // days
                        || $interval->h // hours
                        || $interval->i // minutes
                        || $interval->s // seconds
                        || $interval->f // microseconds
                    ) )
            );
        }

        return $result;
    }


    /**
     * @param int|float|string|\DateTime         $dt
     * @param int[]|float[]|string[]|\DateTime[] $dates
     *
     * @return bool
     */
    public function isBetween($dt, array $dates = []) : bool
    {
        $list = array_filter(
            array_map($dates,
                [ $this, 'parse' ]
            ),
            [ $this, 'isDateTime' ]
        );

        if (! $list) {
            return false;
        }

        $min = min($dates);
        $max = max($dates);

        $result = true
            && $this->isAfterOrSame($dt, $min)
            && $this->isBeforeOrSame($dt, $max);

        return $result;
    }

    /**
     * @param array $dates
     * @param array $datesWith
     *
     * @return bool
     */
    public function isIntersect(array $dates = [], array $datesWith = []) : bool
    {
        $list = array_filter(
            array_map($dates,
                [ $this, 'parse' ]
            ),
            [ $this, 'isDateTime' ]
        );
        $listWith = array_filter(
            array_map($dates,
                [ $this, 'parse' ]
            ),
            [ $this, 'isDateTime' ]
        );

        if (! $list) {
            return false;
        }

        if (! $listWith) {
            return false;
        }

        $min = min($dates);
        $max = max($dates);

        $minWith = min($datesWith);
        $maxWith = max($datesWith);

        $result = false
            || $this->isBetween($min, [ $minWith, $maxWith ])
            || $this->isBetween($max, [ $minWith, $maxWith ]);

        return $result;
    }


    /**
     * @param int|float|string|\DateTime $date
     *
     * @return bool
     */
    public function isDateTime($date) : bool
    {
        return null !== $this->filterDateTime($date);
    }

    /**
     * @param \DateTimeZone $timezone
     *
     * @return bool
     */
    public function isDateTimeZone($timezone) : bool
    {
        return null !== $this->filterDateTimeZone($timezone);
    }


    /**
     * @param int|float|string|\DateTime $date
     *
     * @return bool
     */
    public function isDateval($date) : bool
    {
        return null !== $this->filterDateval($date);
    }

    /**
     * @param string|\DateTimeZone $timezone
     *
     * @return bool
     */
    public function isTimezoneval($timezone) : bool
    {
        return null !== $this->filterTimezoneval($timezone);
    }

    /**
     * @param string|\DateInterval $interval
     *
     * @return bool
     */
    public function isInterval($interval) : bool
    {
        return null !== $this->filterInterval($interval);
    }


    /**
     * @param \DateTime $date
     *
     * @return null|\DateTime
     */
    public function filterDateTime($date) : ?\DateTime
    {
        $result = is_object($date) && is_a($date, \DateTime::class)
            ? $date
            : null;

        return $result;
    }

    /**
     * @param \DateTimeZone $timezone
     *
     * @return null|\DateTimeZone
     */
    public function filterDateTimeZone($timezone) : ?\DateTimeZone
    {
        $result = is_object($timezone) && is_a($timezone, \DateTimeZone::class)
            ? $timezone
            : null;

        return $result;
    }

    /**
     * @param \DateInterval $interval
     *
     * @return null|\DateInterval
     */
    public function filterDateInterval($interval) : ?\DateInterval
    {
        $result = is_object($interval) && is_a($interval, \DateInterval::class)
            ? $interval
            : null;

        return $result;
    }


    /**
     * @param int|float|string|\DateTime $date
     * @param null|\DateTimeZone         $timezone
     *
     * @return null|int|float|string|\DateTime
     */
    public function filterDateval($date, $timezone = null) // : ?int|float|string|\DateTime
    {
        if (null === $this->dateval($date, $timezone)) {
            return null;
        }

        return $date;
    }

    /**
     * @param string|\DateTimeZone $timezone
     *
     * @return null|string|\DateTimeZone
     */
    public function filterTimezoneval($timezone) // : ?string|\DateTimeZone
    {
        if (null === $this->timezoneval($timezone)) {
            return null;
        }

        return $timezone;
    }

    /**
     * @param string|\DateInterval $interval
     *
     * @return null|string|\DateInterval
     */
    public function filterInterval($interval) // : ?string|\DateTimeZone
    {
        if (null === $this->interval($interval)) {
            return null;
        }

        return $interval;
    }


    /**
     * @param \DateTime $date
     *
     * @return \DateTime
     */
    public function assertDateTime($date) : \DateTime
    {
        if (null === ( $filtered = $this->filterDateTime($date) )) {
            throw new InvalidArgumentException([ 'Invalid DateTime passed: %s', $date ]);
        }

        return $filtered;
    }

    /**
     * @param \DateTimeZone $timezone
     *
     * @return \DateTimeZone
     */
    public function assertDateTimeZone($timezone) : \DateTimeZone
    {
        if (null === ( $filtered = $this->filterDateTimeZone($timezone) )) {
            throw new InvalidArgumentException([ 'Invalid DateTimeZone passed: %s', $timezone ]);
        }

        return $filtered;
    }

    /**
     * @param \DateInterval $interval
     *
     * @return \DateInterval
     */
    public function assertDateInterval($interval) : \DateInterval
    {
        if (null === ( $filtered = $this->filterDateInterval($interval) )) {
            throw new InvalidArgumentException([ 'Invalid DateInterval passed: %s', $interval ]);
        }

        return $filtered;
    }


    /**
     * @param int|float|string|\DateTime $date
     * @param null|string|\DateTimeZone  $timezone
     *
     * @return int|float|string|\DateTime
     */
    public function assertDateval($date, $timezone = null) : \DateTime
    {
        if (null === ( $filtered = $this->filterDateval($date, $timezone) )) {
            throw new InvalidArgumentException([ 'Invalid Dateval passed: %s', $date ]);
        }

        return $filtered;
    }

    /**
     * @param string|\DateTimeZone $timezone
     *
     * @return string|\DateTimeZone
     */
    public function assertTimezoneval($timezone) : \DateTimeZone
    {
        if (null === ( $filtered = $this->filterTimezoneval($timezone) )) {
            throw new InvalidArgumentException([ 'Invalid Timezoneval passed: %s', $timezone ]);
        }

        return $filtered;
    }

    /**
     * @param string|\DateInterval $interval
     *
     * @return string|\DateInterval
     */
    public function assertInterval($interval) : \DateInterval
    {
        if (null === ( $filtered = $this->filterInterval($interval) )) {
            throw new InvalidArgumentException([ 'Invalid Interval passed: %s', $interval ]);
        }

        return $filtered;
    }


    /**
     * @param string|\DateTimeZone $timezone
     *
     * @return static
     */
    public function setDefaultTimezone($timezone)
    {
        $this->defaultTimezone = $this->theTimezone($timezone);

        return $this;
    }


    /**
     * @param int|float|string|\DateTime $date
     * @param string|\DateInterval       $interval
     * @param null|string                $unit
     *
     * @return \DateTime
     */
    public function add($date, $interval, $unit = null) : \DateTime
    {
        $date = $this->theDate($date);
        $interval = null
            ?? $this->interval($interval)
            ?? $this->parseInterval($interval, $unit);

        $interval = $this->theInterval($interval);

        $date->add($interval);

        return $date;
    }

    /**
     * @param int|float|string|\DateTime $dateA
     * @param int|float|string|\DateTime $dateB
     *
     * @return float
     */
    public function diff($dateA, $dateB) : float
    {
        $dateA = $this->theDate($dateA);
        $dateB = $this->theDate($dateB);

        $diff = (float) $dateA->format('U.u') - (float) $dateB->format('U.u');

        return $diff;
    }


    /**
     * @param int|float|string|\DateTime $date
     * @param null|\DateTimeZone         $timezone
     *
     * @return null|\DateTime
     */
    public function dateval($date, $timezone = null) : ?\DateTime
    {
        return null
            ?? $this->tryDateFromInstance($date, $timezone)
            ?? $this->tryDateFromInt($date, $timezone)
            ?? $this->tryDateFromFloat($date, $timezone)
            ?? $this->tryDateFromString($date, $timezone);
    }

    /**
     * @param int|float|string|\DateTimeZone $timezone
     * @param null|bool                      $isDst
     * @param null|int                       $utcOffset
     *
     * @return null|\DateTimeZone
     */
    public function timezoneval($timezone, bool $isDst = null, int $utcOffset = null) : ?\DateTimeZone
    {
        return null
            ?? $this->tryTimezoneFromInstance($timezone)
            ?? $this->tryTimezoneFromNumval($timezone, $isDst)
            ?? $this->tryTimezoneFromString($timezone, $isDst, $utcOffset);
    }

    /**
     * @param int|string|\DateInterval $interval
     * @param null|string              $unit
     *
     * @return null|\DateInterval
     */
    public function interval($interval, $unit = null) : ?\DateInterval
    {
        return null
            ?? $this->tryIntervalFromInstance($interval)
            ?? $this->tryIntervalFromInt($interval, $unit)
            ?? $this->tryIntervalFromString($interval, $unit);
    }


    /**
     * @param int|float|string|\DateTime $date
     * @param null|\DateTimeZone         $timezone
     *
     * @return \DateTime
     */
    public function theDate($date, $timezone = null) : \DateTime
    {
        if (null === ( $result = $this->dateval($date, $timezone) )) {
            throw new InvalidArgumentException([ 'Invalid DateTime passed: %s', $date ]);
        }

        return $result;
    }

    /**
     * @param string|\DateTimeZone $timezone
     * @param null|bool            $isDst
     * @param null|int             $utcOffset
     *
     * @return \DateTimeZone
     */
    public function theTimezone($timezone, bool $isDst = null, int $utcOffset = null) : \DateTimeZone
    {
        if (null === ( $result = $this->timezoneval($timezone, $isDst, $utcOffset) )) {
            throw new InvalidArgumentException(
                [ 'Invalid DateTimeZone passed: %s [ %s / %s ]', $timezone, $isDst, $utcOffset ]
            );
        }

        return $result;
    }

    /**
     * @param string|\DateInterval $interval
     * @param null|string          $unit
     *
     * @return \DateInterval
     */
    public function theInterval($interval, string $unit = null) : \DateInterval
    {
        if (null === ( $result = $this->interval($interval, $unit) )) {
            throw new InvalidArgumentException([ 'Invalid DateInterval passed: %s', $interval ]);
        }

        return $result;
    }


    /**
     * @param string      $format
     * @param string      $date
     * @param null|string $instantTimezone
     *
     * @return \DateTime
     */
    public function dateParse(string $format, string $date, $instantTimezone = null) : \DateTime
    {
        $result = $this->parseDateval($format, $date, $instantTimezone);

        if (null === $result) {
            throw new InvalidArgumentException([ 'Invalid Date passed: %s [ %s ]', $format, $date ]);
        }

        return $result;
    }

    /**
     * @param string    $interval
     * @param null|bool $isDst
     * @param null|int  $utcOffset
     *
     * @return \DateTimeZone
     */
    public function timezoneParse(string $interval, bool $isDst = null, int $utcOffset = null) : \DateTimeZone
    {
        $result = $this->parseTimezoneval($interval, $isDst, $utcOffset);

        if (null === $result) {
            throw new InvalidArgumentException([ 'Invalid DateTimeZone passed: %s', $interval ]);
        }

        return $result;
    }

    /**
     * @param string      $interval
     * @param null|string $unit
     *
     * @return \DateInterval
     */
    public function intervalParse(string $interval, string $unit = null) : \DateInterval
    {
        $result = $this->parseInterval($interval, $unit);

        if (null === $result) {
            throw new InvalidArgumentException([ 'Invalid DateInterval passed: %s [ %s ]', $interval, $unit ]);
        }

        return $result;
    }


    /**
     * @param null|string|\DateTimeZone $timezone
     *
     * @return \DateTime
     */
    public function now($timezone = null) : \DateTime
    {
        $timezone = $timezone
            ?? $this->getDefaultTimezone();

        $dateTimeZone = $this->theTimezone($timezone);

        $now = date_create('now', $dateTimeZone);

        return $now;
    }

    /**
     * @param null|string|\DateTimeZone $timezone
     *
     * @return \DateTime
     */
    public function today($timezone = null) : \DateTime
    {
        $timezone = $timezone
            ?? $this->getDefaultTimezone();

        $dateTimeZone = $this->theTimezone($timezone);

        if (! $this->today) {
            $today = date_create('now', $dateTimeZone);

            $this->today = $today;

        } else {
            $today = clone $this->today;

            $today->setTimezone($dateTimeZone);
        }

        return $today;
    }


    /**
     * @param string      $format
     * @param string      $date
     * @param null|string $instantTimezone
     *
     * @return null|\DateTime
     */
    public function parseDateval(string $format, string $date, $instantTimezone = null) : ?\DateTime
    {
        if ('' === $format) return null;
        if ('' === $date) return null;

        $dateTime = date_create_from_format($format, $date, $instantTimezone);

        if (false === $dateTime) {
            return null;
        }

        return $dateTime;
    }

    /**
     * @param int|float|string|\DateTimeZone $timezone
     * @param null|bool                      $isDst
     * @param null|int                       $utcOffset
     *
     * @return null|\DateTimeZone
     */
    public function parseTimezoneval($timezone, bool $isDst = null, int $utcOffset = null) : ?\DateTimeZone
    {
        if (null === ( $dateTimeZone = $this->timezoneval($timezone, $isDst, $utcOffset) )) {
            return null;
        }

        return $dateTimeZone;
    }

    /**
     * @param int|string|\DateInterval $interval
     * @param null|string              $unit
     *
     * @return null|\DateInterval
     */
    public function parseInterval($interval, string $unit = null) : ?\DateInterval
    {
        if (null === ( $dateInterval = $this->interval($interval, $unit) )) {
            return null;
        }

        return $dateInterval;
    }


    /**
     * @param \DateTime                 $instance
     * @param null|string|\DateTimeZone $timezone
     *
     * @return \DateTime
     */
    protected function tryDateFromInstance($instance, $timezone = null) : ?\DateTime
    {
        if (! is_object($instance)) return null;
        if (! is_a($instance, \DateTime::class)) return null;

        if ($timezone) {
            $instance->setTimezone($timezone);
        }

        return $instance;
    }

    /**
     * @param int                       $int
     * @param null|string|\DateTimeZone $timezone
     *
     * @return null|\DateTime
     */
    protected function tryDateFromInt($int, $timezone = null) : ?\DateTime
    {
        if (! is_int($int)) return null;

        $timezone = $timezone ?? $this->getDefaultTimezone();

        $dateTimeZone = $this->theTimezone($timezone);

        $dateTime = $this->now($dateTimeZone);

        $dateTime->setTimestamp($int);
        $dateTime->setTime(
            (int) $dateTime->format('G'), // 0-23 -> int -> 0-23
            (int) $dateTime->format('i'), // 00-59 -> int -> 0-59
            (int) $dateTime->format('s'), // 00-59 -> int -> 0-59
        );

        if (false === $dateTime) {
            return null;
        }

        return $dateTime;
    }

    /**
     * @param float                     $float
     * @param null|string|\DateTimeZone $timezone
     *
     * @return null|\DateTime
     */
    protected function tryDateFromFloat($float, $timezone = null) : ?\DateTime
    {
        if (! is_float($float)) return null;

        $timezone = $timezone ?? $this->getDefaultTimezone();

        $dateTimeZone = $this->theTimezone($timezone);

        [ $int, $microseconds ] = explode('.', sprintf('%f', $float)) + [ null, null ];

        $microseconds = str_pad(
            substr($microseconds, 0, 6), 6, '0'
        );

        $dateTime = $this->now($dateTimeZone);

        $dateTime->setTimestamp($int);
        $dateTime->setTime(
            (int) $dateTime->format('G'), // 0-23 -> int -> 0-23
            (int) $dateTime->format('i'), // 00-59 -> int -> 0-59
            (int) $dateTime->format('s'), // 00-59 -> int -> 0-59
            $microseconds
        );

        if (false === $dateTime) {
            return null;
        }

        return $dateTime;
    }


    /**
     * @param string                    $string
     * @param null|string|\DateTimeZone $timezone
     *
     * @return null|\DateTime
     */
    protected function tryDateFromString($string, $timezone = null) : ?\DateTime
    {
        if (! is_string($string)) return null;
        if ('' === $string) return null;

        $dateTime = null
            ?? $this->tryDateFromStringNumeric($string, $timezone)
            ?? $this->tryDateFromStringDatestring($string, $timezone)
            ?? $this->tryDateFromStringFormat($string, $timezone);

        return $dateTime;
    }

    /**
     * @param string                    $numeric
     * @param null|string|\DateTimeZone $timezone
     *
     * @return null|\DateTime
     */
    protected function tryDateFromStringNumeric($numeric, $timezone = null) : ?\DateTime
    {
        if (! is_string($numeric)) return null;
        if ('' === $numeric) return null;
        if (! is_numeric($numeric)) return null;

        $timezone = $timezone ?? $this->getDefaultTimezone();

        $dateTimeZone = $this->theTimezone($timezone);

        if (null !== ( $int = $this->php->intval($numeric) )) {
            $dateTime = $this->tryDateFromInt($int, $dateTimeZone);

            return $dateTime;
        }

        if (null !== ( $float = $this->php->floatval($numeric) )) {
            $dateTime = $this->tryDateFromFloat($float, $dateTimeZone);

            return $dateTime;
        }

        return null;
    }

    /**
     * @param string                    $datestring
     * @param null|string|\DateTimeZone $timezone
     *
     * @return null|\DateTime
     */
    protected function tryDateFromStringDatestring($datestring, $timezone = null) : ?\DateTime
    {
        if (! is_string($datestring)) return null;
        if ('' === $datestring) return null;
        if (false === strtotime($datestring, time())) return null;

        // if you modify that both dates with relative datestring
        // they are different when compare
        // dates are equal otherwise
        $a = ( new \DateTime('1970-01-01T00:00:00Z') )->modify($datestring);
        $b = ( new \DateTime('1971-12-25T00:00:00Z') )->modify($datestring);
        if ($a == $b) {
            return null;
        }

        $timezone = $timezone ?? $this->getDefaultTimezone();

        $dateTimeZone = $this->theTimezone($timezone);

        $dateTime = $this->tryDateFromInt(
            strtotime($datestring, $this->today($dateTimeZone)->getTimestamp()),
            $dateTimeZone
        );

        return $dateTime;
    }

    /**
     * @param string                    $format
     * @param null|string|\DateTimeZone $timezone
     *
     * @return null|\DateTime
     */
    protected function tryDateFromStringFormat($format, $timezone = null) : ?\DateTime
    {
        if (! is_string($format)) return null;
        if ('' === $format) return null;

        $timezone = $timezone ?? $this->getDefaultTimezone();

        $dateTimeZone = $this->theTimezone($timezone);

        // be aware - timezone will bind instantly here
        foreach ( static::$formatsNoTimezone as $formatNoTimezone => $enabled ) {
            if ($dateTime = $this->parseDateval($formatNoTimezone, $format, $dateTimeZone)) {
                return $dateTime;
            }
        }

        // be careful - timezone will be changed here
        foreach ( static::$formatsTimezone as $formatTimezone => $enabled ) {
            if ($dateTime = $this->parseDateval($formatTimezone, $format)) {
                $dateTime->setTimezone($dateTimeZone);

                return $dateTime;
            }
        }

        return null;
    }


    /**
     * @param \DateTimeZone $instance
     *
     * @return \DateTimeZone
     */
    protected function tryTimezoneFromInstance($instance) : ?\DateTimeZone
    {
        if (! is_object($instance)) return null;
        if (! is_a($instance, \DateTimeZone::class)) return null;

        return $instance;
    }

    /**
     * @param int|float $numval
     * @param null|bool $isDst
     *
     * @return \DateTimeZone
     */
    protected function tryTimezoneFromNumval($numval, bool $isDst = null) : ?\DateTimeZone
    {
        if (null === ( $numval = $this->php->numval($numval) )) {
            return null;
        }

        $numvalRound = round($numval * 2) / 2;

        $dateTimeZone = $this->getDefaultTimezone();

        $dateDefault = $this->theDate('now');
        $dateDefaultAbbreviation = strtolower($dateDefault->format('T'));

        $dateTimeUtc = $this->theDate('now', new \DateTimeZone('UTC'));
        $dateDefaultUtcOffset = $dateTimeZone->getOffset($dateTimeUtc) + ( $numvalRound * 3600 );

        $timezones = [];
        foreach ( timezone_abbreviations_list() as $abbreviation => $cities ) {
            foreach ( $cities as $city ) {
                if (! $city[ 'timezone_id' ]) {
                    continue;
                }

                if (isset($isDst)
                    && $isDst != ( $city[ 'dst' ] ?? null )
                ) {
                    continue;
                }

                $offsetDiff = abs($city[ 'offset' ] - $dateDefaultUtcOffset);
                if ($offsetDiff >= 3600) {
                    continue;
                }

                $timezones[ $city[ 'timezone_id' ] ] = [
                    $abbreviation,
                    $offsetDiff,
                    $city[ 'timezone_id' ],
                ];
            }
        }

        if ($timezones) {
            uasort($timezones, function ($a, $b) use ($dateDefaultAbbreviation) {
                return 0
                    ?: ( $b[ 0 ] === $dateDefaultAbbreviation ) - ( $a[ 0 ] === $dateDefaultAbbreviation )
                        ?: $a[ 1 ] - $b[ 1 ]
                            ?: strcasecmp($a[ 2 ], $b[ 2 ]);
            });

            [ 2 => $timezoneName ] = reset($timezones);

            return new \DateTimeZone($timezoneName);
        }

        return null;
    }

    /**
     * @param string    $string
     * @param null|bool $isDst
     * @param null|int  $utcOffset
     *
     * @return \DateTimeZone
     */
    protected function tryTimezoneFromString($string, bool $isDst = null, int $utcOffset = null) : ?\DateTimeZone
    {
        if (! is_string($string)) return null;
        if ('' === $string) return null;

        $dateTimeZone = null
            ?? $this->tryTimezoneFromStringNumeric($string, $isDst)
            ?? $this->tryTimezoneFromStringName($string)
            ?? $this->tryTimezoneFromStringAbbr($string, $isDst, $utcOffset);

        return $dateTimeZone;
    }

    /**
     * @param string    $numeric
     * @param null|bool $isDst
     *
     * @return \DateTimeZone
     */
    protected function tryTimezoneFromStringNumeric($numeric, bool $isDst = null) : ?\DateTimeZone
    {
        // if (! is_string($number)) return null;
        // if ('' === $number) return null;
        if (! is_numeric($numeric)) return null;

        if (null !== ( $numval = $this->php->numval($numeric) )) {
            $dateTimeZone = $this->tryTimezoneFromNumval($numval, $isDst);

            return $dateTimeZone;
        }

        return null;
    }

    /**
     * @param string $name
     *
     * @return \DateTimeZone
     */
    protected function tryTimezoneFromStringName($name) : ?\DateTimeZone
    {
        if (! is_string($name)) return null;
        if ('' === $name) return null;
        if (is_numeric($name)) return null;

        if (false === ( $dateTimeZone = timezone_open($name) )) {
            return null;
        }

        return $dateTimeZone;
    }

    /**
     * @param string    $abbr
     * @param null|bool $isDst
     * @param null|int  $utcOffset
     *
     * @return \DateTimeZone
     */
    protected function tryTimezoneFromStringAbbr($abbr, bool $isDst = null, int $utcOffset = null) : ?\DateTimeZone
    {
        if (! is_string($abbr)) return null;
        if ('' === $abbr) return null;
        if (is_numeric($abbr)) return null;

        if (false === ( $timezoneName = timezone_name_from_abbr($abbr, $utcOffset, $isDst) )) {
            return null;
        }

        $dateTimeZone = new \DateTimeZone($timezoneName);

        return $dateTimeZone;
    }



    /**
     * @param \DateInterval $instance
     *
     * @return \DateInterval
     */
    protected function tryIntervalFromInstance($instance) : ?\DateInterval
    {
        if (! is_object($instance)) return null;
        if (! is_a($instance, \DateInterval::class)) return null;

        return $instance;
    }

    /**
     * @param string      $int
     * @param null|string $unit
     *
     * @return \DateInterval
     */
    protected function tryIntervalFromInt($int, string $unit = null) : ?\DateInterval
    {
        if (! is_int($int)) return null;

        $unitLower = strtolower($unit);

        $unit = null;
        foreach ( static::THE_UNIT_LIST as $key => $bool ) {
            if (null !== $this->str->starts($unitLower, $key)) {
                $unit = $key;
            }
        }

        if (! $unit) {
            return null;
        }

        try {
            $dateInterval = null;

            switch ( $unit ):
                case static::UNIT_YEAR:
                    $dateInterval = new \DateInterval('P' . $int . 'Y');
                    break;

                case static::UNIT_MONTH:
                    $dateInterval = new \DateInterval('P' . $int . 'M');
                    break;

                case static::UNIT_DAY:
                    $dateInterval = new \DateInterval('P' . $int . 'D');
                    break;

                case static::UNIT_WEEK:
                    $dateInterval = new \DateInterval('P' . $int . 'W');
                    break;

                case static::UNIT_HOUR:
                    $dateInterval = new \DateInterval('PT' . $int . 'H');
                    break;

                case static::UNIT_MINUTE:
                    $dateInterval = new \DateInterval('PT' . $int . 'M');
                    break;

                case static::UNIT_SECOND:
                    $dateInterval = new \DateInterval('PT' . $int . 'S');
                    break;
            endswitch;

            return $dateInterval;
        }
        catch ( \Exception $e ) {
        }

        return null;
    }

    /**
     * @param string      $string
     * @param null|string $unit
     *
     * @return \DateInterval
     */
    protected function tryIntervalFromString($string, string $unit = null) : ?\DateInterval
    {
        if (! is_string($string)) return null;
        if ('' === $string) return null;

        $dateInterval = null
            ?? $this->tryIntervalFromStringNumeric($string, $unit)
            ?? $this->tryIntervalFromStringPattern($string);

        return $dateInterval;
    }

    /**
     * @param int|float   $numeric
     * @param null|string $unit
     *
     * @return \DateInterval
     */
    protected function tryIntervalFromStringNumeric($numeric, string $unit = null) : ?\DateInterval
    {
        if (! is_string($numeric)) return null;
        if ('' === $numeric) return null;
        if (! is_numeric($numeric)) return null;

        if (null !== ( $int = $this->php->intval($numeric) )) {
            $dateInterval = $this->tryIntervalFromInt($int, $unit);

            return $dateInterval;
        }

        return null;
    }

    /**
     * @param string $pattern
     *
     * @return \DateInterval
     */
    protected function tryIntervalFromStringPattern($pattern) : ?\DateInterval
    {
        if (! is_string($pattern)) return null;
        if ('' === $pattern) return null;
        if (is_numeric($pattern)) return null;

        try {
            $dateInterval = new \DateInterval($pattern);
        }
        catch ( \Exception $e ) {
            return null;
        }

        return $dateInterval;
    }


    /**
     * @var array
     */
    protected static $formatsNoTimezone = [
        self::FORMAT_SQL_DATETIME     => true, // 'Y-m-d H:i:s',
        self::FORMAT_SQL_DATE . ' 00' => true, // 'Y-m-d 00',
        self::FORMAT_SQL_TIME         => true, // 'H:i:s',
    ];

    /**
     * @var array
     */
    protected static $formatsTimezone = [
        // \DateTimeInterface::ATOM             => true, // => 'Y-m-d\TH:i:sP',
        // \DateTimeInterface::RFC822           => true, // => 'D, d M y H:i:s O',
        // \DateTimeInterface::RFC1123          => true, // => 'D, d M Y H:i:s O',
        // \DateTimeInterface::RSS              => true, // => 'D, d M Y H:i:s O',
        // \DateTimeInterface::W3C              => true, // => 'Y-m-d\TH:i:sP',

        \DateTimeInterface::COOKIE           => true, // 'l, d-M-Y H:i:s T',
        \DateTimeInterface::ISO8601          => true, // 'Y-m-d\TH:i:sO',
        \DateTimeInterface::RFC850           => true, // 'l, d-M-y H:i:s T',
        \DateTimeInterface::RFC3339_EXTENDED => true, // 'Y-m-d\TH:i:s.vP',
        \DateTimeInterface::RFC3339          => true, // 'Y-m-d\TH:i:sP',
        \DateTimeInterface::RFC2822          => true, // 'D, d M Y H:i:s O',
        \DateTimeInterface::RFC1036          => true, // 'D, d M y H:i:s O',
    ];
}
