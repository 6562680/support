<?php

namespace Gzhegow\Support\Interfaces\Aware;

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