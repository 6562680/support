<?php

namespace Gzhegow\Support\Traits\Load;

use Gzhegow\Support\IDebug;
use Gzhegow\Support\SupportFactory;


/**
 * Trait
 */
trait DebugLoadTrait
{
    /**
     * @var IDebug
     */
    protected $debug;


    /**
     * @param null|IDebug $debug
     *
     * @return static
     */
    public function withDebug(?IDebug $debug)
    {
        $this->debug = $debug;

        return $this;
    }


    /**
     * @return IDebug
     */
    protected function loadDebug() : IDebug
    {
        return SupportFactory::getInstance()->getDebug();
    }


    /**
     * @return IDebug
     */
    public function getDebug() : IDebug
    {
        return $this->debug = $this->debug
            ?? $this->loadDebug();
    }
}