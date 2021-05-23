<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Generated\GeneratedAssert;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;
use Gzhegow\Support\Exceptions\Runtime\UnexpectedValueException;


/**
 * Assert
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
                'TypeService method should start with `assert` like `assertFloat`',
                func_get_args()
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
}
