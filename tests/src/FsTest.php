<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\XFs;
use Gzhegow\Support\IFs;


class FsTest extends AbstractTestCase
{
    protected function getFs() : IFs
    {
        return XFs::getInstance();
    }


    public function testPathval()
    {
        $fs = $this->getFs();

        $directory = __DIR__ . '/../storage/fs/pathval';

        $dirpath = $directory . '/dir';
        $filepath = $directory . '/file.html';

        $fs->mkdir($dirpath, 0775, true);
        touch($filepath);

        $this->assertEquals($filepath, $fs->pathVal($filepath));
        $this->assertEquals(realpath($filepath), $fs->pathFileExistsVal($filepath));
        $this->assertEquals(realpath($filepath), $fs->pathFileVal($filepath));
        $this->assertEquals(null, $fs->pathDirVal($filepath));
        $this->assertEquals(null, $fs->pathLinkVal($filepath));

        $this->assertEquals($dirpath, $fs->pathVal($dirpath));
        $this->assertEquals(realpath($dirpath), $fs->pathFileExistsVal($dirpath));
        $this->assertEquals(null, $fs->pathFileVal($dirpath));
        $this->assertEquals(realpath($dirpath), $fs->pathDirVal($dirpath));
        $this->assertEquals(null, $fs->pathLinkVal($dirpath));

        $fs->rmdir($directory);
    }

    public function testSplval()
    {
        $fs = $this->getFs();

        $directory = __DIR__ . '/../storage/fs/pathval';

        $dirpath = $directory . '/dir';
        $filepath = $directory . '/file.html';

        $fs->mkdir($dirpath, 0775, true);
        touch($filepath);

        $this->assertInstanceOf(\SplFileInfo::class, $fs->splVal($filepath));
        $this->assertInstanceOf(\SplFileInfo::class, $fs->splFileExistsVal($filepath));
        $this->assertInstanceOf(\SplFileObject::class, $fs->splFileVal($filepath));
        $this->assertEquals(null, $fs->splDirVal($filepath));
        $this->assertEquals(null, $fs->splLinkVal($filepath));

        $this->assertInstanceOf(\SplFileInfo::class, $fs->splVal($dirpath));
        $this->assertInstanceOf(\SplFileInfo::class, $fs->splFileExistsVal($dirpath));
        $this->assertEquals(null, $fs->splFileVal($dirpath));
        $this->assertInstanceOf(\SplFileInfo::class, $fs->splDirVal($dirpath));
        $this->assertEquals(null, $fs->splLinkVal($dirpath));

        $fs->rmdir($directory);
    }


    public function testPathSplit()
    {
        $fs = $this->getFs();
        $ds = DIRECTORY_SEPARATOR;

        $this->assertEquals([ 'aa', 'aa', 'aa', 'aa' ], $fs->pathSplit('aa/aa\\aa/aa'));
        $this->assertEquals([ "${ds}aa", 'aa', 'aa', 'aa' ], $fs->pathSplit('/aa/aa\\aa/aa\\'));
        $this->assertEquals([ "${ds}${ds}aa", 'aa', 'aa', 'aa' ], $fs->pathSplit('//aa/aa\\aa/aa\\'));
        $this->assertEquals([ "${ds}${ds}${ds}aa", 'aa', 'aa', 'aa' ], $fs->pathSplit('/\\/aa/aa\\aa/aa\\'));
    }

    public function testPathJoin()
    {
        $fs = $this->getFs();
        $ds = DIRECTORY_SEPARATOR;

        $this->assertEquals('', $fs->pathJoin(''));
        $this->assertEquals(',', $fs->pathJoin(','));
        $this->assertEquals("${ds}", $fs->pathJoin('/'));
        $this->assertEquals('a', $fs->pathJoin('a'));
        $this->assertEquals(',a', $fs->pathJoin(',a'));
        $this->assertEquals("${ds}a", $fs->pathJoin('/a'));
        $this->assertEquals('', $fs->pathJoin('', [ '' ]));
        $this->assertEquals(",${ds},", $fs->pathJoin(',', [ ',' ]));

        $this->assertEquals("${ds}", $fs->pathJoin('/', [ '/' ]));

        $this->assertEquals("a${ds}a", $fs->pathJoin('a', [ 'a' ]));
        $this->assertEquals(",a${ds},a", $fs->pathJoin(',a', [ ',a' ]));

        $this->assertEquals("${ds}a${ds}a", $fs->pathJoin('/a', [ '/a' ]));
        $this->assertEquals("${ds}a", $fs->pathJoin('/', [ '/a' ]));

        $parts = [ '', ',', "${ds}", 'a', ',a', "${ds}a", [ '', ',', "${ds}", 'a', ',a', "${ds}a" ] ];

        $this->assertEquals(",${ds}a${ds},a${ds}a${ds},${ds}a${ds},a${ds}a", $fs->pathJoin(...$parts));
    }

