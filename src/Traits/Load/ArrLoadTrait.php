<?php

namespace Gzhegow\Support\Traits\Load;

use Gzhegow\Support\IArr;
use Gzhegow\Support\SupportFactory;


/**
 * Trait
 */
trait ArrLoadTrait
{
    /**
     * @var IArr
     */
    protected $arr;


    /**
     * @param null|IArr $arr
     *
     * @return static
     */
    public function withArr(?IArr $arr)
    {
        $this->arr = $arr;

        return $this;
    }


    /**
     * @return IArr
     */
    protected function loadArr() : IArr
    {
        return SupportFactory::getInstance()->getArr();
    }


    /**
     * @return IArr
     */
    public function getArr() : IArr
    {
        return $this->arr = $this->arr
            ?? $this->loadArr();
    }
}