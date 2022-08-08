<?php

namespace Gzhegow\Support\Traits;

use Gzhegow\Support\IDebug;


/**
 * Trait
 */
trait DebugAwareTrait
{
    /**
     * @var IDebug
     */
    protected $debug;


    /**
     * @param IDebug $debug
     *
     * @return void
     */
    public function setDebug(IDebug $debug)
    {
        $this->debug = $debug;
    }
}