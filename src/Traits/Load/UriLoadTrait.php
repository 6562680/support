<?php

namespace Gzhegow\Support\Traits\Load;

use Gzhegow\Support\IUri;
use Gzhegow\Support\SupportFactory;


/**
 * Trait
 */
trait UriLoadTrait
{
    /**
     * @var IUri
     */
    protected $uri;


    /**
     * @param null|IUri $uri
     *
     * @return static
     */
    public function withUri(?IUri $uri)
    {
        $this->uri = $uri;

        return $this;
    }


    /**
     * @return IUri
     */
    protected function loadUri() : IUri
    {
        return SupportFactory::getInstance()->getUri();
    }


    /**
     * @return IUri
     */
    public function getUri() : IUri
    {
        return $this->uri = $this->uri
            ?? $this->loadUri();
    }
}