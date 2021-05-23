<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Generated\GeneratedType;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * Type
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
                'TypeService method should start with `is` like `isFloat`',
                func_get_args()
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
}
