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
use Gzhegow\Support\ICriteria;
use Gzhegow\Support\SupportFactory;
use Gzhegow\Support\Traits\Load\CalendarLoadTrait;
use Gzhegow\Support\Traits\Load\CmpLoadTrait;
use Gzhegow\Support\Traits\Load\NumLoadTrait;
use Gzhegow\Support\Traits\Load\StrLoadTrait;
use Gzhegow\Support\XCriteria;

class Criteria
{
    /**
     * @param array            $src
     * @param int|float|string $needle
     * @param null|bool        $coalesce
     *
     * @return bool
     */
    public static function isInNumeric(array $src, $needle, bool $coalesce = null): bool
    {
        return static::getInstance()->isInNumeric($src, $needle, $coalesce);
    }

    /**
     * @param array     $src
     * @param string    $needle
     * @param null|bool $natural
     * @param null|bool $coalesce
     *
     * @return bool
     */
    public static function isInString(array $src, $needle, bool $natural = null, bool $coalesce = null): bool
    {
        return static::getInstance()->isInString($src, $needle, $natural, $coalesce);
    }

    /**
     * @param array     $src
     * @param string    $needle
     * @param null|bool $natural
     * @param null|bool $coalesce
     *
     * @return bool
     */
    public static function isInStringCase(array $src, $needle, bool $natural = null, bool $coalesce = null): bool
    {
        return static::getInstance()->isInStringCase($src, $needle, $natural, $coalesce);
    }

    /**
     * @param array              $src
     * @param \DateTimeInterface $needle
     * @param null|bool          $coalesce
     *
     * @return bool
     */
    public static function isInDate(array $src, \DateTimeInterface $needle, bool $coalesce = null): bool
    {
        return static::getInstance()->isInDate($src, $needle, $coalesce);
    }

    /**
     * @param array            $src
     * @param int|float|string $needle
     * @param null|bool        $coalesce
     *
     * @return bool
     */
    public static function isBetweenNumber(array $src, $needle, bool $coalesce = null): bool
    {
        return static::getInstance()->isBetweenNumber($src, $needle, $coalesce);
    }

    /**
     * @param array              $src
     * @param \DateTimeInterface $needle
     * @param null|bool          $coalesce
     *
     * @return bool
     */
    public static function isBetweenDate(array $src, \DateTimeInterface $needle, bool $coalesce = null): bool
    {
        return static::getInstance()->isBetweenDate($src, $needle, $coalesce);
    }

    /**
     * @param mixed       $needle
     * @param mixed       $src
     * @param null|string $operator
     * @param null|bool   $coalesce
     *
     * @return bool
     */
    public static function satisfy($needle, $src, string $operator = null, bool $coalesce = null): bool
    {
        return static::getInstance()->satisfy($needle, $src, $operator, $coalesce);
    }

    /**
     * @param mixed       $needle
     * @param array       $src
     * @param null|string $operator
     * @param null|bool   $coalesce
     *
     * @return bool
     */
    public static function satisfyArray($needle, array $src, string $operator = null, bool $coalesce = null): bool
    {
        return static::getInstance()->satisfyArray($needle, $src, $operator, $coalesce);
    }

    /**
     * @return ICriteria
     */
    public static function getInstance(): ICriteria
    {
        return SupportFactory::getInstance()->getCriteria();
    }
}
