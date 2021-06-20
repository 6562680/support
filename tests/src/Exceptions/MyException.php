<?php

namespace Gzhegow\Support\Tests\Exceptions;

use Gzhegow\Support\Exceptions\Exception;


/**
 * MyException
 */
class MyException extends Exception
{
    const THE_CODE_LIST = [
        MyException::class => 1,
    ];
}
