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
use Gzhegow\Support\Traits\Load\CalendarLoadTrait;
use Gzhegow\Support\Traits\Load\NumLoadTrait;

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
     * @param null|int       $a
     * @param null|int|mixed $b
     * @param null|bool      $coalesce
     *
     * @return int
     */
    public function cmpint($a, $b, bool $coalesce = null): int;

    /**
     * @param null|float       $a
     * @param null|float|mixed $b
     * @param null|bool        $coalesce
     *
     * @return int
     */
    public function cmpfloat($a, $b, bool $coalesce = null): int;

    /**
     * @param null|int|float       $a
     * @param null|int|float|mixed $b
     * @param null|bool            $coalesce
     *
     * @return int
     */
    public function cmpnum($a, $b, bool $coalesce = null): int;

    /**
     * @param null|int|float|string       $a
     * @param null|int|float|string|mixed $b
     * @param null|bool                   $coalesce
     *
     * @return int
     */
    public function cmpnumeric($a, $b, bool $coalesce = null): int;

    /**
     * @param null|string       $a
     * @param null|string|mixed $b
     * @param null|bool         $natural
     * @param null|bool         $coalesce
     *
     * @return int
     */
    public function cmpstr($a, $b, bool $natural = null, bool $coalesce = null): int;

    /**
     * @param null|string       $a
     * @param null|string|mixed $b
     * @param null|bool         $natural
     * @param null|bool         $coalesce
     *
     * @return int
     */
    public function cmpstrCase($a, $b, bool $natural = null, bool $coalesce = null): int;

    /**
     * @param null|\DateTimeInterface       $a
     * @param null|\DateTimeInterface|mixed $b
     * @param null|bool                     $coalesce
     *
     * @return int
     */
    public function cmpdate(\DateTimeInterface $a = null, $b = null, bool $coalesce = null): int;
}
