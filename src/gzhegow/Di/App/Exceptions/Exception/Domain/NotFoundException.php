<?php

namespace Gzhegow\Di\App\Exceptions\Exception\Domain;

use Psr\Container\NotFoundExceptionInterface;
use Gzhegow\Di\App\Exceptions\RuntimeException;

/**
 * NotFoundException
 */
class NotFoundException extends RuntimeException implements NotFoundExceptionInterface
{
}
