<?php

namespace Gzhegow\Support\Traits\Aware;

use Gzhegow\Support\IItertools;


/**
 * Trait
 */
trait ItertoolsAwareTrait
{
    /**
     * @var IItertools
     */
    protected $itertools;


    /**
     * @param IItertools $itertools
     *
     * @return void
     */
    public function setItertools(IItertools $itertools)
    {
        $this->itertools = $itertools;
    }
}