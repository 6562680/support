<?php

namespace Gzhegow\Support\Traits\Load;

use Gzhegow\Support\ICurl;
use Gzhegow\Support\SupportFactory;


/**
 * Trait
 */
trait CurlLoadTrait
{
    /**
     * @var ICurl
     */
    protected $curl;


    /**
     * @param null|ICurl $curl
     *
     * @return static
     */
    public function withCurl(?ICurl $curl)
    {
        $this->curl = $curl;

        return $this;
    }


    /**
     * @return ICurl
     */
    protected function loadCurl() : ICurl
    {
        return SupportFactory::getInstance()->getCurl();
    }


    /**
     * @return ICurl
     */
    public function getCurl() : ICurl
    {
        return $this->curl = $this->curl
            ?? $this->loadCurl();
    }
}