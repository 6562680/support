<?php

namespace Gzhegow\Support\Traits\Load;

use Gzhegow\Support\IStr;
use Gzhegow\Support\SupportFactory;


/**
 * Trait
 */
trait StrLoadTrait
{
    /**
     * @var IStr
     */
    protected $str;


    /**
     * @param null|IStr $str
     *
     * @return static
     */
    public function withStr(?IStr $str)
    {
        $this->str = $str;

        return $this;
    }


    /**
     * @return IStr
     */
    protected function loadStr() : IStr
    {
        return SupportFactory::getInstance()->getStr();
    }


    /**
     * @return IStr
     */
    public function getStr() : IStr
    {
        return $this->str = $this->str
            ?? $this->loadStr();
    }
}