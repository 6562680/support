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
     * @return void
     */
    public function resetEnv(): void;

    /**
     * @return array
     */
    public function getEnvLocal(): array;

    /**
     * @return array
     */
    public function getEnvRuntime(): array;

    /**
     * @param string    $option
     * @param mixed     $default
     * @param null|bool $ignoreCase
     * @param null|bool $localOnly
     *
     * @return null|string|array|mixed
     */
    public function env(string $option, $default = null, bool $ignoreCase = null, bool $localOnly = null);

    /**
     * @param null|string $option
     * @param null|bool   $ignoreCase
     * @param null|bool   $localOnly
     *
     * @return string|array|false
     */
    public function getenv(string $option = null, bool $ignoreCase = null, bool $localOnly = null);

    /**
     * @param string    $name
     * @param string    $value
     * @param null|bool $ignoreCase
     *
     * @return void
     */
    public function setenv(string $name, string $value, bool $ignoreCase = null): void;

    /**
     * @param string    $name
     * @param string    $value
     * @param null|bool $ignoreCase
     *
     * @return bool
     */
    public function putenv(string $name, string $value, bool $ignoreCase = null): bool;
}
