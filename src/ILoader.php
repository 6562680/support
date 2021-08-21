<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 * @noinspection RedundantSuppression
 */

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\LogicException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Exceptions\RuntimeException;

interface ILoader
{
    /**
     * @return ZLoader
     */
    public function reset();

    /**
     * @return array
     */
    public function getDeclaredClasses(): array;

    /**
     * @param string|object|\ReflectionClass $classOrObject
     *
     * @return array
     */
    public function getUseStatements($classOrObject): array;

    /**
     * @return array
     */
    public function getContracts(): array;

    /**
     * @param string $contract
     *
     * @return array
     */
    public function getContract(string $contract): array;

    /**
     * @param string $contract
     *
     * @return null|array
     */
    public function existsContract($contract): ?array;

    /**
     * @param string       $contract
     * @param string|array $classes
     *
     * @return ZLoader
     */
    public function setContract(string $contract, ...$classes);

    /**
     * @param string       $contract
     * @param string|array $classes
     *
     * @return ZLoader
     */
    public function addContract(string $contract, ...$classes);

    /**
     * @param string|object   $value
     * @param string|string[] $classes
     *
     * @return bool
     */
    public function isClassOneOf($value, $classes): bool;

    /**
     * @param string|object   $value
     * @param string|string[] $classes
     *
     * @return bool
     */
    public function isSubclassOneOf($value, $classes): bool;

    /**
     * @param object          $value
     * @param string|string[] $classes
     *
     * @return bool
     */
    public function isInstanceOneOf($value, $classes): bool;

    /**
     * @param string|mixed $object
     * @param object|mixed $contract
     *
     * @return bool
     */
    public function isContract($object, $contract): bool;

    /**
     * @param string|object   $value
     * @param string|string[] $classes
     *
     * @return null|string|object
     */
    public function filterClassOneOf($value, $classes);

    /**
     * @param string|object   $value
     * @param string|string[] $classes
     *
     * @return null|string|object
     */
    public function filterSubclassOneOf($value, $classes);

    /**
     * @param object          $object
     * @param string|string[] $classes
     *
     * @return null|object
     */
    public function filterInstanceOneOf($object, $classes): ?object;

    /**
     * @param object|mixed $object
     * @param string|mixed $contract
     *
     * @return null|object
     */
    public function filterContract($object, $contract): ?object;

    /**
     * @param string|object   $value
     * @param string|string[] ...$classes
     *
     * @return string|object
     */
    public function assertClassOneOf($value, $classes);

    /**
     * @param string|object   $value
     * @param string|string[] ...$classes
     *
     * @return string|object
     */
    public function assertSubclassOneOf($value, $classes);

    /**
     * @param object          $object
     * @param string|string[] ...$classes
     *
     * @return object
     */
    public function assertInstanceOneOf($object, $classes): object;

    /**
     * @param object|mixed $object
     * @param string|mixed $contract
     *
     * @return object
     */
    public function assertContract($object, $contract): object;

    /**
     * @param object|\ReflectionClass $object
     * @param null|bool               $root
     *
     * @return null|string
     */
    public function objectClassVal($object, bool $root = null): ?string;

    /**
     * @param object|\ReflectionClass $object
     * @param null|bool               $root
     *
     * @return null|string
     */
    public function objectClassOnlyVal($object, bool $root = null): ?string;

    /**
     * @param object|\ReflectionClass $object
     * @param null|bool               $root
     *
     * @return null|string
     */
    public function objectInterfaceOnlyVal($object, bool $root = null): ?string;

    /**
     * @param object|\ReflectionClass $object
     * @param null|bool               $root
     *
     * @return null|string
     */
    public function objectTraitOnlyVal($object, bool $root = null): ?string;

    /**
     * @param object|\ReflectionClass $object
     * @param null|bool               $root
     *
     * @return string
     */
    public function theObjectClassVal($object, bool $root = null): string;

    /**
     * @param object|\ReflectionClass $object
     * @param null|bool               $root
     *
     * @return string
     */
    public function theObjectClassOnlyVal($object, bool $root = null): string;

    /**
     * @param object|\ReflectionClass $object
     * @param null|bool               $root
     *
     * @return string
     */
    public function theObjectInterfaceOnlyVal($object, bool $root = null): string;

    /**
     * @param object|\ReflectionClass $object
     * @param null|bool               $root
     *
     * @return string
     */
    public function theObjectTraitOnlyVal($object, bool $root = null): string;

    /**
     * @param string|object|\ReflectionClass $classOrObject
     * @param null|bool                      $root
     *
     * @return null|string
     */
    public function classVal($classOrObject, bool $root = null): ?string;

    /**
     * @param string|object|\ReflectionClass $classOrObject
     * @param null|bool                      $root
     *
     * @return null|string
     */
    public function classFullnameVal($classOrObject, bool $root = null): ?string;

