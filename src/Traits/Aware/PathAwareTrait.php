<?php

namespace Gzhegow\Support\Traits\Aware;

use Gzhegow\Support\IPath;


/**
 * Trait
 */
trait PathAwareTrait
{
    /**
     * @var IPath
     */
    protected $path;


    /**
     * @param IPath $path
     *
     * @return void
     */
    public function setPath(IPath $path)
    {
        $this->path = $path;
    }
}