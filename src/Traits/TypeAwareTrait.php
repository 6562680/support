<?php

namespace Gzhegow\Support\Traits;

use Gzhegow\Support\IType;


/**
 * Trait
 */
trait TypeAwareTrait
{
    /**
     * @var IType
     */
    protected $type;


    /**
     * @param IType $type
     *
     * @return void
     */
    public function setType(IType $type)
    {
        $this->type = $type;
    }
}