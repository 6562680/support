<?php

namespace Gzhegow\Support\Traits\Aware;

use Gzhegow\Support\IProf;


/**
 * Trait
 */
trait ProfAwareTrait
{
    /**
     * @var IProf
     */
    protected $prof;


    /**
     * @param IProf $prof
     *
     * @return void
     */
    public function setProf(IProf $prof)
    {
        $this->prof = $prof;
    }
}