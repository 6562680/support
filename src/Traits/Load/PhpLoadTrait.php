<?php

namespace Gzhegow\Support\Traits\Load;

use Gzhegow\Support\IPhp;
use Gzhegow\Support\SupportFactory;


/**
 * Trait
 */
trait PhpLoadTrait
{
    /**
     * @var IPhp
     */
    protected $php;


    /**
     * @param null|IPhp $php
     *
     * @return static
     */
    public function withPhp(?IPhp $php)
    {
        $this->php = $php;

        return $this;
    }


    /**
     * @return IPhp
     */
    protected function loadPhp() : IPhp
    {
        return SupportFactory::getInstance()->getPhp();
    }


    /**
     * @return IPhp
     */
    public function getPhp() : IPhp
    {
        return $this->php = $this->php
            ?? $this->loadPhp();
    }
}