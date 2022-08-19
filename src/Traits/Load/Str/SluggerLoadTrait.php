<?php

namespace Gzhegow\Support\Traits\Load\Str;

use Gzhegow\Support\SupportFactory;
use Gzhegow\Support\Domain\Str\SluggerInterface;


/**
 * Trait
 */
trait SluggerLoadTrait
{
    /**
     * @var SluggerInterface
     */
    protected $slugger;


    /**
     * @param null|SluggerInterface $slugger
     *
     * @return static
     */
    public function withSlugger(?SluggerInterface $slugger)
    {
        $this->slugger = $slugger;

        return $this;
    }


    /**
     * @return SluggerInterface
     */
    protected function loadSlugger() : SluggerInterface
    {
        return SupportFactory::getInstance()->getStrSlugger();
    }


    /**
     * @return SluggerInterface
     */
    public function getSlugger() : SluggerInterface
    {
        return $this->slugger = $this->slugger
            ?? $this->loadSlugger();
    }
}