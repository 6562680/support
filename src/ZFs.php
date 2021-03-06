<?php
/**
 * @noinspection RedundantSuppression
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Exceptions\Runtime\FilesystemException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * ZFs
 */
class ZFs implements IFs
{
    const FREAD_SIZE = 4096;

    // nginx/fpm on linux expects correct user/group rights
    const RWX_DIR  = 0775;
    const RWX_FILE = 0664;


    /**
     * @var IFilter
     */
    protected $filter;
    /**
     * @var IPhp
     */
    protected $php;


    /**
     * @var IPath
     */
    protected $path;


    /**
     * @var string
     */
    protected $rootPath = '';

    /**
     * @var string
     */
    protected $backupPath;
    /**
     * @var string
     */
    protected $backupPathBase;


    /**
     * Constructor
     *
     * @param IFilter $filter
     * @param IPhp    $php
     */
    public function __construct(
        IFilter $filter,
        IPhp $php
    )
    {
        $this->filter = $filter;
        $this->php = $php;

        $this->reset();
    }


    /**
     * @return static
     */
    public function reset()
    {
        $this->rootPath = '';

        $this->backupPath = null;
        $this->backupPathBase = null;

        return $this;
    }


    /**
     * @param null|string $rootPath
     * @param null|string $backupPath
     * @param null|string $backupPathBase
     *
     * @return static
     */
    public function clone(?string $rootPath, ?string $backupPath, ?string $backupPathBase)
    {
        $instance = clone $this;

        if (isset($rootPath)) $instance->withRootPath($rootPath);
        if (isset($backupPath)) $instance->withBackupPath($backupPath);
        if (isset($backupPathBase)) $instance->withBackupPathBase($backupPathBase);

        return $instance;
    }


    /**
     * @param null|string $rootPath
     * @param null|string $backupPath
     * @param null|string $backupPathBase
     *
     * @return static
     */
    public function with(?string $rootPath, ?string $backupPath, ?string $backupPathBase)
    {
        $this->reset();

        if (isset($rootPath)) $this->withRootPath($rootPath);
        if (isset($backupPath)) $this->withBackupPath($backupPath);
        if (isset($backupPathBase)) $this->withBackupPathBase($backupPath);

        return $this;
    }


    /**
     * @param string $realpath
     *
     * @return static
     */
    public function withRootPath(string $realpath)
    {
        $realpath = $this->thePathDirVal($realpath);

        $this->rootPath = $realpath;

        return $this;
    }


    /**
     * @param string $realpath
     *
     * @return static
     */
    public function withBackupPath(string $realpath)
    {
        $this->backupPath = $this->thePathDirVal($realpath);

        return $this;
    }

    /**
     * @param string $realpath
     *
     * @return static
     */
    public function withBackupPathBase(string $realpath)
    {
        $this->backupPathBase = $this->thePathDirVal($realpath);

        return $this;
    }


