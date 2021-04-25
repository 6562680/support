<?php

namespace Gzhegow\Di\App\Exceptions;

use Psr\Container\ContainerExceptionInterface;
use Gzhegow\Support\Exceptions\LogicException as SupportLogicException;

/**
 * LogicException
 */
class LogicException extends SupportLogicException implements ContainerExceptionInterface
{
}
