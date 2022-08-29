<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\ICli;
use Gzhegow\Support\XCli;


class CliTest extends AbstractTestCase
{
    protected function getCli() : ICli
    {
        return XCli::getInstance();
    }


    public function testMkdir()
    {
        $cli = $this->getCli();


        $directory = __DIR__ . '/../storage/cli/mkdir';
        if (is_dir($directory)) rmdir($directory);

        $this->assertDirectoryDoesNotExist($directory);

        $cli->mkdir($directory, null, true);

        $this->assertDirectoryExists($directory);


        rmdir($directory);
    }

    public function testRmdir()
    {
        $cli = $this->getCli();


        $directory = __DIR__ . '/../storage/cli/rmdir';
        if (! is_dir($directory)) mkdir($directory);

        $this->assertDirectoryExists($directory);

        $cli->rmdir($directory);

        $this->assertDirectoryDoesNotExist($directory);


        $directory = __DIR__ . '/../storage/cli/rmdir';
        if (! is_dir($directory)) mkdir($directory);

        file_put_contents($directory . '/1.txt', __CLASS__);
        file_put_contents($directory . '/2.txt', __CLASS__);
        file_put_contents($directory . '/3.txt', __CLASS__);

        $this->assertDirectoryExists($directory);

        $cli->rmdir($directory, true);

        $this->assertDirectoryDoesNotExist($directory);


        if (is_dir($directory)) rmdir($directory);
    }


    public function testJunctionSymlink()
    {
        $cli = $this->getCli();


        $dir = __DIR__ . '/../storage/cli/symlink';
        if (is_dir($dir)) $cli->rmdir($dir, true);


        $dirJunction = __DIR__ . '/../storage/cli/symlink/1';
        $dirSymlink = __DIR__ . '/../storage/cli/symlink/2';
        $file = __DIR__ . '/../storage/cli/symlink/1.txt';
        if (! is_dir($dirJunction)) mkdir($dirJunction, 0775, true);
        if (! is_dir($dirSymlink)) mkdir($dirSymlink, 0775, true);
        if (! is_file($file)) file_put_contents($file, __METHOD__);

        $resultJunction = $cli->junction($dirJunction, $linkJunction = dirname($dirJunction) . '/1_link');
        $resultSymlink = $cli->symlink($dirSymlink, $linkSymlink = dirname($dirSymlink) . '/2_link');
        $resultFile = $cli->symlink($file, $linkFile = dirname($file) . '/1.txt_link');

        if ($cli->isWindows()) {
            if (! $resultJunction) $this->assertTrue(is_dir($linkJunction));
            if (! $resultSymlink) $this->assertTrue(is_dir($linkSymlink));
            if (! $resultFile) $this->assertTrue(is_file($linkFile));

        } else {
            if (! $resultJunction) $this->assertTrue(is_link($linkJunction));
            if (! $resultSymlink) $this->assertTrue(is_link($linkSymlink));
            if (! $resultFile) $this->assertTrue(is_link($linkFile));
        }

        if (! $resultJunction) $this->assertEquals(readlink($linkJunction), realpath($dirJunction));
        if (! $resultSymlink) $this->assertEquals(readlink($linkSymlink), realpath($dirSymlink));
        if (! $resultFile) $this->assertEquals(readlink($linkFile), realpath($file));


        $cli->rmdir($dir, true);
    }


    public function testFilePut()
    {
        $cli = $this->getCli();

        $directory = __DIR__ . '/../storage/cli/filePut';
        mkdir($directory);

        $file = $directory . '/1.txt';

        $noninteractive = 'yy';

        $realpath = $cli->filePut($file, __CLASS__, true, $noninteractive);
        $this->assertFileExists($realpath);

        $backupPath = $cli->filePut($file, __CLASS__, true, $noninteractive);
        $this->assertNotEquals($realpath, $backupPath);
        $this->assertFileExists($backupPath);

        unlink($realpath);
        unlink($backupPath);

        rmdir($directory);
    }


