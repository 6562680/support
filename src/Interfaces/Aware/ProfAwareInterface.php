<?php

namespace Gzhegow\Support\Interfaces\Aware;

use Gzhegow\Support\IProf;


/**
 * Interface
 */
interface ProfAwareInterface
{
    /**
     * @param IProf $arr
     *
     * @return void
     */
    public function setProf(IProf $arr);
}