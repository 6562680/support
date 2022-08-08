<?php

namespace Gzhegow\Support\Interfaces;

use Gzhegow\Support\IUri;


/**
 * Interface
 */
interface UriAwareInterface
{
    /**
     * @param IUri $arr
     *
     * @return void
     */
    public function setUri(IUri $arr);
}