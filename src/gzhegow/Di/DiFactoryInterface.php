<?php

namespace Gzhegow\Di;


/**
 * DiFactoryInterface
 */
interface DiFactoryInterface
{
    /**
     * @return Di
     */
    public function newDi() : Di;
}
