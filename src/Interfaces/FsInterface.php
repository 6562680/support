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
use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Fs;

interface FsInterface
{
    /**
     * @return Fs
     */
    public function reset();

    /**
     * @param string $root
     *
     * @return Fs
     */
    public function clone(string $root);

    /**
     * @param null|string $root
     *
     * @return Fs
     */
    public function with(?string $root);

    /**
     * @param string $root
     *
     * @return Fs
     */
    public function withRoot(string $root);

    /**
     * @return string
     */
    public function getRoot(): string;

    /**
     * @return bool
     */
    public function isWindows(): bool;

    /**
     * @return bool
     */
    public function isNonWindows(): bool;

    /**
     * @param string $value
     *
     * @return bool
     */
    public function isPathFileExists($value): bool;

    /**
     * @param string $value
     *
     * @return bool
     */
    public function isPathFile($value): bool;

    /**
     * @param string $value
     *
     * @return bool
     */
    public function isPathDir($value): bool;

    /**
     * @param string $value
     *
     * @return bool
     */
    public function isPathLink($value): bool;

    /**
     * @param \SplFileInfo $value
     *
     * @return bool
     */
    public function isSplFileExists($value): bool;

    /**
     * @param \SplFileInfo $value
     *
     * @return bool
     */
    public function isSplFile($value): bool;

    /**
     * @param \SplFileInfo $value
     *
     * @return bool
     */
    public function isSplDir($value): bool;

    /**
     * @param \SplFileInfo $value
     *
     * @return bool
     */
    public function isSplLink($value): bool;

    /**
     * @param string $value
     *
     * @return null|string
     */
    public function filterPathFileExists($value): ?string;

    /**
     * @param string $value
     *
     * @return null|string
     */
    public function filterPathFile($value): ?string;

    /**
     * @param string $value
     *
     * @return null|string
     */
    public function filterPathDir($value): ?string;

    /**
     * @param string $value
     *
     * @return null|string
     */
    public function filterPathLink($value): ?string;

    /**
     * @param \SplFileInfo $value
     *
     * @return null|\SplFileInfo
     */
    public function filterSplFileExists($value): ?\SplFileInfo;

    /**
     * @param \SplFileInfo $value
     *
     * @return null|\SplFileInfo
     */
    public function filterSplFile($value): ?\SplFileInfo;

    /**
     * @param \SplFileInfo $value
     *
     * @return null|\SplFileInfo
     */
    public function filterSplDir($value): ?\SplFileInfo;

    /**
     * @param \SplFileInfo $value
     *
     * @return null|\SplFileInfo
     */
    public function filterSplLink($value): ?\SplFileInfo;

    /**
     * @return bool
     */
    public function assertWindows(): bool;

    /**
     * @return bool
     */
    public function assertNonWindows(): bool;

    /**
     * @param string $value
     *
     * @return null|string
     */
    public function assertPathFileExists($value): ?string;

    /**
     * @param string $value
     *
     * @return null|string
     */
    public function assertPathFile($value): ?string;

    /**
     * @param string $value
     *
     * @return null|string
     */
    public function assertPathDir($value): ?string;

    /**
     * @param string $value
     *
     * @return null|string
     */
    public function assertPathLink($value): ?string;

    /**
     * @param \SplFileInfo $value
     *
     * @return null|\SplFileInfo
     */
    public function assertSplFileExists($value): ?\SplFileInfo;

    /**
     * @param \SplFileInfo $value
     *
     * @return null|\SplFileInfo
     */
    public function assertSplFile($value): ?\SplFileInfo;

    /**
     * @param \SplFileInfo $value
     *
     * @return null|\SplFileInfo
     */
    public function assertSplDir($value): ?\SplFileInfo;