    /**
     * @param string|object|\ReflectionClass $classOrObject
     * @param null|bool                      $root
     *
     * @return string
     */
    public function theClassVal($classOrObject, bool $root = null): string;

    /**
     * @param string|object|\ReflectionClass $classOrObject
     * @param null|bool                      $root
     *
     * @return string
     */
    public function theClassFullnameVal($classOrObject, bool $root = null): string;

    /**
     * @param string|object|\ReflectionClass $classOrObject
     * @param null|bool                      $root
     *
     * @return null|string
     */
    public function classOnlyVal($classOrObject, bool $root = null): ?string;

    /**
     * @param string|object|\ReflectionClass $classOrObject
     * @param null|bool                      $root
     *
     * @return null|string
     */
    public function interfaceOnlyVal($classOrObject, bool $root = null): ?string;

    /**
     * @param string|object|\ReflectionClass $classOrObject
     * @param null|bool                      $root
     *
     * @return null|string
     */
    public function traitOnlyVal($classOrObject, bool $root = null): ?string;

    /**
     * @param string|object|\ReflectionClass $classOrObject
     * @param null|bool                      $root
     *
     * @return string
     */
    public function theClassOnlyVal($classOrObject, bool $root = null): string;

    /**
     * @param string|object|\ReflectionClass $classOrObject
     * @param null|bool                      $root
     *
     * @return string
     */
    public function theInterfaceOnlyVal($classOrObject, bool $root = null): string;

    /**
     * @param string|object|\ReflectionClass $classOrObject
     * @param null|bool                      $root
     *
     * @return string
     */
    public function theTraitOnlyVal($classOrObject, bool $root = null): string;

    /**
     * Получает имя класса из списка `use` для указанного `declaredClass`
     *
     * @param string|object|\ReflectionClass $classOrObject
     * @param string|object|\ReflectionClass $declaredClassOrObject
     * @param null|bool                      $root
     *
     * @return null|string
     */
    public function useClassVal($classOrObject, $declaredClassOrObject, bool $root = null): ?string;

    /**
     * @param string|object|\ReflectionClass $classOrObject
     * @param string|object|\ReflectionClass $declaredClassOrObject
     * @param null|bool                      $root
     *
     * @return null|string
     */
    public function theUseClassVal($classOrObject, $declaredClassOrObject, bool $root = null): string;

    /**
     * @param string|object $classOrObject
     * @param null|bool     $recursive
     *
     * @return array
     */
    public function classTraits($classOrObject, bool $recursive = null): ?array;

    /**
     * @param string    $traitFullname
     * @param null|bool $recursive
     *
     * @return array
     */
    public function traitTraits($traitFullname, bool $recursive = null): ?array;

    /**
     * @param string|object $classOrObject
     *
     * @return string[]
     */
    public function namespaceClass($classOrObject): array;

    /**
     * @param string|object $classOrObject
     *
     * @return string
     */
    public function namespace($classOrObject): string;

    /**
     * @param string|object $classOrObject
     *
     * @return string
     */
    public function className($classOrObject): string;

    /**
     * @return \Gzhegow\Support\IPath
     * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
     */
    public function path(): IPath;

    /**
     * @param string $path
     *
     * @return string
     */
    public function pathOptimize(string $path): string;

    /**
     * @param string $path
     *
     * @return string
     */
    public function pathNormalize(string $path): string;

    /**
     * @param string|string[]|array ...$parts
     *
     * @return array
     */
    public function pathSplit(...$parts): array;

    /**
     * @param string|string[]|array ...$parts
     *
     * @return string
     */
    public function pathJoin(...$parts): string;

    /**
     * @param string|string[]|array ...$parts
     *
     * @return string
     */
    public function pathConcat(...$parts): string;

    /**
     * @param string   $path
     * @param null|int $level
     *
     * @return null|string
     */
    public function pathDirname(string $path, int $level = null): string;

    /**
     * @param string      $path
     * @param null|string $suffix
     * @param null|int    $level
     *
     * @return null|string
     */
    public function pathBasename(string $path, string $suffix = null, int $level = null): string;

    /**
     * @param string      $path
     * @param string|null $base
     *
     * @return string
     */
    public function pathRelative(string $path, string $base = null): ?string;

    /**
     * @param string $filepath
     * @param array  $data
     *
     * @return mixed
     */
    public function include(string $filepath, array $data = []);

    /**
     * @param string $filepath
     * @param array  $data
     *
     * @return mixed
     */
    public function includeOnce(string $filepath, array $data = []);

    /**
     * @param string $filepath
     * @param array  $data
     *
     * @return mixed
     */
    public function require(string $filepath, array $data = []);

    /**
     * @param string $filepath
     * @param array  $data
     *
     * @return mixed
     */
    public function requireOnce(string $filepath, array $data = []);

    /**
     * @param callable $filter
     * @param null|int $limit
     * @param null|int $offset
     *
     * @return array
     */
    public function searchDeclaredClass(callable $filter, int $limit = null, int $offset = null): array;
}
