<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 * @noinspection RedundantSuppression
 */

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;

interface ICmp
{
    /**
     * @param mixed $a
     * @param mixed $b
     *
     * @return int
     */
    public function cmp($a, $b): int;

    /**
     * @param null|int|float|string $a
     * @param mixed                 $b
     * @param null|bool             $coalesce
     *
     * @return int
     */
    public function cmpnum($a, $b, bool $coalesce = null): int;

    /**
     * @param null|string $a
     * @param mixed       $b
     * @param null|bool   $natural
     * @param null|bool   $coalesce
     *
     * @return int
     */
    public function cmpstr($a, $b, bool $natural = null, bool $coalesce = null): int;

    /**
     * @param null|string $a
     * @param mixed       $b
     * @param null|bool   $natural
     * @param null|bool   $coalesce
     *
     * @return int
     */
    public function cmpstrCase($a, $b, bool $natural = null, bool $coalesce = null): int;

    /**
     * @param null|\DateTime $aDate
     * @param mixed          $b
     * @param null|bool      $coalesce
     *
     * @return int
     */
    public function cmpdate(\DateTime $aDate = null, $b = null, bool $coalesce = null): int;
}
