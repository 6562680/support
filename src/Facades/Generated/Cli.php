<?php

/**
 * This file is auto-generated.
 *
 * * @noinspection PhpUnhandledExceptionInspection
 * * @noinspection PhpDocMissingThrowsInspection
 */

namespace Gzhegow\Support\Facades\Generated;

use Gzhegow\Support\Cli as _Cli;

abstract class Cli
{
    /**
     * @param mixed ...$arguments
     */
    public static function stop(...$arguments) : void
    {
        static::getInstance()->stop(...$arguments);
    }

    /**
     * @param mixed ...$arguments
     *
     * @return array
     */
    public static function pause(...$arguments) : array
    {
        return static::getInstance()->pause(...$arguments);
    }

    /**
     * @return string
     */
    public static function readln() : string
    {
        return static::getInstance()->readln();
    }

    /**
     * @param string $search
     *
     * @return string
     */
    public static function cin(string $search = '```') : string
    {
        return static::getInstance()->cin($search);
    }

    /**
     * writeFile
     * сохраняет файл в указанное место, но выводит предупреждение что файл уже есть и предлагает его переписать, сохранив копию
     *
     * @param string $outputPath
     * @param string $content
     * @param string $answer
     *
     * @return _Cli
     */
    public static function writeFile(string $outputPath, string $content, string &$answer = 'n')
    {
        return static::getInstance()->writeFile($outputPath, $content, $answer);
    }

    /**
     * выполняет консольную команду через proc_open и возвращает данные или код ошибки
     *
     * @param string      $cmd
     * @param string|null $stdin
     * @param string|null $cwd
     * @param array|null  $env
     * @param array|null  $other_options
     *
     * @return array
     */
    public static function run(
        string $cmd,
        string $stdin = null,
        string $cwd = null,
        array $env = null,
        array $other_options = null
    ) : array
    {
        return static::getInstance()->run($cmd, $stdin, $cwd, $env, $other_options);
    }


    /**
     * @return _Cli
     */
    abstract public static function getInstance() : _Cli;
}
