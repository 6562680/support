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

use Gzhegow\Support\Domain\Preg\RegExp;
use Gzhegow\Support\IPreg;
use Gzhegow\Support\SupportFactory;
use Gzhegow\Support\ZPreg;

class Preg
{
    /**
     * @param string|string[] $regex
     * @param null|string     $delimiter
     * @param null|string     $flags
     *
     * @return RegExp
     */
    public static function new($regex, string $delimiter = null, string $flags = null): RegExp
    {
        return static::getInstance()->new($regex, $delimiter, $flags);
    }

    /**
     * @param mixed $regex
     *
     * @return bool
     */
    public static function isShort($regex): bool
    {
        return static::getInstance()->isShort($regex);
    }

    /**
     * @param mixed $regex
     *
     * @return bool
     */
    public static function isValid($regex): bool
    {
        return static::getInstance()->isValid($regex);
    }

    /**
     * @param mixed $regex
     *
     * @return null|string
     */
    public static function filterShort($regex): ?string
    {
        return static::getInstance()->filterShort($regex);
    }

    /**
     * @param mixed $regex
     *
     * @return null|string
     */
    public static function filterValid($regex): ?string
    {
        return static::getInstance()->filterValid($regex);
    }

    /**
     * @param string|string[] $regex
     * @param string|string[] ...$regexes
     *
     * @return RegExp
     */
    public static function concat($regex, ...$regexes): string
    {
        return static::getInstance()->concat($regex, ...$regexes);
    }

    /**
     * @return IPreg
     */
    public static function getInstance(): IPreg
    {
        return SupportFactory::getInstance()->getPreg();
    }
}
