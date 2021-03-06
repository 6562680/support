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

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\IPath;
use Gzhegow\Support\SupportFactory;
use Gzhegow\Support\ZPath;

class Path
{
    /**
     * @return ZPath
     */
    public static function reset()
    {
        return static::getInstance()->reset();
    }

    /**
     * @param null|string       $separator
     * @param null|string|array $delimiters
     *
     * @return ZPath
     */
    public static function clone(?string $separator, ?array $delimiters)
    {
        return static::getInstance()->clone($separator, $delimiters);
    }

    /**
     * @param null|string       $separator
     * @param null|string|array $delimiters
     *
     * @return ZPath
     */
    public static function with(?string $separator, ?array $delimiters)
    {
        return static::getInstance()->with($separator, $delimiters);
    }

    /**
     * @param string $separator
     *
     * @return ZPath
     */
    public static function withSeparator(string $separator)
    {
        return static::getInstance()->withSeparator($separator);
    }

    /**
     * @param string[] $delimiters
     *
     * @return ZPath
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
     * @param string|string[] ...$strings
     *
     * @return array
     */
    public static function split(...$strings): array
    {
        return static::getInstance()->split(...$strings);
    }

    /**
     * @param string|string[] ...$strings
     *
     * @return string
     */
    public static function join(...$strings): string
    {
        return static::getInstance()->join(...$strings);
    }

    /**
     * @param string|string[] ...$strings
     *
     * @return string
     */
    public static function concat(...$strings): string
    {
        return static::getInstance()->concat(...$strings);
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
     * @return IPath
     */
    public static function getInstance(): IPath
    {
        return SupportFactory::getInstance()->getPath();
    }
}
