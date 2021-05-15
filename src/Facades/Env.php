<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Env as _Env;
use Gzhegow\Support\Facades\Generated\Env as EnvGenerated;

class Env extends EnvGenerated
{
    public static function getInstance() : _Env
    {
        return new _Env();
    }
}
