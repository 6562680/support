<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;

/**
 * Preg
 */
class Preg
{
    /**
     * @var Type
     */
    protected $type;


    /**
     * Constructor
     *
     * @param Type $type
     */
    public function __construct(Type $type)
    {
        $this->type = $type;
    }


    /**
     * @param string|string[]|string[][] $regex
     * @param string                     $delimiter
     * @param string                     $flags
     *
     * @return string
     */
    public function new($regex, string $flags = '', string $delimiter = '/') : string
    {
        if (! is_iterable($regex)) {
            $regex = [ $regex ];
        }

        $result = [];

        foreach ( $regex as $part ) {
            if (is_array($part)) {
                foreach ( $part as $p ) {
                    if (! $this->type->isTheString($p)) {
                        throw new InvalidArgumentException('Each sub-part should be non-empty string', $p);
                    }

                    $result[] = preg_quote($p, $delimiter);
                }
            } elseif ($this->type->isTheString($part)) {
                $result[] = $part;

            } else {
                throw new InvalidArgumentException('Each part should be non-empty string', $part);
            }
        }

        $result = $delimiter . implode('', $result) . $delimiter . $flags;

        if (! $this->isValid($result)) {
            throw new InvalidArgumentException('Unable to create regex, try to omit separators and flags. ' . $this->lastError(),
                $result);
        }

        return $result;
    }


    /**
     * @param string $regex
     *
     * @return bool
     */
    public function isValid(string $regex) : bool
    {
        return false !== @preg_match($regex, null);
    }


    /**
     * @param int $code
     *
     * @return string
     */
    public function error(int $code) : string
    {
        return static::$errorCodes[ $code ];
    }

    /**
     * @return mixed
     */
    public function lastError()
    {
        return $this->error(preg_last_error());
    }


    /**
     * @var array
     */
    protected static $errorCodes = [
        PREG_NO_ERROR              => 'No errors',
        PREG_INTERNAL_ERROR        => 'There was an internal PCRE error',
        PREG_BACKTRACK_LIMIT_ERROR => 'Backtrack limit was exhausted',
        PREG_RECURSION_LIMIT_ERROR => 'Recursion limit was exhausted',
        PREG_BAD_UTF8_ERROR        => 'The offset didn\'t correspond to the begin of a valid UTF-8 code point',
        PREG_BAD_UTF8_OFFSET_ERROR => 'Malformed UTF-8 data',
    ];
}
