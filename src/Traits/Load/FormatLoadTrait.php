<?php

namespace Gzhegow\Support\Traits\Load;

use Gzhegow\Support\IFormat;
use Gzhegow\Support\SupportFactory;


/**
 * Trait
 */
trait FormatLoadTrait
{
    /**
     * @var IFormat
     */
    protected $format;


    /**
     * @param null|IFormat $format
     *
     * @return static
     */
    public function withFormat(?IFormat $format)
    {
        $this->format = $format;

        return $this;
    }


    /**
     * @return IFormat
     */
    protected function loadFormat() : IFormat
    {
        return SupportFactory::getInstance()->getFormat();
    }


    /**
     * @return IFormat
     */
    public function getFormat() : IFormat
    {
        return $this->format = $this->format
            ?? $this->loadFormat();
    }
}