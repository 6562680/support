<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Facades\Generated\Arr as ArrGenerated;
use Gzhegow\Support\Arr as _Arr;

class Arr extends ArrGenerated
{
    public static function getInstance() : _Arr
    {
        return new _Arr(
            Filter::getInstance(),
            Php::getInstance(),
            Str::getInstance()
        );
    }
}
