<?php

namespace Gzhegow\Support\Traits\Aware;

use Gzhegow\Support\ICli;


/**
 * Trait
 */
trait CliAwareTrait
{
    /**
     * @var ICli
     */
    protected $cli;


    /**
     * @param ICli $cli
     *
     * @return void
     */
    public function setCli(ICli $cli)
    {
        $this->cli = $cli;
    }
}