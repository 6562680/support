<?php

namespace Gzhegow\Support\Interfaces;

use Gzhegow\Support\IType;


/**
 * Interface
 */
interface TypeAwareInterface
{
    /**
     * @param IType $arr
     *
     * @return void
     */
    public function setType(IType $arr);
}