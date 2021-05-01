<?php

/**
 * This file is auto-generated.
 *
 * * @noinspection PhpUnhandledExceptionInspection
 * * @noinspection PhpDocMissingThrowsInspection
 */

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Env as _Env;

class Env
{
    /**
     * @return _Env
     */
    public static function getInstance() : _Env
    {
        return new _Env();
    }


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
    public static function putenv(string $name, string $value) : bool
    {
        return static::getInstance()->putenv($name, $value);
    }
}
