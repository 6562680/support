<?php

namespace Gzhegow\Di\Exceptions;

use Psr\Container\ContainerExceptionInterface;
use Gzhegow\Support\Exceptions\RuntimeException as SupportRuntimeException;

class RuntimeException extends SupportRuntimeException implements ContainerExceptionInterface
{
}