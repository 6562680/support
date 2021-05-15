<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Type as _Type;
use Gzhegow\Support\Facades\Generated\Type as TypeGenerated;

class Type extends TypeGenerated
{
    public static function getInstance() : _Type
    {
        return new _Type(
            Filter::getInstance()
        );
    }
}
