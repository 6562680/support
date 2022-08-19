<?php

namespace Gzhegow\Support\Traits\Aware;

use Gzhegow\Support\IFilter;


/**
 * Trait
 */
trait FilterAwareTrait
{
    /**
     * @var IFilter
     */
    protected $filter;


    /**
     * @param IFilter $filter
     *
     * @return void
     */
    public function setFilter(IFilter $filter)
    {
        $this->filter = $filter;
    }
}