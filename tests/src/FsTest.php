<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\Fs;
use Gzhegow\Support\IFs;


class FsTest extends AbstractTestCase
{
    protected function getFs() : IFs
    {
        return Fs::getInstance();
    }


    public function testPathval()
    {
        $fs = $this->getFs();

        $dir = __DIR__ . '/../storage/fs/pathval';

        $dirpath = $dir . '/dir';
        $filepath = $dir . '/file.html';

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

        $fs->rmdir($dir, true);
    }

    public function testSplval()
    {
        $fs = $this->getFs();

        $dir = __DIR__ . '/../storage/fs/pathval';

        $dirpath = $dir . '/dir';
        $filepath = $dir . '/file.html';

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

        $fs->rmdir($dir, true);
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

        $dir = $fs->mkdir(__DIR__ . '/../storage/fs/fileGet');
        $file = $dir . '/hello.txt';

        $fs->mkdir($dir);

        file_put_contents($file, '123');

        $content = $fs->fileGet($file);

        $this->assertEquals('123', $content);

        $fs->rmdir($dir, true);
    }

    public function testFilePut()
    {
        $fs = $this->getFs();

        $dir = $fs->mkdir(__DIR__ . '/../storage/fs/filePut');
        $file = $dir . '/hello.txt';

        $fs->mkdir($dir);

        $fs->filePut($file, '123');

        $content = file_get_contents($file);

        $this->assertFileExists($file);
        $this->assertEquals('123', $content);

        $fs->rmdir($dir, true);
    }


    public function testMkdir()
    {
        $fs = $this->getFs();

        $dir = $fs->mkdir(__DIR__ . '/../storage/fs/mkdir/1/2/3');

        $this->assertDirectoryExists($dir);

        $fs->rmdir($dir, true);
    }

    public function testRmdir()
    {
        $fs = $this->getFs();

        $filesDir = __DIR__ . '/../storage/fs/rmdir';
        $appDir = $filesDir . '/app';

        $protected[] = $filesDir;
        $protected[] = $appDir;

        $removed[] = $filesDir . '/logs';

        $files = [
            $protected[] = $filesDir . '/app/logs/log.txt',
            $protected[] = $filesDir . '/app/logs/file.html',
            $protected[] = $filesDir . '/file.html',

            $removed[] = $filesDir . '/log.txt',
            $removed[] = $filesDir . '/logs/log.txt',
        ];

        foreach ( $files as $file ) {
            $fs->mkdir(dirname($file));

            touch($file);
        }

        $fs->rmdir($filesDir, true, function (\SplFileInfo $file) use ($appDir) {
            if ($shouldKeep = ( $file->getBasename() === 'file.html' )) {
                return true;
            }

            if ($shouldKeep = 0 === mb_stripos($file->getRealPath(), realpath($appDir))) {
                return true;
            }

            return false;
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
