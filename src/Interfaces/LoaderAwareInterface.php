<?php

namespace Gzhegow\Support\Interfaces;

use Gzhegow\Support\ILoader;


/**
 * Interface
 */
interface LoaderAwareInterface
{
    /**
     * @param ILoader $arr
     *
     * @return void
     */
    public function setLoader(ILoader $arr);
}