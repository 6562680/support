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

    const THE_FORMAT_LIST = [
        self::FORMAT_SQL_DATE     => true,
        self::FORMAT_SQL_DATETIME => true,
        self::FORMAT_SQL_TIME     => true,
    ];


    /**
     * @var Filter
     */
    protected $filter;


    /**
     * @var \DateTime
     */
    protected $today;

    /**
     * @var \DateTimeZone
     */
    protected $timezone;


    /**
     * Constructor
     *
     * @param Filter $filter
     */
    public function __construct(
        Filter $filter
    )
    {
        $this->filter = $filter;

        $this->timezone = new \DateTimeZone('UTC');
    }


    /**
     * @return \DateTimeZone
     */
    public function getTimezone() : \DateTimeZone
    {
        return $this->timezone;
    }

    /**
     * @return string
     */
    public function getTimezoneName() : string
    {
        return $this->timezone->getName();
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
     * @param \DateTimeZone $tz
     *
     * @return bool
     */
    public function isDateTimeZone($tz) : bool
    {
        return null !== $this->filterDateTimeZone($tz);
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
     * @param string|\DateTimeZone $tz
     *
     * @return bool
     */
    public function isTzval($tz) : bool
    {
        return null !== $this->filterTzval($tz);
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

        $parsedA = $this->parse($a);
        $parsedB = $this->parse($b);

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
        $parsedA = $this->parse($a);
        $parsedB = $this->parse($b);

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

        $parsedA = $this->parse($a);
        $parsedB = $this->parse($b);

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
        $parsedA = $this->parse($a);
        $parsedB = $this->parse($b);

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

        $parsedA = $this->parse($a);
        $parsedB = $this->parse($b);

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
     * @param \DateTimeZone $tz
     *
     * @return null|\DateTimeZone
     */
    public function filterDateTimeZone($tz) : ?\DateTimeZone
    {
        $result = is_object($tz) && is_a($tz, \DateTimeZone::class)
            ? $tz
            : null;

        return $result;
    }


    /**
     * @param int|float|string|\DateTime $date
     * @param null|string                $format
     * @param \DateTimeZone|null         $tz
     *
     * @return null|int|float|string|\DateTime
     */
    public function filterDateval($date, $format = null, $tz = null) // : ?int|float|string|\DateTime
    {
        if (null === $this->dateval($date, $format, $tz)) {
            return null;
        }

        return $date;
    }

    /**
     * @param string|\DateTimeZone $tz
     *
     * @return null|string|\DateTimeZone
     */
    public function filterTzval($tz) // : ?string|\DateTimeZone
    {
        if (null === $this->tzval($tz)) {
            return null;
        }

        return $tz;
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
     * @param \DateTimeZone $tz
     *
     * @return \DateTimeZone
     */
    public function assertDateTimeZone($tz) : \DateTimeZone
    {
        if (null === ( $filtered = $this->filterDateTimeZone($tz) )) {
            throw new InvalidArgumentException([ 'Invalid DateTimeZone passed: %s', $tz ]);
        }

        return $filtered;
    }


    /**
     * @param int|float|string|\DateTime $date
     * @param null|string                $format
     * @param string|\DateTimeZone|null  $tz
     *
     * @return int|float|string|\DateTime
     */
    public function assertDateval($date, $format = null, $tz = null) : \DateTime
    {
        if (null === ( $filtered = $this->filterDateval($date, $format, $tz) )) {
            throw new InvalidArgumentException([ 'Invalid Dateval passed: %s', $date ]);
        }

        return $filtered;
    }

    /**
     * @param string|\DateTimeZone $tz
     *
     * @return string|\DateTimeZone
     */
    public function assertTzval($tz) : \DateTimeZone
    {
        if (null === ( $filtered = $this->filterTzval($tz) )) {
            throw new InvalidArgumentException([ 'Invalid Tzval passed: %s', $tz ]);
        }

        return $filtered;
    }


    /**
     * @param string|\DateTimeZone $tz
     *
     * @return static
     */
    public function setTimezone($tz)
    {
        $this->timezone = $this->timezone($tz);

        return $this;
    }


    /**
     * @param int|float|string|\DateTime $date
     * @param null|string                $format
     * @param \DateTimeZone|null         $tz
     *
     * @return null|\DateTime
     */
    public function dateval($date, $format = null, $tz = null) : ?\DateTime
    {
        $result = $this->parse($date, $format, $tz);

        return $result;
    }

    /**
     * @param string|\DateTimeZone $tz
     *
     * @return null|\DateTimeZone
     */
    public function tzval($tz) : ?\DateTimeZone
    {
        $result = null;

        if (is_string($tz)) {
            $result = timezone_open($tz);

        } elseif (null !== ( $dateTimeZone = $this->filterDateTimeZone($tz) )) {
            $result = $dateTimeZone;
        }

        return $result;
    }


    /**
     * @param int|float|string|\DateTime $date
     * @param string|null                $format
     * @param \DateTimeZone|null         $tz
     *
     * @return \DateTime
     */
    public function date($date, $format = null, $tz = null) : \DateTime
    {
        $result = $this->dateval($date, $format, $tz);

        if (null === $result) {
            throw new InvalidArgumentException([ 'Invalid Date passed: %s', $date ]);
        }

        return $result;
    }

    /**
     * @param \DateTimeZone|null $tz
     *
     * @return \DateTimeZone
     */
    public function timezone($tz) : \DateTimeZone
    {
        $result = $this->tzval($tz);

        if (null === $result) {
            throw new InvalidArgumentException([ 'Invalid TimeZone passed: %s', $tz ]);
        }

        return $result;
    }


    /**
     * @param \DateTimeZone|null $tz
     *
     * @return \DateTime
     */
    public function now($tz = null) : \DateTime
    {
        $tz = $tz
            ?? $this->getTimezone();

        $now = null;
        try {
            $now = new \DateTime('now', $tz);
        }
        catch ( \Throwable $e ) {
            // never thrown
        }

        return $now;
    }

    /**
     * @param \DateTimeZone|null $tz
     *
     * @return \DateTime
     */
    public function today($tz = null) : \DateTime
    {
        $tz = $tz
            ?? $this->getTimezone();

        if (! isset($this->today)) {
            try {
                $this->today = new \DateTime('now', $tz);
            }
            catch ( \Throwable $e ) {
                // never thrown
            }
        }

        $today = clone $this->today;

        $today->setTimezone($tz);

        return $today;
    }


    /**
     * @param int|float|string|\DateTime $a
     * @param int|float|string|\DateTime $b
     *
     * @return float
     */
    public function diff($a, $b) : float
    {
        $dateA = $this->date($a);
        $dateB = $this->date($b);

        $diff = (float) $dateA->format('U.u') - (float) $dateB->format('U.u');

        return $diff;
    }


    /**
     * @param int|float|string|\DateTime $date
     * @param string|null                $format
     * @param \DateTimeZone|null         $tz
     *
     * @return \DateTime
     */
    public function parse($date, $format = null, $tz = null) : ?\DateTime
    {
        if (null !== $format) {
            $this->filter->assert()->assertStrval($format);

            $format = strval($format);
        }

        $tz = ( null !== $tz )
            ? $this->timezone($tz)
            : null;

        return null
            ?? $this->tryParseDateFromInstance($date, $tz)
            ?? $this->tryParseDateFromInt($date, $tz)
            ?? $this->tryParseDateFromFloat($date, $tz)
            ?? $this->tryParseDateFromString($date, $format, $tz);
    }

    /**
     * @param int|float|string|\DateTime $date
     *
     * @return \DateTimeZone
     */
    public function parseTimezone($date) : \DateTimeZone
    {
        $result = $this->date($date)->getTimezone();

        return $result;
    }


    /**
     * @param \DateTime          $instance
     * @param null|\DateTimeZone $tz
     *
     * @return \DateTime
     */
    protected function tryParseDateFromInstance($instance, \DateTimeZone $tz = null) : ?\DateTime
    {
        if (! is_object($instance)) return null;
        if (! is_a($instance, \DateTime::class)) return null;

        if ($tz) {
            $instance->setTimezone($tz);
        }

        return $instance;
    }

    /**
     * @param int                $int
     * @param \DateTimeZone|null $tz
     *
     * @return null|\DateTime
     */
    protected function tryParseDateFromInt($int, \DateTimeZone $tz = null) : ?\DateTime
    {
        if (! is_int($int)) {
            return null;
        }

        try {
            $dt = $this->now($tz);
            $dt = $dt->setTimestamp($int);

            $dt->setTime(
                (int) $dt->format('G'), // 0-23 -> int -> 0-23
                (int) $dt->format('i'), // 00-59 -> int -> 0-59
                (int) $dt->format('s'), // 00-59 -> int -> 0-59
                0
            );

            if (false === $dt) {
                return null;
            }
        }
        catch ( \Throwable $e ) {
            dd($e);

            return null;
        }

        return $dt;
    }

    /**
     * @param float              $float
     * @param \DateTimeZone|null $tz
     *
     * @return null|\DateTime
     */
    protected function tryParseDateFromFloat($float, \DateTimeZone $tz = null) : ?\DateTime
    {
        if (! is_float($float)) {
            return null;
        }

        [ $int, $microseconds ] = explode('.', sprintf('%f', $float)) + [ null, null ];

        $microseconds = str_pad(substr($microseconds, 0, 6), 6, '0');

        try {
            $dt = $this->now($tz);
            $dt = $dt->setTimestamp($int);
            $dt->setTime(
                (int) $dt->format('G'), // 0-23 -> int -> 0-23
                (int) $dt->format('i'), // 00-59 -> int -> 0-59
                (int) $dt->format('s'), // 00-59 -> int -> 0-59
                $microseconds
            );

            if (false === $dt) {
                return null;
            }
        }
        catch ( \Throwable $e ) {
            return null;
        }

        return $dt;
    }

    /**
     * @param string             $string
     * @param string|null        $format
     * @param \DateTimeZone|null $tz
     *
     * @return null|\DateTime
     */
    protected function tryParseDateFromString($string, string $format = null, \DateTimeZone $tz = null) : ?\DateTime
    {
        if (! is_string($string)) return null;
        if ('' === $string) return null;

        if (is_numeric($string)) {
            if (false !== ( $int = filter_var($string, FILTER_VALIDATE_INT) )) {
                return $this->tryParseDateFromInt($int, $tz);
            }

            if (false !== ( $float = filter_var($string, FILTER_VALIDATE_FLOAT) )) {
                return $this->tryParseDateFromFloat($float, $tz);
            }
        }

        $tz = $tz ?? $this->getTimezoneName();

        // try to parse using certain format
        if (null !== $format) {
            try {
                if (false !== ( $dt = \DateTime::createFromFormat($format, $string, $tz) )) {
                    return $dt; // ! return
                }
            }
            catch ( \Throwable $e ) {
                // never thrown
            }

            return null;
        }

        // try to create date from '+1 days'
        try {
            $nowTimestamp = $this->now($tz)->getTimestamp();

            $isValid = ( false !== ( $int = strtotime($string, $nowTimestamp) ) );
            if ($isValid) {
                $dt1 = ( new \DateTime('1970-01-01T00:00:00Z') )->modify($string);
                $dt2 = ( new \DateTime('1971-12-25T00:00:00Z') )->modify($string);

                if ($isRelativeDateString = ( $dt1 != $dt2 )) {
                    $dt = $this->tryParseDateFromInt($int);

                    return $dt; // ! return
                }
            }
        }
        catch ( \Throwable $e ) {
            // never thrown
        }

        // try to parse without timezone
        foreach ( static::$formatsNoTimezone as $format => $enabled ) {
            try {
                if (false !== ( $dt = \DateTime::createFromFormat($format, $string, $tz) )) {
                    return $dt; // ! return
                }
            }
            catch ( \Throwable $e ) {
                // never thrown
            }
        }

        // try to parse with timezone
        try {
            if ($dt = new \DateTime($string, $this->parseTimezone($string))) {
                return $dt; // ! return
            }
        }
        catch ( \Throwable $e ) {
            // never thrown
        }

        return null;
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
