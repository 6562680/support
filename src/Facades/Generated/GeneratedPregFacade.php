<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support\Facades\Generated;

use Gzhegow\Support\Domain\Preg\RegExp;
use Gzhegow\Support\Preg;

abstract class GeneratedPregFacade
{
    /**
     * @param string|string[] $regex
     * @param null|string     $delimiter
     * @param null|string     $flags
     *
     * @return RegExp
     */
    public static function newRegExp($regex, string $delimiter = null, string $flags = null): RegExp
    {
        return static::getInstance()->newRegExp($regex, $delimiter, $flags);
    }

    /**
     * @param string|string[] $regex
     * @param null|string     $delimiter
     * @param null|string     $flags
     *
     * @return RegExp
     */
    public static function new($regex, string $delimiter = null, string $flags = null): string
    {
        return static::getInstance()->new($regex, $delimiter, $flags);
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
     * @return Preg
     */
    abstract public static function getInstance(): Preg;
}
