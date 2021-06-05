<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support\Facades\Generated;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Path;

abstract class GeneratedPathFacade
{
    /**
     * @param string|string[]|array ...$delimiters
     *
     * @return Path
     */
    public static function clone(...$delimiters)
    {
        return static::getInstance()->clone(...$delimiters);
    }

    /**
     * @return string
     */
    public static function getSeparator(): string
    {
        return static::getInstance()->getSeparator();
    }

    /**
     * @return string[]
     */
    public static function getDelimiters(): array
    {
        return static::getInstance()->getDelimiters();
    }

    /**
     * @param string $separator
     *
     * @return Path
     */
    public static function setSeparator(string $separator)
    {
        return static::getInstance()->setSeparator($separator);
    }

    /**
     * @param string[] $delimiters
     *
     * @return Path
     */
    public static function setDelimiters(array $delimiters)
    {
        return static::getInstance()->setDelimiters($delimiters);
    }

    /**
     * @param string|string[] $delimiters
     *
     * @return Path
     */
    public static function using(...$delimiters)
    {
        return static::getInstance()->using(...$delimiters);
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public static function optimize(string $path): string
    {
        return static::getInstance()->optimize($path);
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public static function normalize(string $path): string
    {
        return static::getInstance()->normalize($path);
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
    public static function concat(...$strvals): string
    {
        return static::getInstance()->concat(...$strvals);
    }

    /**
     * @param string   $path
     * @param null|int $levels
     *
     * @return null|string
     */
    public static function dirname(string $path, int $levels = null): ?string
    {
        return static::getInstance()->dirname($path, $levels);
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
    public static function relative(string $path, string $base = ''): ?string
    {
        return static::getInstance()->relative($path, $base);
    }

    /**
     * @param string|array ...$strings
     *
     * @return array
     */
    public static function protocol(...$strings): array
    {
        return static::getInstance()->protocol(...$strings);
    }

    /**
     * @return Path
     */
    abstract public static function getInstance(): Path;
}
