<?php

namespace Gzhegow\Support\Interfaces;

use Gzhegow\Support\IFilter;


/**
 * Interface
 */
interface FilterAwareInterface
{
    /**
     * @param IFilter $arr
     *
     * @return void
     */
    public function setFilter(IFilter $arr);
}