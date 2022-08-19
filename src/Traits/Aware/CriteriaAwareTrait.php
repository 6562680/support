<?php

namespace Gzhegow\Support\Traits\Aware;

use Gzhegow\Support\ICriteria;


/**
 * Trait
 */
trait CriteriaAwareTrait
{
    /**
     * @var ICriteria
     */
    protected $criteria;


    /**
     * @param ICriteria $criteria
     *
     * @return void
     */
    public function setCriteria(ICriteria $criteria)
    {
        $this->criteria = $criteria;
    }
}