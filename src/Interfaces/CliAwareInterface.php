<?php

namespace Gzhegow\Support\Interfaces;

use Gzhegow\Support\ICli;


/**
 * Interface
 */
interface CliAwareInterface
{
    /**
     * @param ICli $arr
     *
     * @return void
     */
    public function setCli(ICli $arr);
}