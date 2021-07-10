<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support;

use Gzhegow\Support\Domain\Preg\RegExp;

interface IPreg
{
    /**
     * @param string|string[] $regex
     * @param null|string     $delimiter
     * @param null|string     $flags
     *
     * @return RegExp
     */
    public function new($regex, string $delimiter = null, string $flags = null): RegExp;

    /**
     * @param mixed $regex
     *
     * @return bool
     */
    public function isShort($regex): bool;

    /**
     * @param mixed $regex
     *
     * @return bool
     */
    public function isValid($regex): bool;

    /**
     * @param mixed $regex
     *
     * @return null|string
     */
    public function filterShort($regex): ?string;

    /**
     * @param mixed $regex
     *
     * @return null|string
     */
    public function filterValid($regex): ?string;

    /**
     * @param string|string[] $regex
     * @param string|string[] ...$regexes
     *
     * @return RegExp
     */
    public function concat($regex, ...$regexes): string;
}
