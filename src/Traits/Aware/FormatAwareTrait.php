<?php

namespace Gzhegow\Support\Traits\Aware;

use Gzhegow\Support\IFormat;


/**
 * Trait
 */
trait FormatAwareTrait
{
    /**
     * @var IFormat
     */
    protected $format;


    /**
     * @param IFormat $format
     *
     * @return void
     */
    public function setFormat(IFormat $format)
    {
        $this->format = $format;
    }
}