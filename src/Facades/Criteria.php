<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Criteria as _Criteria;
use Gzhegow\Support\Facades\Generated\Criteria as CriteriaGenerated;

class Criteria extends CriteriaGenerated
{
    public static function getInstance() : _Criteria
    {
        return new _Criteria(
            Calendar::getInstance(),
            Cmp::getInstance(),
            Filter::getInstance(),
            Str::getInstance()
        );
    }
}
