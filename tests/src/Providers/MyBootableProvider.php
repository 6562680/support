<?php

namespace Gzhegow\Di\Tests\Providers;

use Gzhegow\Di\Tests\Services\MyAService;
use Gzhegow\Di\Domain\Provider\BootableProvider;
use Gzhegow\Di\Tests\Services\MyServiceAInterface;

/**
 * Class MyBootableProvider
 */
class MyBootableProvider extends BootableProvider
{
    /**
     * @return MyServiceAInterface
     */
    protected function getMyAService() : MyServiceAInterface
    {
        return $this->di->get(MyServiceAInterface::class);
    }


    /**
     * @return void
     */
    public function register() : void
    {
        $this->di->bind(MyServiceAInterface::class, MyAService::class);
    }


    /**
     * @return void
     */
    public function boot() : void
    {
        // will done once you call method ->boot() on $di instance, immediately otherwise

        $myAService = $this->getMyAService();

        $myAService::setStaticOption(1);
        $myAService->setDynamicOption(2);
    }


    /**
     * @return array
     */
    protected function define() : array
    {
        return [
            'config'     => __DIR__ . '/../../config/src/file.conf',
            'resources'  => __DIR__ . '/../../config/src/dir',
            'resources2' => __DIR__ . '/../../config/src/dir/', // ends with slash
        ];
    }

    /**
     * @return array
     */
    protected function sync() : array
    {
        return [
            'config'     => __DIR__ . '/../../config/dest/file.conf',
            'resources'  => __DIR__ . '/../../config/dest/dir',
            'resources2' => __DIR__ . '/../../config/dest/dir/', // ends with slash
        ];
    }
}
