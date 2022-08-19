<?php

namespace Gzhegow\Support\Traits\Load;

use Gzhegow\Support\IFilter;
use Gzhegow\Support\SupportFactory;


/**
 * Trait
 */
trait FilterLoadTrait
{
    /**
     * @var IFilter
     */
    protected $filter;


    /**
     * @param null|IFilter $filter
     *
     * @return static
     */
    public function withFilter(?IFilter $filter)
    {
        $this->filter = $filter;

        return $this;
    }


    /**
     * @return IFilter
     */
    protected function loadFilter() : IFilter
    {
        return SupportFactory::getInstance()->getFilter();
    }


    /**
     * @return IFilter
     */
    public function getFilter() : IFilter
    {
        return $this->filter = $this->filter
            ?? $this->loadFilter();
    }
}