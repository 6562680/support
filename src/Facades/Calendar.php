<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 * @noinspection RedundantSuppression
 */

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\ICalendar;
use Gzhegow\Support\ZCalendar;

class Calendar
{
    /**
     * @return \DateTimeZone
     */
    public static function getDefaultTimezone(): \DateTimeZone
    {
        return static::getInstance()->getDefaultTimezone();
    }

    /**
     * @param string|\DateTimeZone $timezone
     *
     * @return ZCalendar
     */
    public static function setDefaultTimezone($timezone)
    {
        return static::getInstance()->setDefaultTimezone($timezone);
    }

    /**
     * @param int|float|string|\DateTimeInterface|mixed $a
     * @param int|float|string|\DateTimeInterface|mixed $b
     *
     * @return bool
     */
    public static function isSame($a, $b): bool
    {
        return static::getInstance()->isSame($a, $b);
    }

    /**
     * @param int|float|string|\DateTimeInterface|mixed $a
     * @param int|float|string|\DateTimeInterface|mixed $b
     *
     * @return bool
     */
    public static function isBefore($a, $b): bool
    {
        return static::getInstance()->isBefore($a, $b);
    }

    /**
     * @param int|float|string|\DateTimeInterface|mixed $a
     * @param int|float|string|\DateTimeInterface|mixed $b
     *
     * @return bool
     */
    public static function isBeforeOrSame($a, $b): bool
    {
        return static::getInstance()->isBeforeOrSame($a, $b);
    }

    /**
     * @param int|float|string|\DateTimeInterface|mixed $a
     * @param int|float|string|\DateTimeInterface|mixed $b
     *
     * @return bool
     */
    public static function isAfter($a, $b): bool
    {
        return static::getInstance()->isAfter($a, $b);
    }

    /**
     * @param int|float|string|\DateTimeInterface|mixed $a
     * @param int|float|string|\DateTimeInterface|mixed $b
     *
     * @return bool
     */
    public static function isAfterOrSame($a, $b): bool
    {
        return static::getInstance()->isAfterOrSame($a, $b);
    }

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     * @param int|float|string|\DateTimeInterface|array $dates
     *
     * @return bool
     */
    public static function isBetween($date, ...$dates): bool
    {
        return static::getInstance()->isBetween($date, ...$dates);
    }

    /**
     * @param int[]|float[]|string[]|\DateTimeInterface[] $dates
     * @param int[]|float[]|string[]|\DateTimeInterface[] $datesWith
     *
     * @return bool
     */
    public static function isIntersect($dates = [], $datesWith = []): bool
    {
        return static::getInstance()->isIntersect($dates, $datesWith);
    }

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     *
     * @return bool
     */
    public static function isDateTimeInterface($date): bool
    {
        return static::getInstance()->isDateTimeInterface($date);
    }

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     *
     * @return bool
     */
    public static function isDateTimeImmutable($date): bool
    {
        return static::getInstance()->isDateTimeImmutable($date);
    }

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     *
     * @return bool
     */
    public static function isDateTime($date): bool
    {
        return static::getInstance()->isDateTime($date);
    }

    /**
     * @param \DateTimeZone $timezone
     *
     * @return bool
     */
    public static function isDateTimeZone($timezone): bool
    {
        return static::getInstance()->isDateTimeZone($timezone);
    }

    /**
     * @param string|\DateInterval $interval
     *
     * @return bool
     */
    public static function isDateInterval($interval): bool
    {
        return static::getInstance()->isDateInterval($interval);
    }

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     *
     * @return bool
     */
    public static function isIDate($date): bool
    {
        return static::getInstance()->isIDate($date);
    }

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     *
     * @return bool
     */
    public static function isDate($date): bool
    {
        return static::getInstance()->isDate($date);
    }

    /**
     * @param string|\DateTimeZone $timezone
     *
     * @return bool
     */
    public static function isTimezone($timezone): bool
    {
        return static::getInstance()->isTimezone($timezone);
    }

    /**
     * @param string|\DateInterval $interval
     *
     * @return bool
     */
    public static function isInterval($interval): bool
    {
        return static::getInstance()->isInterval($interval);
    }

    /**
     * @param \DateTimeInterface|mixed $date
     *
     * @return null|\DateTimeInterface
     */
    public static function filterDateTimeInterface($date): ?\DateTimeInterface
    {
        return static::getInstance()->filterDateTimeInterface($date);
    }

