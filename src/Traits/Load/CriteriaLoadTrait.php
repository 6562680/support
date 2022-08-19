<?php

namespace Gzhegow\Support\Traits\Load;

use Gzhegow\Support\ICriteria;
use Gzhegow\Support\SupportFactory;


/**
 * Trait
 */
trait CriteriaLoadTrait
{
    /**
     * @var ICriteria
     */
    protected $criteria;


    /**
     * @param null|ICriteria $criteria
     *
     * @return static
     */
    public function withCriteria(?ICriteria $criteria)
    {
        $this->criteria = $criteria;

        return $this;
    }


    /**
     * @return ICriteria
     */
    protected function loadCriteria() : ICriteria
    {
        return SupportFactory::getInstance()->getCriteria();
    }


    /**
     * @return ICriteria
     */
    public function getCriteria() : ICriteria
    {
        return $this->criteria = $this->criteria
            ?? $this->loadCriteria();
    }
}