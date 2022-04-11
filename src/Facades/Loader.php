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
use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\ILoader;
use Gzhegow\Support\SupportFactory;
use Gzhegow\Support\ZLoader;

class Loader
{
    /**
     * @return ZLoader
     */
    public static function reset()
    {
        return static::getInstance()->reset();
    }

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
     * @param string       $contract
     * @param string|array $classes
     *
     * @return ZLoader
     */
    public static function setContract(string $contract, ...$classes)
    {
        return static::getInstance()->setContract($contract, ...$classes);
    }

    /**
     * @param string       $contract
     * @param string|array $classes
     *
     * @return ZLoader
     */
    public static function addContract(string $contract, ...$classes)
    {
        return static::getInstance()->addContract($contract, ...$classes);
    }

    /**
     * @param object|\ReflectionClass $object
     * @param null|bool               $root
     *
     * @return null|string
     */
    public static function objectClassVal($object, bool $root = null): ?string
    {
        return static::getInstance()->objectClassVal($object, $root);
    }

    /**
     * @param object|\ReflectionClass $object
     * @param null|bool               $root
     *
     * @return null|string
     */
    public static function objectClassOnlyVal($object, bool $root = null): ?string
    {
        return static::getInstance()->objectClassOnlyVal($object, $root);
    }

    /**
     * @param object|\ReflectionClass $object
     * @param null|bool               $root
     *
     * @return null|string
     */
    public static function objectInterfaceOnlyVal($object, bool $root = null): ?string
    {
        return static::getInstance()->objectInterfaceOnlyVal($object, $root);
    }

    /**
     * @param object|\ReflectionClass $object
     * @param null|bool               $root
     *
     * @return null|string
     */
    public static function objectTraitOnlyVal($object, bool $root = null): ?string
    {
        return static::getInstance()->objectTraitOnlyVal($object, $root);
    }

    /**
     * @param object|\ReflectionClass $object
     * @param null|bool               $root
     *
     * @return string
     */
    public static function theObjectClassVal($object, bool $root = null): string
    {
        return static::getInstance()->theObjectClassVal($object, $root);
    }

    /**
     * @param object|\ReflectionClass $object
     * @param null|bool               $root
     *
     * @return string
     */
    public static function theObjectClassOnlyVal($object, bool $root = null): string
    {
        return static::getInstance()->theObjectClassOnlyVal($object, $root);
    }

    /**
     * @param object|\ReflectionClass $object
     * @param null|bool               $root
     *
     * @return string
     */
    public static function theObjectInterfaceOnlyVal($object, bool $root = null): string
    {
        return static::getInstance()->theObjectInterfaceOnlyVal($object, $root);
    }

    /**
     * @param object|\ReflectionClass $object
     * @param null|bool               $root
     *
     * @return string
     */
    public static function theObjectTraitOnlyVal($object, bool $root = null): string
    {
        return static::getInstance()->theObjectTraitOnlyVal($object, $root);
    }

    /**
     * @param string|object|\ReflectionClass $classOrObject
     * @param null|bool                      $root
     *
     * @return null|string
     */
    public static function classVal($classOrObject, bool $root = null): ?string
    {
        return static::getInstance()->classVal($classOrObject, $root);
    }

    /**
     * @param string|object|\ReflectionClass $classOrObject
     * @param null|bool                      $root
     *
     * @return null|string
     */
    public static function classFullnameVal($classOrObject, bool $root = null): ?string
    {
        return static::getInstance()->classFullnameVal($classOrObject, $root);
    }

    /**
     * @param string|object|\ReflectionClass $classOrObject
     * @param null|bool                      $root
     *
     * @return string
     */
    public static function theClassVal($classOrObject, bool $root = null): string
    {
        return static::getInstance()->theClassVal($classOrObject, $root);
    }

    /**
     * @param string|object|\ReflectionClass $classOrObject
     * @param null|bool                      $root
     *
     * @return string
     */
    public static function theClassFullnameVal($classOrObject, bool $root = null): string
    {
        return static::getInstance()->theClassFullnameVal($classOrObject, $root);
    }

    /**
     * @param string|object|\ReflectionClass $classOrObject
     * @param null|bool                      $root
     *
     * @return null|string
     */
    public static function classOnlyVal($classOrObject, bool $root = null): ?string
    {
        return static::getInstance()->classOnlyVal($classOrObject, $root);
    }

    /**
     * @param string|object|\ReflectionClass $classOrObject
     * @param null|bool                      $root
     *
     * @return null|string
     */
    public static function interfaceOnlyVal($classOrObject, bool $root = null): ?string
    {
        return static::getInstance()->interfaceOnlyVal($classOrObject, $root);
    }

    /**
     * @param string|object|\ReflectionClass $classOrObject
     * @param null|bool                      $root
     *
     * @return null|string
     */
    public static function traitOnlyVal($classOrObject, bool $root = null): ?string
    {
        return static::getInstance()->traitOnlyVal($classOrObject, $root);
    }

    /**
     * @param string|object|\ReflectionClass $classOrObject
     * @param null|bool                      $root
     *
     * @return string
     */
    public static function theClassOnlyVal($classOrObject, bool $root = null): string
    {
        return static::getInstance()->theClassOnlyVal($classOrObject, $root);
    }

    /**
     * @param string|object|\ReflectionClass $classOrObject
     * @param null|bool                      $root
     *
     * @return string
     */
    public static function theInterfaceOnlyVal($classOrObject, bool $root = null): string
    {
        return static::getInstance()->theInterfaceOnlyVal($classOrObject, $root);
    }