    /**
     * @param \DateTimeImmutable|mixed $date
     *
     * @return null|\DateTimeImmutable
     */
    public static function filterDateTimeImmutable($date): ?\DateTimeImmutable
    {
        return static::getInstance()->filterDateTimeImmutable($date);
    }

    /**
     * @param \DateTime|mixed $date
     *
     * @return null|\DateTime
     */
    public static function filterDateTime($date): ?\DateTime
    {
        return static::getInstance()->filterDateTime($date);
    }

    /**
     * @param \DateTimeZone|mixed $timezone
     *
     * @return null|\DateTimeZone
     */
    public static function filterDateTimeZone($timezone): ?\DateTimeZone
    {
        return static::getInstance()->filterDateTimeZone($timezone);
    }

    /**
     * @param \DateInterval|mixed $interval
     *
     * @return null|\DateInterval
     */
    public static function filterDateInterval($interval): ?\DateInterval
    {
        return static::getInstance()->filterDateInterval($interval);
    }

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     *
     * @return null|int|float|string|\DateTimeImmutable
     */
    public static function filterIDate($date)
    {
        return static::getInstance()->filterIDate($date);
    }

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     *
     * @return null|int|float|string|\DateTime
     */
    public static function filterDate($date)
    {
        return static::getInstance()->filterDate($date);
    }

    /**
     * @param string|\DateTimeZone $timezone
     *
     * @return null|string|\DateTimeZone
     */
    public static function filterTimezone($timezone)
    {
        return static::getInstance()->filterTimezone($timezone);
    }

    /**
     * @param string|\DateInterval $interval
     *
     * @return null|string|\DateInterval
     */
    public static function filterInterval($interval)
    {
        return static::getInstance()->filterInterval($interval);
    }

    /**
     * @param \DateTime|mixed $date
     *
     * @return \DateTimeInterface
     */
    public static function assertDateTimeInterface($date): \DateTimeInterface
    {
        return static::getInstance()->assertDateTimeInterface($date);
    }

    /**
     * @param \DateTime|mixed $date
     *
     * @return \DateTime
     */
    public static function assertDateTimeImmutable($date): \DateTime
    {
        return static::getInstance()->assertDateTimeImmutable($date);
    }

    /**
     * @param \DateTime|mixed $date
     *
     * @return \DateTime
     */
    public static function assertDateTime($date): \DateTime
    {
        return static::getInstance()->assertDateTime($date);
    }

    /**
     * @param \DateTimeZone|mixed $timezone
     *
     * @return \DateTimeZone
     */
    public static function assertDateTimeZone($timezone): \DateTimeZone
    {
        return static::getInstance()->assertDateTimeZone($timezone);
    }

    /**
     * @param \DateInterval|mixed $interval
     *
     * @return \DateInterval
     */
    public static function assertDateInterval($interval): \DateInterval
    {
        return static::getInstance()->assertDateInterval($interval);
    }

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     *
     * @return int|float|string|\DateTimeImmutable
     */
    public static function assertIDate($date)
    {
        return static::getInstance()->assertIDate($date);
    }

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     *
     * @return int|float|string|\DateTime
     */
    public static function assertDate($date)
    {
        return static::getInstance()->assertDate($date);
    }

    /**
     * @param string|\DateTimeZone $timezone
     *
     * @return string|\DateTimeZone
     */
    public static function assertTimezone($timezone)
    {
        return static::getInstance()->assertTimezone($timezone);
    }

    /**
     * @param string|\DateInterval $interval
     *
     * @return string|\DateInterval
     */
    public static function assertInterval($interval)
    {
        return static::getInstance()->assertInterval($interval);
    }

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     * @param null|\DateTimeZone                        $timezone
     *
     * @return null|\DateTimeImmutable
     */
    public static function iDateVal($date, $timezone = null): ?\DateTimeImmutable
    {
        return static::getInstance()->iDateVal($date, $timezone);
    }

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     * @param null|\DateTimeZone                        $timezone
     *
     * @return null|\DateTime
     */
    public static function dateVal($date, $timezone = null): ?\DateTime
    {
        return static::getInstance()->dateVal($date, $timezone);
    }

