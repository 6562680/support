<?php

namespace Gzhegow\Di\Exceptions\Exception;

use Gzhegow\Di\Exceptions\Exception;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Class NotFoundException
 */
class NotFoundException extends Exception implements NotFoundExceptionInterface
{
}