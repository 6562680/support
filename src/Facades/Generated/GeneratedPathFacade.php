<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpDocMissingThrowsInspection
 */

namespace Gzhegow\Support\Facades\Generated;

use Gzhegow\Support\Path;

abstract class GeneratedPathFacade
{
    /**
     * @param string|string[] $delimiters
     *
     * @return static
     */
    public static function using(...$delimiters): self
    {
        return static::getInstance()->using(...$delimiters);
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function optimize(string $string): string
    {
        return static::getInstance()->optimize($string);
    }

    /**
     * @param string     $string
     * @param null|array $delimiters
     *
     * @return string
     */
    public static function pregOptimize(string $string, array &$delimiters = null): string
    {
        return static::getInstance()->pregOptimize($string, $delimiters);
    }

    /**
     * @param string|string[] ...$strvals
     *
     * @return array
     */
    public static function split(...$strvals): array
    {
        return static::getInstance()->split(...$strvals);
    }

    /**
     * @param string|string[] ...$strvals
     *
     * @return string
     */
    public static function join(...$strvals): string
    {
        return static::getInstance()->join(...$strvals);
    }

    /**
     * @param string|string[] ...$strvals
     *
     * @return string
     */
    public static function normalize(...$strvals): string
    {
        return static::getInstance()->normalize(...$strvals);
    }

    /**
     * @param string|string[] ...$strvals
     *
     * @return string
     */
    public static function concat(...$strvals): string
    {
        return static::getInstance()->concat(...$strvals);
    }

    /**
     * @param string      $path
     * @param null|string $suffix
     * @param null|int    $levels
     *
     * @return null|string
     */
    public static function basename(string $path, string $suffix = null, int $levels = null): ?string
    {
        return static::getInstance()->basename($path, $suffix, $levels);
    }

    /**
     * @param string      $path
     * @param string|null $base
     *
     * @return string
     */
    public static function basepath(string $path, string $base = ''): ?string
    {
        return static::getInstance()->basepath($path, $base);
    }

    /**
     * @return Path
     */
    abstract public static function getInstance(): Path;
}
