<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Preg as _Preg;
use Gzhegow\Support\Facades\Generated\Preg as PregGenerated;

class Preg extends PregGenerated
{
    public static function getInstance() : _Preg
    {
        return new _Preg(
            Str::getInstance()
        );
    }
}