    /**
     * @param string|object|\ReflectionClass $classOrObject
     * @param null|bool                      $root
     *
     * @return string
     */
    public static function theTraitOnlyVal($classOrObject, bool $root = null): string
    {
        return static::getInstance()->theTraitOnlyVal($classOrObject, $root);
    }

    /**
     * Получает имя класса из списка `use` для указанного `declaredClass`
     *
     * @param string|object|\ReflectionClass $classOrObject
     * @param string|object|\ReflectionClass $declaredClassOrObject
     * @param null|bool                      $root
     *
     * @return null|string
     */
    public static function useClassVal($classOrObject, $declaredClassOrObject, bool $root = null): ?string
    {
        return static::getInstance()->useClassVal($classOrObject, $declaredClassOrObject, $root);
    }

    /**
     * @param string|object|\ReflectionClass $classOrObject
     * @param string|object|\ReflectionClass $declaredClassOrObject
     * @param null|bool                      $root
     *
     * @return null|string
     */
    public static function theUseClassVal($classOrObject, $declaredClassOrObject, bool $root = null): string
    {
        return static::getInstance()->theUseClassVal($classOrObject, $declaredClassOrObject, $root);
    }

    /**
     * @param string|object   $value
     * @param string|string[] $classes
     *
     * @return bool
     */
    public static function isClassOneOf($value, $classes): bool
    {
        return static::getInstance()->isClassOneOf($value, $classes);
    }

    /**
     * @param string|object   $value
     * @param string|string[] $classes
     *
     * @return bool
     */
    public static function isSubclassOneOf($value, $classes): bool
    {
        return static::getInstance()->isSubclassOneOf($value, $classes);
    }

    /**
     * @param object          $value
     * @param string|string[] $classes
     *
     * @return bool
     */
    public static function isInstanceOneOf($value, $classes): bool
    {
        return static::getInstance()->isInstanceOneOf($value, $classes);
    }

    /**
     * @param string|mixed $object
     * @param object|mixed $contract
     *
     * @return bool
     */
    public static function isContract($object, $contract): bool
    {
        return static::getInstance()->isContract($object, $contract);
    }

    /**
     * @param string|object   $value
     * @param string|string[] $classes
     *
     * @return null|string|object
     */
    public static function filterClassOneOf($value, $classes)
    {
        return static::getInstance()->filterClassOneOf($value, $classes);
    }

    /**
     * @param string|object   $value
     * @param string|string[] $classes
     *
     * @return null|string|object
     */
    public static function filterSubclassOneOf($value, $classes)
    {
        return static::getInstance()->filterSubclassOneOf($value, $classes);
    }

    /**
     * @param object          $object
     * @param string|string[] $classes
     *
     * @return null|object
     */
    public static function filterInstanceOneOf($object, $classes): ?object
    {
        return static::getInstance()->filterInstanceOneOf($object, $classes);
    }

    /**
     * @param object|mixed $object
     * @param string|mixed $contract
     *
     * @return null|object
     */
    public static function filterContract($object, $contract): ?object
    {
        return static::getInstance()->filterContract($object, $contract);
    }

    /**
     * @param string|object   $value
     * @param string|string[] ...$classes
     *
     * @return string|object
     */
    public static function assertClassOneOf($value, $classes)
    {
        return static::getInstance()->assertClassOneOf($value, $classes);
    }

    /**
     * @param string|object   $value
     * @param string|string[] ...$classes
     *
     * @return string|object
     */
    public static function assertSubclassOneOf($value, $classes)
    {
        return static::getInstance()->assertSubclassOneOf($value, $classes);
    }

    /**
     * @param object          $object
     * @param string|string[] ...$classes
     *
     * @return object
     */
    public static function assertInstanceOneOf($object, $classes): object
    {
        return static::getInstance()->assertInstanceOneOf($object, $classes);
    }

    /**
     * @param object|mixed $object
     * @param string|mixed $contract
     *
     * @return object
     */
    public static function assertContract($object, $contract): object
    {
        return static::getInstance()->assertContract($object, $contract);
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
     * @param string|object $classOrObject
     * @param null|bool     $recursive
     *
     * @return array
     */
    public static function classTraits($classOrObject, bool $recursive = null): ?array
    {
        return static::getInstance()->classTraits($classOrObject, $recursive);
    }

    /**
     * @param string    $traitFullname
     * @param null|bool $recursive
     *
     * @return array
     */
    public static function traitTraits($traitFullname, bool $recursive = null): ?array
    {
        return static::getInstance()->traitTraits($traitFullname, $recursive);
    }

    /**
     * @param string|object $classOrObject
     *
     * @return string[]
     */
    public static function namespaceClass($classOrObject): array
    {
        return static::getInstance()->namespaceClass($classOrObject);
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
     * @return \Gzhegow\Support\IPath
     * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
     */
    public static function path(): \Gzhegow\Support\IPath
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
     * @param string      $path
     * @param string|null $base
     *
     * @return string
     */
    public static function pathRelative(string $path, string $base = null): ?string
    {
        return static::getInstance()->pathRelative($path, $base);
    }

    /**
     * @param string $filepath
     * @param array  $data
     *
     * @return mixed
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
     * @return ILoader
     */
    public static function getInstance(): ILoader
    {
        return SupportFactory::getInstance()->getLoader();
    }
}
