<?php

namespace Gzhegow\Support\Traits\Load;

use Gzhegow\Support\INum;
use Gzhegow\Support\SupportFactory;


/**
 * Trait
 */
trait NumLoadTrait
{
    /**
     * @var INum
     */
    protected $num;


    /**
     * @param null|INum $num
     *
     * @return static
     */
    public function withNum(?INum $num)
    {
        $this->num = $num;

        return $this;
    }


    /**
     * @return INum
     */
    protected function loadNum() : INum
    {
        return SupportFactory::getInstance()->getNum();
    }


    /**
     * @return INum
     */
    public function getNum() : INum
    {
        return $this->num = $this->num
            ?? $this->loadNum();
    }
}