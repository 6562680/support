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
use Gzhegow\Support\ICmp;
use Gzhegow\Support\SupportFactory;
use Gzhegow\Support\Traits\Load\CalendarLoadTrait;
use Gzhegow\Support\Traits\Load\NumLoadTrait;
use Gzhegow\Support\XCmp;

class Cmp
{
    /**
     * @param mixed $a
     * @param mixed $b
     *
     * @return int
     */
    public static function cmp($a, $b): int
    {
        return static::getInstance()->cmp($a, $b);
    }

    /**
     * @param null|int       $a
     * @param null|int|mixed $b
     * @param null|bool      $coalesce
     *
     * @return int
     */
    public static function cmpint($a, $b, bool $coalesce = null): int
    {
        return static::getInstance()->cmpint($a, $b, $coalesce);
    }

    /**
     * @param null|float       $a
     * @param null|float|mixed $b
     * @param null|bool        $coalesce
     *
     * @return int
     */
    public static function cmpfloat($a, $b, bool $coalesce = null): int
    {
        return static::getInstance()->cmpfloat($a, $b, $coalesce);
    }

    /**
     * @param null|int|float       $a
     * @param null|int|float|mixed $b
     * @param null|bool            $coalesce
     *
     * @return int
     */
    public static function cmpnum($a, $b, bool $coalesce = null): int
    {
        return static::getInstance()->cmpnum($a, $b, $coalesce);
    }

    /**
     * @param null|int|float|string       $a
     * @param null|int|float|string|mixed $b
     * @param null|bool                   $coalesce
     *
     * @return int
     */
    public static function cmpnumeric($a, $b, bool $coalesce = null): int
    {
        return static::getInstance()->cmpnumeric($a, $b, $coalesce);
    }

    /**
     * @param null|string       $a
     * @param null|string|mixed $b
     * @param null|bool         $natural
     * @param null|bool         $coalesce
     *
     * @return int
     */
    public static function cmpstr($a, $b, bool $natural = null, bool $coalesce = null): int
    {
        return static::getInstance()->cmpstr($a, $b, $natural, $coalesce);
    }

    /**
     * @param null|string       $a
     * @param null|string|mixed $b
     * @param null|bool         $natural
     * @param null|bool         $coalesce
     *
     * @return int
     */
    public static function cmpstrCase($a, $b, bool $natural = null, bool $coalesce = null): int
    {
        return static::getInstance()->cmpstrCase($a, $b, $natural, $coalesce);
    }

    /**
     * @param null|\DateTimeInterface       $a
     * @param null|\DateTimeInterface|mixed $b
     * @param null|bool                     $coalesce
     *
     * @return int
     */
    public static function cmpdate(\DateTimeInterface $a = null, $b = null, bool $coalesce = null): int
    {
        return static::getInstance()->cmpdate($a, $b, $coalesce);
    }

    /**
     * @return ICmp
     */
    public static function getInstance(): ICmp
    {
        return SupportFactory::getInstance()->getCmp();
    }
}
