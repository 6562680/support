<?php

namespace Gzhegow\Support\Interfaces\Aware;

use Gzhegow\Support\ICurl;


/**
 * Interface
 */
interface CurlAwareInterface
{
    /**
     * @param ICurl $arr
     *
     * @return void
     */
    public function setCurl(ICurl $arr);
}