<?php

namespace Gzhegow\Support\Interfaces;

use Gzhegow\Support\IPath;


/**
 * Interface
 */
interface PathAwareInterface
{
    /**
     * @param IPath $arr
     *
     * @return void
     */
    public function setPath(IPath $arr);
}