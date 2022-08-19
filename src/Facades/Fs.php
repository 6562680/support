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
use Gzhegow\Support\Traits\Load\CliLoadTrait;
use Gzhegow\Support\Traits\Load\PathLoadTrait;
use Gzhegow\Support\Traits\Load\StrLoadTrait;
use Gzhegow\Support\XFs;

class Fs
{
    /**
     * @param null|string $realpath
     *
     * @return XFs
     */
    public static function withRootPath(?string $realpath)
    {
        return static::getInstance()->withRootPath($realpath);
    }

    /**
     * @param null|string $realpath
     *
     * @return XFs
     */
    public static function withBackupPath(?string $realpath)
    {
        return static::getInstance()->withBackupPath($realpath);
    }

    /**
     * @param null|string $realpath
     *
     * @return XFs
     */
    public static function withBackupPathBase(?string $realpath)
    {
        return static::getInstance()->withBackupPathBase($realpath);
    }

    /**
     * @return string
     */
    public static function loadRootPath(): string
    {
        return static::getInstance()->loadRootPath();
    }

    /**
     * @return string
     */
    public static function getRootPath(): string
    {
        return static::getInstance()->getRootPath();
    }

    /**
     * @param string $value
     *
     * @return null|string
     */
    public static function filterFilename($value): ?string
    {
        return static::getInstance()->filterFilename($value);
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
     * @param resource|mixed $h
     *
     * @return null|resource
     */
    public static function filterResource($h)
    {
        return static::getInstance()->filterResource($h);
    }

    /**
     * @param resource|mixed $h
     *
     * @return null|resource
     */
    public static function filterResourceOpened($h)
    {
        return static::getInstance()->filterResourceOpened($h);
    }

    /**
     * @param resource|mixed $h
     *
     * @return null|resource
     */
    public static function filterResourceClosed($h)
    {
        return static::getInstance()->filterResourceClosed($h);
    }

    /**
     * @param resource|mixed $h
     *
     * @return null|resource
     */
    public static function filterResourceReadable($h)
    {
        return static::getInstance()->filterResourceReadable($h);
    }

    /**
     * @param resource|mixed $h
     *
     * @return null|resource
     */
    public static function filterResourceWritable($h)
    {
        return static::getInstance()->filterResourceWritable($h);
    }

    /**
     * @param \SplFileInfo|mixed $value
     *
     * @return null|\SplFileInfo
     */
    public static function filterFileInfo($value): ?\SplFileInfo
    {
        return static::getInstance()->filterFileInfo($value);
    }

    /**
     * @param \SplFileObject|mixed $value
     *
     * @return null|\SplFileObject
     */
    public static function filterFileObject($value): ?\SplFileObject
    {
        return static::getInstance()->filterFileObject($value);
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|string
     */
    public static function filenameVal($pathOrSpl): ?string
    {
        return static::getInstance()->filenameVal($pathOrSpl);
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
    public static function theFilenameVal($pathOrSpl): string
    {
        return static::getInstance()->theFilenameVal($pathOrSpl);
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
     * @param string|\SplFileInfo      $dir
     * @param null|bool|\Closure|array $keepers
     * @param null|bool                $recursive
     *
     * @return array
     */
    public static function rmdir($dir, $keepers = null, bool $recursive = null): array
    {
        return static::getInstance()->rmdir($dir, $keepers, $recursive);
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
