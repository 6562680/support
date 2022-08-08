<?php

namespace Gzhegow\Support\Traits;

use Gzhegow\Support\ILoader;


/**
 * Trait
 */
trait LoaderAwareTrait
{
    /**
     * @var ILoader
     */
    protected $loader;


    /**
     * @param ILoader $loader
     *
     * @return void
     */
    public function setLoader(ILoader $loader)
    {
        $this->loader = $loader;
    }
}