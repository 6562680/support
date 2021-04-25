<?php

namespace Gzhegow\Di\Exceptions;

use Psr\Container\ContainerExceptionInterface;
use Gzhegow\Support\Exceptions\Exception as SupportException;

class Exception extends SupportException implements ContainerExceptionInterface
{
}