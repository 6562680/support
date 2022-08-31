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
use Gzhegow\Support\Traits\Load\CmpLoadTrait;
use Gzhegow\Support\Traits\Load\NumLoadTrait;
use Gzhegow\Support\Traits\Load\StrLoadTrait;

interface ICriteria
{
    /**
     * @param array            $src
     * @param int|float|string $needle
     * @param null|bool        $coalesce
     *
     * @return bool
     */
    public function isInNumeric(array $src, $needle, bool $coalesce = null): bool;

    /**
     * @param array     $src
     * @param string    $needle
     * @param null|bool $natural
     * @param null|bool $coalesce
     *
     * @return bool
     */
    public function isInString(array $src, $needle, bool $natural = null, bool $coalesce = null): bool;

    /**
     * @param array     $src
     * @param string    $needle
     * @param null|bool $natural
     * @param null|bool $coalesce
     *
     * @return bool
     */
    public function isInStringCase(array $src, $needle, bool $natural = null, bool $coalesce = null): bool;

    /**
     * @param array              $src
     * @param \DateTimeInterface $needle
     * @param null|bool          $coalesce
     *
     * @return bool
     */
    public function isInDate(array $src, \DateTimeInterface $needle, bool $coalesce = null): bool;

    /**
     * @param array            $src
     * @param int|float|string $needle
     * @param null|bool        $coalesce
     *
     * @return bool
     */
    public function isBetweenNumber(array $src, $needle, bool $coalesce = null): bool;

    /**
     * @param array              $src
     * @param \DateTimeInterface $needle
     * @param null|bool          $coalesce
     *
     * @return bool
     */
    public function isBetweenDate(array $src, \DateTimeInterface $needle, bool $coalesce = null): bool;

    /**
     * @param mixed       $needle
     * @param mixed       $src
     * @param null|string $operator
     * @param null|bool   $coalesce
     *
     * @return bool
     */
    public function satisfy($needle, $src, string $operator = null, bool $coalesce = null): bool;

    /**
     * @param mixed       $needle
     * @param array       $src
     * @param null|string $operator
     * @param null|bool   $coalesce
     *
     * @return bool
     */
    public function satisfyArray($needle, array $src, string $operator = null, bool $coalesce = null): bool;
}
