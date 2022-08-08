<?php

namespace Gzhegow\Support\Traits;

use Gzhegow\Support\IUri;


/**
 * Trait
 */
trait UriAwareTrait
{
    /**
     * @var IUri
     */
    protected $uri;


    /**
     * @param IUri $uri
     *
     * @return void
     */
    public function setUri(IUri $uri)
    {
        $this->uri = $uri;
    }
}