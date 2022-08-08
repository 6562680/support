<?php

namespace Gzhegow\Support\Traits;

use Gzhegow\Support\ICmp;


/**
 * Trait
 */
trait CmpAwareTrait
{
    /**
     * @var ICmp
     */
    protected $cmp;


    /**
     * @param ICmp $cmp
     *
     * @return void
     */
    public function setCmp(ICmp $cmp)
    {
        $this->cmp = $cmp;
    }
}