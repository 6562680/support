<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\ICli;
use Gzhegow\Support\ZCli;


class CliTest extends AbstractTestCase
{
    protected function getCli() : ICli
    {
        return ZCli::getInstance();
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

    public function testRmdir()
    {
        $cli = $this->getCli();

        $directory = __DIR__ . '/../storage/cli/rmdir';

        mkdir($directory);
        file_put_contents($directory . '/1.txt', __CLASS__);
        file_put_contents($directory . '/2.txt', __CLASS__);
        file_put_contents($directory . '/3.txt', __CLASS__);

        $realpath2 = realpath($directory . '/2.txt');

        $noninteractive = 'yy';

        $cli->rmdir($directory, function (\SplFileInfo $spl) use ($realpath2) {
            return $spl->getRealPath() === $realpath2;
        }, $noninteractive);

        $this->assertFileExists($realpath2);
        $this->assertDirectoryExists($directory);

        unlink($realpath2);
        rmdir($directory);
    }
}
