<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Filter as _Filter;
use Gzhegow\Support\Facades\Generated\Filter as FilterGenerated;

class Filter extends FilterGenerated
{
    public static function getInstance() : _Filter
    {
        return new _Filter();
    }
}
