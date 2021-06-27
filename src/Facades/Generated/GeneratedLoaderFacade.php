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
use Gzhegow\Support\Interfaces\LoaderInterface;
use Gzhegow\Support\Loader;

abstract class GeneratedLoaderFacade
{
    /**
     * @return array
     */
    public static function getDeclaredClasses(): array
    {
        return static::getInstance()->getDeclaredClasses();
    }

    /**
     * @param object          $value
     * @param string|string[] $classes
     *
     * @return bool
     */
    public static function isInstanceOf($value, $classes): bool
    {
        return static::getInstance()->isInstanceOf($value, $classes);
    }

    /**
     * @param string|object   $value
     * @param string|string[] $classes
     *
     * @return bool
     */
    public static function isClassOf($value, $classes): bool
    {
        return static::getInstance()->isClassOf($value, $classes);
    }

    /**
     * @param string|object   $value
     * @param string|string[] $classes
     *
     * @return bool
     */
    public static function isSubclassOf($value, $classes): bool
    {
        return static::getInstance()->isSubclassOf($value, $classes);
    }

    /**
     * @param object          $value
     * @param string|string[] $classes
     *
     * @return null|object
     */
    public static function filterInstanceOf($value, $classes)
    {
        return static::getInstance()->filterInstanceOf($value, $classes);
    }

    /**
     * @param string|object   $value
     * @param string|string[] $classes
     *
     * @return null|string|object
     */
    public static function filterClassOf($value, $classes)
    {
        return static::getInstance()->filterClassOf($value, $classes);
    }

    /**
     * @param string|object   $value
     * @param string|string[] $classes
     *
     * @return null|string|object
     */
    public static function filterSubclassOf($value, $classes)
    {
        return static::getInstance()->filterSubclassOf($value, $classes);
    }

    /**
     * @param object          $value
     * @param string|string[] ...$classes
     *
     * @return null|object
     */
    public static function assertInstanceOf($value, $classes)
    {
        return static::getInstance()->assertInstanceOf($value, $classes);
    }

    /**
     * @param string|object   $value
     * @param string|string[] ...$classes
     *
     * @return null|string|object
     */
    public static function assertClassOf($value, $classes)
    {
        return static::getInstance()->assertClassOf($value, $classes);
    }

    /**
     * @param string|object   $value
     * @param string|string[] ...$classes
     *
     * @return null|string|object
     */
    public static function assertSubclassOf($value, $classes)
    {
        return static::getInstance()->assertSubclassOf($value, $classes);
    }

    /**
     * @param mixed $classOrObject
     *
     * @return null|string
     */
    public static function classVal($classOrObject): ?string
    {
        return static::getInstance()->classVal($classOrObject);
    }

    /**
     * @param string|object $classOrObject
     *
     * @return string[]
     */
    public static function nsClass($classOrObject): array
    {
        return static::getInstance()->nsClass($classOrObject);
    }

    /**
     * @param string|object $classOrObject
     *
     * @return null|string
     */
    public static function namespace($classOrObject): ?string
    {
        return static::getInstance()->namespace($classOrObject);
    }

    /**
     * @param string|object $classOrObject
     *
     * @return string
     */
    public static function className($classOrObject): string
    {
        return static::getInstance()->className($classOrObject);
    }

    /**
     * @return Path
     */
    public static function path(): \Gzhegow\Support\Path
    {
        return static::getInstance()->path();
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public static function pathOptimize(string $path): string
    {
        return static::getInstance()->pathOptimize($path);
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public static function pathNormalize(string $path): string
    {
        return static::getInstance()->pathNormalize($path);
    }

    /**
     * @param string|string[]|array ...$parts
     *
     * @return array
     */
    public static function pathSplit(...$parts): array
    {
        return static::getInstance()->pathSplit(...$parts);
    }

    /**
     * @param string|string[]|array ...$parts
     *
     * @return string
     */
    public static function pathJoin(...$parts): string
    {
        return static::getInstance()->pathJoin(...$parts);
    }

    /**
     * @param string|string[]|array ...$parts
     *
     * @return string
     */
    public static function pathConcat(...$parts): string
    {
        return static::getInstance()->pathConcat(...$parts);
    }

    /**
     * @param string $path
     * @param int    $levels
     *
     * @return null|string
     */
    public static function pathDirname(string $path, int $levels = 0): ?string
    {
        return static::getInstance()->pathDirname($path, $levels);
    }

    /**
     * @param string      $path
     * @param null|string $suffix
     * @param int         $levels
     *
     * @return null|string
     */
    public static function pathBasename(string $path, string $suffix = null, int $levels = 0): ?string
    {
        return static::getInstance()->pathBasename($path, $suffix, $levels);
    }

    /**
     * @param string|object $classOrObject
     * @param string|null   $base
     *
     * @return string
     */
    public static function pathRelative($classOrObject, string $base = ''): ?string
    {
        return static::getInstance()->pathRelative($classOrObject, $base);
    }

    /**
     * @param callable $filter
     * @param null|int $limit
     * @param int      $offset
     *
     * @return array
     */
    public static function searchDeclaredClass(callable $filter, int $limit = null, int $offset = 0): array
    {
        return static::getInstance()->searchDeclaredClass($filter, $limit, $offset);
    }

    /**
     * @return Loader
     */
    abstract public static function getInstance(): Loader;
}
