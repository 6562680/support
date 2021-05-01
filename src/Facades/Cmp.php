<?php

/**
 * This file is auto-generated.
 *
 * * @noinspection PhpUnhandledExceptionInspection
 * * @noinspection PhpDocMissingThrowsInspection
 */

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Cmp as _Cmp;

class Cmp
{
    /**
     * @return _Cmp
     */
    public static function getInstance() : _Cmp
    {
        return new _Cmp(
            Calendar::getInstance(),
            Type::getInstance()
        );
    }


    /**
     * @param mixed $a
     * @param mixed $b
     *
     * @return int
     */
    public static function cmp($a, $b) : int
    {
        return static::getInstance()->cmp($a, $b);
    }

    /**
     * @param null|int|float $a
     * @param mixed          $b
     * @param null|bool      $coalesce
     *
     * @return int
     */
    public static function cmpnum($a, $b, bool $coalesce = null) : int
    {
        return static::getInstance()->cmpnum($a, $b, $coalesce);
    }

    /**
     * @param null|string $a
     * @param mixed       $b
     * @param null|bool   $natural
     * @param null|bool   $coalesce
     *
     * @return int
     */
    public static function cmpstr($a, $b, bool $natural = null, bool $coalesce = null) : int
    {
        return static::getInstance()->cmpstr($a, $b, $natural, $coalesce);
    }

    /**
     * @param null|string $a
     * @param mixed       $b
     * @param null|bool   $natural
     * @param null|bool   $coalesce
     *
     * @return int
     */
    public static function cmpstrCase($a, $b, bool $natural = null, bool $coalesce = null) : int
    {
        return static::getInstance()->cmpstrCase($a, $b, $natural, $coalesce);
    }

    /**
     * @param null|\DateTime $aDate
     * @param mixed          $b
     * @param null|bool      $coalesce
     *
     * @return int
     */
    public static function cmpdate(\DateTime $aDate = null, $b = null, bool $coalesce = null) : int
    {
        return static::getInstance()->cmpdate($aDate, $b, $coalesce);
    }
}
