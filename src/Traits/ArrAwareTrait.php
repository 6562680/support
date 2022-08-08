<?php

namespace Gzhegow\Support\Traits;

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