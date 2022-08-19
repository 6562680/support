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

use Gzhegow\Support\IEnv;
use Gzhegow\Support\SupportFactory;
use Gzhegow\Support\XEnv;

class Env
{
    /**
     * @param string    $key
     * @param mixed     $default
     * @param bool|null $runtime
     *
     * @return null|array|false|mixed|string
     */
    public static function env(string $key, $default = null, bool $runtime = null)
    {
        return static::getInstance()->env($key, $default, $runtime);
    }

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
    public static function getInstance(): IEnv
    {
        return SupportFactory::getInstance()->getEnv();
    }
}
