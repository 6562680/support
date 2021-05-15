<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Str as _Str;
use Gzhegow\Support\Facades\Generated\Str as StrGenerated;

class Str extends StrGenerated
{
    public static function getInstance() : _Str
    {
        return new _Str(
            Filter::getInstance()
        );
    }
}
