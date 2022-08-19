<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 * @noinspection RedundantSuppression
 */

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Traits\Load\ArrLoadTrait;
use Gzhegow\Support\Traits\Load\NumLoadTrait;
use Gzhegow\Support\Traits\Load\StrLoadTrait;

interface ICalendar
{
    /**
     * @param null|string|\DateTimeZone $timezone
     *
     * @return XCalendar
     */
    public function withDefaultTimezone($timezone = null);

    /**
     * @return \DateTimeZone
     */
    public function getDefaultTimezone(): \DateTimeZone;

    /**
     * @param int|float|string|\DateTimeInterface|mixed $a
     * @param int|float|string|\DateTimeInterface|mixed $b
     *
     * @return bool
     */
    public function isSame($a, $b): bool;

    /**
     * @param int|float|string|\DateTimeInterface|mixed $a
     * @param int|float|string|\DateTimeInterface|mixed $b
     *
     * @return bool
     */
    public function isBefore($a, $b): bool;

    /**
     * @param int|float|string|\DateTimeInterface|mixed $a
     * @param int|float|string|\DateTimeInterface|mixed $b
     *
     * @return bool
     */
    public function isBeforeOrSame($a, $b): bool;

    /**
     * @param int|float|string|\DateTimeInterface|mixed $a
     * @param int|float|string|\DateTimeInterface|mixed $b
     *
     * @return bool
     */
    public function isAfter($a, $b): bool;

    /**
     * @param int|float|string|\DateTimeInterface|mixed $a
     * @param int|float|string|\DateTimeInterface|mixed $b
     *
     * @return bool
     */
    public function isAfterOrSame($a, $b): bool;

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     * @param int|float|string|\DateTimeInterface|array $dates
     *
     * @return bool
     */
    public function isBetween($date, ...$dates): bool;

    /**
     * @param int[]|float[]|string[]|\DateTimeInterface[] $dates
     * @param int[]|float[]|string[]|\DateTimeInterface[] $datesWith
     *
     * @return bool
     */
    public function isIntersect($dates = [], $datesWith = []): bool;

    /**
     * @param \DateTimeInterface|mixed $date
     *
     * @return null|\DateTimeInterface
     */
    public function filterDateTimeInterface($date): ?\DateTimeInterface;

    /**
     * @param \DateTimeImmutable|mixed $date
     *
     * @return null|\DateTimeImmutable
     */
    public function filterDateTimeImmutable($date): ?\DateTimeImmutable;

    /**
     * @param \DateTime|mixed $date
     *
     * @return null|\DateTime
     */
    public function filterDateTime($date): ?\DateTime;

    /**
     * @param \DateTimeZone|mixed $timezone
     *
     * @return null|\DateTimeZone
     */
    public function filterDateTimeZone($timezone): ?\DateTimeZone;

    /**
     * @param \DateInterval|mixed $interval
     *
     * @return null|\DateInterval
     */
    public function filterDateInterval($interval): ?\DateInterval;

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     *
     * @return null|int|float|string|\DateTimeImmutable
     */
    public function filterIDate($date);

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     *
     * @return null|int|float|string|\DateTime
     */
    public function filterDate($date);

    /**
     * @param string|\DateTimeZone $timezone
     *
     * @return null|string|\DateTimeZone
     */
    public function filterTimezone($timezone);

    /**
     * @param string|\DateInterval $interval
     *
     * @return null|string|\DateInterval
     */
    public function filterInterval($interval);

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     * @param null|\DateTimeZone                        $timezone
     *
     * @return null|\DateTimeImmutable
     */
    public function iDateVal($date, $timezone = null): ?\DateTimeImmutable;

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     * @param null|\DateTimeZone                        $timezone
     *
     * @return null|\DateTime
     */
    public function dateVal($date, $timezone = null): ?\DateTime;

    /**
     * @param int|float|string|\DateTimeZone $timezone
     * @param null|bool                      $isDst
     * @param null|int                       $utcOffset
     *
     * @return null|\DateTimeZone
     */
    public function timezoneVal($timezone, bool $isDst = null, int $utcOffset = null): ?\DateTimeZone;

    /**
     * @param int|string|\DateInterval $interval
     * @param null|string              $unit
     *
     * @return null|\DateInterval
     */
    public function intervalVal($interval, $unit = null): ?\DateInterval;

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     * @param null|\DateTimeZone                        $timezone
     *
     * @return \DateTimeImmutable
     */
    public function theIDateVal($date, $timezone = null): \DateTimeImmutable;

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     * @param null|\DateTimeZone                        $timezone
     *
     * @return \DateTime
     */
    public function theDateVal($date, $timezone = null): \DateTime;

    /**
     * @param string|\DateTimeZone $timezone
     * @param null|bool            $isDst
     * @param null|int             $utcOffset
     *
     * @return \DateTimeZone
     */
    public function theTimezoneVal($timezone, bool $isDst = null, int $utcOffset = null): \DateTimeZone;

    /**
     * @param string|\DateInterval $interval
     * @param null|string          $unit
     *
     * @return \DateInterval
     */
    public function theIntervalVal($interval, string $unit = null): \DateInterval;

    /**
     * @param int|float|string|\DateTimeInterface|array $dates
     * @param null|bool                                 $uniq
     * @param null|bool                                 $recursive
     *
     * @return \DateTimeInterface[]
     */
    public function datevals($dates, bool $uniq = null, bool $recursive = null): array;

    /**
     * @param int|float|string|\DateTimeInterface|array $dates
     * @param null|bool                                 $uniq
     * @param null|bool                                 $recursive
     *
     * @return \DateTimeInterface[]
     */
    public function theDatevals($dates, bool $uniq = null, bool $recursive = null): array;

