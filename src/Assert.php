<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Generated\GeneratedAssert;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;
use Gzhegow\Support\Exceptions\Runtime\UnexpectedValueException;


/**
 * Assert
 *
 * Этот класс оборачивает Filter и бросает исключение, если фильтрация неудачная. Если все хорошо - вернет исходное значение
 * Это может пригодится при проверка входящих данных в сеттерах и бизнеслогике в одну строку
 */
class Assert extends GeneratedAssert
{
    /**
     * @param string $method
     * @param array  $arguments
     *
     * @return bool
     */
    public function __call($method, $arguments)
    {
        if (0 !== strpos($method, 'assert')) {
            throw new BadMethodCallException(
                [ 'TypeService method should start with `assert` like `assertFloat`: %s', $method ],
            );
        }

        $type = substr($method, '6');

        $filtered = null;

        try {
            $filtered = call_user_func_array([ $this->filter, 'filter' . $type ], $arguments);
        }
        catch ( \Throwable $e ) {
        }

        if (null === $filtered) {
            throw new UnexpectedValueException('Invalid ' . $method . ' passed', $arguments);
        }

        return $filtered;
    }


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
     * @return Type
     */
    public function type() : Type
    {
        return $this->filter->type();
    }
}
