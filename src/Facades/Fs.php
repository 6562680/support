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
use Gzhegow\Support\Exceptions\Runtime\FilesystemException;
use Gzhegow\Support\IFs;
use Gzhegow\Support\SupportFactory;
use Gzhegow\Support\ZFs;

class Fs
{
    /**
     * @return ZFs
     */
    public static function reset()
    {
        return static::getInstance()->reset();
    }

    /**
     * @param null|string $rootPath
     * @param null|string $backupPath
     *
     * @return ZFs
     */
    public static function clone(?string $rootPath, ?string $backupPath)
    {
        return static::getInstance()->clone($rootPath, $backupPath);
    }

    /**
     * @param null|string $rootPath
     * @param null|string $backupPath
     *
     * @return ZFs
     */
    public static function with(?string $rootPath, ?string $backupPath)
    {
        return static::getInstance()->with($rootPath, $backupPath);
    }

    /**
     * @param string $absolutePath
     *
     * @return ZFs
     */
    public static function withRootPath(string $absolutePath)
    {
        return static::getInstance()->withRootPath($absolutePath);
    }

    /**
     * @param string $path
     *
     * @return ZFs
     */
    public static function withBackupPath(string $path)
    {
        return static::getInstance()->withBackupPath($path);
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
    public static function isPath($value): bool
    {
        return static::getInstance()->isPath($value);
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
    public static function isPathImage($value): bool
    {
        return static::getInstance()->isPathImage($value);
    }

    /**
     * @param string $value
     *
     * @return null|string
     */
    public static function filterPath($value): ?string
    {
        return static::getInstance()->filterPath($value);
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
     * @param array  $mimetypes
     *
     * @return null|string
     */
    public static function filterPathImage($value, $mimetypes = null): ?string
    {
        return static::getInstance()->filterPathImage($value, $mimetypes);
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
     * @return string
     */
    public static function assertPath($value): string
    {
        return static::getInstance()->assertPath($value);
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public static function assertPathFileExists($value): string
    {
        return static::getInstance()->assertPathFileExists($value);
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public static function assertPathDir($value): string
    {
        return static::getInstance()->assertPathDir($value);
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public static function assertPathLink($value): string
    {
        return static::getInstance()->assertPathLink($value);
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public static function assertPathFile($value): string
    {
        return static::getInstance()->assertPathFile($value);
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public static function assertPathImage($value): string
    {
        return static::getInstance()->assertPathImage($value);
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|string
     */
    public static function pathVal($pathOrSpl): ?string
    {
        return static::getInstance()->pathVal($pathOrSpl);
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|string
     */
    public static function pathFileExistsVal($pathOrSpl): ?string
    {
        return static::getInstance()->pathFileExistsVal($pathOrSpl);
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|string
     */
    public static function pathDirVal($pathOrSpl): ?string
    {
        return static::getInstance()->pathDirVal($pathOrSpl);
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|string
     */
    public static function pathLinkVal($pathOrSpl): ?string
    {
        return static::getInstance()->pathLinkVal($pathOrSpl);
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|string
     */
    public static function pathFileVal($pathOrSpl): ?string
    {
        return static::getInstance()->pathFileVal($pathOrSpl);
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|string
     */
    public static function pathImageVal($pathOrSpl): ?string
    {
        return static::getInstance()->pathImageVal($pathOrSpl);
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|\SplFileInfo
     */
    public static function splVal($pathOrSpl): ?\SplFileInfo
    {
        return static::getInstance()->splVal($pathOrSpl);
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|\SplFileInfo
     */
    public static function splFileExistsVal($pathOrSpl): ?\SplFileInfo
    {
        return static::getInstance()->splFileExistsVal($pathOrSpl);
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|\SplFileInfo
     */
    public static function splDirVal($pathOrSpl): ?\SplFileInfo
    {
        return static::getInstance()->splDirVal($pathOrSpl);
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|\SplFileInfo
     */
    public static function splLinkVal($pathOrSpl): ?\SplFileInfo
    {
        return static::getInstance()->splLinkVal($pathOrSpl);
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|\SplFileObject
     */
    public static function splFileVal($pathOrSpl): ?\SplFileObject
    {
        return static::getInstance()->splFileVal($pathOrSpl);
    }

    /**
     * @param \SplFileInfo|string $pathOrSpl
     *
     * @return null|\SplFileObject
     */
    public static function splImageVal($pathOrSpl): ?\SplFileObject
    {
        return static::getInstance()->splImageVal($pathOrSpl);
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return string
     */
    public static function thePathVal($pathOrSpl): string
    {
        return static::getInstance()->thePathVal($pathOrSpl);
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return string
     */
    public static function thePathFileExistsVal($pathOrSpl): string
    {
        return static::getInstance()->thePathFileExistsVal($pathOrSpl);
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return string
     */
    public static function thePathDirVal($pathOrSpl): string
    {
        return static::getInstance()->thePathDirVal($pathOrSpl);
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return string
     */
    public static function thePathLinkVal($pathOrSpl): string
    {
        return static::getInstance()->thePathLinkVal($pathOrSpl);
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return string
     */
    public static function thePathFileVal($pathOrSpl): string
    {
        return static::getInstance()->thePathFileVal($pathOrSpl);
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return string
     */
    public static function thePathImageVal($pathOrSpl): string
    {
        return static::getInstance()->thePathImageVal($pathOrSpl);
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return \SplFileInfo
     */
    public static function theSplVal($pathOrSpl): \SplFileInfo
    {
        return static::getInstance()->theSplVal($pathOrSpl);
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return \SplFileInfo
     */
    public static function theSplFileExistsVal($pathOrSpl): \SplFileInfo
    {
        return static::getInstance()->theSplFileExistsVal($pathOrSpl);
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return \SplFileInfo
     */
    public static function theSplDirVal($pathOrSpl): \SplFileInfo
    {
        return static::getInstance()->theSplDirVal($pathOrSpl);
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return \SplFileInfo
     */
    public static function theSplLinkVal($pathOrSpl): \SplFileInfo
    {
        return static::getInstance()->theSplLinkVal($pathOrSpl);
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return \SplFileObject
     */
    public static function theSplFileVal($pathOrSpl): \SplFileObject
    {
        return static::getInstance()->theSplFileVal($pathOrSpl);
    }

    /**
     * @param \SplFileInfo|string $pathOrSpl
     *
     * @return \SplFileObject
     */
    public static function theSplImageVal($pathOrSpl): \SplFileObject
    {
        return static::getInstance()->theSplImageVal($pathOrSpl);
    }

    /**
     * @return \Gzhegow\Support\IPath
     * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
     * @noinspection PhpFullyQualifiedNameUsageInspection
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
        $offset = null,
        $length = null
    ): string {
        return static::getInstance()->fileGet($file, $use_include_path, $context, $offset, $length);
    }

    /**
     * @param string    $filepath
     * @param mixed     $data
     * @param null|bool $backup
     * @param null|int  $flags
     * @param null      $context
     *
     * @return string
     */
    public static function filePut(
        string $filepath,
        $data,
        bool $backup = null,
        int $flags = null,
        $context = null
    ): string {
        return static::getInstance()->filePut($filepath, $data, $backup, $flags, $context);
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
    public static function mkdir(string $dirname, int $mode = null, bool $recursive = null, $context = null): string
    {
        return static::getInstance()->mkdir($dirname, $mode, $recursive, $context);
    }

    /**
     * @param string|\SplFileInfo $dir
     * @param null|bool|\Closure  $recursive
     *
     * @return array
     */
    public static function rmdir($dir, $recursive = null): array
    {
        return static::getInstance()->rmdir($dir, $recursive);
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
     * @return IFs
     */
    public static function getInstance(): IFs
    {
        return SupportFactory::getInstance()->getFs();
    }
}