    /**
     * @param int|float|string|\DateTimeInterface|array $iDates
     * @param null|bool                                 $uniq
     * @param null|bool                                 $recursive
     *
     * @return \DateTimeImmutable[]
     */
    public function iDatevals($iDates, bool $uniq = null, bool $recursive = null): array;

    /**
     * @param int|float|string|\DateTimeInterface|array $iDates
     * @param null|bool                                 $uniq
     * @param null|bool                                 $recursive
     *
     * @return \DateTimeImmutable[]
     */
    public function theIDatevals($iDates, bool $uniq = null, bool $recursive = null): array;

    /**
     * @param \DateTime|array $dateTimeObjects
     * @param null|bool       $uniq
     * @param null|bool       $recursive
     *
     * @return \DateTime[]
     */
    public function dates($dateTimeObjects, bool $uniq = null, bool $recursive = null): array;

    /**
     * @param \DateTime|array $dateTimeObjects
     * @param null|bool       $uniq
     * @param null|bool       $recursive
     *
     * @return \DateTime[]
     */
    public function theDates($dateTimeObjects, bool $uniq = null, bool $recursive = null): array;

    /**
     * @param \DateTimeImmutable|array $dateTimeImmutableObjects
     * @param null|bool                $uniq
     * @param null|bool                $recursive
     *
     * @return \DateTimeImmutable[]
     */
    public function iDates($dateTimeImmutableObjects, bool $uniq = null, bool $recursive = null): array;

    /**
     * @param \DateTimeImmutable|array $dateTimeImmutableObjects
     * @param null|bool                $uniq
     * @param null|bool                $recursive
     *
     * @return \DateTimeImmutable[]
     */
    public function theIDates($dateTimeImmutableObjects, bool $uniq = null, bool $recursive = null): array;

    /**
     * @param \DateTimeInterface|array $dateTimeAllObjects
     * @param null|bool                $uniq
     * @param null|bool                $recursive
     *
     * @return \DateTimeInterface[]
     */
    public function datesAll($dateTimeAllObjects, bool $uniq = null, bool $recursive = null): array;

    /**
     * @param int|float|string|\DateTimeInterface|array $dateTimeAllObjects
     * @param null|bool                                 $uniq
     * @param null|bool                                 $recursive
     *
     * @return \DateTimeInterface[]
     */
    public function theDatesAll($dateTimeAllObjects, bool $uniq = null, bool $recursive = null): array;

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     * @param string|\DateInterval                      $interval
     * @param null|string                               $unit
     *
     * @return \DateTime
     */
    public function dateAdd($date, $interval, $unit = null): \DateTimeInterface;

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     * @param string|\DateInterval                      $interval
     * @param null|string                               $unit
     *
     * @return \DateTime
     */
    public function dateSub($date, $interval, $unit = null): \DateTimeInterface;

    /**
     * @param int|float|string|\DateTimeInterface|mixed $dateA
     * @param int|float|string|\DateTimeInterface|mixed $dateB
     *
     * @return string
     */
    public function diffSeconds($dateA, $dateB): string;

    /**
     * @param string      $format
     * @param string      $date
     * @param null|string $timezoneInitial
     *
     * @return \DateTimeImmutable
     */
    public function iDateParse(string $format, string $date, $timezoneInitial = null): \DateTimeImmutable;

    /**
     * @param string      $format
     * @param string      $date
     * @param null|string $timezoneInitial
     *
     * @return \DateTime
     */
    public function dateParse(string $format, string $date, $timezoneInitial = null): \DateTime;

    /**
     * @param string    $interval
     * @param null|bool $isDst
     * @param null|int  $utcOffset
     *
     * @return \DateTimeZone
     */
    public function timezoneParse(string $interval, bool $isDst = null, int $utcOffset = null): \DateTimeZone;

    /**
     * @param string      $interval
     * @param null|string $unit
     *
     * @return \DateInterval
     */
    public function intervalParse(string $interval, string $unit = null): \DateInterval;

    /**
     * @param null|string|\DateTimeZone $timezone
     *
     * @return \DateTime
     */
    public function now($timezone = null): \DateTime;

    /**
     * @param null|string|\DateTimeZone $timezone
     *
     * @return \DateTimeImmutable
     */
    public function iNow($timezone = null): \DateTimeImmutable;

    /**
     * @param null|string|\DateTimeZone $timezone
     *
     * @return \DateTime
     */
    public function nowInstant($timezone = null): \DateTime;

    /**
     * @param null|string|\DateTimeZone $timezone
     *
     * @return \DateTimeImmutable
     */
    public function iNowInstant($timezone = null): \DateTimeImmutable;

    /**
     * @param string      $format
     * @param string      $date
     * @param null|string $timezoneInitial
     *
     * @return null|\DateTime
     */
    public function iDateRead(string $format, string $date, $timezoneInitial = null): ?\DateTimeImmutable;

    /**
     * @param string      $format
     * @param string      $date
     * @param null|string $timezoneInitial
     *
     * @return null|\DateTime
     */
    public function dateRead(string $format, string $date, $timezoneInitial = null): ?\DateTime;

    /**
     * @param int|float|string|\DateTimeZone $timezone
     * @param null|bool                      $isDst
     * @param null|int                       $utcOffset
     *
     * @return null|\DateTimeZone
     */
    public function timezoneRead($timezone, bool $isDst = null, int $utcOffset = null): ?\DateTimeZone;

    /**
     * @param int|string|\DateInterval $interval
     * @param null|string              $unit
     *
     * @return null|\DateInterval
     */
    public function intervalRead($interval, string $unit = null): ?\DateInterval;
}
