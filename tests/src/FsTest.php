<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\Fs;
use Gzhegow\Support\Filter;


class FsTest extends AbstractTestCase
{
    protected function getFilter() : Filter
    {
        return new Filter();
    }

    protected function getFs() : Fs
    {
        return new Fs(
            $this->getFilter()
        );
    }


    public function testRmdir()
    {
        $fs = $this->getFs();

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
