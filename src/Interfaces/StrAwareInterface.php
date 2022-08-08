<?php

namespace Gzhegow\Support\Interfaces;

use Gzhegow\Support\IStr;


/**
 * Interface
 */
interface StrAwareInterface
{
    /**
     * @param IStr $arr
     *
     * @return void
     */
    public function setStr(IStr $arr);
}