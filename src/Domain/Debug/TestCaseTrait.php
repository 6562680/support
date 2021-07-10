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
     * @return void
     */
    protected static function boot() : void
    {
    }

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
        $tryCallable = null;
        $catchCallable = null;
        $finallyCallable = null;

        $args = array_slice(func_get_args(), 1);

        foreach ( $args as $arg ) {
            if (is_string($arg)
                && ( null === $message )
            ) {
                $message = $arg;

            } elseif (is_callable($arg)) {
                if (null === $tryCallable) {
                    $tryCallable = $arg;

                } elseif (null === $catchCallable) {
                    $catchCallable = $arg;

                } elseif (null === $finallyCallable) {
                    $finallyCallable = $arg;
                }
            }
        }

        $message = is_string($message) && $message
            ? $message
            : 'Failed exception was thrown: ' . $type;

        $catched = false;

        if (null === $tryCallable) {
            $this->{'expectException'}($type);

        } else {
            $result = null;
            $exception = null;
            try {
                $result = $tryCallable();
            }
            catch ( \Exception $exception ) {
                $catched = true;

                $this->{'assertThat'}($exception, $this->newConstraintException($type));

                if ($catchCallable) {
                    $catchCallable($exception);
                }
            }
            finally {
                if ($finallyCallable) {
                    $finallyCallable($result, $exception);
                }
            }
        }

        $this->{'assertTrue'}($catched, $message);
    }

    /**
     * @var bool
     */
    protected static $boot = false;
}
