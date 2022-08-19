<?php

namespace Gzhegow\Support\Traits\Load;

use Gzhegow\Support\IPath;
use Gzhegow\Support\SupportFactory;


/**
 * Trait
 */
trait PathLoadTrait
{
    /**
     * @var IPath
     */
    protected $path;


    /**
     * @param null|IPath $path
     *
     * @return static
     */
    public function withPath(?IPath $path)
    {
        $this->path = $path;

        return $this;
    }


    /**
     * @return IPath
     */
    protected function loadPath() : IPath
    {
        return SupportFactory::getInstance()->getPath();
    }


    /**
     * @return IPath
     */
    public function getPath() : IPath
    {
        return $this->path = $this->path
            ?? $this->loadPath();
    }
}