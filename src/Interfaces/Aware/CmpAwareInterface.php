<?php

namespace Gzhegow\Support\Interfaces\Aware;

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