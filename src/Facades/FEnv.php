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

use Gzhegow\Support\Env;
use Gzhegow\Support\IEnv;

class FEnv
{
    /**
     * @param null|string $option
     * @param null|bool   $runtime
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
     * @return IEnv
     */
    public static function getInstance()
    {
        return static::getInstance()->getInstance();
    }
}
