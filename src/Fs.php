<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * Fs
 */
class Fs
{
    // nginx/fpm on linux expects correct user/group rights
    const RWX = 0775;


    /**
     * @var Filter
     */
    protected $filter;
    /**
     * @var Str
     */
    protected $str;


    /**
     * Constructor
     *
     * @param Filter $filter
     * @param Str    $str
     */
    public function __construct(
        Filter $filter,
        Str $str
    )
    {
        $this->filter = $filter;
        $this->str = $str;
    }


    /**
     * @return bool
     */
    public function isWindows() : bool
    {
        return strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
    }


    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isSplFile($value) : bool
    {
        return $this->isSplFilePath($value)
            || ( null !== $this->filter->filterFileInfo($value) );
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isFile($value) : bool
    {
        return $this->isFilePath($value)
            || ( ( null !== ( $spl = $this->filter->filterFileInfo($value) ) )
                && ! $spl->isDir()
            );
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isDir($value) : bool
    {
        return $this->isDirPath($value)
            || ( ( null !== ( $spl = $this->filter->filterFileInfo($value) ) )
                && $spl->isDir()
            );
    }


    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isSplFilePath($value) : bool
    {
        return ( null !== $this->filter->filterTheString($value) )
            && file_exists($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isFilePath($value) : bool
    {
        return ( null !== $this->filter->filterTheString($value) )
            && is_file($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isDirPath($value) : bool
    {
        return ( null !== $this->filter->filterTheString($value) )
            && is_dir($value);
    }


    /**
     * @param      $filepathA
     * @param      $filepathB
     * @param bool $unsafe
     *
     * @return bool
     */
    public function isDiffFiles($filepathA, $filepathB, bool $unsafe = false) : bool
    {
        if ($unsafe) {
            $result = is_file($filepathA) - is_file($filepathB);

        } else {
            if (! is_file($filepathA)) {
                throw new RuntimeException('File not found: ' . $filepathA);
            }

            if (! is_file($filepathB)) {
                throw new RuntimeException('File not found: ' . $filepathB);
            }

            $result = true;
        }

        if ($result) {
            if (filesize($filepathA) != filesize($filepathB)) {
                $result = false;

            } else {
                $result = $this->isDiffResources(
                    fopen($filepathA, 'r'),
                    fopen($filepathB, 'r')
                );
            }
        }

        return $result;
    }

    /**
     * @param resource $resourceA
     * @param resource $resourceB
     * @param bool     $close
     *
     * @return bool
     */
    public function isDiffResources($resourceA, $resourceB, bool $close = true) : bool
    {
        $result = true;

        if (! ( 1
            && is_resource($resourceA)
            && ( 'resource (closed)' !== gettype($resourceA) )
            && ( ! feof($resourceA) )
        )) {
            throw new RuntimeException('ResourceA should be opened readable resource', $resourceA);
        }

        if (! ( 1
            && is_resource($resourceB)
            && ( 'resource (closed)' !== gettype($resourceB) )
            && ( ! feof($resourceB) )
        )) {
            throw new RuntimeException('ResourceB should be opened readable resource', $resourceB);
        }

        while ( ( $bytesA = fread($resourceA, 4096) ) !== false ) {
            $bytesB = fread($resourceB, 4096);
            if ($bytesA !== $bytesB) {
                $result = false;
                break;
            }
        }

        if ($close) {
            fclose($resourceA);
            fclose($resourceB);
        }

        return $result;
    }


    /**
     * @param mixed $value
     *
     * @return null|\SplFileInfo
     */
    public function filterSplFile($value) : ?\SplFileInfo
    {
        $spl = null;

        if (0
            || ( null !== ( $spl = $this->filterSplFile($value) ) )
            || ( null !== ( $spl = $this->filter->filterFileInfo($value) ) )
        ) {
            return $spl;
        }

        return null;
    }

    /**
     * @param mixed $value
     *
     * @return null|\SplFileInfo
     */
    public function filterFile($value) : ?\SplFileInfo
    {
        $spl = null;

        if (0
            || ( null !== ( $spl = $this->filterFile($value) ) )
            || ( ( null !== ( $spl = $this->filter->filterFileInfo($value) ) )
                && ! $spl->isDir()
            )
        ) {
            return $spl;
        }

        return null;
    }

    /**
     * @param mixed $value
     *
     * @return null|\SplFileInfo
     */
    public function filterDir($value) : ?\SplFileInfo
    {
        $spl = null;

        if (0
            || ( null !== ( $spl = $this->filterDir($value) ) )
            || ( ( null !== ( $spl = $this->filter->filterFileInfo($value) ) )
                && $spl->isDir()
            )
        ) {
            return $spl;
        }

        return null;
    }

    /**
     * @param mixed $value
     *
     * @return null|\SplFileInfo
     */
    public function filterSplFilePath($value) : ?\SplFileInfo
    {
        return ( $this->isSplFilePath($value) && ( $spl = new \SplFileInfo($value) ) )
            ? $spl
            : null;
    }

    /**
     * @param mixed $value
     *
     * @return null|\SplFileInfo
     */
    public function filterFilePath($value) : ?\SplFileInfo
    {
        return ( $this->isFilePath($value) && ( $spl = new \SplFileInfo($value) ) )
            ? $spl
            : null;
    }

    /**
     * @param mixed $value
     *
     * @return null|\SplFileInfo
     */
    public function filterDirPath($value) : ?\SplFileInfo
    {
        return ( $this->isDirPath($value) && ( $spl = new \SplFileInfo($value) ) )
            ? $spl
            : null;
    }


    /**
     * @param string $pathname
     * @param string $separator
     * @param string ...$replacements
     *
     * @return string
     */
    public function optimize(string $pathname, string $separator = '/', string ...$replacements) : string
    {
        if ('' === $pathname) {
            return '';
        }

        $optimized = str_replace($separator, "\0", $pathname);

        $search = array_merge([ '/', '\\', DIRECTORY_SEPARATOR ], ...$replacements);
        $optimized = str_replace($search,
            $separator,
            $optimized
        );

        if (false !== strpos($pathname, $separator . $separator)) {
            $optimized = preg_replace('~' . preg_quote($separator, '/') . '{2,}~', $separator,
                $optimized
            );
        }

        $optimized = str_replace("\0", $separator, $optimized);

        return $optimized;
    }

    /**
     * @param string $pathname
     *
     * @return string
     */
    public function normalize(string $pathname) : string
    {
        return $this->optimize($pathname, DIRECTORY_SEPARATOR);
    }


    /**
     * @param string $path
     *
     * @return string
     */
    public function realpath(string $path) : string
    {
        if (false === ( $result = realpath($path) )) {
            throw new InvalidArgumentException('Indexer not exists: ' . $path);
        }

        return $result;
    }

    /**
     * @param string      $path
     * @param string|null $base
     *
     * @return string
     */
    public function basepath(string $path, string $base = null) : ?string
    {
        $currentPath = $this->normalize($path);
        $basePath = $this->normalize($base);

        if (null === ( $result = $this->str->starts($currentPath, $basePath) )) {
            return null;
        }

        $result = ltrim($result, DIRECTORY_SEPARATOR);

        return $result;
    }


    /**
     * заменяет все наклонные черты на текущий DS и распознает DRIVE с поддержкой homedir
     *
     * @param string ...$path
     *
     * @return string
     */
    public function resolve(string ...$path) : string
    {
        $join = array_shift($path);

        foreach ( $path as $p ) {
            $join = rtrim($join, DIRECTORY_SEPARATOR)
                . DIRECTORY_SEPARATOR
                . ltrim($p, DIRECTORY_SEPARATOR);
        }

        [ $drive, $relpath ] = $this->ospath($join);

        $parts = [];
        foreach ( explode(DIRECTORY_SEPARATOR, $relpath) as $part ) {
            if ('.' == $part) continue;
            if ('..' == $part) {
                array_pop($parts);

            } else {
                $parts[] = $part;

            }
        }

        $result = $this->mount($drive)
            . ltrim(implode(DIRECTORY_SEPARATOR, $parts), DIRECTORY_SEPARATOR);

        if (1
            && function_exists('readlink')
            && file_exists($result)
            && is_link($result)
        ) {
            $result = readlink($result);
        }

        return $result;
    }


    /**
     * ospath
     * нормализует путь и возвращает массив [ drive, relpath ] где drive это 'C:\', 'C:/', '\\', '/', '' или '~',
     *
     * @param string $path
     *
     * @return array
     */
    public function ospath(string $path = '') : array
    {
        $path = $path
            ?: getcwd();

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
            $drive = str_replace([ '/', '\\', DIRECTORY_SEPARATOR ],
                DIRECTORY_SEPARATOR,
                mb_substr($path, 0, $pos + 2)
            );
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

        $relpath = rtrim(
            str_replace([ '/', '\\' ], DIRECTORY_SEPARATOR, $relpath),
            DIRECTORY_SEPARATOR
        );

        if (mb_substr_count($relpath, DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR)) {
            throw new InvalidArgumentException('Invalid path passed: ' . $relpath, func_get_args());
        }

        if (mb_substr_count($relpath, ':')) {
            throw new InvalidArgumentException('Invalid path passed: ' . $relpath, func_get_args());
        }

        return [ $drive, $relpath ];
    }


    /**
     * @param string   $pathname
     * @param null|int $mode
     * @param bool     $recursive
     * @param null     $context
     *
     * @return string
     */
    public function mkdir(string $pathname, int $mode = null, bool $recursive = true, $context = null) : string
    {
        if (! is_dir($pathname)) {
            $mode = $mode ?? static::RWX;

            $context
                ? mkdir($pathname, $mode, $recursive, $context)
                : mkdir($pathname, $mode, $recursive);
        }

        return realpath($pathname);
    }


    /**
     * @param string        $dir
     * @param bool          $self
     * @param null|\Closure $keepFunc
     *
     * @return bool
     */
    public function rmdir(
        string $dir,
        bool $self = false,
        \Closure $keepFunc = null
    ) : bool
    {
        /**
         * @var \SplFileInfo $splFileInfo
         */

        if (! is_dir($dir)) {
            return true;
        }

        $dir = realpath($dir);

        $dirs = [];

        $it = new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS);
        $iit = new \RecursiveIteratorIterator($it, \RecursiveIteratorIterator::CHILD_FIRST);

        foreach ( $iit as $splFileInfo ) {
            $shouldKeep = $keepFunc ? $keepFunc($splFileInfo) : false;

            $dirname = dirname($splFileInfo->getRealPath());

            $dirs[ $dirname ] = $dirs[ $dirname ]
                ?: $shouldKeep;

            if ($splFileInfo->isDir()) {
                $dirs[ $splFileInfo->getRealPath() ] =
                    $dirs[ $splFileInfo->getRealPath() ]
                        ?: $shouldKeep;
            }

            if (! $shouldKeep) {
                if ($splFileInfo->isFile()) {
                    unlink($splFileInfo->getRealPath());
                }
            }
        }

        $keepSelf = $dirs[ $dir ] ?? false;

        unset($dirs[ $dir ]);
        foreach ( $dirs as $dirPath => $shouldKeep ) {
            if (! $shouldKeep) {
                rmdir($dirPath);
            }
        }

        if ($self && ! $keepSelf) {
            rmdir($dir);
        }

        return true;
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
    public function fileGet(string $filename, bool $use_include_path = false, $context = null,
        $offset = 0,
        $length = null
    ) : ?string
    {
        if (! is_file($filename)) {
            throw new RuntimeException('File not found: ' . $filename);
        }

        if (! is_readable($filename)) {
            throw new RuntimeException('File is not readable: ' . $filename);
        }

        $result = file_get_contents($filename, $use_include_path, $context, $offset, $length);

        return ( false !== $result )
            ? $result
            : null;
    }

    /**
     * @param string $filename
     * @param        $data
     * @param int    $flags
     * @param null   $context
     *
     * @return null|string
     */
    public function filePut(string $filename, $data, int $flags = 0, $context = null) : ?string
    {
        if (! is_writable($filename)) {
            throw new RuntimeException('File is not writable: ' . $filename);
        }

        isset($context)
            ? file_put_contents($filename, $data, $flags, $context)
            : file_put_contents($filename, $data, $flags);

        $result = realpath($filename);

        return ( false !== $result )
            ? $result
            : null;
    }


    /**
     * @param string $file
     *
     * @return array
     */
    public function fileOwner(string $file) : array
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            throw new \RuntimeException('Only allowed to run on Linux');
        }

        if ('' === $file) {
            throw new InvalidArgumentException('File should be not empty');
        }

        if (! file_exists($file)) {
            throw new RuntimeException('File not found: ' . $file);
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
     * @param string $file
     *
     * @return string
     */
    public function filePerms(string $file) : string
    {
        if ('' === $file) {
            throw new InvalidArgumentException('File should be not empty');
        }

        if (! file_exists($file)) {
            throw new RuntimeException('File not found: ' . $file);
        }

        $result = substr(sprintf('%o', fileperms($file)), -4);

        return $result;
    }


    /**
     * size_convert
     * конвертирует текстовое представление размера файла в число
     *
     * @param string $string
     *
     * @return float
     */
    public function size(string $string) : float
    {
        if ('' === $string) {
            throw new InvalidArgumentException('Filesize should be not empty', func_get_args());
        }

        $number = null;
        $unit = null;
        foreach ( array_keys(static::$units) as $unit ) {
            if ($number = $this->str->ends($string, $unit)) {
                break;
            }
        }

        if (! $number) {
            throw new RuntimeException('Unable to decode unit', func_get_args());
        }

        $result = floatval($number) * 1024 * pow(10, 3 * static::$units[ $unit ]);

        return $result;
    }

    /**
     * size_format
     * конвертирует размер файла в читабельный вид (1024 => 1Mb)
     *
     * @param string $filesize
     *
     * @return string
     */
    public function sizeFormat(string $filesize) : string
    {
        if (! ( false !== filter_var($filesize, FILTER_VALIDATE_INT) )) {
            throw new InvalidArgumentException('Filesize should be int or float');
        }

        $filesize = (float) $filesize;

        $multiplier = 0;
        while ( $filesize / 1024 > 0.9 ) {
            $filesize = $filesize / 1024;
            $multiplier++;
        }

        $result = round($filesize) . array_search($multiplier, static::$units);

        return $result;
    }


    /**
     * @param string $drive
     *
     * @return string
     */
    protected function mount(string $drive) : string
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
        'B'  => 0,
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
