<?php

namespace Gzhegow\Support\Traits\Aware;

use Gzhegow\Support\IArr;


/**
 * Trait
 */
trait ArrAwareTrait
{
    /**
     * @var IArr
     */
    protected $arr;


    /**
     * @param IArr $arr
     *
     * @return void
     */
    public function setArr(IArr $arr)
    {
        $this->arr = $arr;
    }
}