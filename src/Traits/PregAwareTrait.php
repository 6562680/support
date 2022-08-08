<?php

namespace Gzhegow\Support\Traits;

use Gzhegow\Support\IPreg;


/**
 * Trait
 */
trait PregAwareTrait
{
    /**
     * @var IPreg
     */
    protected $preg;


    /**
     * @param IPreg $preg
     *
     * @return void
     */
    public function setPreg(IPreg $preg)
    {
        $this->preg = $preg;
    }
}