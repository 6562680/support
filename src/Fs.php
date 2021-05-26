<?php /** @noinspection PhpUnusedAliasInspection */

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * Fs
 */
class Fs
{
    const FREAD_SIZE = 4096;

    // nginx/fpm on linux expects correct user/group rights
    const RWX_DIR  = 0775;
    const RWX_FILE = 0664;


    /**
     * @var Filter
     */
    protected $filter;
    /**
     * @var Path
     */
    protected $path;
    /**
     * @var Php
     */
    protected $php;

    /**
     * @var string
     */
    protected $root = '';


    /**
     * Constructor
     *
     * @param Filter $filter
     * @param Path   $path
     * @param Php    $php
     */
    public function __construct(
        Filter $filter,
        Path $path,
        Php $php
    )
    {
        $this->filter = $filter;
        $this->path = $path;
        $this->php = $php;

        $path->using(DIRECTORY_SEPARATOR, '/', '\\');
    }


    /**
     * @param string $root
     *
     * @return static
     */
    public function clone(string $root)
    {
        $instance = clone $this;

        $instance->using($root);

        return $instance;
    }


    /**
     * @return string
     */
    public function getRoot() : string
    {
        return $this->root;
    }


    /**
     * @return bool
     */
    public function isWindows() : bool
    {
        return strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
    }

    /**
     * @return bool
     */
    public function isNonWindows() : bool
    {
        return false === $this->isWindows();
    }


