<?php

namespace Gzhegow\Support\Traits\Load;

use Gzhegow\Support\IMath;
use Gzhegow\Support\SupportFactory;


/**
 * Trait
 */
trait MathLoadTrait
{
    /**
     * @var IMath
     */
    protected $math;


    /**
     * @param null|IMath $math
     *
     * @return static
     */
    public function withMath(?IMath $math)
    {
        $this->math = $math;

        return $this;
    }


    /**
     * @return IMath
     */
    protected function loadMath() : IMath
    {
        return SupportFactory::getInstance()->getMath();
    }


    /**
     * @return IMath
     */
    public function getMath() : IMath
    {
        return $this->math = $this->math
            ?? $this->loadMath();
    }
}