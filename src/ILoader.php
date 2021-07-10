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
    public function isClassOf($value, $classes): bool;

    /**
     * @param string|object   $value
     * @param string|string[] $classes
     *
     * @return bool
     */
    public function isSubclassOf($value, $classes): bool;

    /**
     * @param object          $value
     * @param string|string[] $classes
     *
     * @return bool
     */
    public function isInstanceOf($value, $classes): bool;

    /**
     * @param string|mixed $contract
     * @param object|mixed $object
     *
     * @return bool
     */
    public function isContact($contract, $object): bool;

    /**
     * @param string|object   $value
     * @param string|string[] $classes
     *
     * @return null|string|object
     */
    public function filterClassOf($value, $classes);

    /**
     * @param string|object   $value
     * @param string|string[] $classes
     *
     * @return null|string|object
     */
    public function filterSubclassOf($value, $classes);

    /**
     * @param object          $object
     * @param string|string[] $classes
     *
     * @return null|object
     */
    public function filterInstanceOf($object, $classes): ?object;

    /**
     * @param string|mixed $contract
     * @param object|mixed $object
     *
     * @return null|object
     */
    public function filterContract($contract, $object): ?object;

    /**
     * @param string|object   $value
     * @param string|string[] ...$classes
     *
     * @return string|object
     */
    public function assertClassOf($value, $classes);

    /**
     * @param string|object   $value
     * @param string|string[] ...$classes
     *
     * @return string|object
     */
    public function assertSubclassOf($value, $classes);

    /**
     * @param object          $object
     * @param string|string[] ...$classes
     *
     * @return object
     */
    public function assertInstanceOf($object, $classes): object;

    /**
     * @param string|mixed $contract
     * @param object|mixed $object
     *
     * @return object
     */
    public function assertContract($contract, $object): object;

    /**
     * @param string|object|\ReflectionClass $classOrObject
     * @param null|bool                      $prefixed
     *
     * @return null|string
     */
    public function classVal($classOrObject, bool $prefixed = null): ?string;

    /**
     * @param string|object|\ReflectionClass $classOrObject
     * @param null|bool                      $prefixed
     *
     * @return string
     */
    public function theClassVal($classOrObject, bool $prefixed = null): string;

    /**
     * @param object|\ReflectionClass $object
     * @param null|bool               $prefixed
     *
     * @return null|string
     */
    public function objectClassVal($object, bool $prefixed = null): ?string;

    /**
     * @param object|\ReflectionClass $object
     * @param null|bool               $prefixed
     *
     * @return string
     */
    public function theObjectClassVal($object, bool $prefixed = null): string;

    /**
     * @param string|object|\ReflectionClass $classOrObject
     * @param string|object|\ReflectionClass $declaredClassOrObject
     * @param null|bool                      $prefixed
     *
     * @return null|string
     */
    public function useClassVal($classOrObject, $declaredClassOrObject, bool $prefixed = null): ?string;

    /**
     * @param string|object|\ReflectionClass $classOrObject
     * @param string|object|\ReflectionClass $declaredClassOrObject
     * @param null|bool                      $prefixed
     *
     * @return null|string
     */
    public function theUseClassVal($classOrObject, $declaredClassOrObject, bool $prefixed = null): string;

    /**
     * @param string|object $classOrObject
     *
     * @return string[]
     */
    public function nsClass($classOrObject): array;

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
     * @param string|object $classOrObject
     * @param string|null   $base
     *
     * @return string
     */
    public function pathRelative($classOrObject, string $base = null): ?string;

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
