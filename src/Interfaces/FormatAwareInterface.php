<?php

namespace Gzhegow\Support\Interfaces;

use Gzhegow\Support\IFormat;


/**
 * Interface
 */
interface FormatAwareInterface
{
    /**
     * @param IFormat $arr
     *
     * @return void
     */
    public function setFormat(IFormat $arr);
}