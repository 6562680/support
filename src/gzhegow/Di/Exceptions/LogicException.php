<?php

namespace Gzhegow\Di\Exceptions;

use Psr\Container\ContainerExceptionInterface;

class LogicException extends \LogicException implements ContainerExceptionInterface
{
}