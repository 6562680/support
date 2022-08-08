<?php

namespace Gzhegow\Support\Traits;

use Gzhegow\Support\INet;


/**
 * Trait
 */
trait NetAwareTrait
{
    /**
     * @var INet
     */
    protected $net;


    /**
     * @param INet $net
     *
     * @return void
     */
    public function setNet(INet $net)
    {
        $this->net = $net;
    }
}