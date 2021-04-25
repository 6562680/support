<?php

namespace Gzhegow\Di\App\Exceptions\Runtime\Domain;

use Gzhegow\Di\App\Exceptions\RuntimeException;
use Psr\Container\NotFoundExceptionInterface;

/**
 * NotFoundException
 */
class NotFoundException extends RuntimeException implements NotFoundExceptionInterface
{
}