    /**
     * @param \SplFileInfo $value
     *
     * @return null|\SplFileInfo
     */
    public function assertSplLink($value): ?\SplFileInfo;

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|string
     */
    public function pathvalFileExists($pathOrSpl): ?string;

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|string
     */
    public function pathvalFile($pathOrSpl): ?string;

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|string
     */
    public function pathvalDir($pathOrSpl): ?string;

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|string
     */
    public function pathvalLink($pathOrSpl): ?string;

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|\SplFileInfo
     */
    public function splvalFileExists($pathOrSpl): ?\SplFileInfo;

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|\SplFileInfo
     */
    public function splvalFile($pathOrSpl): ?\SplFileInfo;

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|\SplFileInfo
     */
    public function splvalDir($pathOrSpl): ?\SplFileInfo;

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|\SplFileInfo
     */
    public function splvalLink($pathOrSpl): ?\SplFileInfo;

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return string
     */
    public function thePathvalFileExists($pathOrSpl): string;

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return string
     */
    public function thePathvalFile($pathOrSpl): string;

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return string
     */
    public function thePathvalDir($pathOrSpl): string;

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return string
     */
    public function thePathvalLink($pathOrSpl): string;

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return \SplFileInfo
     */
    public function theSplvalFileExists($pathOrSpl): \SplFileInfo;

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return \SplFileInfo
     */
    public function theSplvalFile($pathOrSpl): \SplFileInfo;

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return \SplFileInfo
     */
    public function theSplvalDir($pathOrSpl): \SplFileInfo;

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return \SplFileInfo
     */
    public function theSplvalLink($pathOrSpl): \SplFileInfo;

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
     * @param string      $path
     * @param string|null $base
     *
     * @return string
     */
    public function pathRelative(string $path, string $base = null): ?string;

    /**
     * @param string      $value
     * @param string|null $base
     *
     * @return string
     */
    public function secure($value, string $base = null): ?string;

    /**
     * распознает DRIVE/HOME и возвращает realpath
     *
     * @param string|string[]|array ...$parts
     *
     * @return string
     */
    public function resolve(...$parts): string;

    /**
     * возвращает массив [ drive, relpath ] где drive это 'C:\', 'C:/', '\\', '/', '' или '~',
     *
     * @param string $path
     *
     * @return array
     */
    public function drive(string $path): array;

    /**
     * @param string|\SplFileInfo $file
     * @param bool                $use_include_path
     * @param null                $context
     * @param int                 $offset
     * @param null                $length
     *
     * @return null|string
     */
    public function fileGet($file, bool $use_include_path = null, $context = null, $offset = 0, $length = null): string;

    /**
     * @param string    $filepath
     * @param mixed     $data
     * @param null|bool $backup
     * @param null|int  $flags
     * @param null      $context
     *
     * @return string
     */
    public function filePut(string $filepath, $data, bool $backup = null, int $flags = null, $context = null): string;

    /**
     * @param string $file
     *
     * @return array
     */
    public function fileOwner($file): array;

    /**
     * @param string|\SplFileInfo $file
     *
     * @return string
     */
    public function filePerms($file): string;

    /**
     * @param string   $dirname
     * @param null|int $mode
     * @param bool     $recursive
     * @param null     $context
     *
     * @return string
     */
    public function mkdir(string $dirname, int $mode = null, bool $recursive = null, $context = null): string;

    /**
     * @param string|\SplFileInfo $dir
     * @param bool                $rmSelf
     * @param null|\Closure       $keepFilter
     *
     * @return array
     */
    public function rmdir($dir, bool $rmSelf = false, \Closure $keepFilter = null): array;

    /**
     * @param resource $readableA
     * @param resource $readableB
     * @param bool     $close
     *
     * @return bool
     */
    public function diff($readableA, $readableB, bool $close = false): bool;

    /**
     * @param string                       $contentA
     * @param string|resource|\SplFileInfo $readableB
     * @param bool                         $close
     *
     * @return bool
     */
    public function diffContent(string $contentA, $readableB, bool $close = false): bool;

    /**
     * @param string|\SplFileInfo          $fileA
     * @param string|resource|\SplFileInfo $readableB
     * @param bool                         $throw
     * @param bool                         $close
     *
     * @return bool
     */
    public function diffFile($fileA, $readableB, bool $throw = false, bool $close = false): bool;

    /**
     * @param resource                     $resourceA
     * @param string|resource|\SplFileInfo $readableB
     * @param bool                         $throw
     * @param bool                         $close
     *
     * @return bool
     */
    public function diffResource($resourceA, $readableB, bool $throw = false, bool $close = false): bool;

    /**
     * @param string|\SplFileInfo|resource $readable
     * @param null|string                  $mode
     * @param bool                         $use_include_path
     * @param null                         $context
     *
     * @return null|resource
     */
    public function readableOpen($readable, $mode, $use_include_path = false, $context = null);
}
