<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support\Interfaces;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Loader;

interface LoaderInterface
{
    /**
     * @return array
     */
    public function getDeclaredClasses(): array;

    /**
     * @param object          $value
     * @param string|string[] $classes
     *
     * @return bool
     */
    public function isInstanceOf($value, $classes): bool;

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
     * @return null|object
     */
    public function filterInstanceOf($value, $classes);

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
     * @param object          $value
     * @param string|string[] ...$classes
     *
     * @return null|object
     */
    public function assertInstanceOf($value, $classes);

    /**
     * @param string|object   $value
     * @param string|string[] ...$classes
     *
     * @return null|string|object
     */
    public function assertClassOf($value, $classes);

    /**
     * @param string|object   $value
     * @param string|string[] ...$classes
     *
     * @return null|string|object
     */
    public function assertSubclassOf($value, $classes);

    /**
     * @param mixed $classOrObject
     *
     * @return null|string
     */
    public function classVal($classOrObject): ?string;

    /**
     * @param mixed $classOrObject
     *
     * @return string
     */
    public function theClassVal($classOrObject): string;

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
     * @return Path
     */
    public function path(): \Gzhegow\Support\Path;

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
     * @param string $path
     * @param int    $levels
     *
     * @return null|string
     */
    public function pathDirname(string $path, int $levels = null): string;

    /**
     * @param string      $path
     * @param null|string $suffix
     * @param int         $levels
     *
     * @return null|string
     */
    public function pathBasename(string $path, string $suffix = null, int $levels = null): string;

    /**
     * @param string|object $classOrObject
     * @param string|null   $base
     *
     * @return string
     */
    public function pathRelative($classOrObject, string $base = null): ?string;

    /**
     * @param callable $filter
     * @param null|int $limit
     * @param int      $offset
     *
     * @return array
     */
    public function searchDeclaredClass(callable $filter, int $limit = null, int $offset = null): array;
}
