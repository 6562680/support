<?php

namespace Gzhegow\Support\Traits\Aware;

use Gzhegow\Support\ICurl;


/**
 * Trait
 */
trait CurlAwareTrait
{
    /**
     * @var ICurl
     */
    protected $curl;


    /**
     * @param ICurl $curl
     *
     * @return void
     */
    public function setCurl(ICurl $curl)
    {
        $this->curl = $curl;
    }
}