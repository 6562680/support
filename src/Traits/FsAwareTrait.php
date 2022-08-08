<?php

namespace Gzhegow\Support\Traits;

use Gzhegow\Support\IFs;


/**
 * Trait
 */
trait FsAwareTrait
{
    /**
     * @var IFs
     */
    protected $fs;


    /**
     * @param IFs $fs
     *
     * @return void
     */
    public function setFs(IFs $fs)
    {
        $this->fs = $fs;
    }
}