<?php

namespace Gzhegow\Support\Traits\Load;

use Gzhegow\Support\ILogger;
use Gzhegow\Support\SupportFactory;


/**
 * Trait
 */
trait LoggerLoadTrait
{
    /**
     * @var ILogger
     */
    protected $logger;


    /**
     * @param null|ILogger $logger
     *
     * @return static
     */
    public function withLogger(?ILogger $logger)
    {
        $this->logger = $logger;

        return $this;
    }


    /**
     * @return ILogger
     */
    protected function loadLogger() : ILogger
    {
        return SupportFactory::getInstance()->getLogger();
    }


    /**
     * @return ILogger
     */
    protected function getLogger() : ILogger
    {
        return $this->logger = $this->logger
            ?? $this->loadLogger();
    }
}