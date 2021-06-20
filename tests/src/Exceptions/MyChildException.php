<?php

namespace Gzhegow\Support\Tests\Exceptions;


/**
 * MyChildException
 */
class MyChildException extends MyException
{
    const THE_CODE_LIST = [
        MyChildException::class => 2,
    ];
}
