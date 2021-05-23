<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpDocMissingThrowsInspection
 */

namespace Gzhegow\Support\Facades\Generated;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
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
     * @param string|string[] ...$classes
     *
     * @return bool
     */
    public static function isInstanceOf($value, ...$classes): bool
    {
        return static::getInstance()->isInstanceOf($value, ...$classes);
    }

    /**
     * @param string|object   $value
     * @param string|string[] ...$classes
     *
     * @return bool
     */
    public static function isClassOf($value, ...$classes): bool
    {
        return static::getInstance()->isClassOf($value, ...$classes);
    }

    /**
     * @param string|object   $value
     * @param string|string[] ...$classes
     *
     * @return bool
     */
    public static function isSubclassOf($value, ...$classes): bool
    {
        return static::getInstance()->isSubclassOf($value, ...$classes);
    }

    /**
     * @param object          $value
     * @param string|string[] ...$classes
     *
     * @return null|object
     */
    public static function filterInstanceOf($value, ...$classes)
    {
        return static::getInstance()->filterInstanceOf($value, ...$classes);
    }

    /**
     * @param string|object   $value
     * @param string|string[] ...$classes
     *
     * @return null|string|object
     */
    public static function filterClassOf($value, ...$classes)
    {
        return static::getInstance()->filterClassOf($value, ...$classes);
    }

    /**
     * @param string|object   $value
     * @param string|string[] ...$classes
     *
     * @return null|string|object
     */
    public static function filterSubclassOf($value, ...$classes)
    {
        return static::getInstance()->filterSubclassOf($value, ...$classes);
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
     * @param string|object $classOrObject
     * @param null|string   $suffix
     * @param null|int      $limit
     *
     * @return string
     */
    public static function basename($classOrObject, string $suffix = null, int $limit = null): ?string
    {
        return static::getInstance()->basename($classOrObject, $suffix, $limit);
    }

    /**
     * @param string|object $classOrObject
     * @param string|null   $base
     *
     * @return string
     */
    public static function basepath($classOrObject, string $base = null): ?string
    {
        return static::getInstance()->basepath($classOrObject, $base);
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
