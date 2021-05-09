<?php

/**
 * This file is auto-generated.
 *
 * * @noinspection PhpUnhandledExceptionInspection
 * * @noinspection PhpDocMissingThrowsInspection
 */

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Criteria as _Criteria;

class Criteria
{
    /**
     * @return _Criteria
     */
    public static function getInstance() : _Criteria
    {
        return new _Criteria(
            Calendar::getInstance(),
            Cmp::getInstance(),
            Filter::getInstance(),
            Str::getInstance()
        );
    }


    /**
     * @param number    $needle
     * @param array     $src
     * @param null|bool $coalesce
     *
     * @return bool
     */
    public static function isInNumber($needle, array $src, bool $coalesce = null) : bool
    {
        return static::getInstance()->isInNumber($needle, $src, $coalesce);
    }

    /**
     * @param string    $needle
     * @param array     $src
     * @param null|bool $natural
     * @param null|bool $coalesce
     *
     * @return bool
     */
    public static function isInString($needle, array $src, bool $natural = null, bool $coalesce = null) : bool
    {
        return static::getInstance()->isInString($needle, $src, $natural, $coalesce);
    }

    /**
     * @param string    $needle
     * @param array     $src
     * @param null|bool $natural
     * @param null|bool $coalesce
     *
     * @return bool
     */
    public static function isInStringCase($needle, array $src, bool $natural = null, bool $coalesce = null) : bool
    {
        return static::getInstance()->isInStringCase($needle, $src, $natural, $coalesce);
    }

    /**
     * @param \DateTime $needle
     * @param array     $src
     * @param null|bool $coalesce
     *
     * @return bool
     */
    public static function isInDate(\DateTime $needle, array $src, bool $coalesce = null) : bool
    {
        return static::getInstance()->isInDate($needle, $src, $coalesce);
    }

    /**
     * @param int|float $needle
     * @param array     $src
     * @param null|bool $coalesce
     *
     * @return bool
     */
    public static function isBetweenNumber($needle, array $src, bool $coalesce = null) : bool
    {
        return static::getInstance()->isBetweenNumber($needle, $src, $coalesce);
    }

    /**
     * @param \DateTime $needle
     * @param array     $src
     * @param null|bool $coalesce
     *
     * @return bool
     */
    public static function isBetweenDate(\DateTime $needle, array $src, bool $coalesce = null) : bool
    {
        return static::getInstance()->isBetweenDate($needle, $src, $coalesce);
    }

    /**
     * @param mixed     $needle
     * @param mixed     $src
     * @param string    $operator
     * @param null|bool $coalesce
     *
     * @return bool
     */
    public static function satisfy($needle, $src, string $operator, bool $coalesce = null) : bool
    {
        return static::getInstance()->satisfy($needle, $src, $operator, $coalesce);
    }

    /**
     * @param mixed     $needle
     * @param array     $arr
     * @param string    $operator
     * @param null|bool $coalesce
     *
     * @return bool
     */
    public static function satisfyArray($needle, array $arr, string $operator, bool $coalesce = null) : bool
    {
        return static::getInstance()->satisfyArray($needle, $arr, $operator, $coalesce);
    }
}
