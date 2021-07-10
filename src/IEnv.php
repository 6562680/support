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

interface IEnv
{
    /**
     * @param null|string $option
     * @param null|bool   $runtime
     *
     * @return null|array|false|string
     */
    public function getenv($option = null, bool $runtime = null);

    /**
     * @param string $name
     * @param string $value
     *
     * @return bool
     */
    public function putenv(string $name, string $value): bool;
}
