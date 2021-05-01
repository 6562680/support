<?php

namespace Gzhegow\Di\Exceptions;

use Psr\Container\ContainerExceptionInterface;
use Gzhegow\Support\Exceptions\LogicException as SupportLogicException;

/**
 * LogicException
 */
class LogicException extends SupportLogicException implements ContainerExceptionInterface
{
}
