<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support\Facades\Generated;

use Gzhegow\Support\Calendar;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;

abstract class GeneratedCalendarFacade
{
    /**
     * @return \DateTimeZone
     */
    public static function getDefaultTimezone(): \DateTimeZone
    {
        return static::getInstance()->getDefaultTimezone();
    }

    /**
     * @param int|float|string|\DateTime $a
     * @param int|float|string|\DateTime $b
     *
     * @return bool
     */
    public static function isSame($a, $b): bool
    {
        return static::getInstance()->isSame($a, $b);
    }

    /**
     * @param int|float|string|\DateTime $a
     * @param int|float|string|\DateTime $b
     *
     * @return bool
     */
    public static function isBefore($a, $b): bool
    {
        return static::getInstance()->isBefore($a, $b);
    }

    /**
     * @param int|float|string|\DateTime $a
     * @param int|float|string|\DateTime $b
     *
     * @return bool
     */
    public static function isBeforeOrSame($a, $b): bool
    {
        return static::getInstance()->isBeforeOrSame($a, $b);
    }

    /**
     * @param int|float|string|\DateTime $a
     * @param int|float|string|\DateTime $b
     *
     * @return bool
     */
    public static function isAfter($a, $b): bool
    {
        return static::getInstance()->isAfter($a, $b);
    }

    /**
     * @param int|float|string|\DateTime $a
     * @param int|float|string|\DateTime $b
     *
     * @return bool
     */
    public static function isAfterOrSame($a, $b): bool
    {
        return static::getInstance()->isAfterOrSame($a, $b);
    }

    /**
     * @param int|float|string|\DateTime         $date
     * @param int[]|float[]|string[]|\DateTime[] $dates
     *
     * @return bool
     */
    public static function isBetween($date, ...$dates): bool
    {
        return static::getInstance()->isBetween($date, ...$dates);
    }

    /**
     * @param int[]|float[]|string[]|\DateTime[] $dates
     * @param int[]|float[]|string[]|\DateTime[] $datesWith
     *
     * @return bool
     */
    public static function isIntersect($dates = [], $datesWith = []): bool
    {
        return static::getInstance()->isIntersect($dates, $datesWith);
    }

    /**
     * @param int|float|string|\DateTime $date
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
     * @param int|float|string|\DateTime $date
     *
     * @return bool
     */
    public static function isDateval($date): bool
    {
        return static::getInstance()->isDateval($date);
    }

