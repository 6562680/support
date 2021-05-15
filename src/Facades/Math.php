<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Math as _Math;
use Gzhegow\Support\Facades\Generated\Math as MathGenerated;

class Math extends MathGenerated
{
    public static function getInstance() : _Math
    {
        return new _Math(
            Php::getInstance(),
            Type::getInstance(),
        );
    }
}
