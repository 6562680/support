<?php

namespace Gzhegow\Support\Traits\Load\Curl;

use Gzhegow\Support\SupportFactory;
use Gzhegow\Support\Domain\Curl\CurloptManagerInterface;


/**
 * Trait
 */
trait CurloptManagerLoadTrait
{
    /**
     * @var CurloptManagerInterface
     */
    protected $curloptManager;


    /**
     * @param null|CurloptManagerInterface $curloptManager
     *
     * @return static
     */
    public function withCurloptManager(?CurloptManagerInterface $curloptManager)
    {
        $this->curloptManager = $curloptManager;

        return $this;
    }


    /**
     * @return CurloptManagerInterface
     */
    protected function loadCurloptManager() : CurloptManagerInterface
    {
        return SupportFactory::getInstance()->getCurlCurloptManager();
    }


    /**
     * @return CurloptManagerInterface
     */
    public function getCurloptManager() : CurloptManagerInterface
    {
        return $this->curloptManager = $this->curloptManager
            ?? $this->loadCurloptManager();
    }
}