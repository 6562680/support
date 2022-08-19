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
}