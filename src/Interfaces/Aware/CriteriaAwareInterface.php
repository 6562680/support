<?php

namespace Gzhegow\Support\Interfaces\Aware;

use Gzhegow\Support\ICriteria;


/**
 * Interface
 */
interface CriteriaAwareInterface
{
    /**
     * @param ICriteria $arr
     *
     * @return void
     */
    public function setCriteria(ICriteria $arr);
}