    public function testPathConcat()
    {
        $fs = $this->getFs();
        $ds = DIRECTORY_SEPARATOR;

        $this->assertEquals("1${ds}2${ds}3", $fs->pathConcat('1/2/3', ''));
        $this->assertEquals("1${ds}2${ds}3", $fs->pathConcat('1/2/3', '/'));
        $this->assertEquals("1${ds}2${ds}3${ds}1", $fs->pathConcat('1/2/3', '1'));
        $this->assertEquals("1${ds}2${ds}3${ds}4", $fs->pathConcat('1/2/3', '3/4'));
        $this->assertEquals("1${ds}2${ds}3${ds}4", $fs->pathConcat('1/2/3', '2/3/4'));
        $this->assertEquals("1${ds}2${ds}3${ds}4", $fs->pathConcat('1/2/3', '1/2/3/4'));
        $this->assertEquals("1${ds}2${ds}3${ds}0${ds}1${ds}2${ds}3${ds}4", $fs->pathConcat('1/2/3', '0/1/2/3/4'));

        $this->assertEquals("1${ds}2${ds}3", $fs->pathConcat('1/2/3/', ''));
        $this->assertEquals("1${ds}2${ds}3", $fs->pathConcat('1/2/3/', '/'));
        $this->assertEquals("1${ds}2${ds}3${ds}1", $fs->pathConcat('1/2/3/', '1'));
        $this->assertEquals("1${ds}2${ds}3${ds}4", $fs->pathConcat('1/2/3/', '3/4'));
        $this->assertEquals("1${ds}2${ds}3${ds}4", $fs->pathConcat('1/2/3/', '2/3/4'));
        $this->assertEquals("1${ds}2${ds}3${ds}4", $fs->pathConcat('1/2/3/', '1/2/3/4'));
        $this->assertEquals("1${ds}2${ds}3${ds}0${ds}1${ds}2${ds}3${ds}4", $fs->pathConcat('1/2/3/', '0/1/2/3/4'));

        $this->assertEquals("1${ds}2${ds}3", $fs->pathConcat('1/2/3', '//'));
        $this->assertEquals("1${ds}2${ds}3${ds}1", $fs->pathConcat('1/2/3', '/1'));
        $this->assertEquals("1${ds}2${ds}3${ds}4", $fs->pathConcat('1/2/3', '/3/4'));
        $this->assertEquals("1${ds}2${ds}3${ds}4", $fs->pathConcat('1/2/3', '/2/3/4'));
        $this->assertEquals("1${ds}2${ds}3${ds}4", $fs->pathConcat('1/2/3', '/1/2/3/4'));
        $this->assertEquals("1${ds}2${ds}3${ds}0${ds}1${ds}2${ds}3${ds}4", $fs->pathConcat('1/2/3', '/0/1/2/3/4'));
    }


    public function testPathDirname()
    {
        $fs = $this->getFs();
        $ds = DIRECTORY_SEPARATOR;

        $a = __CLASS__;
        $b = 'A\\B/C\\D';
        $c = '\\A\\B/C\\D';

        $this->assertEquals("Gzhegow${ds}Support${ds}Tests", $fs->pathDirname($a));

        $this->assertEquals("A${ds}B${ds}C", $fs->pathDirname($b));

        $this->assertEquals("${ds}A${ds}B", $fs->pathDirname($c, 2));
    }

    public function testPathBasename()
    {
        $fs = $this->getFs();
        $ds = DIRECTORY_SEPARATOR;

        $a = __CLASS__;
        $b = 'A\\B/C\\D';
        $c = '\\A\\B/C\\D';

        $this->assertEquals('Fs', $fs->pathBasename($a, 'Test'));

        $this->assertEquals('D', $fs->pathBasename($b));

        $this->assertEquals("B${ds}C${ds}D", $fs->pathBasename($c, null, 2));
    }

    public function testPathRelative()
    {
        $fs = $this->getFs();
        $ds = DIRECTORY_SEPARATOR;

        $a = __CLASS__;
        $b = 'A\\B/C\\D';
        $c = '\\A\\B/C\\D';

        $this->assertEquals("Support${ds}Tests${ds}FsTest", $fs->pathRelative($a, 'Gzhegow'));

        $this->assertEquals("A${ds}B${ds}C${ds}D", $fs->pathRelative($b));

        $this->assertEquals("B${ds}C${ds}D", $fs->pathRelative($b, 'A'));

        $this->assertEquals("B${ds}C${ds}D", $fs->pathRelative($c, '/A'));
        $this->assertEquals(null, $fs->pathRelative($c, 'A'));
    }


    public function testFileGet()
    {
        $fs = $this->getFs();

        $directory = $fs->mkdir(__DIR__ . '/../storage/fs/fileGet');
        $file = $directory . '/hello.txt';

        $fs->mkdir($directory);

        file_put_contents($file, '123');

        $content = $fs->fileGet($file);

        $this->assertEquals('123', $content);

        $fs->rmdir($directory);
    }

