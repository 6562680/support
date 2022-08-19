<?php

namespace Gzhegow\Support\Interfaces\Aware;

use Gzhegow\Support\IArr;


/**
 * Interface
 */
interface ArrAwareInterface
{
    /**
     * @param IArr $arr
     *
     * @return void
     */
    public function setArr(IArr $arr);
}