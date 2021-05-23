<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpDocMissingThrowsInspection
 */

namespace Gzhegow\Support\Facades\Generated;

use Gzhegow\Support\Calendar;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;

abstract class GeneratedCalendarFacade
{
    /**
     * @return string
     */
    public static function getTimezoneName(): string
    {
        return static::getInstance()->getTimezoneName();
    }

    /**
     * @return \DateTimeZone
     */
    public static function getTimezone(): \DateTimeZone
    {
        return static::getInstance()->getTimezone();
    }

    /**
     * @param mixed $date
     *
     * @return bool
     */
    public static function isDate($date): bool
    {
        return static::getInstance()->isDate($date);
    }

    /**
     * @param mixed              $date
     * @param \DateTimeZone|null $tz
     *
     * @return bool
     */
    public static function isDateable($date, \DateTimeZone $tz = null): bool
    {
        return static::getInstance()->isDateable($date, $tz);
    }

    /**
     * @param mixed $a
     * @param mixed $b
     *
     * @return bool
     */
    public static function isSame($a, $b): bool
    {
        return static::getInstance()->isSame($a, $b);
    }

    /**
     * @param mixed $a
     * @param mixed $b
     *
     * @return bool
     */
    public static function isBefore($a, $b): bool
    {
        return static::getInstance()->isBefore($a, $b);
    }

    /**
     * @param mixed $a
     * @param mixed $b
     *
     * @return bool
     */
    public static function isBeforeOrSame($a, $b): bool
    {
        return static::getInstance()->isBeforeOrSame($a, $b);
    }

    /**
     * @param mixed $a
     * @param mixed $b
     *
     * @return bool
     */
    public static function isAfter($a, $b): bool
    {
        return static::getInstance()->isAfter($a, $b);
    }

    /**
     * @param mixed $a
     * @param mixed $b
     *
     * @return bool
     */
    public static function isAfterOrSame($a, $b): bool
    {
        return static::getInstance()->isAfterOrSame($a, $b);
    }

    /**
     * @param mixed $dt
     * @param array $dates
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
     * @param mixed              $date
     * @param \DateTimeZone|null $tz
     *
     * @return null|\DateTime
     */
    public static function detectDate($date, \DateTimeZone $tz = null): ?\DateTime
    {
        return static::getInstance()->detectDate($date, $tz);
    }

    /**
     * @param mixed $timezone
     *
     * @return static
     */
    public static function setTimezone($timezone)
    {
        return static::getInstance()->setTimezone($timezone);
    }

    /**
     * @param mixed              $date
     * @param null|string        $format
     * @param \DateTimeZone|null $tz
     *
     * @return \DateTime
     */
    public static function date($date, string $format = null, \DateTimeZone $tz = null): \DateTime
    {
        return static::getInstance()->date($date, $format, $tz);
    }

    /**
     * @param \DateTimeZone|null $tz
     *
     * @return \DateTime
     */
    public static function now(\DateTimeZone $tz = null): \DateTime
    {
        return static::getInstance()->now($tz);
    }

    /**
     * @param \DateTimeZone|null $tz
     *
     * @return \DateTime
     */
    public static function today(\DateTimeZone $tz = null): \DateTime
    {
        return static::getInstance()->today($tz);
    }

    /**
     * @param mixed $a
     * @param mixed $b
     *
     * @return float
     */
    public static function diff(\DateTime $a, \DateTime $b): float
    {
        return static::getInstance()->diff($a, $b);
    }

    /**
     * @param mixed              $date
     * @param null|string        $format
     * @param \DateTimeZone|null $tz
     *
     * @return \DateTime
     */
    public static function parse($date, string $format = null, \DateTimeZone $tz = null): ?\DateTime
    {
        return static::getInstance()->parse($date, $format, $tz);
    }

    /**
     * @return Calendar
     */
    abstract public static function getInstance(): Calendar;
}
