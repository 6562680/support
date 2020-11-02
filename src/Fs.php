<?php

namespace Gzhegow\Support;

/**
 * Class Fs
 */
class Fs
{
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
}
