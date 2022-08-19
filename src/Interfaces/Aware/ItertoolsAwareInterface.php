<?php

namespace Gzhegow\Support\Interfaces\Aware;

use Gzhegow\Support\IItertools;


/**
 * Interface
 */
interface ItertoolsAwareInterface
{
    /**
     * @param IItertools $itertools
     *
     * @return void
     */
    public function setItertools(IItertools $itertools);
}