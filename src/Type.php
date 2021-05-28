<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Generated\GeneratedType;


/**
 * Type
 *
 * Этот класс оборачивает Filter и конвертирует результаты в булев тип
 * Это может пригодится при фильтрации массива через array_filter, где не удобно отсеивать null/false/0/0.0/'0'/''/[]
 */
class Type extends GeneratedType
{
    /**
     * @return Filter
     */
    public function filter() : Filter
    {
        return $this->filter;
    }

    /**
     * @return Assert
     */
    public function assert() : Assert
    {
        return $this->filter->assert();
    }

    /**
     * @return Php
     */
    public function php() : Php
    {
        return $this->filter->php();
    }

    /**
     * @return Type
     */
    public function type() : Type
    {
        return $this;
    }
}
