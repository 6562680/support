<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Generated\GeneratedAssert;


/**
 * Assert
 *
 * Этот класс оборачивает Filter и бросает исключение, если фильтрация неудачная. Если все хорошо - вернет исходное значение
 * Это может пригодится при проверка входящих данных в сеттерах и бизнеслогике в одну строку
 */
class Assert extends GeneratedAssert
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
        return $this;
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
        return $this->filter->type();
    }
}
