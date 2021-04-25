<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * Fs
 */
class Fs
{
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
     * @param string $pathname
     * @param int    $mode
     * @param bool   $recursive
     * @param null   $context
     *
     * @return string
     */
    public function mkdir(string $pathname, int $mode = 0755, bool $recursive = true, $context = null) : string
    {
        if (! is_dir($pathname)) {
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
    public function fileGet(string $filename, bool $use_include_path = false, $context = null, $offset = 0,
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
     * @noinspection PhpComposerExtensionStubsInspection
     *
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
            $group = posix_getgrgid($stat[ 5 ]);
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
}
