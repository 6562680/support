<?php

namespace Gzhegow\Support\Exceptions\Domain;


/**
 * ExceptionInterface
 */
interface ExceptionInterface
{
    const CODE_UNKNOWN = -1;

    const THE_CODE_LIST = [
        ExceptionInterface::class => self::CODE_UNKNOWN,
    ];
}
