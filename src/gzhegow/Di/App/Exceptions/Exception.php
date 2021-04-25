<?php

namespace Gzhegow\Di\App\Exceptions;

use Psr\Container\ContainerExceptionInterface;
use Gzhegow\Support\Exceptions\Exception as SupportException;

/**
 * Exception
 */
class Exception extends SupportException implements ContainerExceptionInterface
{
}
