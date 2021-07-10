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

interface IFs
{
    /**
     * @return ZFs
     */
    public function reset();

    /**
     * @param string $root
     *
     * @return ZFs
     */
    public function clone(string $root);

    /**
     * @param null|string $root
     *
     * @return ZFs
     */
    public function with(?string $root);

    /**
     * @param string $root
     *
     * @return ZFs
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
    public function isPath($value): bool;

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
    public function isPathDir($value): bool;

    /**
     * @param string $value
     *
     * @return bool
     */
    public function isPathLink($value): bool;

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
    public function isPathImage($value): bool;

    /**
     * @param string $value
     *
     * @return null|string
     */
    public function filterPath($value): ?string;

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
    public function filterPathDir($value): ?string;

    /**
     * @param string $value
     *
     * @return null|string
     */
    public function filterPathLink($value): ?string;

    /**
     * @param string $value
     *
     * @return null|string
     */
    public function filterPathFile($value): ?string;

    /**
     * @param string $value
     * @param array  $mimetypes
     *
     * @return null|string
     */
    public function filterPathImage($value, $mimetypes = null): ?string;

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
     * @return string
     */
    public function assertPath($value): string;

    /**
     * @param string $value
     *
     * @return string
     */
    public function assertPathFileExists($value): string;

    /**
     * @param string $value
     *
     * @return string
     */
    public function assertPathDir($value): string;

    /**
     * @param string $value
     *
     * @return string
     */
    public function assertPathLink($value): string;

    /**
     * @param string $value
     *
     * @return string
     */
    public function assertPathFile($value): string;

    /**
     * @param string $value
     *
     * @return string
     */
    public function assertPathImage($value): string;

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|string
     */
    public function pathVal($pathOrSpl): ?string;

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|string
     */
    public function pathFileExistsVal($pathOrSpl): ?string;

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|string
     */
    public function pathDirVal($pathOrSpl): ?string;

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|string
     */
    public function pathLinkVal($pathOrSpl): ?string;

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|string
     */
    public function pathFileVal($pathOrSpl): ?string;

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|string
     */
    public function pathImageVal($pathOrSpl): ?string;

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|\SplFileInfo
     */
    public function splVal($pathOrSpl): ?\SplFileInfo;

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|\SplFileInfo
     */
    public function splFileExistsVal($pathOrSpl): ?\SplFileInfo;

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|\SplFileInfo
     */
    public function splDirVal($pathOrSpl): ?\SplFileInfo;

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|\SplFileInfo
     */
    public function splLinkVal($pathOrSpl): ?\SplFileInfo;

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|\SplFileObject
     */
    public function splFileVal($pathOrSpl): ?\SplFileObject;

    /**
     * @param \SplFileInfo|string $pathOrSpl
     *
     * @return null|\SplFileObject
     */
    public function splImageVal($pathOrSpl): ?\SplFileObject;

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return string
     */
    public function thePathVal($pathOrSpl): string;

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return string
     */
    public function thePathFileExistsVal($pathOrSpl): string;

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return string
     */
    public function thePathDirVal($pathOrSpl): string;

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return string
     */
    public function thePathLinkVal($pathOrSpl): string;

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return string
     */
    public function thePathFileVal($pathOrSpl): string;

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return string
     */
    public function thePathImageVal($pathOrSpl): string;

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return \SplFileInfo
     */
    public function theSplVal($pathOrSpl): \SplFileInfo;

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return \SplFileInfo
     */
    public function theSplFileExistsVal($pathOrSpl): \SplFileInfo;

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return \SplFileInfo
     */
    public function theSplDirVal($pathOrSpl): \SplFileInfo;

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return \SplFileInfo
     */
    public function theSplLinkVal($pathOrSpl): \SplFileInfo;

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return \SplFileObject
     */
    public function theSplFileVal($pathOrSpl): \SplFileObject;

    /**
     * @param \SplFileInfo|string $pathOrSpl
     *
     * @return \SplFileObject
     */
    public function theSplImageVal($pathOrSpl): \SplFileObject;

    /**
     * @return \Gzhegow\Support\IPath
     * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
     * @noinspection PhpFullyQualifiedNameUsageInspection
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
    public function fileGet(
        $file,
        bool $use_include_path = null,
        $context = null,
        $offset = null,
        $length = null
    ): string;

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
