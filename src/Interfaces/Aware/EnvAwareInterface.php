<?php

namespace Gzhegow\Support\Interfaces\Aware;

use Gzhegow\Support\IEnv;


/**
 * Interface
 */
interface EnvAwareInterface
{
    /**
     * @param IEnv $arr
     *
     * @return void
     */
    public function setEnv(IEnv $arr);
}