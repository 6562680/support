<?php

namespace Gzhegow\Support\Traits;

use Gzhegow\Support\IMath;


/**
 * Trait
 */
trait MathAwareTrait
{
    /**
     * @var IMath
     */
    protected $math;


    /**
     * @param IMath $math
     *
     * @return void
     */
    public function setMath(IMath $math)
    {
        $this->math = $math;
    }
}