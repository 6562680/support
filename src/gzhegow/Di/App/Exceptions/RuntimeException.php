<?php

namespace Gzhegow\Di\App\Exceptions;

use Psr\Container\ContainerExceptionInterface;
use Gzhegow\Support\Exceptions\RuntimeException as SupportRuntimeException;

/**
 * RuntimeException
 */
class RuntimeException extends SupportRuntimeException implements ContainerExceptionInterface
{
}
