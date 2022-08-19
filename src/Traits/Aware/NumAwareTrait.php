<?php

namespace Gzhegow\Support\Traits\Aware;

use Gzhegow\Support\INum;


/**
 * Trait
 */
trait NumAwareTrait
{
    /**
     * @var INum
     */
    protected $num;


    /**
     * @param INum $num
     *
     * @return void
     */
    public function setNum(INum $num)
    {
        $this->num = $num;
    }
}