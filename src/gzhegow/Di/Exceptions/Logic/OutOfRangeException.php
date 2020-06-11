<?php

namespace Gzhegow\Di\Exceptions;

use Psr\Container\NotFoundExceptionInterface;

class OutOfRangeException extends LogicException implements NotFoundExceptionInterface
{
}