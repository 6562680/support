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
use Gzhegow\Support\Interfaces\PathInterface;
use Gzhegow\Support\Path;

abstract class GeneratedPathFacade
{
    /**
     * @return Path
     */
    public static function reset()
    {
        return static::getInstance()->reset();
    }

    /**
     * @param null|string       $separator
     * @param null|string|array $delimiters
     *
     * @return Path
     */
    public static function clone(?string $separator, ?array $delimiters)
    {
        return static::getInstance()->clone($separator, $delimiters);
    }

    /**
     * @param null|string       $separator
     * @param null|string|array $delimiters
     *
     * @return Path
     */
    public static function with(?string $separator, ?array $delimiters)
    {
        return static::getInstance()->with($separator, $delimiters);
    }

    /**
     * @param string $separator
     *
     * @return Path
     */
    public static function withSeparator(string $separator)
    {
        return static::getInstance()->withSeparator($separator);
    }

    /**
     * @param string[] $delimiters
     *
     * @return Path
     */
    public static function withDelimiters(array $delimiters)
    {
        return static::getInstance()->withDelimiters($delimiters);
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
     * @param null|int $level
     *
     * @return string
     */
    public static function dirname(string $path, int $level = null): string
    {
        return static::getInstance()->dirname($path, $level);
    }

    /**
     * @param string      $path
     * @param null|string $suffix
     * @param null|int    $level
     *
     * @return string
     */
    public static function basename(string $path, string $suffix = null, int $level = null): string
    {
        return static::getInstance()->basename($path, $suffix, $level);
    }

    /**
     * @param string      $path
     * @param string|null $base
     *
     * @return string
     */
    public static function relative(string $path, string $base = null): ?string
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