    /**
     * @return string
     */
    public function getRoot() : string
    {
        return $this->rootPath;
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
    public function isPath($value) : bool
    {
        return null !== $this->filterPath($value);
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
    public function isPathImage($value) : bool
    {
        return null !== $this->filterPathImage($value);
    }


    /**
     * @param string $value
     *
     * @return null|string
     */
    public function filterPath($value) : ?string
    {
        if (null === $this->filter->filterWord($value)) {
            return null;
        }

        if (false === ctype_print($value)) {
            return null;
        }

        if ($this->isWindows()) {
            $regex = preg_quote(self::getForbiddenSymbolsFilenameWindows(), '/');

            $test = implode('', $this->pathSplit($value));
            if (preg_match('/[' . $regex . ']/', $test)) {
                return null;
            }
        }

        return $value;
    }

    /**
     * @param string $value
     *
     * @return null|string
     */
    public function filterPathFileExists($value) : ?string
    {
        if (null === $this->filterPath($value)) {
            return null;
        }

        if (! file_exists($value)) {
            return null;
        }

        return $value;
    }

    /**
     * @param string $value
     *
     * @return null|string
     */
    public function filterPathDir($value) : ?string
    {
        if (null === $this->filterPath($value)) {
            return null;
        }

        if (! is_dir($value)) {
            return null;
        }

        return $value;
    }

    /**
     * @param string $value
     *
     * @return null|string
     */
    public function filterPathLink($value) : ?string
    {
        if (null === $this->filterPath($value)) {
            return null;
        }

        if (! is_link($value)) {
            return null;
        }

        return $value;
    }

    /**
     * @param string $value
     *
     * @return null|string
     */
    public function filterPathFile($value) : ?string
    {
        if (null === $this->filterPath($value)) {
            return null;
        }

        if (! is_file($value)) {
            return null;
        }

        return $value;
    }

    /**
     * @param string $value
     * @param array  $mimetypes
     *
     * @return null|string
     */
    public function filterPathImage($value, $mimetypes = null) : ?string
    {
        if (null === $this->filterPath($value)) {
            return null;
        }

        if (! is_file($value)) {
            return null;
        }

        if (function_exists($func = 'exif_imagetype')) {
            if (! $func($value)) {
                return null;
            }

        } else {
            $mimetypes = ( is_array($mimetypes) )
                ? $mimetypes
                : [ $mimetypes ];
            $mimetypes = array_filter($mimetypes, 'strlen');
            $mimetypes = $mimetypes ?: static::getMimeTypesImage();

            $h = finfo_open(FILEINFO_MIME_TYPE);
            $finfoMime = finfo_file($h, $value);
            finfo_close($h);

            if (! in_array($finfoMime, $mimetypes)) {
                return null;
            }
        }

        return $value;
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
     * @return string
     */
    public function assertPath($value) : string
    {
        if (null === $this->filterPath($value)) {
            throw new InvalidArgumentException(
                [ 'Invalid path: %s', $this->secure($value) ]
            );
        }

        return $value;
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function assertPathFileExists($value) : string
    {
        if (null === $this->filterPathFileExists($value)) {
            throw new InvalidArgumentException(
                [ 'Invalid path or file/dir/link not found: %s', $this->secure($value) ]
            );
        }

        return $value;
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function assertPathDir($value) : string
    {
        if (null === $this->filterPathDir($value)) {
            throw new InvalidArgumentException(
                [ 'Invalid path or dir not found: %s', $this->secure($value) ]
            );
        }

        return $value;
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function assertPathLink($value) : string
    {
        if (null === $this->filterPathLink($value)) {
            throw new InvalidArgumentException(
                [ 'Invalid path or link not found: %s', $this->secure($value) ]
            );
        }

        return $value;
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function assertPathFile($value) : string
    {
        if (null === $this->filterPathFile($value)) {
            throw new InvalidArgumentException(
                [ 'Invalid path or file not found: %s', $this->secure($value) ]
            );
        }

        return $value;
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function assertPathImage($value) : string
    {
        if (null === $this->filterPathImage($value)) {
            throw new InvalidArgumentException(
                [ 'Invalid path or image not found: %s', $this->secure($value) ]
            );
        }

        return $value;
    }


    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|string
     */
    public function pathVal($pathOrSpl) : ?string
    {
        if (null !== ( $spl = $this->filter->filterFileInfo($pathOrSpl) )) {
            return $spl->getPathname();
        }

        if (null !== $this->filterPath($pathOrSpl)) {
            return $pathOrSpl;
        }

        return null;
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|string
     */
    public function pathFileExistsVal($pathOrSpl) : ?string
    {
        if (null !== ( $spl = $this->filter->filterFileInfo($pathOrSpl) )) {
            if (false !== ( $realpath = $spl->getRealPath() )) {
                return $realpath;
            }
        }

        if (null !== ( $spl = $this->filter->filterFileObject($pathOrSpl) )) {
            return $spl->getRealPath();
        }

        if (null !== $this->filterPathFileExists($pathOrSpl)) {
            return realpath($pathOrSpl);
        }

        return null;
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|string
     */
    public function pathDirVal($pathOrSpl) : ?string
    {
        if (null !== ( $spl = $this->filter->filterFileInfo($pathOrSpl) )) {
            if ($spl->isDir()) {
                return $spl->getRealPath();
            }
        }

        if (null !== ( $spl = $this->filter->filterFileObject($pathOrSpl) )) {
            if ($spl->isDir()) {
                return $spl->getRealPath();
            }
        }

        if (null !== $this->filterPathDir($pathOrSpl)) {
            return realpath($pathOrSpl);
        }

        return null;
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|string
     */
    public function pathLinkVal($pathOrSpl) : ?string
    {
        if (null !== ( $spl = $this->filter->filterFileInfo($pathOrSpl) )) {
            if ($spl->isLink()) {
                return $spl->getRealPath();
            }
        }

        if (null !== ( $spl = $this->filter->filterFileObject($pathOrSpl) )) {
            if ($spl->isLink()) {
                return $spl->getRealPath();
            }
        }

        if (null !== $this->filterPathLink($pathOrSpl)) {
            return realpath($pathOrSpl);
        }

        return null;
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|string
     */
    public function pathFileVal($pathOrSpl) : ?string
    {
        if (null !== ( $spl = $this->filter->filterFileInfo($pathOrSpl) )) {
            if ($spl->isFile()) {
                return $spl->getRealPath();
            }
        }

        if (null !== ( $spl = $this->filter->filterFileObject($pathOrSpl) )) {
            if ($spl->isFile()) {
                return $spl->getRealPath();
            }
        }

        if (null !== $this->filterPathFile($pathOrSpl)) {
            return realpath($pathOrSpl);
        }

        return null;
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|string
     */
    public function pathImageVal($pathOrSpl) : ?string
    {
        if (null !== ( $spl = $this->filter->filterFileInfo($pathOrSpl) )) {
            if ($spl->isFile() && strlen($this->filterPathImage($realpath = $spl->getRealPath()))) {
                return $realpath;
            }
        }

        if (null !== ( $spl = $this->filter->filterFileObject($pathOrSpl) )) {
            if ($spl->isFile() && strlen($this->filterPathImage($realpath = $spl->getRealPath()))) {
                return $realpath;
            }
        }

        if (null !== $this->filterPathImage($pathOrSpl)) {
            return realpath($pathOrSpl);
        }

        return null;
    }


    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|\SplFileInfo
     */
    public function splVal($pathOrSpl) : ?\SplFileInfo
    {
        if (null !== ( $spl = $this->filter->filterFileInfo($pathOrSpl) )) {
            return $spl;
        }

        if (null !== $this->filterPath($pathOrSpl)) {
            return new \SplFileInfo($pathOrSpl);
        }

        return null;
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|\SplFileInfo
     */
    public function splFileExistsVal($pathOrSpl) : ?\SplFileInfo
    {
        if (null !== ( $spl = $this->filter->filterFileInfo($pathOrSpl) )) {
            if (false !== ( $realpath = $spl->getRealPath() )) {
                return new \SplFileInfo($realpath);
            }
        }

        if (null !== ( $spl = $this->filter->filterFileObject($pathOrSpl) )) {
            return $spl;
        }

        if (null !== $this->filterPathFileExists($pathOrSpl)) {
            return new \SplFileInfo($pathOrSpl);
        }

        return null;
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|\SplFileInfo
     */
    public function splDirVal($pathOrSpl) : ?\SplFileInfo
    {
        if (null !== ( $spl = $this->filter->filterFileInfo($pathOrSpl) )) {
            if ($spl->isDir()) {
                return new \SplFileInfo($spl->getRealPath());
            }
        }

        if (null !== ( $spl = $this->filter->filterFileObject($pathOrSpl) )) {
            if ($spl->isDir()) {
                return $spl;
            }
        }

        if (null !== $this->filterPathDir($pathOrSpl)) {
            return new \SplFileInfo($pathOrSpl);
        }

        return null;
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|\SplFileInfo
     */
    public function splLinkVal($pathOrSpl) : ?\SplFileInfo
    {
        if (null !== ( $spl = $this->filter->filterFileInfo($pathOrSpl) )) {
            if ($spl->isLink()) {
                return new \SplFileInfo($spl->getRealPath());
            }
        }

        if (null !== ( $spl = $this->filter->filterFileObject($pathOrSpl) )) {
            if ($spl->isLink()) {
                return $spl;
            }
        }

        if (null !== $this->filterPathLink($pathOrSpl)) {
            return new \SplFileInfo($pathOrSpl);
        }

        return null;
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return null|\SplFileObject
     */
    public function splFileVal($pathOrSpl) : ?\SplFileObject
    {
        if (null !== ( $spl = $this->filter->filterFileInfo($pathOrSpl) )) {
            if ($spl->isFile()) {
                return new \SplFileObject($spl->getRealPath());
            }
        }

        if (null !== ( $spl = $this->filter->filterFileObject($pathOrSpl) )) {
            if ($spl->isFile()) {
                return $spl;
            }
        }

        if (null !== $this->filterPathFile($pathOrSpl)) {
            return new \SplFileObject($pathOrSpl);
        }

        return null;
    }

    /**
     * @param \SplFileInfo|string $pathOrSpl
     *
     * @return null|\SplFileObject
     */
    public function splImageVal($pathOrSpl) : ?\SplFileObject
    {
        if (null !== ( $spl = $this->filter->filterFileInfo($pathOrSpl) )) {
            if ($spl->isFile() && strlen($this->filterPathImage($realpath = $spl->getRealPath()))) {
                return new \SplFileObject($realpath);
            }
        }

        if (null !== ( $spl = $this->filter->filterFileObject($pathOrSpl) )) {
            if ($spl->isFile() && strlen($this->filterPathImage($realpath = $spl->getRealPath()))) {
                return $spl;
            }
        }

        if (null !== $this->filterPathImage($pathOrSpl)) {
            return new \SplFileObject($pathOrSpl);
        }

        return null;
    }


    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return string
     */
    public function thePathVal($pathOrSpl) : string
    {
        if (null === ( $val = $this->pathVal($pathOrSpl) )) {
            throw new InvalidArgumentException(
                [ 'Value should be convertable to path: %s', $pathOrSpl ],
            );
        }

        return $val;
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return string
     */
    public function thePathFileExistsVal($pathOrSpl) : string
    {
        if (null === ( $val = $this->pathFileExistsVal($pathOrSpl) )) {
            throw new InvalidArgumentException(
                [ 'Value should be convertable to path and file should exists: %s', $pathOrSpl ],
            );
        }

        return $val;
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return string
     */
    public function thePathDirVal($pathOrSpl) : string
    {
        if (null === ( $val = $this->pathDirVal($pathOrSpl) )) {
            throw new InvalidArgumentException(
                [ 'Value should be convertable to path and be directory: %s', $pathOrSpl ],
            );
        }

        return $val;
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return string
     */
    public function thePathLinkVal($pathOrSpl) : string
    {
        if (null === ( $val = $this->pathLinkVal($pathOrSpl) )) {
            throw new InvalidArgumentException(
                [ 'Value should be convertable to path and be symlink/hardlink: %s', $pathOrSpl ],
            );
        }

        return $val;
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return string
     */
    public function thePathFileVal($pathOrSpl) : string
    {
        if (null === ( $val = $this->pathFileVal($pathOrSpl) )) {
            throw new InvalidArgumentException(
                [ 'Value should be convertable to path and be file: %s', $pathOrSpl ],
            );
        }

        return $val;
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return string
     */
    public function thePathImageVal($pathOrSpl) : string
    {
        if (null === ( $val = $this->pathImageVal($pathOrSpl) )) {
            throw new InvalidArgumentException(
                [ 'Value should be convertable to path and be image: %s', $pathOrSpl ],
            );
        }

        return $val;
    }


    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return \SplFileInfo
     */
    public function theSplVal($pathOrSpl) : \SplFileInfo
    {
        if (null === ( $val = $this->splVal($pathOrSpl) )) {
            throw new InvalidArgumentException(
                [ 'Value should be convertable to \SplFileInfo: %s', $pathOrSpl ],
            );
        }

        return $val;
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return \SplFileInfo
     */
    public function theSplFileExistsVal($pathOrSpl) : \SplFileInfo
    {
        if (null === ( $val = $this->splFileExistsVal($pathOrSpl) )) {
            throw new InvalidArgumentException(
                [ 'Value should be convertable to \SplFileObject and file should exists: %s', $pathOrSpl ],
            );
        }

        return $val;
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return \SplFileInfo
     */
    public function theSplDirVal($pathOrSpl) : \SplFileInfo
    {
        if (null === ( $val = $this->splDirVal($pathOrSpl) )) {
            throw new InvalidArgumentException(
                [ 'Value should be convertable to \SplFileObject and be directory: %s', $pathOrSpl ],
            );
        }

        return $val;
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return \SplFileInfo
     */
    public function theSplLinkVal($pathOrSpl) : \SplFileInfo
    {
        if (null === ( $val = $this->splLinkVal($pathOrSpl) )) {
            throw new InvalidArgumentException(
                [ 'Value should be convertable to \SplFileObject and be symlink/hardlink: %s', $pathOrSpl ],
            );
        }

        return $val;
    }

    /**
     * @param string|\SplFileInfo $pathOrSpl
     *
     * @return \SplFileObject
     */
    public function theSplFileVal($pathOrSpl) : \SplFileObject
    {
        if (null === ( $val = $this->splFileVal($pathOrSpl) )) {
            throw new InvalidArgumentException(
                [ 'Value should be convertable to \SplFileObject and be file: %s', $pathOrSpl ],
            );
        }

        return $val;
    }

    /**
     * @param \SplFileInfo|string $pathOrSpl
     *
     * @return \SplFileObject
     */
    public function theSplImageVal($pathOrSpl) : \SplFileObject
    {
        if (null === ( $val = $this->splImageVal($pathOrSpl) )) {
            throw new InvalidArgumentException(
                [ 'Value should be convertable to \SplFileObject and be image: %s', $pathOrSpl ],
            );
        }

        return $val;
    }


    /**
     * @return \Gzhegow\Support\IPath
     * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
     * @noinspection PhpFullyQualifiedNameUsageInspection
     */
    public function path() : \Gzhegow\Support\IPath
    {
        if (! isset($this->path)) {
            $this->path = SupportFactory::getInstance()
                ->newPath()
                ->withSeparator(DIRECTORY_SEPARATOR)
                ->withDelimiters([ '/', '\\' ]);
        }

        return $this->path;
    }


    /**
     * @param string $path
     *
     * @return string
     */
    public function pathOptimize(string $path) : string
    {
        $result = $this->path()->optimize($path);

        return $result;
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public function pathNormalize(string $path) : string
    {
        $result = $this->path()->normalize($path);

        return $result;
    }


    /**
     * @param string|string[]|array ...$parts
     *
     * @return array
     */
    public function pathSplit(...$parts) : array
    {
        $result = $this->path()->split(...$parts);

        return $result;
    }

    /**
     * @param string|string[]|array ...$parts
     *
     * @return string
     */
    public function pathJoin(...$parts) : string
    {
        $result = $this->path()->join(...$parts);

        return $result;
    }

    /**
     * @param string|string[]|array ...$parts
     *
     * @return string
     */
    public function pathConcat(...$parts) : string
    {
        $result = $this->path()->concat(...$parts);

        return $result;
    }


    /**
     * @param string   $path
     * @param null|int $level
     *
     * @return null|string
     */
    public function pathDirname(string $path, int $level = null) : string
    {
        $result = $this->path()->dirname($path, $level);

        return $result;
    }

    /**
     * @param string      $path
     * @param null|string $suffix
     * @param null|int    $level
     *
     * @return null|string
     */
    public function pathBasename(string $path, string $suffix = null, int $level = null) : string
    {
        $result = $this->path()->basename($path, $suffix, $level);

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
        $base = $base ?? $this->rootPath;

        $result = $this->path()->relative($path, $base);

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
                [ 'Invalid path passed: %s', $this->secure($relpath) ]
            );
        }

        $drive = $this->path()->normalize($drive);
        $relpath = $this->path()->normalize($relpath);

        return [ $drive, $relpath ];
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
        $offset = null,
        $length = null
    ) : string
    {
        $offset = $offset ?? 0;

        if (null === ( $filepath = $this->pathVal($file) )) {
            throw new InvalidArgumentException(
                [ 'Invalid filepath/spl: %s', $this->secure($file) ]
            );
        }

        if (! is_file($filepath)) {
            throw new FilesystemException(
                [ 'Invalid file: %s', $this->secure($file) ]
            );
        }

        $realpath = realpath($filepath);

        if (! is_readable($realpath)) {
            throw new FilesystemException(
                [ 'File is not readable: %s', $this->secure($realpath) ]
            );
        }

        $content = null !== $length
            ? file_get_contents($realpath, $use_include_path, $context, $offset, $length)
            : file_get_contents($realpath, $use_include_path, $context, $offset);

        if (false === $content) {
            throw new RuntimeException(
                [ 'Unable to read file: %s', $this->secure($realpath) ]
            );
        }

        return $content;
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
    public function filePut(string $filepath, $data, bool $backup = null, int $flags = null, $context = null) : string
    {
        $backup = $backup ?? true;

        $backupPath = null;
        if (file_exists($filepath)) {
            $realpath = realpath($filepath);

            if (! is_writable($filepath)) {
                throw new FilesystemException(
                    [ 'File is not writable: %s', $this->secure($filepath) ]
                );
            }

            if ($backup) {
                $dirPath = dirname($realpath);

                $relativeDirPath = null
                    ?? ( strlen($this->backupPathBase) ? $this->pathRelative($dirPath, $this->backupPathBase) : null )
                    ?? '';

                $newDirpath = null
                    ?? ( ( strlen($this->backupPath) && strlen($relativeDirPath) ) ? $this->pathJoin($this->backupPath, $relativeDirPath) : null )
                    ?? ( strlen($this->backupPath) ? $this->backupPath : null )
                    ?? ( strlen($relativeDirPath) ? $this->pathJoin($dirPath, $relativeDirPath) : null )
                    ?? $dirPath;

                $this->mkdir($newDirpath);

                $backupPath = $newDirpath . DIRECTORY_SEPARATOR
                    . basename($realpath) . '.backup' . date('Ymd_His');

                rename($realpath, $backupPath);

                $backupPath = realpath($backupPath);

                chmod($backupPath, static::RWX_FILE);
            }
        }

        isset($context)
            ? file_put_contents($filepath, $data, $flags, $context)
            : file_put_contents($filepath, $data, $flags);

        $realpath = realpath($filepath);

        chmod($realpath, static::RWX_FILE);

        return $backupPath ?? $realpath;
    }


    /**
     * @param string $file
     *
     * @return array
     */
    public function fileOwner($file) : array
    {
        $this->assertNonWindows();

        if (null !== ( $filepath = $this->pathVal($file) )) {
            throw new RuntimeException(
                [ 'Invalid filepath/spl: %s', $this->secure($file) ]
            );
        }

        if (! file_exists($filepath)) {
            throw new FilesystemException(
                [ 'File not found: %s', $this->secure($file) ]
            );
        }

        $realpath = realpath($filepath);

        $result = false;

        $stat = stat($realpath);
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
        if (null !== ( $filepath = $this->pathVal($file) )) {
            throw new RuntimeException(
                [ 'Invalid filepath/spl: %s', $this->secure($file) ]
            );
        }

        if (! file_exists($filepath)) {
            throw new FilesystemException(
                [ 'File not found: %s', $this->secure($file) ]
            );
        }

        $realpath = realpath($filepath);

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
    public function mkdir(string $dirname, int $mode = null, bool $recursive = null, $context = null) : string
    {
        $mode = $mode ?? static::RWX_DIR;
        $recursive = $recursive ?? true;

        if (! is_dir($dirname)) {
            if (file_exists($dirname)) {
                throw new FilesystemException([
                    'Unable to create directory, same file exists: %s',
                    $this->secure($dirname),
                ]);
            }

            $context
                ? mkdir($dirname, $mode, $recursive, $context)
                : mkdir($dirname, $mode, $recursive);
        }

        $result = realpath($dirname);

        return $result;
    }

    /**
     * @param string|\SplFileInfo      $dir
     * @param null|bool|\Closure|array $keepers
     * @param null|bool                $recursive
     *
     * @return array
     */
    public function rmdir($dir, $keepers = null, bool $recursive = null) : array
    {
        if (null === ( $realpathSelf = $this->pathDirVal($dir) )) {
            // directory not exists
            return [];
        }

        $recursive = $recursive ?? true; // delete recursive
        $keepers = $keepers ?? false; // true means `do not delete`
        $keepers = is_array($keepers)
            ? $keepers
            : [ $keepers ];

        $report = [];

        $keepIndex = [];

        $flags = 0
            | \FilesystemIterator::SKIP_DOTS
            | \FilesystemIterator::KEY_AS_PATHNAME
            | \FilesystemIterator::CURRENT_AS_FILEINFO;

        // files
        $its[] = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($realpathSelf, $flags));
        // directories
        $its[] = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($realpathSelf, $flags),
            \RecursiveIteratorIterator::CHILD_FIRST
        );

        if (! $recursive) {
            foreach ( $its as $it ) {
                $it->setMaxDepth(0);
            }
        }

        $spl = null;
        $reducer = function (bool $carry, $keeper) use (&$spl) {
            return null
                ?? ( $keeper instanceof \Closure ? ( (bool) $keeper($spl, $carry) ) : null )
                ?? (bool) $keeper;
        };

        foreach ( $its as $it ) {
            foreach ( $it as $spl ) {
                $realpath = $spl->getRealPath();

                $keepIndex[ $realpath ] = $keepIndex[ $realpath ]
                    ?? false;

                $isKeep = $keepIndex[ $realpath ]
                    || array_reduce($keepers, $reducer, false);

                if ($isKeep) {
                    $keepIndex[ $realpathSelf ] = true;

                    $parent = $realpath;
                    while ( $parent !== $realpathSelf ) {
                        $keepIndex[ $parent ] = true;
                        $parent = dirname($parent);
                    }
                } else {
                    $report[] = $realpath;

                    $spl->isDir()
                        ? rmdir($realpath)
                        : unlink($realpath);
                }
            }
        }

        $keepIndex[ $realpathSelf ] = $keepIndex[ $realpathSelf ]
            ?? false;

        if (! $keepIndex[ $realpathSelf ]) {
            $spl = new \SplFileInfo($realpathSelf);

            $isKeep = array_reduce($keepers, $reducer, false);
            if (! $isKeep) {
                rmdir($realpathSelf);
            }
        }

        return $report;
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
            if (null !== ( $realpathB = $this->pathFileVal($readableB) )) {
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
        if (null === ( $realpathA = $this->pathFileVal($fileA) )) {
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

            if (null !== ( $realpathB = $this->pathFileVal($readableB) )) {
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

        $hA = fopen($realpathA, 'r');

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

        if (null !== ( $realpath = $this->pathFileVal($readable) )) {
            $h = $context
                ? fopen($realpath, $mode, $use_include_path, $context)
                : fopen($realpath, $mode, $use_include_path);

            return $h;
        }

        if (null !== ( $content = $this->filter->filterStringOrNum($readable) )) {
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
     * @return IFs
     */
    public static function getInstance() : IFs
    {
        return SupportFactory::getInstance()->getFs();
    }


    /**
     * @return string
     */
    protected static function getForbiddenSymbolsFilenameWindows() : string
    {
        // https://stackoverflow.com/a/31976060/2119205
        return implode('', [
            '<', // (less than)
            '>', // (greater than)
            '"', // (double quote)
            '/', // (forward slash)
            '\\', // (backslash)
            '|', // (vertical bar or pipe)
            '?', // (question mark)
            '*', // (asterisk)

            // drive separator
            // ':', // (colon - sometimes works, but is actually NTFS Alternate Data Streams)
        ]);
    }

    /**
     * @return string[]
     */
    protected static function getMimeTypesImage() : array
    {
        // https://www.thoughtco.com/mime-types-by-content-type-3469108#mntl-sc-block_1-0-23
        return [
            'bmp'  => 'image/bmp',
            'cmx'  => 'image/x-cmx',
            'cod'  => 'image/cis-cod',
            'gif'  => 'image/gif',
            'ico'  => 'image/x-icon',
            'ief'  => 'image/ief',
            'jfif' => 'image/pipeg',
            'jpe'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg'  => 'image/jpeg',
            'pbm'  => 'image/x-portable-bitmap',
            'pgm'  => 'image/x-portable-graymap',
            'pnm'  => 'image/x-portable-anymap',
            'ppm'  => 'image/x-portable-pixmap',
            'ras'  => 'image/x-cmu-raster',
            'rgb'  => 'image/x-rgb',
            'svg'  => 'image/svg+xml',
            'tif'  => 'image/tiff',
            'tiff' => 'image/tiff',
            'xbm'  => 'image/x-xbitmap',
            'xpm'  => 'image/x-xpixmap',
            'xwd'  => 'image/x-xwindowdump',
        ];
    }
}
