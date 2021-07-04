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
use Gzhegow\Support\Exceptions\RuntimeException;
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
     * @param string|object|\ReflectionClass $classOrObject
     *
     * @return array
     */
    public static function getUseStatements($classOrObject): array
    {
        return static::getInstance()->getUseStatements($classOrObject);
    }

    /**
     * @return array
     */
    public static function getContracts(): array
    {
        return static::getInstance()->getContracts();
    }

    /**
     * @param string $contract
     *
     * @return array
     */
    public static function getContract(string $contract): array
    {
        return static::getInstance()->getContract($contract);
    }

    /**
     * @param string $contract
     *
     * @return null|array
     */
    public static function existsContract($contract): ?array
    {
        return static::getInstance()->existsContract($contract);
    }

    /**
     * @param string       $contract
     * @param string|array $classes
     *
     * @return Loader
     */
    public static function setContract(string $contract, ...$classes)
    {
        return static::getInstance()->setContract($contract, ...$classes);
    }

    /**
     * @param string       $contract
     * @param string|array $classes
     *
     * @return Loader
     */
    public static function addContract(string $contract, ...$classes)
    {
        return static::getInstance()->addContract($contract, ...$classes);
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
     * @return bool
     */
    public static function isInstanceOf($value, $classes): bool
    {
        return static::getInstance()->isInstanceOf($value, $classes);
    }

    /**
     * @param string|mixed $contract
     * @param object|mixed $object
     *
     * @return bool
     */
    public static function isContact($contract, $object): bool
    {
        return static::getInstance()->isContact($contract, $object);
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
     * @param object          $object
     * @param string|string[] $classes
     *
     * @return null|object
     */
    public static function filterInstanceOf($object, $classes): ?object
    {
        return static::getInstance()->filterInstanceOf($object, $classes);
    }

    /**
     * @param string|mixed $contract
     * @param object|mixed $object
     *
     * @return null|object
     */
    public static function filterContract($contract, $object): ?object
    {
        return static::getInstance()->filterContract($contract, $object);
    }

    /**
     * @param string|object   $value
     * @param string|string[] ...$classes
     *
     * @return string|object
     */
    public static function assertClassOf($value, $classes)
    {
        return static::getInstance()->assertClassOf($value, $classes);
    }

    /**
     * @param string|object   $value
     * @param string|string[] ...$classes
     *
     * @return string|object
     */
    public static function assertSubclassOf($value, $classes)
    {
        return static::getInstance()->assertSubclassOf($value, $classes);
    }

    /**
     * @param object          $object
     * @param string|string[] ...$classes
     *
     * @return object
     */
    public static function assertInstanceOf($object, $classes): object
    {
        return static::getInstance()->assertInstanceOf($object, $classes);
    }

    /**
     * @param string|mixed $contract
     * @param object|mixed $object
     *
     * @return object
     */
    public static function assertContract($contract, $object): object
    {
        return static::getInstance()->assertContract($contract, $object);
    }

    /**
     * @param string|object|\ReflectionClass $classOrObject
     * @param null|bool                      $prefixed
     *
     * @return null|string
     */
    public static function classVal($classOrObject, bool $prefixed = null): ?string
    {
        return static::getInstance()->classVal($classOrObject, $prefixed);
    }

    /**
     * @param string|object|\ReflectionClass $classOrObject
     * @param null|bool                      $prefixed
     *
     * @return string
     */
    public static function theClassVal($classOrObject, bool $prefixed = null): string
    {
        return static::getInstance()->theClassVal($classOrObject, $prefixed);
    }

    /**
     * @param object|\ReflectionClass $object
     * @param null|bool               $prefixed
     *
     * @return null|string
     */
    public static function objectClassVal($object, bool $prefixed = null): ?string
    {
        return static::getInstance()->objectClassVal($object, $prefixed);
    }

    /**
     * @param object|\ReflectionClass $object
     * @param null|bool               $prefixed
     *
     * @return string
     */
    public static function theObjectClassVal($object, bool $prefixed = null): string
    {
        return static::getInstance()->theObjectClassVal($object, $prefixed);
    }

    /**
     * @param string|object|\ReflectionClass $classOrObject
     * @param string|object|\ReflectionClass $declaredClassOrObject
     * @param null|bool                      $prefixed
     *
     * @return null|string
     */
    public static function useClassVal($classOrObject, $declaredClassOrObject = null, bool $prefixed = null)
    {
        return static::getInstance()->useClassVal($classOrObject, $declaredClassOrObject, $prefixed);
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
     * @return string
     */
    public static function namespace($classOrObject): string
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
     * @param string   $path
     * @param null|int $level
     *
     * @return null|string
     */
    public static function pathDirname(string $path, int $level = null): string
    {
        return static::getInstance()->pathDirname($path, $level);
    }

    /**
     * @param string      $path
     * @param null|string $suffix
     * @param null|int    $level
     *
     * @return null|string
     */
    public static function pathBasename(string $path, string $suffix = null, int $level = null): string
    {
        return static::getInstance()->pathBasename($path, $suffix, $level);
    }

    /**
     * @param string|object $classOrObject
     * @param string|null   $base
     *
     * @return string
     */
    public static function pathRelative($classOrObject, string $base = null): ?string
    {
        return static::getInstance()->pathRelative($classOrObject, $base);
    }

    /**
     * @param string $filepath
     * @param array  $data
     *
     * @return mixed
     * @noinspection PhpIncludeInspection
     */
    public static function include(string $filepath, array $data = [])
    {
        return static::getInstance()->include($filepath, $data);
    }

    /**
     * @param string $filepath
     * @param array  $data
     *
     * @return mixed
     * @noinspection PhpIncludeInspection
     */
    public static function includeOnce(string $filepath, array $data = [])
    {
        return static::getInstance()->includeOnce($filepath, $data);
    }

    /**
     * @param string $filepath
     * @param array  $data
     *
     * @return mixed
     * @noinspection PhpIncludeInspection
     */
    public static function require(string $filepath, array $data = [])
    {
        return static::getInstance()->require($filepath, $data);
    }

    /**
     * @param string $filepath
     * @param array  $data
     *
     * @return mixed
     * @noinspection PhpIncludeInspection
     */
    public static function requireOnce(string $filepath, array $data = [])
    {
        return static::getInstance()->requireOnce($filepath, $data);
    }

    /**
     * @param callable $filter
     * @param null|int $limit
     * @param null|int $offset
     *
     * @return array
     */
    public static function searchDeclaredClass(callable $filter, int $limit = null, int $offset = null): array
    {
        return static::getInstance()->searchDeclaredClass($filter, $limit, $offset);
    }

    /**
     * @return Loader
     */
    abstract public static function getInstance(): Loader;
}
