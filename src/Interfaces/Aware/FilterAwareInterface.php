<?php

namespace Gzhegow\Support\Interfaces\Aware;

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