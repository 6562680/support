<?php

/**
 * This file is auto-generated.
 *
 * * @noinspection PhpUnhandledExceptionInspection
 * * @noinspection PhpDocMissingThrowsInspection
 */

namespace Gzhegow\Support\Facades\Generated;

use Gzhegow\Support\Debug as _Debug;

abstract class Debug
{
    /**
     * Prints any type for debug, to work with exceptions and debug_backtrace()
     *
     * @param mixed $arg
     *
     * @return string
     */
    public static function arg($arg) : string
    {
        return static::getInstance()->arg($arg);
    }

    /**
     * @param array $args
     *
     * @return string[]
     */
    public static function args(array $args) : array
    {
        return static::getInstance()->args($args);
    }

    /**
     * Replaces any count of spaces to one space like HTML do
     *
     * @param string $content
     *
     * @return string
     */
    public static function dom(string $content) : string
    {
        return static::getInstance()->dom($content);
    }

    /**
     * @param array       $trace
     * @param array       $columns
     * @param null|string $implode
     *
     * @return array
     */
    public static function trace(array $trace, array $columns = [], string $implode = null) : array
    {
        return static::getInstance()->trace($trace, $columns, $implode);
    }

    /**
     * @param array $arguments
     *
     * @return string
     */
    public static function varDump(...$arguments) : string
    {
        return static::getInstance()->varDump(...$arguments);
    }

    /**
     * Executes print_r, replaces all spaces to one when return
     *
     * @param mixed     $arg
     * @param bool|null $return
     *
     * @return string
     */
    public static function printR($arg, bool $return = null) : ?string
    {
        return static::getInstance()->printR($arg, $return);
    }

    /**
     * Executes var_export, replaces all spaces to one when return
     *
     * @param mixed     $arg
     * @param bool|null $return
     *
     * @return string
     */
    public static function varExport($arg, bool $return = null) : ?string
    {
        return static::getInstance()->varExport($arg, $return);
    }


    /**
     * @return _Debug
     */
    abstract public static function getInstance() : _Debug;
}
