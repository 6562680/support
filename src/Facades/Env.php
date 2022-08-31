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
     * @return void
     */
    public static function resetEnv(): void
    {
        static::getInstance()->resetEnv();
    }

    /**
     * @return array
     */
    public static function getEnvLocal(): array
    {
        return static::getInstance()->getEnvLocal();
    }

    /**
     * @return array
     */
    public static function getEnvRuntime(): array
    {
        return static::getInstance()->getEnvRuntime();
    }

    /**
     * @param string    $option
     * @param mixed     $default
     * @param null|bool $ignoreCase
     * @param null|bool $localOnly
     *
     * @return null|string|array|mixed
     */
    public static function env(string $option, $default = null, bool $ignoreCase = null, bool $localOnly = null)
    {
        return static::getInstance()->env($option, $default, $ignoreCase, $localOnly);
    }

    /**
     * @param null|string $option
     * @param null|bool   $ignoreCase
     * @param null|bool   $localOnly
     *
     * @return string|array|false
     */
    public static function getenv(string $option = null, bool $ignoreCase = null, bool $localOnly = null)
    {
        return static::getInstance()->getenv($option, $ignoreCase, $localOnly);
    }

    /**
     * @param string    $name
     * @param string    $value
     * @param null|bool $ignoreCase
     *
     * @return void
     */
    public static function setenv(string $name, string $value, bool $ignoreCase = null): void
    {
        static::getInstance()->setenv($name, $value, $ignoreCase);
    }

    /**
     * @param string    $name
     * @param string    $value
     * @param null|bool $ignoreCase
     *
     * @return bool
     */
    public static function putenv(string $name, string $value, bool $ignoreCase = null): bool
    {
        return static::getInstance()->putenv($name, $value, $ignoreCase);
    }

    /**
     * @return IEnv
     */
    public static function getInstance(): IEnv
    {
        return SupportFactory::getInstance()->getEnv();
    }
}
