<?php

namespace Gzhegow\Support\Traits;

use Gzhegow\Support\IStr;


/**
 * Trait
 */
trait StrAwareTrait
{
    /**
     * @var IStr
     */
    protected $str;


    /**
     * @param IStr $str
     *
     * @return void
     */
    public function setStr(IStr $str)
    {
        $this->str = $str;
    }
}