<?php

namespace Gzhegow\Support\Interfaces\Aware;

use Gzhegow\Support\INum;


/**
 * Interface
 */
interface NumAwareInterface
{
    /**
     * @param INum $arr
     *
     * @return void
     */
    public function setNum(INum $arr);
}