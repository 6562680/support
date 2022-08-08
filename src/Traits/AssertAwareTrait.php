<?php

namespace Gzhegow\Support\Traits;

use Gzhegow\Support\IAssert;


/**
 * Trait
 */
trait AssertAwareTrait
{
    /**
     * @var IAssert
     */
    protected $assert;


    /**
     * @param IAssert $assert
     *
     * @return void
     */
    public function setAssert(IAssert $assert)
    {
        $this->assert = $assert;
    }
}