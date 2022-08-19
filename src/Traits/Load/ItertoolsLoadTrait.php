<?php

namespace Gzhegow\Support\Traits\Load;

use Gzhegow\Support\IItertools;
use Gzhegow\Support\SupportFactory;


/**
 * Trait
 */
trait ItertoolsLoadTrait
{
    /**
     * @var IItertools
     */
    protected $itertools;


    /**
     * @param null|IItertools $itertools
     *
     * @return static
     */
    public function withItertools(?IItertools $itertools)
    {
        $this->itertools = $itertools;

        return $this;
    }


    /**
     * @return IItertools
     */
    protected function loadItertools() : IItertools
    {
        return SupportFactory::getInstance()->getItertools();
    }


    /**
     * @return IItertools
     */
    public function getItertools() : IItertools
    {
        return $this->itertools = $this->itertools
            ?? $this->loadItertools();
    }
}