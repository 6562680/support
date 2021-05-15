<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Facades\Generated\Bcmath as BcmathGenerated;
use Gzhegow\Support\Bcmath as _Bcmath;

class Bcmath extends BcmathGenerated
{
    public static function getInstance() : _Bcmath
    {
        return new _Bcmath();
    }
}
