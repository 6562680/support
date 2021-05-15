<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Cmp as _Cmp;
use Gzhegow\Support\Facades\Generated\Cmp as CmpGenerated;

class Cmp extends CmpGenerated
{
    public static function getInstance() : _Cmp
    {
        return new _Cmp(
            Calendar::getInstance(),
            Type::getInstance()
        );
    }
}
