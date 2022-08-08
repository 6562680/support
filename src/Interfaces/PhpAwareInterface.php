<?php

namespace Gzhegow\Support\Interfaces;

use Gzhegow\Support\IPhp;


/**
 * Interface
 */
interface PhpAwareInterface
{
    /**
     * @param IPhp $arr
     *
     * @return void
     */
    public function setPhp(IPhp $arr);
}