<?php
/**
 * @noinspection RedundantSuppression
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support;

use Gzhegow\Support\Traits\Load\StrLoadTrait;
use Gzhegow\Support\Traits\Load\ArrLoadTrait;
use Gzhegow\Support\Traits\Load\NumLoadTrait;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * XCalendar
 */
class XCalendar implements ICalendar
{
    use ArrLoadTrait;
    use StrLoadTrait;
    use NumLoadTrait;


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
     */
    public function __construct()
    {
        $this->defaultTimezone = null
            ?? new \DateTimeZone(date_default_timezone_get())
            ?? new \DateTimeZone('UTC');
    }


    /**
     * @param null|string|\DateTimeZone $timezone
     *
     * @return static
     */
    public function withDefaultTimezone($timezone = null)
    {
        if ($timezone) {
            $timezone = $this->theTimezoneVal($timezone);
        }

        $this->defaultTimezone = $timezone
            ?? new \DateTimeZone(date_default_timezone_get());

        return $this;
    }


    /**
     * @return bool[]
     */
    protected static function loadFormatsNoTimezone()
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
    protected static function loadFormatsTimezone()
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
     * @return \DateTimeZone
     */
    public function getDefaultTimezone() : \DateTimeZone
    {
        return $this->defaultTimezone;
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

        $isDateA = $parsedA instanceof \DateTime;
        $isDateB = $parsedB instanceof \DateTime;

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

        $isDateA = $parsedA instanceof \DateTime;
        $isDateB = $parsedB instanceof \DateTime;

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

        $isDateA = $parsedA instanceof \DateTime;
        $isDateB = $parsedB instanceof \DateTime;

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

        $isDateA = $parsedA instanceof \DateTime;
        $isDateB = $parsedB instanceof \DateTime;

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

        $isDateA = $parsedA instanceof \DateTime;
        $isDateB = $parsedB instanceof \DateTime;

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
        $dates = $this->theDatevals($dates, true, true);

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
     * @param \DateTimeInterface|mixed $date
     *
     * @return null|\DateTimeInterface
     */
    public function filterDateTimeInterface($date) : ?\DateTimeInterface
    {
        if ($date instanceof \DateTimeInterface) {
            return $date;
        }

        return null;
    }

    /**
     * @param \DateTimeImmutable|mixed $date
     *
     * @return null|\DateTimeImmutable
     */
    public function filterDateTimeImmutable($date) : ?\DateTimeImmutable
    {
        if ($date instanceof \DateTimeImmutable) {
            return $date;
        }

        return null;
    }

    /**
     * @param \DateTime|mixed $date
     *
     * @return null|\DateTime
     */
    public function filterDateTime($date) : ?\DateTime
    {
        if ($date instanceof \DateTime) {
            return $date;
        }

        return null;
    }

    /**
     * @param \DateTimeZone|mixed $timezone
     *
     * @return null|\DateTimeZone
     */
    public function filterDateTimeZone($timezone) : ?\DateTimeZone
    {
        if ($timezone instanceof \DateTimeZone) {
            return $timezone;
        }

        return null;
    }

    /**
     * @param \DateInterval|mixed $interval
     *
     * @return null|\DateInterval
     */
    public function filterDateInterval($interval) : ?\DateInterval
    {
        if ($interval instanceof \DateInterval) {
            return $interval;
        }

        return null;
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
                ?? $this->tryDateFromString($date, $timezone)
                ?? $this->tryDateFromFloat($date, $timezone);

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
                ?? $this->tryDateFromString($date, $timezone)
                ?? $this->tryDateFromFloat($date, $timezone);
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
        if (null === ( $val = $this->iDateVal($date, $timezone) )) {
            throw new InvalidArgumentException(
                [ 'Invalid IDate passed: %s', $date ]
            );
        }

        return $val;
    }

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     * @param null|\DateTimeZone                        $timezone
     *
     * @return \DateTime
     */
    public function theDateVal($date, $timezone = null) : \DateTime
    {
        if (null === ( $val = $this->dateVal($date, $timezone) )) {
            throw new InvalidArgumentException(
                [ 'Invalid DateTime passed: %s', $date ]
            );
        }

        return $val;
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
        if (null === ( $val = $this->timezoneVal($timezone, $isDst, $utcOffset) )) {
            throw new InvalidArgumentException(
                [ 'Invalid DateTimeZone passed: %s [ %s / %s ]', $timezone, $isDst, $utcOffset ]
            );
        }

        return $val;
    }

    /**
     * @param string|\DateInterval $interval
     * @param null|string          $unit
     *
     * @return \DateInterval
     */
    public function theIntervalVal($interval, string $unit = null) : \DateInterval
    {
        if (null === ( $val = $this->intervalVal($interval, $unit) )) {
            throw new InvalidArgumentException([ 'Invalid DateInterval passed: %s', $interval ]);
        }

        return $val;
    }


    /**
     * @param int|float|string|\DateTimeInterface|array $dates
     * @param null|bool                                 $uniq
     * @param null|bool                                 $recursive
     *
     * @return \DateTimeInterface[]
     */
    public function datevals($dates, bool $uniq = null, bool $recursive = null) : array
    {
        $result = [];

        $dates = is_array($dates)
            ? $dates
            : [ $dates ];

        $input = [];
        if ($recursive) {
            array_walk_recursive($dates, function ($item) use (&$result, &$input) {
                if (null !== ( $val = $this->dateVal($item) )) {
                    $input[] = $item;
                    $result[] = $val;
                }
            });

        } else {
            foreach ( $dates as $item ) {
                if (null !== ( $val = $this->dateVal($item) )) {
                    $input[] = $item;
                    $result[] = $val;
                }
            }
        }

        if ($uniq) {
            $input = $this->getArr()->distinct($input);

            foreach ( $result as $idx => $i ) {
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
     * @param null|bool                                 $recursive
     *
     * @return \DateTimeInterface[]
     */
    public function theDatevals($dates, bool $uniq = null, bool $recursive = null) : array
    {
        $result = [];

        $dates = is_array($dates)
            ? $dates
            : [ $dates ];

        $input = [];
        if ($recursive) {
            array_walk_recursive($dates, function ($item) use (&$result, &$input) {
                $val = $this->theDateVal($item);

                $input[] = $item;
                $result[] = $val;
            });

        } else {
            foreach ( $dates as $item ) {
                $val = $this->theDateVal($item);

                $input[] = $item;
                $result[] = $val;
            }
        }

        if ($uniq) {
            $input = $this->getArr()->distinct($input);

            foreach ( $result as $idx => $i ) {
                if (! isset($input[ $idx ])) {
                    unset($result[ $idx ]);
                }
            }

            $result = array_values($result);
        }

        return $result;
    }


    /**
     * @param int|float|string|\DateTimeInterface|array $iDates
     * @param null|bool                                 $uniq
     * @param null|bool                                 $recursive
     *
     * @return \DateTimeImmutable[]
     */
    public function iDatevals($iDates, bool $uniq = null, bool $recursive = null) : array
    {
        $result = [];

        $iDates = is_array($iDates)
            ? $iDates
            : [ $iDates ];

        $input = [];
        if ($recursive) {
            array_walk_recursive($iDates, function ($item) use (&$result, &$input) {
                if (null !== ( $val = $this->iDateVal($item) )) {
                    $input[] = $item;
                    $result[] = $val;
                }
            });

        } else {
            foreach ( $iDates as $item ) {
                if (null !== ( $val = $this->iDateVal($item) )) {
                    $input[] = $item;
                    $result[] = $val;
                }
            }
        }

        if ($uniq) {
            $input = $this->getArr()->distinct($input);

            foreach ( $result as $idx => $i ) {
                if (! isset($input[ $idx ])) {
                    unset($result[ $idx ]);
                }
            }

            $result = array_values($result);
        }

        return $result;
    }

    /**
     * @param int|float|string|\DateTimeInterface|array $iDates
     * @param null|bool                                 $uniq
     * @param null|bool                                 $recursive
     *
     * @return \DateTimeImmutable[]
     */
    public function theIDatevals($iDates, bool $uniq = null, bool $recursive = null) : array
    {
        $result = [];

        $iDates = is_array($iDates)
            ? $iDates
            : [ $iDates ];

        $input = [];
        if ($recursive) {
            array_walk_recursive($iDates, function ($item) use (&$result, &$input) {
                $val = $this->theIDateVal($item);

                $input[] = $item;
                $result[] = $val;
            });

        } else {
            foreach ( $iDates as $item ) {
                $val = $this->theIDateVal($item);

                $input[] = $item;
                $result[] = $val;
            }
        }

        if ($uniq) {
            $input = $this->getArr()->distinct($input);

            foreach ( $result as $idx => $i ) {
                if (! isset($input[ $idx ])) {
                    unset($result[ $idx ]);
                }
            }

            $result = array_values($result);
        }

        return $result;
    }


    /**
     * @param \DateTime|array $dateTimeObjects
     * @param null|bool       $uniq
     * @param null|bool       $recursive
     *
     * @return \DateTime[]
     */
    public function dates($dateTimeObjects, bool $uniq = null, bool $recursive = null) : array
    {
        $result = [];

        $dateTimeObjects = is_array($dateTimeObjects)
            ? $dateTimeObjects
            : [ $dateTimeObjects ];

        if ($recursive) {
            array_walk_recursive($dateTimeObjects, function ($item) use (&$result) {
                if (null !== $this->filterDateTime($item)) {
                    $result[] = $item;
                }
            });

        } else {
            foreach ( $dateTimeObjects as $item ) {
                if (null !== $this->filterDateTime($item)) {
                    $result[] = $item;
                }
            }
        }

        if ($uniq) {
            $result = $this->getArr()->distinct($result);
            $result = array_values($result);
        }

        return $result;
    }

    /**
     * @param \DateTime|array $dateTimeObjects
     * @param null|bool       $uniq
     * @param null|bool       $recursive
     *
     * @return \DateTime[]
     */
    public function theDates($dateTimeObjects, bool $uniq = null, bool $recursive = null) : array
    {
        $result = [];

        $dateTimeObjects = is_array($dateTimeObjects)
            ? $dateTimeObjects
            : [ $dateTimeObjects ];

        if ($recursive) {
            array_walk_recursive($dateTimeObjects, function ($item) use (&$result) {
                if (null === $this->filterDateTime($item)) {
                    throw new InvalidArgumentException([
                        'The `item` should extends ' . \DateTime::class,
                    ]);
                }

                $result[] = $item;
            });

        } else {
            foreach ( $dateTimeObjects as $item ) {
                if (null === $this->filterDateTime($item)) {
                    throw new InvalidArgumentException([
                        'The `item` should extends ' . \DateTime::class,
                    ]);
                }

                $result[] = $item;
            }
        }

        if ($uniq) {
            $result = $this->getArr()->distinct($result);
            $result = array_values($result);
        }

        return $result;
    }


    /**
     * @param \DateTimeImmutable|array $dateTimeImmutableObjects
     * @param null|bool                $uniq
     * @param null|bool                $recursive
     *
     * @return \DateTimeImmutable[]
     */
    public function iDates($dateTimeImmutableObjects, bool $uniq = null, bool $recursive = null) : array
    {
        $result = [];

        $dateTimeImmutableObjects = is_array($dateTimeImmutableObjects)
            ? $dateTimeImmutableObjects
            : [ $dateTimeImmutableObjects ];

        if ($recursive) {
            array_walk_recursive($dateTimeImmutableObjects, function ($item) use (&$result) {
                if (null !== $this->filterDateTimeImmutable($item)) {
                    $result[] = $item;
                }
            });

        } else {
            foreach ( $dateTimeImmutableObjects as $item ) {
                if (null !== $this->filterDateTimeImmutable($item)) {
                    $result[] = $item;
                }
            }
        }

        if ($uniq) {
            $result = $this->getArr()->distinct($result);
            $result = array_values($result);
        }

        return $result;
    }

    /**
     * @param \DateTimeImmutable|array $dateTimeImmutableObjects
     * @param null|bool                $uniq
     * @param null|bool                $recursive
     *
     * @return \DateTimeImmutable[]
     */
    public function theIDates($dateTimeImmutableObjects, bool $uniq = null, bool $recursive = null) : array
    {
        $result = [];

        $dateTimeImmutableObjects = is_array($dateTimeImmutableObjects)
            ? $dateTimeImmutableObjects
            : [ $dateTimeImmutableObjects ];

        if ($recursive) {
            array_walk_recursive($dateTimeImmutableObjects, function ($item) use (&$result) {
                if (null === $this->filterDateTimeImmutable($item)) {
                    throw new InvalidArgumentException([
                        'The `item` should extends ' . \DateTimeImmutable::class,
                    ]);
                }

                $result[] = $item;
            });

        } else {
            foreach ( $dateTimeImmutableObjects as $item ) {
                if (null === $this->filterDateTimeImmutable($item)) {
                    throw new InvalidArgumentException([
                        'The `item` should extends ' . \DateTimeImmutable::class,
                    ]);
                }

                $result[] = $item;
            }
        }

        if ($uniq) {
            $result = $this->getArr()->distinct($result);
            $result = array_values($result);
        }

        return $result;
    }


    /**
     * @param \DateTimeInterface|array $dateTimeAllObjects
     * @param null|bool                $uniq
     * @param null|bool                $recursive
     *
     * @return \DateTimeInterface[]
     */
    public function datesAll($dateTimeAllObjects, bool $uniq = null, bool $recursive = null) : array
    {
        $result = [];

        $dateTimeAllObjects = is_array($dateTimeAllObjects)
            ? $dateTimeAllObjects
            : [ $dateTimeAllObjects ];

        if ($recursive) {
            array_walk_recursive($dateTimeAllObjects, function ($item) use (&$result) {
                if (null !== $this->filterDateTimeInterface($item)) {
                    $result[] = $item;
                }
            });

        } else {
            foreach ( $dateTimeAllObjects as $item ) {
                if (null !== $this->filterDateTimeInterface($item)) {
                    $result[] = $item;
                }
            }
        }

        if ($uniq) {
            $result = $this->getArr()->distinct($result);
            $result = array_values($result);
        }

        return $result;
    }

    /**
     * @param int|float|string|\DateTimeInterface|array $dateTimeAllObjects
     * @param null|bool                                 $uniq
     * @param null|bool                                 $recursive
     *
     * @return \DateTimeInterface[]
     */
    public function theDatesAll($dateTimeAllObjects, bool $uniq = null, bool $recursive = null) : array
    {
        $result = [];

        $dateTimeAllObjects = is_array($dateTimeAllObjects)
            ? $dateTimeAllObjects
            : [ $dateTimeAllObjects ];

        if ($recursive) {
            array_walk_recursive($dateTimeAllObjects, static function ($item) use (&$result) {
                if (null === $this->filterDateTimeInterface($item)) {
                    throw new InvalidArgumentException([
                        'The `item` should implements ' . \DateTimeInterface::class,
                    ]);
                }

                $result[] = $item;
            });

        } else {
            foreach ( $dateTimeAllObjects as $item ) {
                if (null === $this->filterDateTimeInterface($item)) {
                    throw new InvalidArgumentException([
                        'The `item` should implements ' . \DateTimeInterface::class,
                    ]);
                }

                $result[] = $item;
            }
        }

        if ($uniq) {
            $result = $this->getArr()->distinct($result);
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
    public function dateAdd($date, $interval, $unit = null) : \DateTimeInterface
    {
        $date = $this->theDateVal($date);

        $date->add($this->theIntervalVal($interval, $unit));

        return $date;
    }

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     * @param string|\DateInterval                      $interval
     * @param null|string                               $unit
     *
     * @return \DateTime
     */
    public function dateSub($date, $interval, $unit = null) : \DateTimeInterface
    {
        $date = $this->theDateVal($date);

        $date->sub($this->theIntervalVal($interval, $unit));

        return $date;
    }


    /**
     * @param int|float|string|\DateTimeInterface|mixed $dateA
     * @param int|float|string|\DateTimeInterface|mixed $dateB
     *
     * @return string
     */
    public function diffSeconds($dateA, $dateB) : string
    {
        $dateA = $this->theDateVal($dateA);
        $dateB = $this->theDateVal($dateB);

        $diff = bcsub(
            $dateA->format('U.u'),
            $dateB->format('U.u'),
            6
        );

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

        // if we set incorrect time date becomes false
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

        $decimals = 6;

        [ $int, $microseconds ] = explode('.', sprintf('%.' . $decimals . 'f', $float)) + [ null, null ];

        $microseconds = str_pad(substr($microseconds, 0, $decimals), $decimals, '0');

        $dateTime = $this->nowInstant($dateTimeZone);

        $dateTime = $dateTime->setTimestamp($int);
        $dateTime = $dateTime->setTime(
            (int) $dateTime->format('G'), // 0-23 -> int -> 0-23
            (int) $dateTime->format('i'), // 00-59 -> int -> 0-59
            (int) $dateTime->format('s'), // 00-59 -> int -> 0-59
            $microseconds
        );

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
        if (null === ( $numval = $this->getNum()->numval($numeric) )) {
            return null;
        }

        $timezone = $timezone
            ?? $this->getDefaultTimezone();

        $dateTimeZone = $this->theTimezoneVal($timezone);

        $val = null;

        if (is_int($numval)) {
            $val = $this->tryDateFromInt($numval, $dateTimeZone);

        } elseif (is_float($numval)) {
            $val = $this->tryDateFromFloat($numval, $dateTimeZone);
        }

        return $val;
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

        // if you modify that both dates with same relative datestring they are different when compare
        // otherwise if it is not a relative datestring - dates will be equal
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

        foreach ( static::loadFormatsNoTimezone() as $formatNoTimezone => $enabled ) {
            $dateTimeZone = $this->theTimezoneVal($timezone ?? $this->getDefaultTimezone());

            // be careful - timezone will be bound instantly here
            if ($dateTime = $this->dateRead($formatNoTimezone, $format, $dateTimeZone)) {
                return $dateTime;
            }
        }

        foreach ( static::loadFormatsTimezone() as $formatTimezone => $enabled ) {
            if ($dateTime = $this->dateRead($formatTimezone, $format)) {
                if (null !== $timezone) {
                    $dateTimeZone = $this->theTimezoneVal($timezone);

                    // be careful - timezone will be changed here
                    $dateTime->setTimezone($dateTimeZone);
                }

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
            ?? $this->tryTimezoneFromStringName($string)
            ?? $this->tryTimezoneFromStringAbbr($string, $isDst, $utcOffset)
            ?? $this->tryTimezoneFromStringNumeric($string, $isDst);

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
        if (null === ( $val = $this->getNum()->numericval($numeric) )) {
            return null;
        }

        $dateTimeZone = $this->tryTimezoneFromNumeric($val, $isDst);

        return $dateTimeZone;
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
        if (null === ( $numval = $this->getNum()->numericval($numval) )) {
            return null;
        }

        $numvalRound = round($numval * 2) / 2;

        $dateTimeZone = $this->getDefaultTimezone();

        $dateDefault = $this->theDateVal('now');
        $dateUtc = $this->theDateVal('now', new \DateTimeZone('UTC'));

        $dateDefaultAbbreviation = strtolower($dateDefault->format('T'));
        $dateDefaultUtcOffset = $dateTimeZone->getOffset($dateUtc) + ( $numvalRound * 3600 );

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
        if (! ( $instance instanceof \DateInterval )) return null;

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
            if (null !== $this->getStr()->starts($unitLower, $key)) {
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

        if (null !== ( $int = $this->getNum()->intval($numeric) )) {
            $dateInterval = $this->tryIntervalFromInt($int, $unit);

            return $dateInterval;
        }

        return null;
    }


    /**
     * @return ICalendar
     */
    public static function getInstance() : ICalendar
    {
        return SupportFactory::getInstance()->getCalendar();
    }
}