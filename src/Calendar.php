<?php

namespace Gzhegow\Support;

use Gzhegow\Support\SupportFactory;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * Calendar
 */
class Calendar implements ICalendar
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

    const THE_FORMAT_SQL_LIST = [
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
     * @var IFilter
     */
    protected $filter;
    /**
     * @var INum
     */
    protected $num;
    /**
     * @var IPhp
     */
    protected $php;
    /**
     * @var IStr
     */
    protected $str;


    /**
     * @var \DateTime
     */
    protected $now;
    /**
     * @var \DateTimeImmutable
     */
    protected $iNow;

    /**
     * @var \DateTimeZone
     */
    protected $defaultTimezone;


    /**
     * Constructor
     *
     * @param IFilter $filter
     * @param INum    $php
     * @param IPhp    $num
     * @param IStr    $str
     */
    public function __construct(
        IFilter $filter,
        INum $num,
        IPhp $php,
        IStr $str
    )
    {
        $this->filter = $filter;
        $this->num = $num;
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
     * @param string|\DateTimeZone $timezone
     *
     * @return static
     */
    public function setDefaultTimezone($timezone)
    {
        $this->defaultTimezone = $this->theTimezoneVal($timezone);

        return $this;
    }


    /**
     * @param int|float|string|\DateTimeInterface|mixed $a
     * @param int|float|string|\DateTimeInterface|mixed $b
     *
     * @return bool
     */
    public function isSame($a, $b) : bool
    {
        if ($a === $b) return true;

        $parsedA = $this->dateVal($a);
        $parsedB = $this->dateVal($b);

        $isDateA = is_a($parsedA, \DateTime::class);
        $isDateB = is_a($parsedB, \DateTime::class);

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
     * @param int|float|string|\DateTimeInterface|mixed $a
     * @param int|float|string|\DateTimeInterface|mixed $b
     *
     * @return bool
     */
    public function isBefore($a, $b) : bool
    {
        if ($a === $b) return false;

        $parsedA = $this->dateVal($a);
        $parsedB = $this->dateVal($b);

        $isDateA = is_a($parsedA, \DateTime::class);
        $isDateB = is_a($parsedB, \DateTime::class);

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
     * @param int|float|string|\DateTimeInterface|mixed $a
     * @param int|float|string|\DateTimeInterface|mixed $b
     *
     * @return bool
     */
    public function isBeforeOrSame($a, $b) : bool
    {
        if ($a === $b) return true;

        $parsedA = $this->dateVal($a);
        $parsedB = $this->dateVal($b);

        $isDateA = is_a($parsedA, \DateTime::class);
        $isDateB = is_a($parsedB, \DateTime::class);

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
     * @param int|float|string|\DateTimeInterface|mixed $a
     * @param int|float|string|\DateTimeInterface|mixed $b
     *
     * @return bool
     */
    public function isAfter($a, $b) : bool
    {
        if ($a === $b) return false;

        $parsedA = $this->dateVal($a);
        $parsedB = $this->dateVal($b);

        $isDateA = is_a($parsedA, \DateTime::class);
        $isDateB = is_a($parsedB, \DateTime::class);

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
     * @param int|float|string|\DateTimeInterface|mixed $a
     * @param int|float|string|\DateTimeInterface|mixed $b
     *
     * @return bool
     */
    public function isAfterOrSame($a, $b) : bool
    {
        if ($a === $b) return true;

        $parsedA = $this->dateVal($a);
        $parsedB = $this->dateVal($b);

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
     * @param int|float|string|\DateTimeInterface|mixed $date
     * @param int|float|string|\DateTimeInterface|array $dates
     *
     * @return bool
     */
    public function isBetween($date, ...$dates) : bool
    {
        $date = $this->theDateVal($date);
        $dates = $this->theDatevals($dates, true);

        $min = min($dates);
        $max = max($dates);

        $result = true
            && $this->isAfterOrSame($date, $min)
            && $this->isBeforeOrSame($date, $max);

        return $result;
    }

    /**
     * @param int[]|float[]|string[]|\DateTimeInterface[] $dates
     * @param int[]|float[]|string[]|\DateTimeInterface[] $datesWith
     *
     * @return bool
     */
    public function isIntersect($dates = [], $datesWith = []) : bool
    {
        $dates = $this->theDatevals($dates, true);
        $datesWith = $this->theDatevals($datesWith, true);

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
     * @param int|float|string|\DateTimeInterface|mixed $date
     *
     * @return bool
     */
    public function isDateTimeInterface($date) : bool
    {
        return null !== $this->filterDateTimeInterface($date);
    }

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     *
     * @return bool
     */
    public function isDateTimeImmutable($date) : bool
    {
        return null !== $this->filterDateTimeImmutable($date);
    }

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
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
     * @param string|\DateInterval $interval
     *
     * @return bool
     */
    public function isDateInterval($interval) : bool
    {
        return null !== $this->filterDateInterval($interval);
    }


    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     *
     * @return bool
     */
    public function isIDate($date) : bool
    {
        return null !== $this->filterIDate($date);
    }

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     *
     * @return bool
     */
    public function isDate($date) : bool
    {
        return null !== $this->filterDate($date);
    }

    /**
     * @param string|\DateTimeZone $timezone
     *
     * @return bool
     */
    public function isTimezone($timezone) : bool
    {
        return null !== $this->filterTimezone($timezone);
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
     * @param \DateTimeInterface|mixed $date
     *
     * @return null|\DateTimeInterface
     */
    public function filterDateTimeInterface($date) : ?\DateTimeInterface
    {
        $result = is_a($date, \DateTimeInterface::class)
            ? $date
            : null;

        return $result;
    }

    /**
     * @param \DateTimeImmutable|mixed $date
     *
     * @return null|\DateTimeImmutable
     */
    public function filterDateTimeImmutable($date) : ?\DateTimeImmutable
    {
        $result = is_a($date, \DateTimeImmutable::class)
            ? $date
            : null;

        return $result;
    }

    /**
     * @param \DateTime|mixed $date
     *
     * @return null|\DateTime
     */
    public function filterDateTime($date) : ?\DateTime
    {
        $result = is_a($date, \DateTime::class)
            ? $date
            : null;

        return $result;
    }

    /**
     * @param \DateTimeZone|mixed $timezone
     *
     * @return null|\DateTimeZone
     */
    public function filterDateTimeZone($timezone) : ?\DateTimeZone
    {
        $result = is_a($timezone, \DateTimeZone::class)
            ? $timezone
            : null;

        return $result;
    }

    /**
     * @param \DateInterval|mixed $interval
     *
     * @return null|\DateInterval
     */
    public function filterDateInterval($interval) : ?\DateInterval
    {
        $result = is_a($interval, \DateInterval::class)
            ? $interval
            : null;

        return $result;
    }


    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     *
     * @return null|int|float|string|\DateTimeImmutable
     */
    public function filterIDate($date) // : ?int|float|string|\DateTimeInterface|mixed
    {
        if (null === $this->iDateVal($date)) {
            return null;
        }

        return $date;
    }

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     *
     * @return null|int|float|string|\DateTime
     */
    public function filterDate($date) // : ?int|float|string|\DateTime
    {
        if (null === $this->dateVal($date)) {
            return null;
        }

        return $date;
    }

    /**
     * @param string|\DateTimeZone $timezone
     *
     * @return null|string|\DateTimeZone
     */
    public function filterTimezone($timezone) // : ?string|\DateTimeZone
    {
        if (null === $this->timezoneVal($timezone)) {
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
        if (null === $this->intervalVal($interval)) {
            return null;
        }

        return $interval;
    }


    /**
     * @param \DateTime|mixed $date
     *
     * @return \DateTimeInterface
     */
    public function assertDateTimeInterface($date) : \DateTimeInterface
    {
        if (null === ( $filtered = $this->filterDateTime($date) )) {
            throw new InvalidArgumentException([ 'Invalid DateTime passed: %s', $date ]);
        }

        return $filtered;
    }

    /**
     * @param \DateTime|mixed $date
     *
     * @return \DateTime
     */
    public function assertDateTimeImmutable($date) : \DateTime
    {
        if (null === ( $filtered = $this->filterDateTime($date) )) {
            throw new InvalidArgumentException([ 'Invalid DateTime passed: %s', $date ]);
        }

        return $filtered;
    }

    /**
     * @param \DateTime|mixed $date
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
     * @param \DateTimeZone|mixed $timezone
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
     * @param \DateInterval|mixed $interval
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
     * @param int|float|string|\DateTimeInterface|mixed $date
     *
     * @return int|float|string|\DateTimeImmutable
     */
    public function assertIDate($date) // : int|float|string|\DateTimeImmutable
    {
        if (null === ( $filtered = $this->filterIDate($date) )) {
            throw new InvalidArgumentException([ 'Invalid Dateval passed: %s', $date ]);
        }

        return $filtered;
    }

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     *
     * @return int|float|string|\DateTime
     */
    public function assertDate($date) // : int|float|string|\DateTime
    {
        if (null === ( $filtered = $this->filterDate($date) )) {
            throw new InvalidArgumentException([ 'Invalid Dateval passed: %s', $date ]);
        }

        return $filtered;
    }

    /**
     * @param string|\DateTimeZone $timezone
     *
     * @return string|\DateTimeZone
     */
    public function assertTimezone($timezone) // : string|\DateTimeZone
    {
        if (null === ( $filtered = $this->filterTimezone($timezone) )) {
            throw new InvalidArgumentException([ 'Invalid Timezoneval passed: %s', $timezone ]);
        }

        return $filtered;
    }

    /**
     * @param string|\DateInterval $interval
     *
     * @return string|\DateInterval
     */
    public function assertInterval($interval) // : string|\DateInterval
    {
        if (null === ( $filtered = $this->filterInterval($interval) )) {
            throw new InvalidArgumentException([ 'Invalid Interval passed: %s', $interval ]);
        }

        return $filtered;
    }


    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     * @param null|\DateTimeZone                        $timezone
     *
     * @return null|\DateTimeImmutable
     */
    public function iDateVal($date, $timezone = null) : ?\DateTimeImmutable
    {
        if (! $iDateVal = $this->tryIDateFromInstance($date, $timezone)) {
            $dateVal = null
                ?? $this->tryDateFromInstance($date, $timezone)
                ?? $this->tryDateFromInt($date, $timezone)
                ?? $this->tryDateFromFloat($date, $timezone)
                ?? $this->tryDateFromString($date, $timezone);

            if ($dateVal) {
                $iDateVal = \DateTimeImmutable::createFromMutable($dateVal);
            }
        }

        return $iDateVal;
    }

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     * @param null|\DateTimeZone                        $timezone
     *
     * @return null|\DateTime
     */
    public function dateVal($date, $timezone = null) : ?\DateTime
    {
        if ($iDateVal = $this->tryIDateFromInstance($date, $timezone)) {
            $dateVal = \DateTime::createFromImmutable($iDateVal);

        } else {
            $dateVal = null
                ?? $this->tryDateFromInstance($date, $timezone)
                ?? $this->tryDateFromInt($date, $timezone)
                ?? $this->tryDateFromFloat($date, $timezone)
                ?? $this->tryDateFromString($date, $timezone);
        }

        return $dateVal;
    }

    /**
     * @param int|float|string|\DateTimeZone $timezone
     * @param null|bool                      $isDst
     * @param null|int                       $utcOffset
     *
     * @return null|\DateTimeZone
     */
    public function timezoneVal($timezone, bool $isDst = null, int $utcOffset = null) : ?\DateTimeZone
    {
        return null
            ?? $this->tryTimezoneFromInstance($timezone)
            ?? $this->tryTimezoneFromNumeric($timezone, $isDst)
            ?? $this->tryTimezoneFromString($timezone, $isDst, $utcOffset);
    }

    /**
     * @param int|string|\DateInterval $interval
     * @param null|string              $unit
     *
     * @return null|\DateInterval
     */
    public function intervalVal($interval, $unit = null) : ?\DateInterval
    {
        return null
            ?? $this->tryIntervalFromInstance($interval)
            ?? $this->tryIntervalFromInt($interval, $unit)
            ?? $this->tryIntervalFromString($interval, $unit);
    }


    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     * @param null|\DateTimeZone                        $timezone
     *
     * @return \DateTimeImmutable
     */
    public function theIDateVal($date, $timezone = null) : \DateTimeImmutable
    {
        if (null === ( $result = $this->iDateVal($date, $timezone) )) {
            throw new InvalidArgumentException([ 'Invalid IDate passed: %s', $date ]);
        }

        return $result;
    }

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     * @param null|\DateTimeZone                        $timezone
     *
     * @return \DateTime
     */
    public function theDateVal($date, $timezone = null) : \DateTime
    {
        if (null === ( $result = $this->dateVal($date, $timezone) )) {
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
    public function theTimezoneVal($timezone, bool $isDst = null, int $utcOffset = null) : \DateTimeZone
    {
        if (null === ( $result = $this->timezoneVal($timezone, $isDst, $utcOffset) )) {
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
    public function theIntervalVal($interval, string $unit = null) : \DateInterval
    {
        if (null === ( $result = $this->intervalVal($interval, $unit) )) {
            throw new InvalidArgumentException([ 'Invalid DateInterval passed: %s', $interval ]);
        }

        return $result;
    }


    /**
     * @param int|float|string|\DateTimeInterface|array $dates
     * @param null|bool                                 $uniq
     *
     * @return \DateTimeInterface[]
     */
    public function datevals($dates, $uniq = null) : array
    {
        $result = [];

        $dates = is_array($dates)
            ? $dates
            : [ $dates ];

        $input = [];
        array_walk_recursive($dates, function ($date) use (&$input, &$result) {
            if (null !== ( $dateval = $this->dateVal($date) )) {
                $input[] = $date;
                $result[] = $dateval;
            }
        });

        if ($uniq ?? false) {
            $input = $this->php->distinct($input);

            foreach ( $result as $idx => $val ) {
                if (! isset($input[ $idx ])) {
                    unset($result[ $idx ]);
                }
            }

            $result = array_values($result);
        }

        return $result;
    }

    /**
     * @param int|float|string|\DateTimeInterface|array $dates
     * @param null|bool                                 $uniq
     *
     * @return \DateTimeInterface[]
     */
    public function theDatevals($dates, $uniq = null) : array
    {
        $result = [];

        $dates = is_array($dates)
            ? $dates
            : [ $dates ];

        $input = [];
        array_walk_recursive($dates, function ($date) use (&$input, &$result) {
            $theDate = $this->theDateVal($date);

            $input[] = $date;
            $result[] = $theDate;
        });

        if ($uniq ?? false) {
            $input = $this->php->distinct($input);

            foreach ( $result as $idx => $val ) {
                if (! isset($input[ $idx ])) {
                    unset($result[ $idx ]);
                }
            }

            $result = array_values($result);
        }

        return $result;
    }


    /**
     * @param int|float|string|\DateTimeInterface|array $dates
     * @param null|bool                                 $uniq
     *
     * @return \DateTimeImmutable[]
     */
    public function iDatevals($dates, $uniq = null) : array
    {
        $result = [];

        $dates = is_array($dates)
            ? $dates
            : [ $dates ];

        $input = [];
        array_walk_recursive($dates, function ($date) use (&$input, &$result) {
            if (null !== ( $dateval = $this->iDateVal($date) )) {
                $input[] = $date;
                $result[] = $dateval;
            }
        });

        if ($uniq ?? false) {
            $input = $this->php->distinct($input);

            foreach ( $result as $idx => $val ) {
                if (! isset($input[ $idx ])) {
                    unset($result[ $idx ]);
                }
            }

            $result = array_values($result);
        }

        return $result;
    }

    /**
     * @param int|float|string|\DateTimeInterface|array $dates
     * @param null|bool                                 $uniq
     *
     * @return \DateTimeImmutable[]
     */
    public function theIDatevals($dates, $uniq = null) : array
    {
        $result = [];

        $dates = is_array($dates)
            ? $dates
            : [ $dates ];

        $input = [];
        array_walk_recursive($dates, function ($date) use (&$input, &$result) {
            $theDate = $this->theIDateVal($date);

            $input[] = $date;
            $result[] = $theDate;
        });

        if ($uniq ?? false) {
            $input = $this->php->distinct($input);

            foreach ( $result as $idx => $val ) {
                if (! isset($input[ $idx ])) {
                    unset($result[ $idx ]);
                }
            }

            $result = array_values($result);
        }

        return $result;
    }


    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     * @param string|\DateInterval                      $interval
     * @param null|string                               $unit
     *
     * @return \DateTime
     */
    public function add($date, $interval, $unit = null) : \DateTimeInterface
    {
        $date = $this->theDateVal($date);

        $date->add($this->theIntervalVal($interval, $unit));

        return $date;
    }


    /**
     * @param \DateTime|array $dates
     * @param null|bool       $uniq
     *
     * @return \DateTime[]
     */
    public function dates($dates, $uniq = null) : array
    {
        $result = [];

        $dates = is_array($dates)
            ? $dates
            : [ $dates ];

        array_walk_recursive($dates, function ($date) use (&$result) {
            if (null !== $this->filterDateTime($date)) {
                $result[] = $date;
            }
        });

        if ($uniq ?? false) {
            $result = $this->php->distinct($result);
            $result = array_values($result);
        }

        return $result;
    }

    /**
     * @param \DateTime|array $dates
     * @param null|bool       $uniq
     *
     * @return \DateTime[]
     */
    public function theDates($dates, $uniq = null) : array
    {
        $result = [];

        $dates = is_array($dates)
            ? $dates
            : [ $dates ];

        array_walk_recursive($dates, function ($date) use (&$result) {
            if (null !== $this->assertDateTime($date)) {
                $result[] = $date;
            }
        });

        if ($uniq ?? false) {
            $result = $this->php->distinct($result);
            $result = array_values($result);
        }

        return $result;
    }


    /**
     * @param \DateTimeImmutable|array $dates
     * @param null|bool                $uniq
     *
     * @return \DateTimeImmutable[]
     */
    public function iDates($dates, $uniq = null) : array
    {
        $result = [];

        $dates = is_array($dates)
            ? $dates
            : [ $dates ];

        array_walk_recursive($dates, function ($date) use (&$result) {
            if (null !== $this->filterDateTimeImmutable($date)) {
                $result[] = $date;
            }
        });

        if ($uniq ?? false) {
            $result = $this->php->distinct($result);
            $result = array_values($result);
        }

        return $result;
    }

    /**
     * @param \DateTimeImmutable|array $dates
     * @param null|bool                $uniq
     *
     * @return \DateTimeImmutable[]
     */
    public function theIDates($dates, $uniq = null) : array
    {
        $result = [];

        $dates = is_array($dates)
            ? $dates
            : [ $dates ];

        array_walk_recursive($dates, function ($date) use (&$result) {
            if (null !== $this->assertDateTimeImmutable($date)) {
                $result[] = $date;
            }
        });

        if ($uniq ?? false) {
            $result = $this->php->distinct($result);
            $result = array_values($result);
        }

        return $result;
    }


    /**
     * @param \DateTimeInterface|array $dates
     * @param null|bool                $uniq
     *
     * @return \DateTimeInterface[]
     */
    public function datesAll($dates, $uniq = null) : array
    {
        $result = [];

        $dates = is_array($dates)
            ? $dates
            : [ $dates ];

        array_walk_recursive($dates, function ($date) use (&$result) {
            if (null !== $this->filterDateTimeInterface($date)) {
                $result[] = $date;
            }
        });

        if ($uniq ?? false) {
            $result = $this->php->distinct($result);
            $result = array_values($result);
        }

        return $result;
    }

    /**
     * @param int|float|string|\DateTimeInterface|array $dates
     * @param null|bool                                 $uniq
     *
     * @return \DateTimeInterface[]
     */
    public function theDatesAll($dates, $uniq = null) : array
    {
        $result = [];

        $dates = is_array($dates)
            ? $dates
            : [ $dates ];

        array_walk_recursive($dates, function ($date) use (&$result) {
            if (null !== $this->assertDateTimeInterface($date)) {
                $result[] = $date;
            }
        });

        if ($uniq ?? false) {
            $result = $this->php->distinct($result);
            $result = array_values($result);
        }

        return $result;
    }


    /**
     * @param int|float|string|\DateTimeInterface|mixed $dateA
     * @param int|float|string|\DateTimeInterface|mixed $dateB
     *
     * @return float
     */
    public function diff($dateA, $dateB) : float
    {
        $dateA = $this->theDateVal($dateA);
        $dateB = $this->theDateVal($dateB);

        $diff = (float) $dateA->format('U.u') - (float) $dateB->format('U.u');

        return $diff;
    }


    /**
     * @param string      $format
     * @param string      $date
     * @param null|string $timezoneInitial
     *
     * @return \DateTimeImmutable
     */
    public function iDateParse(string $format, string $date, $timezoneInitial = null) : \DateTimeImmutable
    {
        $result = $this->iDateRead($format, $date, $timezoneInitial);

        if (null === $result) {
            throw new InvalidArgumentException([ 'Invalid iDate passed: %s [ %s ]', $format, $date ]);
        }

        return $result;
    }

    /**
     * @param string      $format
     * @param string      $date
     * @param null|string $timezoneInitial
     *
     * @return \DateTime
     */
    public function dateParse(string $format, string $date, $timezoneInitial = null) : \DateTime
    {
        $result = $this->dateRead($format, $date, $timezoneInitial);

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
        $result = $this->timezoneRead($interval, $isDst, $utcOffset);

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
        $result = $this->intervalRead($interval, $unit);

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

        $dateTimeZone = $this->theTimezoneVal($timezone);

        if (! isset($this->now)) {
            $this->now = date_create('now', $dateTimeZone);
        }

        $now = ( clone $this->now )->setTimezone($dateTimeZone);

        return $now;
    }

    /**
     * @param null|string|\DateTimeZone $timezone
     *
     * @return \DateTimeImmutable
     */
    public function iNow($timezone = null) : \DateTimeImmutable
    {
        $timezone = $timezone
            ?? $this->getDefaultTimezone();

        $dateTimeZone = $this->theTimezoneVal($timezone);

        if (! isset($this->iNow)) {
            $this->iNow = date_create_immutable('now', $dateTimeZone);
        }

        $now = ( clone $this->iNow )->setTimezone($dateTimeZone);

        return $now;
    }


    /**
     * @param null|string|\DateTimeZone $timezone
     *
     * @return \DateTime
     */
    public function nowInstant($timezone = null) : \DateTime
    {
        $timezone = $timezone
            ?? $this->getDefaultTimezone();

        $now = date_create('now',
            $dateTimeZone = $this->theTimezoneVal($timezone)
        );

        return $now;
    }

    /**
     * @param null|string|\DateTimeZone $timezone
     *
     * @return \DateTimeImmutable
     */
    public function iNowInstant($timezone = null) : \DateTimeImmutable
    {
        $timezone = $timezone
            ?? $this->getDefaultTimezone();

        $now = date_create_immutable('now',
            $dateTimeZone = $this->theTimezoneVal($timezone)
        );

        return $now;
    }


    /**
     * @param string      $format
     * @param string      $date
     * @param null|string $timezoneInitial
     *
     * @return null|\DateTime
     */
    public function iDateRead(string $format, string $date, $timezoneInitial = null) : ?\DateTimeImmutable
    {
        if ('' === $format) return null;
        if ('' === $date) return null;

        $iDateTime = date_create_immutable_from_format($format, $date, $timezoneInitial);

        if (false === $iDateTime) {
            return null;
        }

        return $iDateTime;
    }

    /**
     * @param string      $format
     * @param string      $date
     * @param null|string $timezoneInitial
     *
     * @return null|\DateTime
     */
    public function dateRead(string $format, string $date, $timezoneInitial = null) : ?\DateTime
    {
        if ('' === $format) return null;
        if ('' === $date) return null;

        $dateTime = date_create_from_format($format, $date, $timezoneInitial);

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
    public function timezoneRead($timezone, bool $isDst = null, int $utcOffset = null) : ?\DateTimeZone
    {
        if (null === ( $dateTimeZone = $this->timezoneVal($timezone, $isDst, $utcOffset) )) {
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
    public function intervalRead($interval, string $unit = null) : ?\DateInterval
    {
        if (null === ( $dateInterval = $this->intervalVal($interval, $unit) )) {
            return null;
        }

        return $dateInterval;
    }


    /**
     * @param \DateTime                 $instance
     * @param null|string|\DateTimeZone $timezone
     *
     * @return \DateTimeImmutable
     */
    protected function tryIDateFromInstance($instance, $timezone = null) : ?\DateTimeImmutable
    {
        if (! is_a($instance, \DateTimeImmutable::class)) return null;

        if ($timezone) {
            $instance = $instance->setTimezone($timezone);
        }

        return $instance;
    }

    /**
     * @param \DateTime                 $instance
     * @param null|string|\DateTimeZone $timezone
     *
     * @return \DateTime
     */
    protected function tryDateFromInstance($instance, $timezone = null) : ?\DateTime
    {
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

        $timezone = $timezone
            ?? $this->getDefaultTimezone();

        $dateTimeZone = $this->theTimezoneVal($timezone);

        $dateTime = $this->nowInstant($dateTimeZone);

        $dateTime = $dateTime->setTimestamp($int);
        $dateTime = $dateTime->setTime(
            (int) $dateTime->format('G'), // 0-23 -> int -> 0-23
            (int) $dateTime->format('i'), // 00-59 -> int -> 0-59
            (int) $dateTime->format('s') // 00-59 -> int -> 0-59
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

        $timezone = $timezone
            ?? $this->getDefaultTimezone();

        $dateTimeZone = $this->theTimezoneVal($timezone);

        [ $int, $microseconds ] = explode('.', sprintf('%f', $float)) + [ null, null ];

        $microseconds = str_pad(
            substr($microseconds, 0, 6), 6, '0'
        );

        $dateTime = $this->nowInstant($dateTimeZone);

        $dateTime = $dateTime->setTimestamp($int);
        $dateTime = $dateTime->setTime(
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

        $timezone = $timezone
            ?? $this->getDefaultTimezone();

        $dateTimeZone = $this->theTimezoneVal($timezone);

        if (null !== ( $int = $this->num->intval($numeric) )) {
            $dateTime = $this->tryDateFromInt($int, $dateTimeZone);

            return $dateTime;
        }

        if (null !== ( $float = $this->num->floatval($numeric) )) {
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

        $timezone = $timezone
            ?? $this->getDefaultTimezone();

        $dateTimeZone = $this->theTimezoneVal($timezone);

        $dateTime = $this->tryDateFromInt(
            strtotime($datestring, $this->now($dateTimeZone)->getTimestamp()),
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

        $timezone = $timezone
            ?? $this->getDefaultTimezone();

        $dateTimeZone = $this->theTimezoneVal($timezone);

        // be aware - timezone will bind instantly here
        foreach ( static::getFormatsNoTimezone() as $formatNoTimezone => $enabled ) {
            if ($dateTime = $this->dateRead($formatNoTimezone, $format, $dateTimeZone)) {
                return $dateTime;
            }
        }

        // be careful - timezone will be changed here
        foreach ( static::getFormatsTimezone() as $formatTimezone => $enabled ) {
            if ($dateTime = $this->dateRead($formatTimezone, $format)) {
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
        if (! is_a($instance, \DateTimeZone::class)) return null;

        return $instance;
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

        if (null !== ( $numval = $this->num->numericval($numeric) )) {
            $dateTimeZone = $this->tryTimezoneFromNumeric($numval, $isDst);

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
     * @param int|float $numval
     * @param null|bool $isDst
     *
     * @return \DateTimeZone
     */
    protected function tryTimezoneFromNumeric($numval, bool $isDst = null) : ?\DateTimeZone
    {
        if (null === ( $numval = $this->num->numericval($numval) )) {
            return null;
        }

        $numvalRound = round($numval * 2) / 2;

        $dateTimeZone = $this->getDefaultTimezone();

        $dateDefault = $this->theDateVal('now');
        $dateDefaultAbbreviation = strtolower($dateDefault->format('T'));

        $dateTimeUtc = $this->theDateVal('now', new \DateTimeZone('UTC'));
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
     * @param \DateInterval $instance
     *
     * @return \DateInterval
     */
    protected function tryIntervalFromInstance($instance) : ?\DateInterval
    {
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

        $unit = $unit ?? static::UNIT_SECOND;

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
            ?? $this->tryIntervalFromStringPattern($string)
            ?? $this->tryIntervalFromStringDatestring($string)
            ?? $this->tryIntervalFromStringNumeric($string, $unit);

        return $dateInterval;
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
     * @param string $datestring
     *
     * @return \DateInterval
     */
    protected function tryIntervalFromStringDatestring($datestring) : ?\DateInterval
    {
        if (! is_string($datestring)) return null;
        if ('' === $datestring) return null;
        if (false === strtotime($datestring, time())) return null;

        try {
            $dateInterval = date_create('now')->diff(date_create($datestring));
        }
        catch ( \Exception $e ) {
            return null;
        }

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

        if (null !== ( $int = $this->num->intval($numeric) )) {
            $dateInterval = $this->tryIntervalFromInt($int, $unit);

            return $dateInterval;
        }

        return null;
    }


    /**
     * @return bool[]
     */
    protected static function getFormatsNoTimezone()
    {
        return [
            self::FORMAT_SQL_DATETIME     => true, // 'Y-m-d H:i:s',
            self::FORMAT_SQL_DATE . ' 00' => true, // 'Y-m-d 00',
            self::FORMAT_SQL_TIME         => true, // 'H:i:s',
        ];
    }

    /**
     * @return bool[]
     */
    protected static function getFormatsTimezone()
    {
        return [
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


    /**
     * @return static
     */
    public static function me()
    {
        return SupportFactory::getInstance()->getCalendar();
    }
}
