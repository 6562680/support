<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\Fs;

Class FsTest extends AbstractTestCase
{
	public function testRmdir()
	{
		$fs = new Fs();

		$protected[] = $filesDir = __DIR__ . '/../storage/fs/rmdir';

		$protected[] = $filesDir . '/app';
		$removed[] = $filesDir . '/logs';

		$files = [
			$protected[] = $filesDir . '/app/logs/log.txt',
			$protected[] = $filesDir . '/app/logs/file.html',
			$removed[] = $filesDir . '/logs/log.txt',

			$protected[] = $filesDir . '/file.html',
			$removed[] = $filesDir . '/log.txt',
		];

		foreach ( $files as $file ) {
			if (! is_dir($dir = dirname($file))) {
				mkdir($dir, 0755, true);
			}

			touch($file);
		}

		$fs->rmdir($filesDir, true, function (\SplFileInfo $file) use ($filesDir) {
			$shouldIgnore = ( 0
				|| ( 0 === mb_stripos($file->getRealPath(), realpath($filesDir . DIRECTORY_SEPARATOR . 'app')) )
				|| ( $file->getBasename() === 'file.html' )
			);

			return $shouldIgnore;
		});

		foreach ( $protected as $file ) {
			static::assertFileExists($file);
		}

		foreach ( $removed as $file ) {
			static::assertFileDoesNotExist($file);
		}

		$fs->rmdir($filesDir, true);
	}
}