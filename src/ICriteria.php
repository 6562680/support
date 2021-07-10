<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;

interface ICriteria
{
    /**
     * @param int|float|string $needle
     * @param array            $src
     * @param null|bool        $coalesce
     *
     * @return bool
     */
    public function isInNumber($needle, array $src, bool $coalesce = null): bool;

    /**
     * @param string    $needle
     * @param array     $src
     * @param null|bool $natural
     * @param null|bool $coalesce
     *
     * @return bool
     */
    public function isInString($needle, array $src, bool $natural = null, bool $coalesce = null): bool;

    /**
     * @param string    $needle
     * @param array     $src
     * @param null|bool $natural
     * @param null|bool $coalesce
     *
     * @return bool
     */
    public function isInStringCase($needle, array $src, bool $natural = null, bool $coalesce = null): bool;

    /**
     * @param \DateTime $needle
     * @param array     $src
     * @param null|bool $coalesce
     *
     * @return bool
     */
    public function isInDate(\DateTime $needle, array $src, bool $coalesce = null): bool;

    /**
     * @param int|float $needle
     * @param array     $src
     * @param null|bool $coalesce
     *
     * @return bool
     */
    public function isBetweenNumber($needle, array $src, bool $coalesce = null): bool;

    /**
     * @param \DateTime $needle
     * @param array     $src
     * @param null|bool $coalesce
     *
     * @return bool
     */
    public function isBetweenDate(\DateTime $needle, array $src, bool $coalesce = null): bool;

    /**
     * @param mixed     $needle
     * @param mixed     $src
     * @param string    $operator
     * @param null|bool $coalesce
     *
     * @return bool
     */
    public function satisfy($needle, $src, string $operator, bool $coalesce = null): bool;

    /**
     * @param mixed     $needle
     * @param array     $arr
     * @param string    $operator
     * @param null|bool $coalesce
     *
     * @return bool
     */
    public function satisfyArray($needle, array $arr, string $operator, bool $coalesce = null): bool;
}
