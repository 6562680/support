<?php

namespace Gzhegow\Support\Traits\Load;

use Gzhegow\Support\IProf;
use Gzhegow\Support\SupportFactory;


/**
 * Trait
 */
trait ProfLoadTrait
{
    /**
     * @var IProf
     */
    protected $prof;


    /**
     * @param null|IProf $prof
     *
     * @return static
     */
    public function withProf(?IProf $prof)
    {
        $this->prof = $prof;

        return $this;
    }


    /**
     * @return IProf
     */
    protected function loadProf() : IProf
    {
        return SupportFactory::getInstance()->getProf();
    }


    /**
     * @return IProf
     */
    public function getProf() : IProf
    {
        return $this->prof = $this->prof
            ?? $this->loadProf();
    }
}