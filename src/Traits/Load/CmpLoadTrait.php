<?php

namespace Gzhegow\Support\Traits\Load;

use Gzhegow\Support\ICmp;
use Gzhegow\Support\SupportFactory;


/**
 * Trait
 */
trait CmpLoadTrait
{
    /**
     * @var ICmp
     */
    protected $cmp;


    /**
     * @param null|ICmp $cmp
     *
     * @return static
     */
    public function withCmp(?ICmp $cmp)
    {
        $this->cmp = $cmp;

        return $this;
    }


    /**
     * @return ICmp
     */
    protected function loadCmp() : ICmp
    {
        return SupportFactory::getInstance()->getCmp();
    }


    /**
     * @return ICmp
     */
    public function getCmp() : ICmp
    {
        return $this->cmp = $this->cmp
            ?? $this->loadCmp();
    }
}