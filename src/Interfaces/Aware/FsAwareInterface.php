<?php

namespace Gzhegow\Support\Interfaces\Aware;

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