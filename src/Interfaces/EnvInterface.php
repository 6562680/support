<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support\Interfaces;

use Gzhegow\Support\Env;

interface EnvInterface
{
    /**
     * @param null      $option
     * @param bool|null $runtime
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
