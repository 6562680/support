<?php

namespace Gzhegow\Support\Interfaces;

use Gzhegow\Support\IDebug;


/**
 * Interface
 */
interface DebugAwareInterface
{
    /**
     * @param IDebug $arr
     *
     * @return void
     */
    public function setDebug(IDebug $arr);
}