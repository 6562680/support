<?php

namespace Gzhegow\Support\Interfaces\Aware;

use Gzhegow\Support\ILogger;


/**
 * Interface
 */
interface LoggerAwareInterface
{
    /**
     * @param ILogger $logger
     *
     * @return void
     */
    public function setLogger(ILogger $logger);
}