    public function testFilePut()
    {
        $fs = $this->getFs();

        $root = __DIR__ . '/../storage/fs';
        $directory = $root . '/filePut';
        $directoryBackup = $root . '/filePut.backup';
        $subdirectory = $directory . '/1';

        $fs->mkdir($subdirectory);
        $fs->mkdir($directoryBackup);


        $file = $subdirectory . '/hello.txt';

        $filepath = $fs->filePut($file, __CLASS__);
        $this->assertFileExists($file);
        $this->assertFileExists($filepath);

        $content = file_get_contents($filepath);
        $this->assertEquals(__CLASS__, $content);


        $file = $subdirectory . '/hello.txt';

        $backupPath = $fs->filePut($file, __CLASS__);
        $this->assertFileExists($file);
        $this->assertFileExists($filepath);
        $this->assertFileExists($backupPath);

        $content = file_get_contents($filepath);
        $this->assertEquals(__CLASS__, $content);


        // now set the backup path
        $fs->withBackupPath($directoryBackup);

        $backupPath = $fs->filePut($file, __CLASS__);
        $this->assertFileExists($file);
        $this->assertFileExists($filepath);
        $this->assertFileExists($backupPath);

        $content = file_get_contents($backupPath);
        $this->assertEquals(__CLASS__, $content);


        // now set the backup path base to keep folder structure
        $backupDirPathBase = __DIR__ . '/../storage/fs/filePut';
        $fs->withBackupPathBase($backupDirPathBase);

        $backupPath = $fs->filePut($file, __CLASS__);
        $this->assertFileExists($file);
        $this->assertFileExists($filepath);
        $this->assertFileExists($backupPath);

        $content = file_get_contents($backupPath);
        $this->assertEquals(__CLASS__, $content);

        $fs->rmdir($directoryBackup);
        $fs->rmdir($directory);
    }


    public function testMkdir()
    {
        $fs = $this->getFs();

        $directory = __DIR__ . '/../storage/fs/mkdir';

        $dir = $fs->mkdir($directory . '/1/2/3');

        $this->assertDirectoryExists($dir);

        $fs->rmdir($directory);
    }

    public function testRmdir()
    {
        $fs = $this->getFs();

        $directory = __DIR__ . '/../storage/fs/rmdir';

        $dir1 = $directory . '/1';
        $dir11 = $directory . '/1/11';
        $dir2 = $directory . '/2';
        $dir21 = $directory . '/2/21';

        $ignoredDirs[] = $directory;
        $ignoredDirs[] = $dir1;
        $ignoredDirs[] = $dir11;
        // $ignoredDirs[] = $dir2;
        // $ignoredDirs[] = $dir21;

        // $removedDirs[] = $dir;
        // $removedDirs[] = $dir1;
        // $removedDirs[] = $dir11;
        $removedDirs[] = $dir2;
        $removedDirs[] = $dir21;

        $files = [
            $ignored[] = $directory . '/1.txt',
            // $ignored[] = $directory . '/2.txt',
            // $ignored[] = $directory . '/1/11.txt',
            // $ignored[] = $directory . '/1/12.txt',
            $ignored[] = $directory . '/1/11/111.txt',
            $ignored[] = $directory . '/1/11/112.txt',
            // $ignored[] = $directory . '/2/21.txt',
            // $ignored[] = $directory . '/2/22.txt',
            // $ignored[] = $directory . '/2/21/211.txt',
            // $ignored[] = $directory . '/2/21/212.txt',

            // $removed[] = $directory . '/1.txt',
            $removed[] = $directory . '/2.txt',
            $removed[] = $directory . '/1/11.txt',
            $removed[] = $directory . '/1/12.txt',
            // $removed[] = $$directorydir . '/1/11/111.txt',
            // $removed[] = $directory . '/1/11/112.txt',
            $removed[] = $directory . '/2/21.txt',
            $removed[] = $directory . '/2/22.txt',
            $removed[] = $directory . '/2/21/211.txt',
            $removed[] = $directory . '/2/21/212.txt',
        ];

        foreach ( $files as $file ) {
            $fs->mkdir(dirname($file));

            touch($file);
        }

        $fs->rmdir($directory, function (\SplFileInfo $file) use ($dir11) {
            if ($file->getBasename() === '1.txt') {
                return true;
            }

            $startsWith = 0 === mb_stripos($file->getRealPath(), realpath($dir11) . DIRECTORY_SEPARATOR);
            if ($startsWith) {
                return true;
            }

            return false;
        });

        foreach ( $ignoredDirs as $dir ) {
            $this->assertDirectoryExists($dir);
        }

        foreach ( $ignored as $file ) {
            $this->assertFileExists($file);
        }

        foreach ( $removedDirs as $dir ) {
            $this->assertDirectoryDoesNotExist($dir);
        }

        foreach ( $removed as $file ) {
            $this->assertFileDoesNotExist($file);
        }

        $fs->rmdir($directory);

        $this->assertDirectoryDoesNotExist($directory);
    }
}