    /**
     * @param int|float|string|\DateTimeZone $timezone
     * @param null|bool                      $isDst
     * @param null|int                       $utcOffset
     *
     * @return null|\DateTimeZone
     */
    public static function timezoneVal($timezone, bool $isDst = null, int $utcOffset = null): ?\DateTimeZone
    {
        return static::getInstance()->timezoneVal($timezone, $isDst, $utcOffset);
    }

    /**
     * @param int|string|\DateInterval $interval
     * @param null|string              $unit
     *
     * @return null|\DateInterval
     */
    public static function intervalVal($interval, $unit = null): ?\DateInterval
    {
        return static::getInstance()->intervalVal($interval, $unit);
    }

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     * @param null|\DateTimeZone                        $timezone
     *
     * @return \DateTimeImmutable
     */
    public static function theIDateVal($date, $timezone = null): \DateTimeImmutable
    {
        return static::getInstance()->theIDateVal($date, $timezone);
    }

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     * @param null|\DateTimeZone                        $timezone
     *
     * @return \DateTime
     */
    public static function theDateVal($date, $timezone = null): \DateTime
    {
        return static::getInstance()->theDateVal($date, $timezone);
    }

    /**
     * @param string|\DateTimeZone $timezone
     * @param null|bool            $isDst
     * @param null|int             $utcOffset
     *
     * @return \DateTimeZone
     */
    public static function theTimezoneVal($timezone, bool $isDst = null, int $utcOffset = null): \DateTimeZone
    {
        return static::getInstance()->theTimezoneVal($timezone, $isDst, $utcOffset);
    }

    /**
     * @param string|\DateInterval $interval
     * @param null|string          $unit
     *
     * @return \DateInterval
     */
    public static function theIntervalVal($interval, string $unit = null): \DateInterval
    {
        return static::getInstance()->theIntervalVal($interval, $unit);
    }

    /**
     * @param int|float|string|\DateTimeInterface|array $dates
     * @param null|bool                                 $uniq
     *
     * @return \DateTimeInterface[]
     */
    public static function datevals($dates, $uniq = null): array
    {
        return static::getInstance()->datevals($dates, $uniq);
    }

    /**
     * @param int|float|string|\DateTimeInterface|array $dates
     * @param null|bool                                 $uniq
     *
     * @return \DateTimeInterface[]
     */
    public static function theDatevals($dates, $uniq = null): array
    {
        return static::getInstance()->theDatevals($dates, $uniq);
    }

    /**
     * @param int|float|string|\DateTimeInterface|array $dates
     * @param null|bool                                 $uniq
     *
     * @return \DateTimeImmutable[]
     */
    public static function iDatevals($dates, $uniq = null): array
    {
        return static::getInstance()->iDatevals($dates, $uniq);
    }

    /**
     * @param int|float|string|\DateTimeInterface|array $dates
     * @param null|bool                                 $uniq
     *
     * @return \DateTimeImmutable[]
     */
    public static function theIDatevals($dates, $uniq = null): array
    {
        return static::getInstance()->theIDatevals($dates, $uniq);
    }

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     * @param string|\DateInterval                      $interval
     * @param null|string                               $unit
     *
     * @return \DateTime
     */
    public static function add($date, $interval, $unit = null): \DateTimeInterface
    {
        return static::getInstance()->add($date, $interval, $unit);
    }

    /**
     * @param \DateTime|array $dates
     * @param null|bool       $uniq
     *
     * @return \DateTime[]
     */
    public static function dates($dates, $uniq = null): array
    {
        return static::getInstance()->dates($dates, $uniq);
    }

    /**
     * @param \DateTime|array $dates
     * @param null|bool       $uniq
     *
     * @return \DateTime[]
     */
    public static function theDates($dates, $uniq = null): array
    {
        return static::getInstance()->theDates($dates, $uniq);
    }

    /**
     * @param \DateTimeImmutable|array $dates
     * @param null|bool                $uniq
     *
     * @return \DateTimeImmutable[]
     */
    public static function iDates($dates, $uniq = null): array
    {
        return static::getInstance()->iDates($dates, $uniq);
    }

    /**
     * @param \DateTimeImmutable|array $dates
     * @param null|bool                $uniq
     *
     * @return \DateTimeImmutable[]
     */
    public static function theIDates($dates, $uniq = null): array
    {
        return static::getInstance()->theIDates($dates, $uniq);
    }

    /**
     * @param \DateTimeInterface|array $dates
     * @param null|bool                $uniq
     *
     * @return \DateTimeInterface[]
     */
    public static function datesAll($dates, $uniq = null): array
    {
        return static::getInstance()->datesAll($dates, $uniq);
    }

