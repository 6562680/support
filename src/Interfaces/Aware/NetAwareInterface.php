<?php

namespace Gzhegow\Support\Interfaces\Aware;

use Gzhegow\Support\INet;


/**
 * Interface
 */
interface NetAwareInterface
{
    /**
     * @param INet $arr
     *
     * @return void
     */
    public function setNet(INet $arr);
}