<?php

namespace Gzhegow\Support\Traits\Load;

use Gzhegow\Support\IFs;
use Gzhegow\Support\SupportFactory;


/**
 * Trait
 */
trait FsLoadTrait
{
    /**
     * @var IFs
     */
    protected $fs;


    /**
     * @param null|IFs $fs
     *
     * @return static
     */
    public function withFs(?IFs $fs)
    {
        $this->fs = $fs;

        return $this;
    }


    /**
     * @return IFs
     */
    protected function loadFs() : IFs
    {
        return SupportFactory::getInstance()->getFs();
    }


    /**
     * @return IFs
     */
    public function getFs() : IFs
    {
        return $this->fs = $this->fs
            ?? $this->loadFs();
    }
}