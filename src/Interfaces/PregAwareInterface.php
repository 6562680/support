<?php

namespace Gzhegow\Support\Interfaces;

use Gzhegow\Support\IPreg;


/**
 * Interface
 */
interface PregAwareInterface
{
    /**
     * @param IPreg $arr
     *
     * @return void
     */
    public function setPreg(IPreg $arr);
}