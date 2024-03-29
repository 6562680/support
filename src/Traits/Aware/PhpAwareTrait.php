<?php

namespace Gzhegow\Support\Traits\Aware;

use Gzhegow\Support\IPhp;


/**
 * Trait
 */
trait PhpAwareTrait
{
    /**
     * @var IPhp
     */
    protected $php;


    /**
     * @param IPhp $php
     *
     * @return void
     */
    public function setPhp(IPhp $php)
    {
        $this->php = $php;
    }
}