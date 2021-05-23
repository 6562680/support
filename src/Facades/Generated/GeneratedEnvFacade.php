<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support\Facades\Generated;

use Gzhegow\Support\Env;

abstract class GeneratedEnvFacade
{
    /**
     * @param null      $option
     * @param bool|null $runtime
     *
     * @return null|array|false|string
     */
    public static function getenv($option = null, bool $runtime = null)
    {
        return static::getInstance()->getenv($option, $runtime);
    }

    /**
     * @param string $name
     * @param string $value
     *
     * @return bool
     */
    public static function putenv(string $name, string $value): bool
    {
        return static::getInstance()->putenv($name, $value);
    }

    /**
     * @return Env
     */
    abstract public static function getInstance(): Env;
}