    public function testZipUnzip()
    {
        $cli = $this->getCli();


        $directory = __DIR__ . '/../storage/cli/zip';
        $cli->rmdir($directory, true);
        mkdir($directory, 0775, true);


        if (! is_dir($directorySrc = $directory . '/src')) mkdir($directorySrc, 0775, true);
        if (! is_dir($directoryDest = $directory . '/dest')) mkdir($directoryDest, 0775, true);
        if (! is_dir($directoryDestAbsolute = $directoryDest . '/absolute')) mkdir($directoryDestAbsolute, 0775, true);
        if (! is_dir($directoryDestRelative = $directoryDest . '/relative')) mkdir($directoryDestRelative, 0775, true);

        if (! is_dir($directory1 = $directorySrc . '/1/1')) mkdir($directory1, 0775, true);
        if (! is_dir($directory2 = $directorySrc . '/2/1')) mkdir($directory2, 0775, true);
        if (! is_dir($directory3 = $directorySrc . '/3')) mkdir($directory3, 0775, true);
        if (! is_dir($directory1A = $directory1 . '/a')) mkdir($directory1A, 0775, true);
        if (! is_dir($directory1B = $directory1A . '/b')) mkdir($directory1B, 0775, true);
        if (! is_dir($directory1C = $directory1B . '/c')) mkdir($directory1C, 0775, true);
        if (! is_dir($directory2A = $directory2 . '/a')) mkdir($directory2A, 0775, true);
        if (! is_dir($directory2B = $directory2A . '/b')) mkdir($directory2B, 0775, true);
        if (! is_dir($directory2C = $directory2B . '/c')) mkdir($directory2C, 0775, true);

        $i = 0;

        file_put_contents($directory1A . '/a1.txt', str_repeat('0', ++$i));
        file_put_contents($directory1A . '/a2.txt', str_repeat('0', ++$i));
        file_put_contents($directory1B . '/b1.txt', str_repeat('0', ++$i));
        file_put_contents($directory1B . '/b2.txt', str_repeat('0', ++$i));
        file_put_contents($directory1C . '/c1.txt', str_repeat('0', ++$i));
        file_put_contents($directory1C . '/c2.txt', str_repeat('0', ++$i));

        file_put_contents($directory2A . '/a1.txt', str_repeat('0', ++$i));
        file_put_contents($directory2A . '/a2.txt', str_repeat('0', ++$i));
        file_put_contents($directory2B . '/b1.txt', str_repeat('0', ++$i));
        file_put_contents($directory2B . '/b2.txt', str_repeat('0', ++$i));
        file_put_contents($directory2C . '/c1.txt', str_repeat('0', ++$i));
        file_put_contents($directory2C . '/c2.txt', str_repeat('0', ++$i));


        $fileAbsolute = $directoryDest . '/absolute.zip';
        $fileRelative = $directoryDest . '/relative.zip';
        $this->assertFileDoesNotExist($fileAbsolute);
        $this->assertFileDoesNotExist($fileRelative);

        $cli->zip($fileAbsolute, null, $directory1, $directory2);
        $cli->zip($fileRelative, $directorySrc, $directory1, $directory2);

        $this->assertFileExists($fileAbsolute);
        $this->assertFileExists($fileRelative);


        $fh = fopen($fileAbsolute, 'r');
        $bytes = fread($fh, 4);
        fclose($fh);
        $this->assertEquals('504b0304', bin2hex($bytes));

        $fh = fopen($fileRelative, 'r');
        $bytes = fread($fh, 4);
        fclose($fh);
        $this->assertEquals('504b0304', bin2hex($bytes));


        $cli->unzip($fileAbsolute, $directoryDestAbsolute);
        $cli->unzip($fileRelative, $directoryDestRelative);


        $itSrc = new \RecursiveDirectoryIterator($directorySrc,
            \FilesystemIterator::KEY_AS_PATHNAME
            | \FilesystemIterator::CURRENT_AS_FILEINFO
            | \FilesystemIterator::SKIP_DOTS
        );
        $iitSrc = new \RecursiveIteratorIterator($itSrc);
        $realpathSrc = realpath($directorySrc);

        $itDestAbsolute = new \RecursiveDirectoryIterator($directoryDestAbsolute,
            \FilesystemIterator::KEY_AS_PATHNAME
            | \FilesystemIterator::CURRENT_AS_FILEINFO
            | \FilesystemIterator::SKIP_DOTS
        );
        $iitDestAbsolute = new \RecursiveIteratorIterator($itDestAbsolute);

        $itDestRelative = new \RecursiveDirectoryIterator($directoryDestRelative,
            \FilesystemIterator::KEY_AS_PATHNAME
            | \FilesystemIterator::CURRENT_AS_FILEINFO
            | \FilesystemIterator::SKIP_DOTS
        );
        $iitDestRelative = new \RecursiveIteratorIterator($itDestRelative);
        $realpathDestRelative = realpath($directoryDestRelative);


        $filesSrc = [];
        foreach ( $iitSrc as $spl ) {
            if (! $spl->isFile()) continue;
            $filesSrc[ $spl->getRealpath() ] = $spl->getSize();
        }

        $filesDestAbsolute = [];
        foreach ( $iitDestAbsolute as $spl ) {
            if (! $spl->isFile()) continue;
            $filesDestAbsolute[ $spl->getRealpath() ] = $spl->getSize();
        }

        $filesDestRelative = [];
        foreach ( $iitDestRelative as $spl ) {
            if (! $spl->isFile()) continue;
            $filesDestRelative[ $spl->getRealpath() ] = $spl->getSize();
        }


        while ( null !== ( $realpathSrcCurrent = key($filesSrc) ) ) {
            $realpathDestAbsoluteCurrent = key($filesDestAbsolute);
            $realpathDestRelativeCurrent = key($filesDestRelative);
            $sizeSrcCurrent = current($filesSrc);
            $sizeDestAbsoluteCurrent = current($filesDestAbsolute);
            $sizeDestRelativeCurrent = current($filesDestRelative);
            next($filesSrc);
            next($filesDestAbsolute);
            next($filesDestRelative);

            $this->assertEquals($sizeSrcCurrent, $sizeDestAbsoluteCurrent);
            $this->assertEquals($sizeSrcCurrent, $sizeDestRelativeCurrent);

            $this->assertEquals(true,
                false !== strpos($realpathDestAbsoluteCurrent,
                    ltrim(str_replace($realpathSrc, '', $realpathSrcCurrent), DIRECTORY_SEPARATOR)
                )
            );
            $this->assertEquals(
                ltrim(str_replace($realpathSrc, '', $realpathSrcCurrent), DIRECTORY_SEPARATOR),
                ltrim(str_replace($realpathDestRelative, '', $realpathDestRelativeCurrent), DIRECTORY_SEPARATOR),
            );
        }


        $cli->rmdir($directory, true);
    }


