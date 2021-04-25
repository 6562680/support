<?php

namespace Gzhegow\Support;


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
     * The date of first call ->now() function
     * Required to relative dates comparation
     *
     * @var \DateTime
     */
    protected $now;


    /**
     * @param string         $date
     * @param \DateTime|null $dt
     *
     * @return \DateTimeZone
     */
    protected function getTimezoneFromDateString(string $date, \DateTime &$dt = null) : \DateTimeZone
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

        return new \DateTimeZone('UTC');
    }


    /**
     * @param                    $date
     * @param \DateTimeZone|null $tz
     * @param null               $dt
     *
     * @return bool
     */
    public function isDate($date, \DateTimeZone $tz = null, &$dt = null) : bool
    {
        if (is_object($date) && is_a($date, \DateTime::class) && ( $dt = $date )) return true;
        if (false !== ( $int = filter_var($date,
                FILTER_VALIDATE_INT) )) {
            return (bool) $dt = $this->createDateFromInt($int, $tz);
        }
        if (false !== ( $float = filter_var($date,
                FILTER_VALIDATE_FLOAT) )) {
            return (bool) $dt = $this->createDateFromInt($float, $tz);
        }
        if (is_string($date) && ( '' !== $date )) {
            try {
                return (bool) $dt = $this->createDateFromString($date, $tz);
            }
            catch ( \Throwable $e ) {
                return false;
            }
        }

        return false;
    }


    /**
     * @param                    $date
     * @param \DateTimeZone|null $tz
     *
     * @return \DateTime
     */
    public function createDate($date, \DateTimeZone $tz = null) : \DateTime
    {
        $result = $this->parse($date, $tz);

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
        $tz = $tz ?? new \DateTimeZone('UTC');

        if (isset($this->now)) {
            $instance = clone $this->now;
            $instance->setTimezone($tz);

            return $instance;
        }

        try {
            $this->now = new \DateTime('now', $tz);
        }
        catch ( \Throwable $e ) {
            // never thrown
        }

        return clone $this->now;
    }

    /**
     * @param mixed              $date
     * @param \DateTimeZone|null $tz
     *
     * @return \DateTime
     */
    public function parse($date, \DateTimeZone $tz = null) : ?\DateTime
    {
        return null
            ?? $this->createDateFromInstance($date)
            ?? $this->createDateFromInt($date, $tz)
            ?? $this->createDateFromFloat($date, $tz)
            ?? $this->createDateFromString($date, $tz);
    }


    /**
     * @param mixed $a
     * @param mixed $b
     *
     * @return bool
     */
    public function equalTo($a, $b) : bool
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
    public function lessThan($a, $b) : bool
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
    public function lessThanOrEqualTo($a, $b) : bool
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
    public function greatherThan($a, $b) : bool
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
    public function greatherThanOrEqualTo($a, $b) : bool
    {
        if ($a === $b) return true;

        $parsedA = $this->parse($a);
        $parsedB = $this->parse($b);

        $isDateA = is_object($parsedA) && is_a($parsedA, \DateTime::class);
        $isDateB = is_object($parsedB) && is_a($parsedB, \DateTime::class);

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
     * @param                    $string
     * @param \DateTimeZone|null $tz
     *
     * @return null|\DateTime
     */
    protected function createDateFromString($string, \DateTimeZone $tz = null) : ?\DateTime
    {
        if (! is_string($string)) return null;
        if ('' === $string) return null;

        if (is_numeric($string)) {
            if (false !== ( $int = filter_var($string, FILTER_VALIDATE_INT) )) {
                return $this->createDateFromInt($int,
                    $tz);
            }
            if (false !== ( $float = filter_var($string,
                    FILTER_VALIDATE_FLOAT) )) {
                return $this->createDateFromFloat($float, $tz);
            }
        }

        try {
            $isRelativeOrNow = ( false !== ( $int = strtotime($string, $this->now($tz)->getTimestamp()) ) )
                && (
                    ( $date1 = ( new \DateTime('1970-01-01T00:00:00Z') )->modify($string) )
                    != ( $date2 = ( new \DateTime('1971-12-25T00:00:00Z') )->modify($string) )
                );

            if ($isRelativeOrNow) {
                $dt = $this->createDateFromInt($int);

                // ! return
                return $dt;
            }
        }
        catch ( \Throwable $e ) {
            // never thrown
        }

        foreach ( static::$formatsNoTimezone as $format => $enabled ) {
            try {
                if ($dt = \DateTime::createFromFormat($format, $string, $tz ?? new \DateTimeZone('UTC'))) {
                    // ! return
                    return $dt;
                }
            }
            catch ( \Throwable $e ) {
            }
        }

        $dateTz = $this->getTimezoneFromDateString($string, $date);
        if ($date) {
            // ! return
            return $date;
        }

        try {
            if ($dt = new \DateTime($string, $dateTz)) {
                // ! return
                return $dt;
            }
        }
        catch ( \Throwable $e ) {
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
