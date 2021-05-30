<?php

namespace Gzhegow\Support\Domain\Debug;


/**
 * TestCaseTrait
 *
 * Если вы пишите "неправильные" тесты и позволяете себе проверять несколько исключений в одном методе - подключите трейт
 */
trait TestCaseTrait
{
    /**
     * @param string $className
     *
     * @return \PHPUnit\Framework\Constraint\Exception
     *
     * @noinspection PhpFullyQualifiedNameUsageInspection
     */
    protected function newConstraintException(string $className)
    {
        $class = 'PHPUnit\Framework\Constraint\Exception';

        return new $class($className);
    }


    /**
     * @param string        $type
     * @param string|null   $message
     * @param null|callable $tryFunc
     * @param null|callable $catchFunc
     * @param null|callable $finallyFunc
     */
    protected function assertException($type, $message = null,
        $tryFunc = null, $catchFunc = null, $finallyFunc = null
    )
    {
        $args = array_slice(func_get_args(), 1, 3);
        foreach ( $args as $arg ) {
            if (is_string($arg)) {
                $message = $arg;

            } elseif (is_callable($arg)) {
                if (! $tryFunc) {
                    $tryFunc = $arg;

                } elseif (! $catchFunc) {
                    $catchFunc = $arg;

                } elseif (! $finallyFunc) {
                    $finallyFunc = $arg;

                }
            }
        }

        $message = is_string($message) && $message
            ? $message
            : 'Failed exception was thrown: ' . $type;

        $catched = false;

        if (! $tryFunc) {
            $this->{'expectException'}($type);

        } else {
            $result = null;
            $exception = null;
            try {
                $result = call_user_func($tryFunc);
            }
            catch ( \Exception $exception ) {
                $catched = true;

                $this->{'assertThat'}($exception, $this->newConstraintException($type));

                if ($catchFunc) {
                    $catchFunc($exception);
                }
            }
            finally {
                if ($finallyFunc) {
                    $finallyFunc($result, $exception);
                }
            }
        }

        $this->{'assertTrue'}($catched, $message);
    }


    /**
     * @return void
     */
    protected function setUp() : void
    {
        if (! static::$boot) {
            static::boot();

            static::$boot = true;
        }
    }


    /**
     * @return void
     */
    protected static function boot() : void
    {
    }


    /**
     * @var bool
     */
    protected static $boot = false;
}
