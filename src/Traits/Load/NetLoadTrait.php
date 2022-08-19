<?php

namespace Gzhegow\Support\Traits\Load;

use Gzhegow\Support\INet;
use Gzhegow\Support\SupportFactory;


/**
 * Trait
 */
trait NetLoadTrait
{
    /**
     * @var INet
     */
    protected $net;


    /**
     * @param null|INet $net
     *
     * @return static
     */
    public function withNet(?INet $net)
    {
        $this->net = $net;

        return $this;
    }


    /**
     * @return INet
     */
    protected function loadNet() : INet
    {
        return SupportFactory::getInstance()->getNet();
    }


    /**
     * @return INet
     */
    public function getNet() : INet
    {
        return $this->net = $this->net
            ?? $this->loadNet();
    }
}