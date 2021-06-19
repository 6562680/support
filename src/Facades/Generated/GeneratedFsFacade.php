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
use Gzhegow\Support\Fs;

abstract class GeneratedFsFacade
{
    /**
     * @param string $root
     *
     * @return Fs
     */
    public static function clone(string $root)
    {
        return static::getInstance()->clone($root);
    }

    /**
     * @return string
     */
    public static function getRoot(): string
    {
        return static::getInstance()->getRoot();
    }

    /**
     * @return bool
     */
    public static function isWindows(): bool
    {
        return static::getInstance()->isWindows();
    }

    /**
     * @return bool
     */
    public static function isNonWindows(): bool
    {
        return static::getInstance()->isNonWindows();
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    public static function isPathFileExists($value): bool
    {
        return static::getInstance()->isPathFileExists($value);
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    public static function isPathFile($value): bool
    {
        return static::getInstance()->isPathFile($value);
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    public static function isPathDir($value): bool
    {
        return static::getInstance()->isPathDir($value);
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    public static function isPathLink($value): bool
    {
        return static::getInstance()->isPathLink($value);
    }

    /**
     * @param \SplFileInfo $value
     *
     * @return bool
     */
    public static function isSplFileExists($value): bool
    {
        return static::getInstance()->isSplFileExists($value);
    }

    /**
     * @param \SplFileInfo $value
     *
     * @return bool
     */
    public static function isSplFile($value): bool
    {
        return static::getInstance()->isSplFile($value);
    }

    /**
     * @param \SplFileInfo $value
     *
     * @return bool
     */
    public static function isSplDir($value): bool
    {
        return static::getInstance()->isSplDir($value);
    }

    /**
     * @param \SplFileInfo $value
     *
     * @return bool
     */
    public static function isSplLink($value): bool
    {
        return static::getInstance()->isSplLink($value);
    }

    /**
     * @param string $value
     *
     * @return null|string
     */
    public static function filterPathFileExists($value): ?string
    {
        return static::getInstance()->filterPathFileExists($value);
    }

    /**
     * @param string $value
     *
     * @return null|string
     */
    public static function filterPathFile($value): ?string
    {
        return static::getInstance()->filterPathFile($value);
    }

    /**
     * @param string $value
     *
     * @return null|string
     */
    public static function filterPathDir($value): ?string
    {
        return static::getInstance()->filterPathDir($value);
    }

    /**
     * @param string $value
     *
     * @return null|string
     */
    public static function filterPathLink($value): ?string
    {
        return static::getInstance()->filterPathLink($value);
    }

    /**
     * @param \SplFileInfo $value
     *
     * @return null|\SplFileInfo
     */
    public static function filterSplFileExists($value): ?\SplFileInfo
    {
        return static::getInstance()->filterSplFileExists($value);
    }

    /**
     * @param \SplFileInfo $value
     *
     * @return null|\SplFileInfo
     */
    public static function filterSplFile($value): ?\SplFileInfo
    {
        return static::getInstance()->filterSplFile($value);
    }

    /**
     * @param \SplFileInfo $value
     *
     * @return null|\SplFileInfo
     */
    public static function filterSplDir($value): ?\SplFileInfo
    {
        return static::getInstance()->filterSplDir($value);
    }

    /**
     * @param \SplFileInfo $value
     *
     * @return null|\SplFileInfo
     */
    public static function filterSplLink($value): ?\SplFileInfo
    {
        return static::getInstance()->filterSplLink($value);
    }

    /**
     * @return bool
     */
    public static function assertWindows(): bool
    {
        return static::getInstance()->assertWindows();
    }

    /**
     * @return bool
     */
    public static function assertNonWindows(): bool
    {
        return static::getInstance()->assertNonWindows();
    }

    /**
     * @param string $value
     *
     * @return null|string
     */
    public static function assertPathFileExists($value): ?string
    {
        return static::getInstance()->assertPathFileExists($value);
    }

    /**
     * @param string $value
     *
     * @return null|string
     */
    public static function assertPathFile($value): ?string
    {
        return static::getInstance()->assertPathFile($value);
    }

    /**
     * @param string $value
     *
     * @return null|string
     */
    public static function assertPathDir($value): ?string
    {
        return static::getInstance()->assertPathDir($value);
    }

    /**
     * @param string $value
     *
     * @return null|string
     */
    public static function assertPathLink($value): ?string
    {
        return static::getInstance()->assertPathLink($value);
    }

    /**
     * @param \SplFileInfo $value
     *
     * @return null|\SplFileInfo
     */
    public static function assertSplFileExists($value): ?\SplFileInfo
    {
        return static::getInstance()->assertSplFileExists($value);
    }

    /**
     * @param \SplFileInfo $value
     *
     * @return null|\SplFileInfo
     */
    public static function assertSplFile($value): ?\SplFileInfo
    {
        return static::getInstance()->assertSplFile($value);
    }

    /**
     * @param \SplFileInfo $value
     *
     * @return null|\SplFileInfo
     */
    public static function assertSplDir($value): ?\SplFileInfo
    {
        return static::getInstance()->assertSplDir($value);
    }

    /**
     * @param \SplFileInfo $value
     *
     * @return null|\SplFileInfo
     */
    public static function assertSplLink($value): ?\SplFileInfo
    {
        return static::getInstance()->assertSplLink($value);
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|string
     */
    public static function pathvalFileExists($pathOrSpl): ?string
    {
        return static::getInstance()->pathvalFileExists($pathOrSpl);
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|string
     */
    public static function pathvalFile($pathOrSpl): ?string
    {
        return static::getInstance()->pathvalFile($pathOrSpl);
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|string
     */
    public static function pathvalDir($pathOrSpl): ?string
    {
        return static::getInstance()->pathvalDir($pathOrSpl);
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|string
     */
    public static function pathvalLink($pathOrSpl): ?string
    {
        return static::getInstance()->pathvalLink($pathOrSpl);
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|\SplFileInfo
     */
    public static function splvalFileExists($pathOrSpl): ?\SplFileInfo
    {
        return static::getInstance()->splvalFileExists($pathOrSpl);
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|\SplFileInfo
     */
    public static function splvalFile($pathOrSpl): ?\SplFileInfo
    {
        return static::getInstance()->splvalFile($pathOrSpl);
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|\SplFileInfo
     */
    public static function splvalDir($pathOrSpl): ?\SplFileInfo
    {
        return static::getInstance()->splvalDir($pathOrSpl);
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|\SplFileInfo
     */
    public static function splvalLink($pathOrSpl): ?\SplFileInfo
    {
        return static::getInstance()->splvalLink($pathOrSpl);
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return string
     */
    public static function thePathvalFileExists($pathOrSpl): string
    {
        return static::getInstance()->thePathvalFileExists($pathOrSpl);
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return string
     */
    public static function thePathvalFile($pathOrSpl): string
    {
        return static::getInstance()->thePathvalFile($pathOrSpl);
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return string
     */
    public static function thePathvalDir($pathOrSpl): string
    {
        return static::getInstance()->thePathvalDir($pathOrSpl);
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return string
     */
    public static function thePathvalLink($pathOrSpl): string
    {
        return static::getInstance()->thePathvalLink($pathOrSpl);
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return \SplFileInfo
     */
    public static function theSplvalFileExists($pathOrSpl): \SplFileInfo
    {
        return static::getInstance()->theSplvalFileExists($pathOrSpl);
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return \SplFileInfo
     */
    public static function theSplvalFile($pathOrSpl): \SplFileInfo
    {
        return static::getInstance()->theSplvalFile($pathOrSpl);
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return \SplFileInfo
     */
    public static function theSplvalDir($pathOrSpl): \SplFileInfo
    {
        return static::getInstance()->theSplvalDir($pathOrSpl);
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return \SplFileInfo
     */
    public static function theSplvalLink($pathOrSpl): \SplFileInfo
    {
        return static::getInstance()->theSplvalLink($pathOrSpl);
    }

    /**
     * @param string $root
     *
     * @return Fs
     */
    public static function using(string $root)
    {
        return static::getInstance()->using($root);
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
     * @param string      $value
     * @param string|null $base
     *
     * @return string
     */
    public static function secure($value, string $base = null): ?string
    {
        return static::getInstance()->secure($value, $base);
    }

    /**
     * распознает DRIVE/HOME и возвращает realpath
     *
     * @param string|string[]|array ...$parts
     *
     * @return string
     */
    public static function resolve(...$parts): string
    {
        return static::getInstance()->resolve(...$parts);
    }

    /**
     * возвращает массив [ drive, relpath ] где drive это 'C:\', 'C:/', '\\', '/', '' или '~',
     *
     * @param string $path
     *
     * @return array
     */
    public static function drive(string $path): array
    {
        return static::getInstance()->drive($path);
    }

    /**
     * @param string|\SplFileInfo $file
     * @param bool                $use_include_path
     * @param null                $context
     * @param int                 $offset
     * @param null                $length
     *
     * @return null|string
     */
    public static function fileGet(
        $file,
        bool $use_include_path = null,
        $context = null,
        $offset = 0,
        $length = null
    ): string {
        return static::getInstance()->fileGet($file, $use_include_path, $context, $offset, $length);
    }

    /**
     * @param string   $filepath
     * @param mixed    $data
     * @param null|int $flags
     * @param null     $context
     *
     * @return string
     */
    public static function filePut(string $filepath, $data, int $flags = null, $context = null): string
    {
        return static::getInstance()->filePut($filepath, $data, $flags, $context);
    }

    /**
     * @param string $file
     *
     * @return array
     */
    public static function fileOwner($file): array
    {
        return static::getInstance()->fileOwner($file);
    }

    /**
     * @param string|\SplFileInfo $file
     *
     * @return string
     */
    public static function filePerms($file): string
    {
        return static::getInstance()->filePerms($file);
    }

    /**
     * @param string   $dirname
     * @param null|int $mode
     * @param bool     $recursive
     * @param null     $context
     *
     * @return string
     */
    public static function mkdir(string $dirname, int $mode = null, bool $recursive = true, $context = null): string
    {
        return static::getInstance()->mkdir($dirname, $mode, $recursive, $context);
    }

    /**
     * @param string|\SplFileInfo $dir
     * @param bool                $removeSelf
     * @param null|\Closure       $keepFunc
     *
     * @return array
     */
    public static function rmdir($dir, bool $removeSelf = false, \Closure $keepFunc = null): array
    {
        return static::getInstance()->rmdir($dir, $removeSelf, $keepFunc);
    }

    /**
     * @param resource $readableA
     * @param resource $readableB
     * @param bool     $close
     *
     * @return bool
     */
    public static function diff($readableA, $readableB, bool $close = false): bool
    {
        return static::getInstance()->diff($readableA, $readableB, $close);
    }

    /**
     * @param string                       $contentA
     * @param string|resource|\SplFileInfo $readableB
     * @param bool                         $close
     *
     * @return bool
     */
    public static function diffContent(string $contentA, $readableB, bool $close = false): bool
    {
        return static::getInstance()->diffContent($contentA, $readableB, $close);
    }

    /**
     * @param string|\SplFileInfo          $fileA
     * @param string|resource|\SplFileInfo $readableB
     * @param bool                         $throw
     * @param bool                         $close
     *
     * @return bool
     */
    public static function diffFile($fileA, $readableB, bool $throw = false, bool $close = false): bool
    {
        return static::getInstance()->diffFile($fileA, $readableB, $throw, $close);
    }

    /**
     * @param resource                     $resourceA
     * @param string|resource|\SplFileInfo $readableB
     * @param bool                         $throw
     * @param bool                         $close
     *
     * @return bool
     */
    public static function diffResource($resourceA, $readableB, bool $throw = false, bool $close = false): bool
    {
        return static::getInstance()->diffResource($resourceA, $readableB, $throw, $close);
    }

    /**
     * @param string|\SplFileInfo|resource $readable
     * @param null|string                  $mode
     * @param bool                         $use_include_path
     * @param null                         $context
     *
     * @return null|resource
     */
    public static function readableOpen($readable, $mode, $use_include_path = false, $context = null)
    {
        return static::getInstance()->readableOpen($readable, $mode, $use_include_path, $context);
    }

    /**
     * @return Fs
     */
    abstract public static function getInstance(): Fs;
}
