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
     * @var string
     */
    protected $timezoneName = 'UTC';


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
    }


    /**
     * @return string
     */
    public function getTimezoneName() : string
    {
        return $this->timezoneName;
    }

    /**
     * @return \DateTimeZone
     */
    public function getTimezone() : \DateTimeZone
    {
        return new \DateTimeZone($this->timezoneName);
    }


    /**
     * @param mixed $date
     *
     * @return bool
     */
    public function isDate($date) : bool
    {
        return is_object($date)
            && is_a($date, \DateTime::class);
    }

    /**
     * @param mixed              $date
     * @param \DateTimeZone|null $tz
     *
     * @return bool
     */
    public function isDateable($date, \DateTimeZone $tz = null) : bool
    {
        return null !== $this->detectDate($date, $tz);
    }


    /**
     * @param mixed $a
     * @param mixed $b
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
     * @param mixed $a
     * @param mixed $b
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
     * @param mixed $a
     * @param mixed $b
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
     * @param mixed $a
     * @param mixed $b
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
     * @param mixed $a
     * @param mixed $b
     *
     * @return bool
     */
    public function isAfterOrSame($a, $b) : bool
    {
        if ($a === $b) return true;

        $parsedA = $this->parse($a);
        $parsedB = $this->parse($b);

        $isDateA = $this->isDate($parsedA);
        $isDateB = $this->isDate($parsedB);

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
     * @param mixed $dt
     * @param array $dates
     *
     * @return bool
     */
    public function isBetween($dt, array $dates = []) : bool
    {
        $list = array_filter(
            array_map($dates,
                [ $this, 'parse' ]
            ),
            [ $this, 'isDate' ]
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
            [ $this, 'isDate' ]
        );
        $listWith = array_filter(
            array_map($dates,
                [ $this, 'parse' ]
            ),
            [ $this, 'isDate' ]
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
     * @param mixed              $date
     * @param \DateTimeZone|null $tz
     *
     * @return null|\DateTime
     */
    public function detectDate($date, \DateTimeZone $tz = null) : ?\DateTime
    {
        if (is_object($date) && is_a($date, \DateTime::class)) {
            return $date;
        }

        if (null !== ( $int = $this->filter->filterInt($date) )) {
            return $this->createDateFromInt($int, $tz);
        }

        if (null !== ( $float = $this->filter->filterFloat($date) )) {
            return $this->createDateFromFloat($float, $tz);
        }

        if (is_string($date) && ( '' !== $date )) {
            try {
                return $this->createDateFromString($date, $tz);
            }
            catch ( \Throwable $e ) {
                return null;
            }
        }

        return null;
    }


    /**
     * @param mixed $timezone
     *
     * @return static
     */
    public function setTimezone($timezone)
    {
        $tz = false;
        if (is_string($timezone)) {
            $tz = timezone_open($timezone);

        } elseif (is_object($timezone) && is_a($timezone, \DateTimeZone::class)) {
            $tz = $timezone;

        }

        if (false === $tz) {
            throw new InvalidArgumentException('Invalid timezone passed', $tz);
        }

        $this->timezoneName = $tz->getName();

        return $this;
    }


    /**
     * @param mixed              $date
     * @param null|string        $format
     * @param \DateTimeZone|null $tz
     *
     * @return \DateTime
     */
    public function date($date, string $format = null, \DateTimeZone $tz = null) : \DateTime
    {
        $result = $this->parse($date, $format, $tz);

        if (! $result) {
            throw new \InvalidArgumentException('Invalid date passed: ' . gettype($date));
        }

        return $result;
    }


    /**
     * @param \DateTimeZone|null $tz
     *
     * @return \DateTime
     */
    public function now(\DateTimeZone $tz = null) : \DateTime
    {
        $tz = $tz ?? $this->getTimezone();

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
    public function today(\DateTimeZone $tz = null) : \DateTime
    {
        $tz = $tz ?? $this->getTimezone();

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
     * @param mixed $a
     * @param mixed $b
     *
     * @return float
     */
    public function diff(\DateTime $a, \DateTime $b) : float
    {
        $diff = (float) $a->format('U.u') - (float) $b->format('U.u');

        return $diff;
    }


    /**
     * @param mixed              $date
     * @param null|string        $format
     * @param \DateTimeZone|null $tz
     *
     * @return \DateTime
     */
    public function parse($date, string $format = null, \DateTimeZone $tz = null) : ?\DateTime
    {
        return null
            ?? $this->createDateFromInstance($date)
            ?? $this->createDateFromInt($date, $tz)
            ?? $this->createDateFromFloat($date, $tz)
            ?? $this->createDateFromString($date, $format, $tz);
    }

    /**
     * @param string $date
     *
     * @return \DateTimeZone
     */
    protected function parseTimezone(string $date) : \DateTimeZone
    {
        foreach ( static::$formatsTimezone as $format => $bool ) {
            try {
                if (false !== ( $dt = \DateTime::createFromFormat($format, $date) )) {
                    return $dt->getTimezone();
                }
            }
            catch ( \Throwable $e ) {
            }
        }

        $result = $this->getTimezone();

        return $result;
    }


    /**
     * @param $instance
     *
     * @return \DateTime
     */
    protected function createDateFromInstance($instance) : ?\DateTime
    {
        if (! is_object($instance)) return null;
        if (! is_a($instance, \DateTime::class)) return null;

        return $instance;
    }

    /**
     * @param                    $int
     * @param \DateTimeZone|null $tz
     *
     * @return null|\DateTime
     */
    protected function createDateFromInt($int, \DateTimeZone $tz = null) : ?\DateTime
    {
        if (! is_int($int)) return null;

        try {
            $dt = $this->now($tz);
            $dt = $dt->setTimestamp($int);
            $dt->setTime(
                (int) $dt->format('G'), // 0-23 -> int -> 0-23
                (int) $dt->format('i'), // 00-59 -> int -> 0-59
                (int) $dt->format('s'), // 00-59 -> int -> 0-59
                0
            );

            if (false === $dt) return null;
        }
        catch ( \Throwable $e ) {
            return null;
        }

        return $dt;
    }

    /**
     * @param                    $float
     * @param \DateTimeZone|null $tz
     *
     * @return null|\DateTime
     */
    protected function createDateFromFloat($float, \DateTimeZone $tz = null) : ?\DateTime
    {
        if (! is_float($float)) return null;

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

            if (false === $dt) return null;
        }
        catch ( \Throwable $e ) {
            return null;
        }

        return $dt;
    }

    /**
     * @param string             $string
     * @param null|string        $format
     * @param \DateTimeZone|null $tz
     *
     * @return null|\DateTime
     */
    protected function createDateFromString($string, string $format = null, \DateTimeZone $tz = null) : ?\DateTime
    {
        if (! is_string($string)) return null;
        if ('' === $string) return null;

        if (is_numeric($string)) {
            if (false !== ( $int = filter_var($string, FILTER_VALIDATE_INT) )) {
                return $this->createDateFromInt($int, $tz);
            }

            if (false !== ( $float = filter_var($string, FILTER_VALIDATE_FLOAT) )) {
                return $this->createDateFromFloat($float, $tz);
            }
        }

        $tz = $tz ?? $this->getTimezone();

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
                    $dt = $this->createDateFromInt($int);

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
