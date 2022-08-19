<?php

namespace Gzhegow\Support\Traits\Load;

use Gzhegow\Support\IEnv;
use Gzhegow\Support\SupportFactory;


/**
 * Trait
 */
trait EnvLoadTrait
{
    /**
     * @var IEnv
     */
    protected $env;


    /**
     * @param null|IEnv $env
     *
     * @return static
     */
    public function withEnv(?IEnv $env)
    {
        $this->env = $env;

        return $this;
    }


    /**
     * @return IEnv
     */
    protected function loadEnv() : IEnv
    {
        return SupportFactory::getInstance()->getEnv();
    }


    /**
     * @return IEnv
     */
    public function getEnv() : IEnv
    {
        return $this->env = $this->env
            ?? $this->loadEnv();
    }
}