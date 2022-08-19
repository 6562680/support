<?php

namespace Gzhegow\Support\Traits\Aware;

use Gzhegow\Support\ILogger;


/**
 * Trait
 */
trait LoggerAwareTrait
{
    /**
     * @var ILogger
     */
    protected $logger;


    /**
     * @param ILogger $logger
     *
     * @return void
     */
    public function setLogger(ILogger $logger)
    {
        $this->logger = $logger;
    }
}