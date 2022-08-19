<?php

namespace Gzhegow\Support\Traits\Load;

use Gzhegow\Support\ICli;
use Gzhegow\Support\SupportFactory;


/**
 * Trait
 */
trait CliLoadTrait
{
    /**
     * @var ICli
     */
    protected $cli;


    /**
     * @param null|ICli $cli
     *
     * @return static
     */
    public function withCli(?ICli $cli)
    {
        $this->cli = $cli;

        return $this;
    }


    /**
     * @return ICli
     */
    protected function loadCli() : ICli
    {
        return SupportFactory::getInstance()->getCli();
    }


    /**
     * @return ICli
     */
    public function getCli() : ICli
    {
        return $this->cli = $this->cli
            ?? $this->loadCli();
    }
}