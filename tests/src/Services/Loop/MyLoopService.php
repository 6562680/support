<?php

namespace Gzhegow\Di\Tests\Services\Loop;

/**
 * Class MyLoopService
 */
class MyLoopService
{
    /**
     * @var MyLoopService
     */
    public $myLoopService;


    /**
     * Constructor
     *
     * @param MyLoopService $myLoopService
     */
    public function __construct(MyLoopService $myLoopService)
    {
        $this->myLoopService = $myLoopService;
    }
}
