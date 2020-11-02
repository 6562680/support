<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;

/**
 * Class Fs
 */
class Fs
{
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
	 * @param \Closure|null $ignoreFunc
	 *
	 * @return bool
	 */
	public function rmdir(string $dir, bool $self = false, \Closure $ignoreFunc = null) : bool
	{
		/**
		 * @var \SplFileInfo $file
		 */

		if (! is_dir($dir)) {
			return true;
		}

		$dir = realpath($dir);

		$dirs = [];

		$it = new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS);
		$iit = new \RecursiveIteratorIterator($it, \RecursiveIteratorIterator::CHILD_FIRST);

		foreach ( $iit as $file ) {
			$fileDir = dirname($file->getRealPath());

			$shouldIgnore = $ignoreFunc
				? $ignoreFunc($file, $fileDir)
				: false;

			$dirs[ $fileDir ] = $dirs[ $fileDir ]
				?: $shouldIgnore;

			if ($file->isDir()) {
				$dirs[ $file->getRealPath() ] =
					$dirs[ $file->getRealPath() ]
						?: $shouldIgnore;
			}

			if (! $shouldIgnore) {
				if ($file->isFile()) {
					unlink($file->getRealPath());
				}
			}
		}


		$hasIgnoredSelf = $dirs[ $dir ] ?? false;
		unset($dirs[ $dir ]);

		foreach ( $dirs as $dirPath => $hasIgnored ) {
			if (! $hasIgnored) {
				rmdir($dirPath);
			}
		}

		if ($self && ! $hasIgnoredSelf) {
			rmdir($dir);
		}

		return true;
	}


	/**
	 * @noinspection PhpComposerExtensionStubsInspection
	 *
	 * @param string $file
	 *
	 * @return array
	 */
	public function fileowner(string $file) : array
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
	public function fileperms(string $file) : string
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
