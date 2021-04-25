<?php

namespace Gzhegow\Di\Domain\Provider;

/**
 * ProviderFactoryInterface
 */
interface ProviderFactoryInterface
{
    /**
     * @param string $name
     *
     * @return ProviderInterface
     */
    public function newProvider(string $name) : ProviderInterface;
}
