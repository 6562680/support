<?php

/**
 * This file is auto-generated.
 *
 * * @noinspection PhpUnhandledExceptionInspection
 * * @noinspection PhpDocMissingThrowsInspection
 */

namespace Gzhegow\Support\Facades\Generated;

use Gzhegow\Support\Fs as _Fs;

abstract class Fs
{
    /**
     * @return bool
     */
    public static function isWindows() : bool
    {
        return static::getInstance()->isWindows();
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isSplFile($value) : bool
    {
        return static::getInstance()->isSplFile($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isFile($value) : bool
    {
        return static::getInstance()->isFile($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isDir($value) : bool
    {
        return static::getInstance()->isDir($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isSplFilePath($value) : bool
    {
        return static::getInstance()->isSplFilePath($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isFilePath($value) : bool
    {
        return static::getInstance()->isFilePath($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isDirPath($value) : bool
    {
        return static::getInstance()->isDirPath($value);
    }

    /**
     * @param      $filepathA
     * @param      $filepathB
     * @param bool $unsafe
     *
     * @return bool
     */
    public static function isDiffFiles($filepathA, $filepathB, bool $unsafe = false) : bool
    {
        return static::getInstance()->isDiffFiles($filepathA, $filepathB, $unsafe);
    }

    /**
     * @param resource $resourceA
     * @param resource $resourceB
     * @param bool     $close
     *
     * @return bool
     */
    public static function isDiffResources($resourceA, $resourceB, bool $close = true) : bool
    {
        return static::getInstance()->isDiffResources($resourceA, $resourceB, $close);
    }

    /**
     * @param mixed $value
     *
     * @return null|\SplFileInfo
     */
    public static function filterSplFile($value) : ?\SplFileInfo
    {
        return static::getInstance()->filterSplFile($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|\SplFileInfo
     */
    public static function filterFile($value) : ?\SplFileInfo
    {
        return static::getInstance()->filterFile($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|\SplFileInfo
     */
    public static function filterDir($value) : ?\SplFileInfo
    {
        return static::getInstance()->filterDir($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|\SplFileInfo
     */
    public static function filterSplFilePath($value) : ?\SplFileInfo
    {
        return static::getInstance()->filterSplFilePath($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|\SplFileInfo
     */
    public static function filterFilePath($value) : ?\SplFileInfo
    {
        return static::getInstance()->filterFilePath($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|\SplFileInfo
     */
    public static function filterDirPath($value) : ?\SplFileInfo
    {
        return static::getInstance()->filterDirPath($value);
    }

    /**
     * @param string $pathname
     * @param string $separator
     * @param string ...$replacements
     *
     * @return string
     */
    public static function optimize(string $pathname, string $separator = '/', string ...$replacements) : string
    {
        return static::getInstance()->optimize($pathname, $separator, ...$replacements);
    }

    /**
     * @param string $pathname
     *
     * @return string
     */
    public static function normalize(string $pathname) : string
    {
        return static::getInstance()->normalize($pathname);
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public static function realpath(string $path) : string
    {
        return static::getInstance()->realpath($path);
    }

    /**
     * @param string      $path
     * @param string|null $base
     *
     * @return string
     */
    public static function basepath(string $path, string $base = null) : ?string
    {
        return static::getInstance()->basepath($path, $base);
    }

    /**
     * заменяет все наклонные черты на текущий DS и распознает DRIVE с поддержкой homedir
     *
     * @param string ...$path
     *
     * @return string
     */
    public static function resolve(string ...$path) : string
    {
        return static::getInstance()->resolve(...$path);
    }

    /**
     * ospath
     * нормализует путь и возвращает массив [ drive, relpath ] где drive это 'C:\', 'C:/', '\\', '/', '' или '~',
     *
     * @param string $path
     *
     * @return array
     */
    public static function ospath(string $path = '') : array
    {
        return static::getInstance()->ospath($path);
    }

    /**
     * @param string   $pathname
     * @param null|int $mode
     * @param bool     $recursive
     * @param null     $context
     *
     * @return string
     */
    public static function mkdir(string $pathname, int $mode = null, bool $recursive = true, $context = null) : string
    {
        return static::getInstance()->mkdir($pathname, $mode, $recursive, $context);
    }

    /**
     * @param string        $dir
     * @param bool          $self
     * @param null|\Closure $keepFunc
     *
     * @return bool
     */
    public static function rmdir(string $dir, bool $self = false, \Closure $keepFunc = null) : bool
    {
        return static::getInstance()->rmdir($dir, $self, $keepFunc);
    }

    /**
     * @param string $filename
     * @param bool   $use_include_path
     * @param null   $context
     * @param int    $offset
     * @param null   $length
     *
     * @return null|string
     */
    public static function fileGet(
        string $filename,
        bool $use_include_path = false,
        $context = null,
        $offset = 0,
        $length = null
    ) : ?string
    {
        return static::getInstance()->fileGet($filename, $use_include_path, $context, $offset, $length);
    }

    /**
     * @param string $filename
     * @param        $data
     * @param int    $flags
     * @param null   $context
     *
     * @return null|string
     */
    public static function filePut(string $filename, $data, int $flags = 0, $context = null) : ?string
    {
        return static::getInstance()->filePut($filename, $data, $flags, $context);
    }

    /**
     * @param string $file
     *
     * @return array
     */
    public static function fileOwner(string $file) : array
    {
        return static::getInstance()->fileOwner($file);
    }

    /**
     * @param string $file
     *
     * @return string
     */
    public static function filePerms(string $file) : string
    {
        return static::getInstance()->filePerms($file);
    }

    /**
     * size_convert
     * конвертирует текстовое представление размера файла в число
     *
     * @param string $string
     *
     * @return float
     */
    public static function size(string $string) : float
    {
        return static::getInstance()->size($string);
    }

    /**
     * size_format
     * конвертирует размер файла в читабельный вид (1024 => 1Mb)
     *
     * @param string $filesize
     *
     * @return string
     */
    public static function sizeFormat(string $filesize) : string
    {
        return static::getInstance()->sizeFormat($filesize);
    }


    /**
     * @return _Fs
     */
    abstract public static function getInstance() : _Fs;
}
