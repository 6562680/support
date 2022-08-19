<?php

namespace Gzhegow\Support\Traits\Load;

use Gzhegow\Support\ILoader;
use Gzhegow\Support\SupportFactory;


/**
 * Trait
 */
trait LoaderLoadTrait
{
    /**
     * @var ILoader
     */
    protected $loader;


    /**
     * @param null|ILoader $loader
     *
     * @return static
     */
    public function withLoader(?ILoader $loader)
    {
        $this->loader = $loader;

        return $this;
    }


    /**
     * @return ILoader
     */
    protected function loadLoader() : ILoader
    {
        return SupportFactory::getInstance()->getLoader();
    }


    /**
     * @return ILoader
     */
    public function getLoader() : ILoader
    {
        return $this->loader = $this->loader
            ?? $this->loadLoader();
    }
}