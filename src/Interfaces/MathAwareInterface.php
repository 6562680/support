<?php

namespace Gzhegow\Support\Interfaces;

use Gzhegow\Support\IMath;


/**
 * Interface
 */
interface MathAwareInterface
{
    /**
     * @param IMath $arr
     *
     * @return void
     */
    public function setMath(IMath $arr);
}