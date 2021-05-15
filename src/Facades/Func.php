<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Func as _Func;
use Gzhegow\Support\Facades\Generated\Func as FuncGenerated;

class Func extends FuncGenerated
{
    public static function getInstance() : _Func
    {
        return new _Func();
    }
}