    /**
     * @param string $value
     *
     * @return bool
     */
    public function isPathFileExists($value) : bool
    {
        return null !== $this->filterPathFileExists($value);
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    public function isPathFile($value) : bool
    {
        return null !== $this->filterPathFile($value);
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    public function isPathDir($value) : bool
    {
        return null !== $this->filterPathDir($value);
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    public function isPathLink($value) : bool
    {
        return null !== $this->filterPathLink($value);
    }


    /**
     * @param \SplFileInfo $value
     *
     * @return bool
     */
    public function isSplFileExists($value) : bool
    {
        return null !== $this->filterSplFileExists($value);
    }

    /**
     * @param \SplFileInfo $value
     *
     * @return bool
     */
    public function isSplFile($value) : bool
    {
        return null !== $this->filterSplFile($value);
    }

    /**
     * @param \SplFileInfo $value
     *
     * @return bool
     */
    public function isSplDir($value) : bool
    {
        return null !== $this->filterSplDir($value);
    }

    /**
     * @param \SplFileInfo $value
     *
     * @return bool
     */
    public function isSplLink($value) : bool
    {
        return null !== $this->filterSplLink($value);
    }


    /**
     * @param string $value
     *
     * @return null|string
     */
    public function filterPathFileExists($value) : ?string
    {
        $result = ( ( null !== $this->filter->filterTheString($value) ) && file_exists($value) )
            ? $value
            : null;

        return $result;
    }

    /**
     * @param string $value
     *
     * @return null|string
     */
    public function filterPathFile($value) : ?string
    {
        $result = ( ( null !== $this->filter->filterTheString($value) ) && is_file($value) )
            ? $value
            : null;

        return $result;
    }

    /**
     * @param string $value
     *
     * @return null|string
     */
    public function filterPathDir($value) : ?string
    {
        $result = ( ( null !== $this->filter->filterTheString($value) ) && is_dir($value) )
            ? $value
            : null;

        return $result;
    }

    /**
     * @param string $value
     *
     * @return null|string
     */
    public function filterPathLink($value) : ?string
    {
        $result = ( ( null !== $this->filter->filterTheString($value) ) && is_link($value) )
            ? $value
            : null;

        return $result;
    }


    /**
     * @param \SplFileInfo $value
     *
     * @return null|\SplFileInfo
     */
    public function filterSplFileExists($value) : ?\SplFileInfo
    {
        $result = ( null !== ( $spl = $this->filter->filterFileInfo($value) ) )
            ? $value
            : null;

        return $result;
    }

    /**
     * @param \SplFileInfo $value
     *
     * @return null|\SplFileInfo
     */
    public function filterSplFile($value) : ?\SplFileInfo
    {
        $result = ( ( null !== ( $spl = $this->filter->filterFileInfo($value) ) ) && $spl->isFile() )
            ? $value
            : null;

        return $result;
    }

    /**
     * @param \SplFileInfo $value
     *
     * @return null|\SplFileInfo
     */
    public function filterSplDir($value) : ?\SplFileInfo
    {
        $result = ( ( null !== ( $spl = $this->filter->filterFileInfo($value) ) ) && $spl->isDir() )
            ? $value
            : null;

        return $result;
    }

    /**
     * @param \SplFileInfo $value
     *
     * @return null|\SplFileInfo
     */
    public function filterSplLink($value) : ?\SplFileInfo
    {
        $result = ( ( null !== ( $spl = $this->filter->filterFileInfo($value) ) ) && $spl->isLink() )
            ? $value
            : null;

        return $result;
    }


    /**
     * @return bool
     */
    public function assertWindows() : bool
    {
        if ($this->isWindows()) {
            throw new RuntimeException('Only Windows is allowed');
        }

        return true;
    }

    /**
     * @return bool
     */
    public function assertNonWindows() : bool
    {
        if ($this->isNonWindows()) {
            throw new RuntimeException('Windows is not support this feature');
        }

        return true;
    }


    /**
     * @param string $value
     *
     * @return null|string
     */
    public function assertPathFileExists($value) : ?string
    {
        if (null === ( $result = $this->filterPathFileExists($value) )) {
            throw new InvalidArgumentException(
                [ 'Invalid path or file/dir/link not found: %s', $this->secure($value) ]
            );
        }

        return $result;
    }

    /**
     * @param string $value
     *
     * @return null|string
     */
    public function assertPathFile($value) : ?string
    {
        if (null === ( $result = $this->filterPathFile($value) )) {
            throw new InvalidArgumentException(
                [ 'Invalid path or file not found: %s', $this->secure($value) ]
            );
        }

        return $result;
    }

    /**
     * @param string $value
     *
     * @return null|string
     */
    public function assertPathDir($value) : ?string
    {
        if (null === ( $result = $this->filterPathDir($value) )) {
            throw new InvalidArgumentException(
                [ 'Invalid path or dir not found: %s', $this->secure($value) ]
            );
        }

        return $result;
    }

    /**
     * @param string $value
     *
     * @return null|string
     */
    public function assertPathLink($value) : ?string
    {
        if (null === ( $result = $this->filterPathLink($value) )) {
            throw new InvalidArgumentException(
                [ 'Invalid path or link not found: %s', $this->secure($value) ]
            );
        }

        return $result;
    }


    /**
     * @param \SplFileInfo $value
     *
     * @return null|\SplFileInfo
     */
    public function assertSplFileExists($value) : ?\SplFileInfo
    {
        if (null === ( $result = $this->filterSplFileExists($value) )) {
            throw new InvalidArgumentException(
                [ 'Invalid spl or spl is not a file/dir/link: %s', $this->secure($value) ]
            );
        }

        return $result;
    }

    /**
     * @param \SplFileInfo $value
     *
     * @return null|\SplFileInfo
     */
    public function assertSplFile($value) : ?\SplFileInfo
    {
        if (null === ( $result = $this->filterSplFile($value) )) {
            throw new InvalidArgumentException(
                [ 'Invalid spl or spl is not a file: %s', $this->secure($value) ]
            );
        }

        return $result;
    }

    /**
     * @param \SplFileInfo $value
     *
     * @return null|\SplFileInfo
     */
    public function assertSplDir($value) : ?\SplFileInfo
    {
        if (null === ( $result = $this->filterSplDir($value) )) {
            throw new InvalidArgumentException(
                [ 'Invalid spl or spl is not a dir: %s', $this->secure($value) ]
            );
        }

        return $result;
    }

    /**
     * @param \SplFileInfo $value
     *
     * @return null|\SplFileInfo
     */
    public function assertSplLink($value) : ?\SplFileInfo
    {
        if (null === ( $result = $this->filterSplLink($value) )) {
            throw new InvalidArgumentException(
                [ 'Invalid spl or spl is not a link: %s', $this->secure($value) ]
            );
        }

        return $result;
    }


    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|string
     */
    public function pathvalFileExists($pathOrSpl) : ?string
    {
        if (null !== ( $spl = $this->filterSplFileExists($pathOrSpl) )) {
            return $spl->getRealPath();
        }

        if (null !== ( $spl = $this->filterPathFileExists($pathOrSpl) )) {
            return realpath($pathOrSpl);
        }

        return null;
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|string
     */
    public function pathvalFile($pathOrSpl) : ?string
    {
        if (null !== ( $spl = $this->filterSplFile($pathOrSpl) )) {
            return $spl->getRealPath();
        }

        if (null !== ( $spl = $this->filterPathFile($pathOrSpl) )) {
            return realpath($pathOrSpl);
        }

        return null;
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|string
     */
    public function pathvalDir($pathOrSpl) : ?string
    {
        if (null !== ( $spl = $this->filterSplDir($pathOrSpl) )) {
            return $spl->getRealPath();
        }

        if (null !== ( $spl = $this->filterPathDir($pathOrSpl) )) {
            return realpath($pathOrSpl);
        }

        return null;
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|string
     */
    public function pathvalLink($pathOrSpl) : ?string
    {
        if (null !== ( $spl = $this->filterSplLink($pathOrSpl) )) {
            return $spl->getRealPath();
        }

        if (null !== ( $spl = $this->filterPathLink($pathOrSpl) )) {
            return realpath($pathOrSpl);
        }

        return null;
    }


    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|\SplFileInfo
     */
    public function splvalFileExists($pathOrSpl) : ?\SplFileInfo
    {
        if (null !== ( $spl = $this->filterSplFileExists($pathOrSpl) )) {
            return $spl;
        }

        if (null !== ( $path = $this->filterPathFileExists($pathOrSpl) )) {
            return new \SplFileInfo($path);
        }

        return null;
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|\SplFileInfo
     */
    public function splvalFile($pathOrSpl) : ?\SplFileInfo
    {
        if (null !== ( $spl = $this->filterSplFile($pathOrSpl) )) {
            return $spl;
        }

        if (null !== ( $path = $this->filterPathFile($pathOrSpl) )) {
            return new \SplFileInfo($path);
        }

        return null;
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|\SplFileInfo
     */
    public function splvalDir($pathOrSpl) : ?\SplFileInfo
    {
        if (null !== ( $spl = $this->filterSplDir($pathOrSpl) )) {
            return $spl;
        }

        if (null !== ( $path = $this->filterPathDir($pathOrSpl) )) {
            return new \SplFileInfo($path);
        }

        return null;
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|\SplFileInfo
     */
    public function splvalLink($pathOrSpl) : ?\SplFileInfo
    {
        if (null !== ( $spl = $this->filterSplLink($pathOrSpl) )) {
            return $spl;
        }

        if (null !== ( $path = $this->filterPathLink($pathOrSpl) )) {
            return new \SplFileInfo($path);
        }

        return null;
    }


    /**
     * @param string $root
     *
     * @return static
     */
    public function using(string $root)
    {
        $realpath = $this->assertPathDir($root);

        $this->root = $realpath;

        return $this;
    }


    /**
     * @return Path
     */
    public function path() : Path
    {
        return $this->path;
    }


    /**
     * @param string|string[]|array ...$parts
     *
     * @return array
     */
    public function pathSplit(...$parts) : array
    {
        $result = $this->path->split(...$parts);

        return $result;
    }

    /**
     * @param string|string[]|array ...$parts
     *
     * @return string
     */
    public function pathJoin(...$parts) : string
    {
        $result = $this->path->join(...$parts);

        return $result;
    }

    /**
     * @param string|string[]|array ...$parts
     *
     * @return string
     */
    public function pathNormalize(...$parts) : string
    {
        $result = $this->path->normalize(...$parts);

        return $result;
    }

    /**
     * @param string|string[]|array ...$parts
     *
     * @return string
     */
    public function pathConcat(...$parts) : string
    {
        $result = $this->path->concat(...$parts);

        return $result;
    }


    /**
     * @param string      $path
     * @param null|string $suffix
     * @param int         $levels
     *
     * @return null|string
     */
    public function pathDirname(string $path, int $levels = 0) : ?string
    {
        $result = $this->path->dirname($path, $levels);

        return $result;
    }

    /**
     * @param string      $path
     * @param null|string $suffix
     * @param int         $levels
     *
     * @return null|string
     */
    public function pathBasename(string $path, string $suffix = null, int $levels = 0) : ?string
    {
        $result = $this->path->basename($path, $suffix, $levels);

        return $result;
    }

    /**
     * @param string      $path
     * @param string|null $base
     *
     * @return string
     */
    public function pathRelative(string $path, string $base = null) : ?string
    {
        $base = $base ?? $this->root;

        $result = $this->path->relative($path, $base);

        return $result;
    }


    /**
     * @param string      $value
     * @param string|null $base
     *
     * @return string
     */
    public function secure($value, string $base = null) : ?string
    {
        $result = ( null !== ( $strval = $this->filter->filterStrval($value) ) )
            ? ( $this->pathRelative($strval, $base) ?? null )
            : null;

        $result = $result ?? $value;

        return $result;
    }

    /**
     * распознает DRIVE/HOME и возвращает realpath
     *
     * @param string|string[]|array ...$parts
     *
     * @return string
     */
    public function resolve(...$parts) : string
    {
        $normalized = $this->pathNormalize(...$parts);

        [ $drive, $relpath ] = $this->drive($normalized);

        $items = [];
        foreach ( explode(DIRECTORY_SEPARATOR, $relpath) as $part ) {
            if ('.' == $part) continue;
            if ('..' == $part) {
                array_pop($items);

            } else {
                $items[] = $part;
            }
        }

        $join = implode(DIRECTORY_SEPARATOR, $items);

        $result = $this->parseDrive($drive) . ltrim($join, DIRECTORY_SEPARATOR);

        if (file_exists($result)
            && is_link($result)
            && function_exists('readlink')
        ) {
            $result = readlink($result);
        }

        return $result;
    }

    /**
     * возвращает массив [ drive, relpath ] где drive это 'C:\', 'C:/', '\\', '/', '' или '~',
     *
     * @param string $path
     *
     * @return array
     */
    public function drive(string $path) : array
    {
        $path = ( '' === $path )
            ? getcwd()
            : $path;

        if ($isWindows = $this->isWindows()) {
            $path = mb_convert_encoding($path, 'utf-8', 'cp1251');
        }

        $pos = false;

        if ($isWindows
            && ( 0
                || ( false !== ( $pos = mb_strpos($path, ':/') ) )
                || ( false !== ( $pos = mb_strpos($path, ':\\') ) )
            )
        ) {
            $drive = mb_substr($path, 0, $pos + 2);
            $relpath = mb_substr($path, $pos + 2);

        } elseif ('\\\\' === mb_substr($path, 0, 2)) {
            $drive = '\\\\';
            $relpath = mb_substr($path, 2);

        } elseif (in_array($path[ 0 ], [ '/', '~' ])) {
            $drive = $path[ 0 ];
            $relpath = mb_substr($path, 1);

        } elseif ($path[ 0 ] === '.') {
            $drive = '.';
            $relpath = mb_substr($path, 1);

        } else {
            $drive = '';
            $relpath = $path;
        }

        if (mb_substr_count($relpath, ':')) {
            throw new InvalidArgumentException(
                'Invalid path passed: ' . $this->secure($relpath)
            );
        }

        $drive = $this->path->normalize($drive);
        $relpath = $this->path->normalize($relpath);

        return [ $drive, $relpath ];
    }


    /**
     * конвертирует цифру размера в читабельный формат (1024 => 1Mb)
     *
     * @param int|float|string $size
     *
     * @return string
     */
    public function sizeFormat($size) : string
    {
        if (null === ( $numval = $this->php->numval($size) )) {
            throw new InvalidArgumentException(
                [ 'Filesize should be int or float: %s', $size ]
            );
        }

        $multiplier = 0;
        while ( $numval / 1024 > 0.9 ) {
            $numval = $numval / 1024;

            $multiplier++;
        }

        $result = round($numval) . array_search($multiplier, static::$units);

        return $result;
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
    public function fileGet($file, bool $use_include_path = null, $context = null,
        $offset = 0,
        $length = null
    ) : string
    {
        if (null === ( $realpath = $this->pathvalFile($file) )) {
            throw new InvalidArgumentException(
                [ 'Invalid file: %s', $this->secure($file) ]
            );
        }

        if (! is_readable($realpath)) {
            throw new InvalidArgumentException(
                'File is not readable: ' . $this->secure($realpath)
            );
        }

        $content = null !== $length
            ? file_get_contents($realpath, $use_include_path, $context, $offset, $length)
            : file_get_contents($realpath, $use_include_path, $context, $offset);

        if (false === $content) {
            throw new RuntimeException(
                'Unable to read file: ' . $this->secure($realpath)
            );
        }

        return $content;
    }

    /**
     * @param string   $filepath
     * @param mixed    $data
     * @param null|int $flags
     * @param null     $context
     *
     * @return string
     */
    public function filePut(string $filepath, $data, int $flags = null, $context = null) : string
    {
        if (file_exists($filepath) && ! is_writable($filepath)) {
            throw new InvalidArgumentException(
                'File is not writable: ' . $this->secure($filepath)
            );
        }

        isset($context)
            ? file_put_contents($filepath, $data, $flags, $context)
            : file_put_contents($filepath, $data, $flags);

        if (false === ( $realpath = realpath($filepath) )) {
            throw new RuntimeException(
                'Unable to write file: ' . $this->secure($filepath)
            );
        }

        chmod($realpath, static::RWX_FILE);

        return $realpath;
    }


    /**
     * @param string $file
     *
     * @return array
     */
    public function fileOwner($file) : array
    {
        $this->assertNonWindows();

        if (null !== ( $realpath = $this->pathvalFileExists($file) )) {
            throw new RuntimeException(
                [ 'Invalid filepath/spl or file not found: %s', $this->secure($file) ]
            );
        }

        $result = false;

        $stat = stat($file);
        if ($stat) {
            /** @noinspection PhpComposerExtensionStubsInspection */
            $group = posix_getgrgid($stat[ 5 ]);

            /** @noinspection PhpComposerExtensionStubsInspection */
            $user = posix_getpwuid($stat[ 4 ]);

            $result = compact('user', 'group');
        }

        return $result;
    }

    /**
     * @param string|\SplFileInfo $file
     *
     * @return string
     */
    public function filePerms($file) : string
    {
        if (null !== ( $realpath = $this->pathvalFileExists($file) )) {
            throw new RuntimeException(
                [ 'Invalid filepath/spl or file not found: %s', $this->secure($file) ]
            );
        }

        $result = substr(sprintf('%o', fileperms($realpath)), -4);

        return $result;
    }


    /**
     * @param string   $dirname
     * @param null|int $mode
     * @param bool     $recursive
     * @param null     $context
     *
     * @return string
     */
    public function mkdir(string $dirname, int $mode = null, bool $recursive = true, $context = null) : string
    {
        if (! is_dir($dirname)) {
            if (file_exists($dirname)) {
                throw new RuntimeException([
                    'Unable to create directory, same file exists: ' . $this->secure($dirname),
                ]);
            }

            $mode = $mode ?? static::RWX_DIR;

            $context
                ? mkdir($dirname, $mode, $recursive, $context)
                : mkdir($dirname, $mode, $recursive);
        }

        $result = realpath($dirname);

        return $result;
    }

    /**
     * @param string|\SplFileInfo $dir
     * @param bool                $removeSelf
     * @param null|\Closure       $keepFunc
     *
     * @return array
     */
    public function rmdir($dir, bool $removeSelf = false, \Closure $keepFunc = null) : array
    {
        if (null === ( $realpath = $this->pathvalDir($dir) )) {
            return [];
        }

        $result = [];
        $keepDirs = [];

        $it = new \RecursiveDirectoryIterator($realpath, \RecursiveDirectoryIterator::SKIP_DOTS);
        $iit = new \RecursiveIteratorIterator($it, \RecursiveIteratorIterator::CHILD_FIRST);
        foreach ( $iit as $splFileInfo ) {
            /** @var \SplFileInfo $splFileInfo */

            $shouldKeep = $keepFunc ? $keepFunc($splFileInfo) : false;

            $dirname = dirname($splFileInfo->getRealPath());

            $keepDirs[ $dirname ] = $keepDirs[ $dirname ]
                ?: $shouldKeep;

            if ($splFileInfo->isDir()) {
                $keepDirs[ $splFileInfo->getRealPath() ] =
                    $keepDirs[ $splFileInfo->getRealPath() ]
                        ?: $shouldKeep;
            }

            if (! $shouldKeep) {
                if ($splFileInfo->isFile()) {
                    $result[] = $splFileInfo->getRealPath();

                    unlink($splFileInfo->getRealPath());
                }
            }
        }

        $keepSelf = $keepDirs[ $realpath ] ?? false;
        unset($keepDirs[ $realpath ]);

        foreach ( $keepDirs as $dirPath => $shouldKeep ) {
            if (! $shouldKeep) {
                $result[] = $dirPath;

                rmdir($dirPath);
            }
        }

        if ($removeSelf && ! $keepSelf) {
            $result[] = $realpath;

            rmdir($realpath);
        }

        return $result;
    }


    /**
     * @param resource $readableA
     * @param resource $readableB
     * @param bool     $close
     *
     * @return bool
     */
    public function diff($readableA, $readableB, bool $close = false) : bool
    {
        $result = true;

        if (null === ( $hA = $this->readableOpen($readableA, 'r') )) {
            throw new RuntimeException(
                [ 'ReadableA should be string/file/spl/resource: %s', $this->secure($readableA), ]
            );
        }

        if (null === ( $hB = $this->readableOpen($readableB, 'r') )) {
            throw new RuntimeException(
                [ 'ReadableB should be string/file/spl/resource: %s', $this->secure($readableB) ]
            );
        }

        do {
            $bytesA = fread($hA, static::FREAD_SIZE);
            $bytesB = fread($hB, static::FREAD_SIZE);

            if ($bytesA !== $bytesB) {
                $result = false;

                break;
            }
        } while ( false !== $bytesA );

        if ($close) {
            fclose($readableA);
            fclose($readableB);
        }

        return $result;
    }


    /**
     * @param string                       $contentA
     * @param string|resource|\SplFileInfo $readableB
     * @param bool                         $close
     *
     * @return bool
     */
    public function diffContent(string $contentA, $readableB, bool $close = false) : bool
    {
        $result = false;

        $filesizeA = mb_strlen($contentA, '8bit');

        if (! $result) {
            if (null !== ( $realpathB = $this->pathvalFile($readableB) )) {
                if ($filesizeA !== filesize($realpathB)) {
                    $result = true;
                }
            }
        }

        if (! $result) {
            if (is_string($readableB)) {
                $result = $contentA !== $readableB;
            }
        }

        if (! $result) {
            $hA = $this->readableOpen($contentA, 'r');

            $result = $this->diff($hA, $readableB, $close);

            fclose($hA);
        }

        return $result;
    }

    /**
     * @param string|\SplFileInfo          $fileA
     * @param string|resource|\SplFileInfo $readableB
     * @param bool                         $throw
     * @param bool                         $close
     *
     * @return bool
     */
    public function diffFile($fileA, $readableB, bool $throw = false, bool $close = false) : bool
    {
        if (null === ( $realpathA = $this->pathvalFile($fileA) )) {
            if (! $throw) {
                return ! is_null($readableB);

            } else {
                throw new InvalidArgumentException(
                    [ 'Invalid file or file not found: %s', $this->secure($fileA) ],
                );
            }
        }

        $result = false;

        if (! $result) {
            $filesizeA = filesize($realpathA);

            if (null !== ( $realpathB = $this->pathvalFile($readableB) )) {
                if ($filesizeA != filesize($realpathB)) {
                    $result = true;
                }
            }
        }

        if (! $result) {
            $hA = fopen($realpathA, 'r');

            $result = $this->diff($hA, $readableB, $close);

            fclose($hA);
        }

        return $result;
    }

    /**
     * @param resource                     $resourceA
     * @param string|resource|\SplFileInfo $readableB
     * @param bool                         $throw
     * @param bool                         $close
     *
     * @return bool
     */
    public function diffResource($resourceA, $readableB, bool $throw = false, bool $close = false) : bool
    {
        if (null === ( $realpathA = $this->filter->filterReadableResource($resourceA) )) {
            if (! $throw) {
                return ! is_null($readableB);

            } else {
                throw new InvalidArgumentException(
                    [ 'Invalid readable resource: %s', $this->secure($resourceA) ],
                );
            }
        }

        $hA = fopen($resourceA, 'r');

        $result = $this->diff($hA, $readableB, $close);

        fclose($hA);

        return $result;
    }


    /**
     * @param string|\SplFileInfo|resource $readable
     * @param null|string                  $mode
     * @param bool                         $use_include_path
     * @param null                         $context
     *
     * @return null|resource
     */
    public function readableOpen($readable, $mode, $use_include_path = false, $context = null) // : ?resource
    {
        if (null !== ( $h = $this->filter->filterReadableResource($readable) )) {
            $meta = stream_get_meta_data($h);

            $themode = rtrim($meta[ 'mode' ], '+');
            if ($themode !== $mode) {
                throw new InvalidArgumentException(
                    [ 'Resource is readable, but mode mismatch: %s [ %s ]', $this->secure($readable), [ $mode, $themode ] ],
                );
            }

            return $h;
        }

        if (null !== ( $realpath = $this->pathvalFile($readable) )) {
            $h = $context
                ? fopen($realpath, $mode, $use_include_path, $context)
                : fopen($realpath, $mode, $use_include_path);

            return $h;
        }

        if (null !== ( $content = $this->filter->filterStringOrNumber($readable) )) {
            $h = fopen('php://temp', 'w+');
            fwrite($h, $content);
            rewind($h);

            return $h;
        }

        return null;
    }


    /**
     * @param string $drive
     *
     * @return string
     */
    protected function parseDrive(string $drive) : string
    {
        $mount = $drive;

        switch ( $drive ) {
            case '/':
                // root
                break;

            case '\\\\':
                // lan
                break;

            case '':
            case '.':
                $mount = getcwd();
                $mount = rtrim($mount, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

                break;

            case '~':
                $mount = $_SERVER[ 'HOME' ]
                    ?? ( ''
                        . ( $_SERVER[ 'HOMEDRIVE' ] ?? '' )
                        . ( $_SERVER[ 'HOMEPATH' ] ?? '' )
                    );
                $mount = rtrim($mount, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

                break;

            default:
                // example: 'C:/'
                break;
        }

        return $mount;
    }


    /**
     * @var array
     */
    protected static $units = [
        'B' => 0,

        'Kb' => 1,
        'Mb' => 2,
        'Gb' => 3,
        'Tb' => 4,
        'Pb' => 5,
        'Eb' => 6,
        'Zb' => 7,
        'Yb' => 8,

        'K' => 1,
        'M' => 2,
        'G' => 3,
        'T' => 4,
        'P' => 5,
        'E' => 6,
        'Z' => 7,
        'Y' => 8,
    ];
}
