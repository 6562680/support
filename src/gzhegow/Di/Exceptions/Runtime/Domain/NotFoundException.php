<?php

namespace Gzhegow\Di\Exceptions\Runtime\Domain;

use Gzhegow\Di\Exceptions\RuntimeException;
use Psr\Container\NotFoundExceptionInterface;

/**
 * NotFoundException
 */
class NotFoundException extends RuntimeException implements NotFoundExceptionInterface
{
}