    /**
     * @param int|float|string|\DateTimeInterface|array $dates
     * @param null|bool                                 $uniq
     *
     * @return \DateTimeInterface[]
     */
    public static function theDatesAll($dates, $uniq = null): array
    {
        return static::getInstance()->theDatesAll($dates, $uniq);
    }

    /**
     * @param int|float|string|\DateTimeInterface|mixed $dateA
     * @param int|float|string|\DateTimeInterface|mixed $dateB
     *
     * @return float
     */
    public static function diff($dateA, $dateB): float
    {
        return static::getInstance()->diff($dateA, $dateB);
    }

    /**
     * @param string      $format
     * @param string      $date
     * @param null|string $timezoneInitial
     *
     * @return \DateTimeImmutable
     */
    public static function iDateParse(string $format, string $date, $timezoneInitial = null): \DateTimeImmutable
    {
        return static::getInstance()->iDateParse($format, $date, $timezoneInitial);
    }

    /**
     * @param string      $format
     * @param string      $date
     * @param null|string $timezoneInitial
     *
     * @return \DateTime
     */
    public static function dateParse(string $format, string $date, $timezoneInitial = null): \DateTime
    {
        return static::getInstance()->dateParse($format, $date, $timezoneInitial);
    }

    /**
     * @param string    $interval
     * @param null|bool $isDst
     * @param null|int  $utcOffset
     *
     * @return \DateTimeZone
     */
    public static function timezoneParse(string $interval, bool $isDst = null, int $utcOffset = null): \DateTimeZone
    {
        return static::getInstance()->timezoneParse($interval, $isDst, $utcOffset);
    }

    /**
     * @param string      $interval
     * @param null|string $unit
     *
     * @return \DateInterval
     */
    public static function intervalParse(string $interval, string $unit = null): \DateInterval
    {
        return static::getInstance()->intervalParse($interval, $unit);
    }

    /**
     * @param null|string|\DateTimeZone $timezone
     *
     * @return \DateTime
     */
    public static function now($timezone = null): \DateTime
    {
        return static::getInstance()->now($timezone);
    }

    /**
     * @param null|string|\DateTimeZone $timezone
     *
     * @return \DateTimeImmutable
     */
    public static function iNow($timezone = null): \DateTimeImmutable
    {
        return static::getInstance()->iNow($timezone);
    }

    /**
     * @param null|string|\DateTimeZone $timezone
     *
     * @return \DateTime
     */
    public static function nowInstant($timezone = null): \DateTime
    {
        return static::getInstance()->nowInstant($timezone);
    }

    /**
     * @param null|string|\DateTimeZone $timezone
     *
     * @return \DateTimeImmutable
     */
    public static function iNowInstant($timezone = null): \DateTimeImmutable
    {
        return static::getInstance()->iNowInstant($timezone);
    }

    /**
     * @param string      $format
     * @param string      $date
     * @param null|string $timezoneInitial
     *
     * @return null|\DateTime
     */
    public static function iDateRead(string $format, string $date, $timezoneInitial = null): ?\DateTimeImmutable
    {
        return static::getInstance()->iDateRead($format, $date, $timezoneInitial);
    }

    /**
     * @param string      $format
     * @param string      $date
     * @param null|string $timezoneInitial
     *
     * @return null|\DateTime
     */
    public static function dateRead(string $format, string $date, $timezoneInitial = null): ?\DateTime
    {
        return static::getInstance()->dateRead($format, $date, $timezoneInitial);
    }

    /**
     * @param int|float|string|\DateTimeZone $timezone
     * @param null|bool                      $isDst
     * @param null|int                       $utcOffset
     *
     * @return null|\DateTimeZone
     */
    public static function timezoneRead($timezone, bool $isDst = null, int $utcOffset = null): ?\DateTimeZone
    {
        return static::getInstance()->timezoneRead($timezone, $isDst, $utcOffset);
    }

    /**
     * @param int|string|\DateInterval $interval
     * @param null|string              $unit
     *
     * @return null|\DateInterval
     */
    public static function intervalRead($interval, string $unit = null): ?\DateInterval
    {
        return static::getInstance()->intervalRead($interval, $unit);
    }

    /**
     * @return ICalendar
     */
    public static function getInstance()
    {
        return static::getInstance()->getInstance();
    }
}
