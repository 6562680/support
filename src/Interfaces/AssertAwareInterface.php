<?php

namespace Gzhegow\Support\Interfaces;

use Gzhegow\Support\IAssert;


/**
 * Interface
 */
interface AssertAwareInterface
{
    /**
     * @param IAssert $arr
     *
     * @return void
     */
    public function setAssert(IAssert $arr);
}