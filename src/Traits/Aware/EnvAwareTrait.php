<?php

namespace Gzhegow\Support\Traits\Aware;

use Gzhegow\Support\IEnv;


/**
 * Trait
 */
trait EnvAwareTrait
{
    /**
     * @var IEnv
     */
    protected $env;


    /**
     * @param IEnv $env
     *
     * @return void
     */
    public function setEnv(IEnv $env)
    {
        $this->env = $env;
    }
}