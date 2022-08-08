<?php

namespace Gzhegow\Support\Interfaces;

use Gzhegow\Support\ICmp;


/**
 * Interface
 */
interface CmpAwareInterface
{
    /**
     * @param ICmp $arr
     *
     * @return void
     */
    public function setCmp(ICmp $arr);
}