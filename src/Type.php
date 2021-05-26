<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Generated\GeneratedType;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * Type
 *
 * Этот класс оборачивает Filter и конвертирует результаты в булев тип
 * Это может пригодится при фильтрации массива через array_filter, где не удобно отсеивать null/false/0/0.0/'0'/''/[]
 */
class Type extends GeneratedType
{
    /**
     * @param string $method
     * @param array  $arguments
     *
     * @return bool
     */
    public function __call($method, $arguments)
    {
        if (0 !== strpos($method, 'is')) {
            throw new BadMethodCallException(
                [ 'TypeService method should start with `is` like `isFloat`: %s', $method ],
            );
        }

        $type = substr($method, '2');

        $filtered = null;

        try {
            $filtered = call_user_func_array([ $this->filter, 'filter' . $type ], $arguments);
        }
        catch ( \Throwable $e ) {
        }

        $result = null !== $filtered;

        return $result;
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
        return $this->filter->assert();
    }

    /**
     * @return Type
     */
    public function type() : Type
    {
        return $this;
    }
}
