<?php

namespace Gzhegow\Support\Traits\Load\Str;

use Gzhegow\Support\SupportFactory;
use Gzhegow\Support\Domain\Str\InflectorInterface;


/**
 * Trait
 */
trait InflectorLoadTrait
{
    /**
     * @var InflectorInterface
     */
    protected $inflector;


    /**
     * @param null|InflectorInterface $inflector
     *
     * @return static
     */
    public function withInflector(?InflectorInterface $inflector)
    {
        $this->inflector = $inflector;

        return $this;
    }


    /**
     * @return InflectorInterface
     */
    protected function loadInflector() : InflectorInterface
    {
        return SupportFactory::getInstance()->getStrInflector();
    }


    /**
     * @return InflectorInterface
     */
    public function getInflector() : InflectorInterface
    {
        return $this->inflector = $this->inflector
            ?? $this->loadInflector();
    }
}