    /**
     * @param string|\DateTimeZone $timezone
     *
     * @return bool
     */
    public static function isTimezoneval($timezone): bool
    {
        return static::getInstance()->isTimezoneval($timezone);
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
     * @param \DateTime $date
     *
     * @return null|\DateTime
     */
    public static function filterDateTime($date): ?\DateTime
    {
        return static::getInstance()->filterDateTime($date);
    }

    /**
     * @param \DateTimeZone $timezone
     *
     * @return null|\DateTimeZone
     */
    public static function filterDateTimeZone($timezone): ?\DateTimeZone
    {
        return static::getInstance()->filterDateTimeZone($timezone);
    }

    /**
     * @param \DateInterval $interval
     *
     * @return null|\DateInterval
     */
    public static function filterDateInterval($interval): ?\DateInterval
    {
        return static::getInstance()->filterDateInterval($interval);
    }

    /**
     * @param int|float|string|\DateTime $date
     * @param null|\DateTimeZone         $timezone
     *
     * @return null|int|float|string|\DateTime
     */
    public static function filterDateval($date, $timezone = null)
    {
        return static::getInstance()->filterDateval($date, $timezone);
    }

    /**
     * @param string|\DateTimeZone $timezone
     *
     * @return null|string|\DateTimeZone
     */
    public static function filterTimezoneval($timezone)
    {
        return static::getInstance()->filterTimezoneval($timezone);
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
     * @param \DateTime $date
     *
     * @return \DateTime
     */
    public static function assertDateTime($date): \DateTime
    {
        return static::getInstance()->assertDateTime($date);
    }

    /**
     * @param \DateTimeZone $timezone
     *
     * @return \DateTimeZone
     */
    public static function assertDateTimeZone($timezone): \DateTimeZone
    {
        return static::getInstance()->assertDateTimeZone($timezone);
    }

    /**
     * @param \DateInterval $interval
     *
     * @return \DateInterval
     */
    public static function assertDateInterval($interval): \DateInterval
    {
        return static::getInstance()->assertDateInterval($interval);
    }

    /**
     * @param int|float|string|\DateTime $date
     * @param null|string|\DateTimeZone  $timezone
     *
     * @return int|float|string|\DateTime
     */
    public static function assertDateval($date, $timezone = null): \DateTime
    {
        return static::getInstance()->assertDateval($date, $timezone);
    }

    /**
     * @param string|\DateTimeZone $timezone
     *
     * @return string|\DateTimeZone
     */
    public static function assertTimezoneval($timezone): \DateTimeZone
    {
        return static::getInstance()->assertTimezoneval($timezone);
    }

    /**
     * @param string|\DateInterval $interval
     *
     * @return string|\DateInterval
     */
    public static function assertInterval($interval): \DateInterval
    {
        return static::getInstance()->assertInterval($interval);
    }

    /**
     * @param string|\DateTimeZone $timezone
     *
     * @return Calendar
     */
    public static function setDefaultTimezone($timezone)
    {
        return static::getInstance()->setDefaultTimezone($timezone);
    }

    /**
     * @param int|float|string|\DateTime $date
     * @param string|\DateInterval       $interval
     * @param null|string                $unit
     *
     * @return \DateTime
     */
    public static function add($date, $interval, $unit = null): \DateTime
    {
        return static::getInstance()->add($date, $interval, $unit);
    }

    /**
     * @param int|float|string|\DateTime $dateA
     * @param int|float|string|\DateTime $dateB
     *
     * @return float
     */
    public static function diff($dateA, $dateB): float
    {
        return static::getInstance()->diff($dateA, $dateB);
    }

    /**
     * @param int|float|string|\DateTime $date
     * @param null|\DateTimeZone         $timezone
     *
     * @return null|\DateTime
     */
    public static function dateval($date, $timezone = null): ?\DateTime
    {
        return static::getInstance()->dateval($date, $timezone);
    }

    /**
     * @param int|float|string|\DateTimeZone $timezone
     * @param null|bool                      $isDst
     * @param null|int                       $utcOffset
     *
     * @return null|\DateTimeZone
     */
    public static function timezoneval($timezone, bool $isDst = null, int $utcOffset = null): ?\DateTimeZone
    {
        return static::getInstance()->timezoneval($timezone, $isDst, $utcOffset);
    }

    /**
     * @param int|string|\DateInterval $interval
     * @param null|string              $unit
     *
     * @return null|\DateInterval
     */
    public static function interval($interval, $unit = null): ?\DateInterval
    {
        return static::getInstance()->interval($interval, $unit);
    }

    /**
     * @param int|float|string|\DateTime $date
     * @param null|\DateTimeZone         $timezone
     *
     * @return \DateTime
     */
    public static function theDate($date, $timezone = null): \DateTime
    {
        return static::getInstance()->theDate($date, $timezone);
    }

    /**
     * @param string|\DateTimeZone $timezone
     * @param null|bool            $isDst
     * @param null|int             $utcOffset
     *
     * @return \DateTimeZone
     */
    public static function theTimezone($timezone, bool $isDst = null, int $utcOffset = null): \DateTimeZone
    {
        return static::getInstance()->theTimezone($timezone, $isDst, $utcOffset);
    }

    /**
     * @param string|\DateInterval $interval
     * @param null|string          $unit
     *
     * @return \DateInterval
     */
    public static function theInterval($interval, string $unit = null): \DateInterval
    {
        return static::getInstance()->theInterval($interval, $unit);
    }

    /**
     * @param string      $format
     * @param string      $date
     * @param null|string $instantTimezone
     *
     * @return \DateTime
     */
    public static function dateParse(string $format, string $date, $instantTimezone = null): \DateTime
    {
        return static::getInstance()->dateParse($format, $date, $instantTimezone);
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
     * @return \DateTime
     */
    public static function today($timezone = null): \DateTime
    {
        return static::getInstance()->today($timezone);
    }

    /**
     * @param string      $format
     * @param string      $date
     * @param null|string $instantTimezone
     *
     * @return null|\DateTime
     */
    public static function parseDateval(string $format, string $date, $instantTimezone = null): ?\DateTime
    {
        return static::getInstance()->parseDateval($format, $date, $instantTimezone);
    }

    /**
     * @param int|float|string|\DateTimeZone $timezone
     * @param null|bool                      $isDst
     * @param null|int                       $utcOffset
     *
     * @return null|\DateTimeZone
     */
    public static function parseTimezoneval($timezone, bool $isDst = null, int $utcOffset = null): ?\DateTimeZone
    {
        return static::getInstance()->parseTimezoneval($timezone, $isDst, $utcOffset);
    }

    /**
     * @param int|string|\DateInterval $interval
     * @param null|string              $unit
     *
     * @return null|\DateInterval
     */
    public static function parseInterval($interval, string $unit = null): ?\DateInterval
    {
        return static::getInstance()->parseInterval($interval, $unit);
    }

    /**
     * @param int|float|string|\DateTime|array $dates
     * @param null|bool                        $uniq
     * @param null|string|array                $message
     * @param mixed                            ...$arguments
     *
     * @return string[]
     */
    public static function datevals($dates, $uniq = null, $message = null, ...$arguments): array
    {
        return static::getInstance()->datevals($dates, $uniq, $message, ...$arguments);
    }

    /**
     * @param int|float|string|\DateTime|array $dates
     * @param null|bool                        $uniq
     * @param null|string|array                $message
     * @param mixed                            ...$arguments
     *
     * @return string[]
     */
    public static function theDatevals($dates, $uniq = null, $message = null, ...$arguments): array
    {
        return static::getInstance()->theDatevals($dates, $uniq, $message, ...$arguments);
    }

    /**
     * @param int|float|string|\DateTime|array $dates
     * @param null|bool                        $uniq
     *
     * @return string[]
     */
    public static function datevalsSkip($dates, $uniq = null): array
    {
        return static::getInstance()->datevalsSkip($dates, $uniq);
    }

    /**
     * @param int|float|string|\DateTime|array $dates
     * @param null|bool                        $uniq
     *
     * @return string[]
     */
    public static function theDatevalsSkip($dates, $uniq = null): array
    {
        return static::getInstance()->theDatevalsSkip($dates, $uniq);
    }

    /**
     * @return Calendar
     */
    abstract public static function getInstance(): Calendar;
}