    public function testTarUntar()
    {
        $cli = $this->getCli();


        $directory = __DIR__ . '/../storage/cli/tar';
        $cli->rmdir($directory, true);
        mkdir($directory, 0775, true);


        if (! is_dir($directorySrc = $directory . '/src')) mkdir($directorySrc, 0775, true);
        if (! is_dir($directoryDest = $directory . '/dest')) mkdir($directoryDest, 0775, true);
        if (! is_dir($directoryDestAbsolute = $directoryDest . '/absolute')) mkdir($directoryDestAbsolute, 0775, true);
        if (! is_dir($directoryDestRelative = $directoryDest . '/relative')) mkdir($directoryDestRelative, 0775, true);

        if (! is_dir($directory1 = $directorySrc . '/1/1')) mkdir($directory1, 0775, true);
        if (! is_dir($directory2 = $directorySrc . '/2/1')) mkdir($directory2, 0775, true);
        if (! is_dir($directory3 = $directorySrc . '/3')) mkdir($directory3, 0775, true);
        if (! is_dir($directory1A = $directory1 . '/a')) mkdir($directory1A, 0775, true);
        if (! is_dir($directory1B = $directory1A . '/b')) mkdir($directory1B, 0775, true);
        if (! is_dir($directory1C = $directory1B . '/c')) mkdir($directory1C, 0775, true);
        if (! is_dir($directory2A = $directory2 . '/a')) mkdir($directory2A, 0775, true);
        if (! is_dir($directory2B = $directory2A . '/b')) mkdir($directory2B, 0775, true);
        if (! is_dir($directory2C = $directory2B . '/c')) mkdir($directory2C, 0775, true);

        $i = 0;

        file_put_contents($directory1A . '/a1.txt', str_repeat('0', ++$i));
        file_put_contents($directory1A . '/a2.txt', str_repeat('0', ++$i));
        file_put_contents($directory1B . '/b1.txt', str_repeat('0', ++$i));
        file_put_contents($directory1B . '/b2.txt', str_repeat('0', ++$i));
        file_put_contents($directory1C . '/c1.txt', str_repeat('0', ++$i));
        file_put_contents($directory1C . '/c2.txt', str_repeat('0', ++$i));

        file_put_contents($directory2A . '/a1.txt', str_repeat('0', ++$i));
        file_put_contents($directory2A . '/a2.txt', str_repeat('0', ++$i));
        file_put_contents($directory2B . '/b1.txt', str_repeat('0', ++$i));
        file_put_contents($directory2B . '/b2.txt', str_repeat('0', ++$i));
        file_put_contents($directory2C . '/c1.txt', str_repeat('0', ++$i));
        file_put_contents($directory2C . '/c2.txt', str_repeat('0', ++$i));


        $fileAbsolute = $directoryDest . '/absolute.tar.gz';
        $fileRelative = $directoryDest . '/relative.tar.gz';
        $this->assertFileDoesNotExist($fileAbsolute);
        $this->assertFileDoesNotExist($fileRelative);

        $cli->tar($fileAbsolute, null, $directory1, $directory2);
        $cli->tar($fileRelative, $directorySrc, $directory1, $directory2);

        $this->assertFileExists($fileAbsolute);
        $this->assertFileExists($fileRelative);


        $fh = fopen($fileAbsolute, 'r');
        $bytes = fread($fh, 4);
        fclose($fh);
        $this->assertEquals('1f8b0800', bin2hex($bytes));

        $fh = fopen($fileRelative, 'r');
        $bytes = fread($fh, 4);
        fclose($fh);
        $this->assertEquals('1f8b0800', bin2hex($bytes));


        $cli->untar($fileAbsolute, $directoryDestAbsolute);
        $cli->untar($fileRelative, $directoryDestRelative);


        $itSrc = new \RecursiveDirectoryIterator($directorySrc,
            \FilesystemIterator::KEY_AS_PATHNAME
            | \FilesystemIterator::CURRENT_AS_FILEINFO
            | \FilesystemIterator::SKIP_DOTS
        );
        $iitSrc = new \RecursiveIteratorIterator($itSrc);
        $realpathSrc = realpath($directorySrc);

        $itDestAbsolute = new \RecursiveDirectoryIterator($directoryDestAbsolute,
            \FilesystemIterator::KEY_AS_PATHNAME
            | \FilesystemIterator::CURRENT_AS_FILEINFO
            | \FilesystemIterator::SKIP_DOTS
        );
        $iitDestAbsolute = new \RecursiveIteratorIterator($itDestAbsolute);

        $itDestRelative = new \RecursiveDirectoryIterator($directoryDestRelative,
            \FilesystemIterator::KEY_AS_PATHNAME
            | \FilesystemIterator::CURRENT_AS_FILEINFO
            | \FilesystemIterator::SKIP_DOTS
        );
        $iitDestRelative = new \RecursiveIteratorIterator($itDestRelative);
        $realpathDestRelative = realpath($directoryDestRelative);


        $filesSrc = [];
        foreach ( $iitSrc as $spl ) {
            if (! $spl->isFile()) continue;
            $filesSrc[ $spl->getRealpath() ] = $spl->getSize();
        }

        $filesDestAbsolute = [];
        foreach ( $iitDestAbsolute as $spl ) {
            if (! $spl->isFile()) continue;
            $filesDestAbsolute[ $spl->getRealpath() ] = $spl->getSize();
        }

        $filesDestRelative = [];
        foreach ( $iitDestRelative as $spl ) {
            if (! $spl->isFile()) continue;
            $filesDestRelative[ $spl->getRealpath() ] = $spl->getSize();
        }


        while ( null !== ( $realpathSrcCurrent = key($filesSrc) ) ) {
            $realpathDestAbsoluteCurrent = key($filesDestAbsolute);
            $realpathDestRelativeCurrent = key($filesDestRelative);
            $sizeSrcCurrent = current($filesSrc);
            $sizeDestAbsoluteCurrent = current($filesDestAbsolute);
            $sizeDestRelativeCurrent = current($filesDestRelative);
            next($filesSrc);
            next($filesDestAbsolute);
            next($filesDestRelative);

            $this->assertEquals($sizeSrcCurrent, $sizeDestAbsoluteCurrent);
            $this->assertEquals($sizeSrcCurrent, $sizeDestRelativeCurrent);

            $this->assertEquals(true,
                false !== strpos($realpathDestAbsoluteCurrent,
                    ltrim(str_replace($realpathSrc, '', $realpathSrcCurrent), DIRECTORY_SEPARATOR)
                )
            );
            $this->assertEquals(
                ltrim(str_replace($realpathSrc, '', $realpathSrcCurrent), DIRECTORY_SEPARATOR),
                ltrim(str_replace($realpathDestRelative, '', $realpathDestRelativeCurrent), DIRECTORY_SEPARATOR),
            );
        }


        $cli->rmdir($directory, true);
    }
}