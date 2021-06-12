<?php

namespace Gzhegow\Support;


use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * Debug
 */
class Debug
{
    /**
     * @param string|array|mixed $message
     * @param mixed              ...$arguments
     *
     * @return null|array
     */
    public function messageVal($message, ...$arguments) : ?array
    {
        if (! ( is_string($message) || is_array($message) )) {
            return null;
        }

        $placeholders = is_array($message)
            ? $message
            : [ $message ];

        $text = array_shift($placeholders);

        $placeholders = array_replace($placeholders, $arguments);

        if ('' === $text) {
            return null;
        }

        return [ $text, $placeholders ];
    }

    /**
     * @param string|array|mixed $message
     * @param mixed              ...$arguments
     *
     * @return array
     */
    public function theMessageVal($message, ...$arguments) : array
    {
        if (null === ( $messageVal = $this->messageVal($message, ...$arguments) )) {
            throw new InvalidArgumentException(
                [ 'Invalid msg passed: %s', func_get_args() ]
            );
        }

        return $messageVal;
    }


    /**
     * @param null|array|\Throwable|mixed $trace
     * @param int                         $limit
     * @param int                         $options
     *
     * @return null|array
     */
    public function traceVal($trace = null,
        int $limit = 0,
        int $options = DEBUG_BACKTRACE_PROVIDE_OBJECT
    ) : ?array
    {
        $limit = max(0, $limit);

        if (is_null($trace)) {
            $trace = debug_backtrace($options, $limit);

        } elseif (is_object($trace) && is_a($trace, \Throwable::class)) {
            $trace = $trace->getTrace();

        } elseif (is_array($trace)) {
            foreach ( array_keys($trace) as $i ) {
                if (! is_int($i)) {
                    $trace = [ $trace ];

                    break;
                }
            }
        } else {
            return null;
        }

        if ($limit) {
            array_splice($trace, 0, $limit);
        }

        foreach ( $trace as $t ) {
            foreach ( array_keys($t) as $key ) {
                if (! isset(static::$traceKeys[ $key ])) {
                    return null;
                }
            }
        }

        return $trace;
    }

    /**
     * @param null|array|\Throwable|mixed $trace
     * @param int                         $limit
     * @param int                         $options
     *
     * @return array
     */
    public function theTraceVal($trace = null,
        int $limit = 0,
        int $options = DEBUG_BACKTRACE_PROVIDE_OBJECT
    ) : array
    {
        if (null === ( $traceVal = $this->traceVal($trace) )) {
            throw new InvalidArgumentException(
                [ 'Invalid trace passed: %s', func_get_args() ]
            );
        }

        return $traceVal;
    }


    /**
     * Выводит любой тип для дебага и отчета в исключениях
     *
     * @param mixed $arg
     *
     * @return string
     */
    public function arg($arg) : string
    {
        if (is_null($arg)) {
            $result = '{ NULL }';

        } elseif (is_bool($arg)) {
            $result = $arg
                ? '{ TRUE }'
                : '{ FALSE }';

        } elseif (is_object($arg)) {
            $result = '{ #' . spl_object_id($arg) . ' ' . get_class($arg) . ' }';

        } elseif (is_resource($arg)) {
            $result = '{ Resource #' . intval($arg) . ' }';

        } else {
            $result = $arg;

        }

        return $result;
    }

    /**
     * @param array $args
     *
     * @return string[]
     */
    public function args(array $args) : array
    {
        array_walk_recursive($args, function (&$v) {
            $v = $this->arg($v);
        });

        return $args;
    }


    /**
     * Извлекает определенные колонки из debug_backtrace()/$throwable->getTrace()
     * может соединить их через разделитель в строку
     *
     * @param null|array|\Throwable $trace
     * @param null|string|array     $columns
     * @param null|string           $implode
     * @param null|int              $limit
     * @param null|int              $options
     *
     * @return array
     */
    public function traceReport($trace, $columns = null, string $implode = null,
        int $limit = null,
        int $options = null
    ) : array
    {
        $result = [];

        $trace = $this->theTraceVal($trace, $limit, $options);

        $columns = null
            ?? ( is_array($columns) ? $columns : null )
            ?? ( ! empty($columns) ? [ $columns ] : null )
            ?? array_keys(static::$traceKeys);

        foreach ( $trace as $t ) {
            $data = [];

            foreach ( $columns as $column ) {
                $data[ $column ] = $t[ $column ] ?? '<' . $column . '>';
            }

            $args = null;
            if (isset($data[ 'args' ])) {
                $args = $this->printR(
                    $this->args($data[ 'args' ])
                );

                unset($data[ 'args' ]);
            }

            if ($implode) {
                $join = [];

                $join[] = implode($implode, $data);

                if (isset($args)) {
                    $join[] = $args;
                }

                $result[] = implode("\n", $join);
            }
        }

        return $result;
    }


    /**
     * Рекурсивно собирает из дерева исключений сообщения в список
     *
     * @param null|\Throwable $e
     * @param null|int        $limit
     *
     * @return array
     */
    public function throwableMessages(\Throwable $e, int $limit = -1)
    {
        $messages = [];

        $parent = $e;
        while ( null !== $parent ) {
            $messages[ get_class($parent) ][] = $parent->getMessage();

            if (! $limit--) break;

            $parent = $parent->getPrevious();
        }

        return $messages;
    }


    /**
     * Возвращает результат var_dump, заменяет все пробелы на один
     *
     * @param array $arguments
     *
     * @return string
     */
    public function varDump(...$arguments) : string
    {
        ob_start();

        var_dump(...$arguments);

        $result = $this->dom(
            ob_get_clean()
        );

        return $result;
    }

    /**
     * Запускает print_r, заменяет все пробелы на один
     *
     * @param mixed     $arg
     * @param bool|null $return
     *
     * @return string
     */
    public function printR($arg, bool $return = null) : ?string
    {
        if (! $return) {
            print_r($arg);

            return null;
        }

        $result = $this->dom(
            print_r($arg, $return)
        );

        return $result;
    }

    /**
     * Запускает var_export, заменяет все пробелы на один
     *
     * @param mixed     $arg
     * @param bool|null $return
     *
     * @return string
     */
    public function varExport($arg, bool $return = null) : ?string
    {
        if (! $return) {
            var_export($arg);

            return null;
        }

        $result = $this->dom(
            var_export($arg, $return)
        );

        return $result;
    }


    /**
     * Заменяет любое число пробелов в тексте на один
     *
     * @param string $content
     *
     * @return string
     */
    public function dom(string $content) : string
    {
        return preg_replace("/\s+/m", ' ', $content);
    }


    /**
     * @var bool[]
     */
    protected static $traceKeys = [
        'function' => true,
        'line'     => true,
        'file'     => true,
        'class'    => true,
        'object'   => true,
        'type'     => true,
        'args'     => true,
    ];
}
