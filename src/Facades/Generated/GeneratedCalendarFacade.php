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
    public static function getTimezone(): \DateTimeZone
    {
        return static::getInstance()->getTimezone();
    }

    /**
     * @return string
     */
    public static function getTimezoneName(): string
    {
        return static::getInstance()->getTimezoneName();
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
     * @param \DateTimeZone $tz
     *
     * @return bool
     */
    public static function isDateTimeZone($tz): bool
    {
        return static::getInstance()->isDateTimeZone($tz);
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
     * @param string|\DateTimeZone $tz
     *
     * @return bool
     */
    public static function isTzval($tz): bool
    {
        return static::getInstance()->isTzval($tz);
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
     * @param int|float|string|\DateTime         $dt
     * @param int[]|float[]|string[]|\DateTime[] $dates
     *
     * @return bool
     */
    public static function isBetween($dt, array $dates = []): bool
    {
        return static::getInstance()->isBetween($dt, $dates);
    }

    /**
     * @param array $dates
     * @param array $datesWith
     *
     * @return bool
     */
    public static function isIntersect(array $dates = [], array $datesWith = []): bool
    {
        return static::getInstance()->isIntersect($dates, $datesWith);
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
     * @param \DateTimeZone $tz
     *
     * @return null|\DateTimeZone
     */
    public static function filterDateTimeZone($tz): ?\DateTimeZone
    {
        return static::getInstance()->filterDateTimeZone($tz);
    }

    /**
     * @param int|float|string|\DateTime $date
     * @param null|string                $format
     * @param \DateTimeZone|null         $tz
     *
     * @return null|int|float|string|\DateTime
     */
    public static function filterDateval($date, $format = null, $tz = null)
    {
        return static::getInstance()->filterDateval($date, $format, $tz);
    }

    /**
     * @param string|\DateTimeZone $tz
     *
     * @return null|string|\DateTimeZone
     */
    public static function filterTzval($tz)
    {
        return static::getInstance()->filterTzval($tz);
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
     * @param \DateTimeZone $tz
     *
     * @return \DateTimeZone
     */
    public static function assertDateTimeZone($tz): \DateTimeZone
    {
        return static::getInstance()->assertDateTimeZone($tz);
    }

    /**
     * @param int|float|string|\DateTime $date
     * @param null|string                $format
     * @param string|\DateTimeZone|null  $tz
     *
     * @return int|float|string|\DateTime
     */
    public static function assertDateval($date, $format = null, $tz = null): \DateTime
    {
        return static::getInstance()->assertDateval($date, $format, $tz);
    }

    /**
     * @param string|\DateTimeZone $tz
     *
     * @return string|\DateTimeZone
     */
    public static function assertTzval($tz): \DateTimeZone
    {
        return static::getInstance()->assertTzval($tz);
    }

    /**
     * @param string|\DateTimeZone $tz
     *
     * @return Calendar
     */
    public static function setTimezone($tz)
    {
        return static::getInstance()->setTimezone($tz);
    }

    /**
     * @param int|float|string|\DateTime $date
     * @param null|string                $format
     * @param \DateTimeZone|null         $tz
     *
     * @return null|\DateTime
     */
    public static function dateval($date, $format = null, $tz = null): ?\DateTime
    {
        return static::getInstance()->dateval($date, $format, $tz);
    }

    /**
     * @param string|\DateTimeZone $tz
     *
     * @return null|\DateTimeZone
     */
    public static function tzval($tz): ?\DateTimeZone
    {
        return static::getInstance()->tzval($tz);
    }

    /**
     * @param int|float|string|\DateTime $date
     * @param string|null                $format
     * @param \DateTimeZone|null         $tz
     *
     * @return \DateTime
     */
    public static function date($date, $format = null, $tz = null): \DateTime
    {
        return static::getInstance()->date($date, $format, $tz);
    }

    /**
     * @param \DateTimeZone|null $tz
     *
     * @return \DateTimeZone
     */
    public static function timezone($tz): \DateTimeZone
    {
        return static::getInstance()->timezone($tz);
    }

    /**
     * @param \DateTimeZone|null $tz
     *
     * @return \DateTime
     */
    public static function now($tz = null): \DateTime
    {
        return static::getInstance()->now($tz);
    }

    /**
     * @param \DateTimeZone|null $tz
     *
     * @return \DateTime
     */
    public static function today($tz = null): \DateTime
    {
        return static::getInstance()->today($tz);
    }

    /**
     * @param int|float|string|\DateTime $a
     * @param int|float|string|\DateTime $b
     *
     * @return float
     */
    public static function diff($a, $b): float
    {
        return static::getInstance()->diff($a, $b);
    }

    /**
     * @param int|float|string|\DateTime $date
     * @param string|null                $format
     * @param \DateTimeZone|null         $tz
     *
     * @return \DateTime
     */
    public static function parse($date, $format = null, $tz = null): ?\DateTime
    {
        return static::getInstance()->parse($date, $format, $tz);
    }

    /**
     * @param int|float|string|\DateTime $date
     *
     * @return \DateTimeZone
     */
    public static function parseTimezone($date): \DateTimeZone
    {
        return static::getInstance()->parseTimezone($date);
    }

    /**
     * @return Calendar
     */
    abstract public static function getInstance(): Calendar;
}
