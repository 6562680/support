<?php

namespace Gzhegow\Support\Interfaces;

use Gzhegow\Support\IFs;


/**
 * Interface
 */
interface FsAwareInterface
{
    /**
     * @param IFs $arr
     *
     * @return void
     */
    public function setFs(IFs $arr);
}