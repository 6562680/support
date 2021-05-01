<?php

namespace Gzhegow\Di\Exceptions\Exception\Domain;

use Psr\Container\NotFoundExceptionInterface;
use Gzhegow\Di\Exceptions\RuntimeException;

/**
 * NotFoundException
 */
class NotFoundException extends RuntimeException implements NotFoundExceptionInterface
{
}
