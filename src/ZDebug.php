<?php
/**
 * @noinspection RedundantSuppression
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support;

use Gzhegow\Support\Domain\Debug\Message;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * ZDebug
 */
class ZDebug implements IDebug
{
    /**
     * @param string|array|mixed $message
     * @param mixed              ...$arguments
     *
     * @return null|Message
     */
    public function messageVal($message, ...$arguments) : ?Message
    {
        $val = null;

        $placeholders = null;
        if (is_a($message, Message::class)) {
            $val = $message;

        } elseif (is_a($message, \Throwable::class)) {
            $val = new Message($message->getMessage());

        } elseif (is_string($message) || is_array($message)) {
            $placeholders = is_array($message)
                ? $message
                : [ $message ];

            $text = array_shift($placeholders);
            if (! is_string($text)) {
                return null;
            }

            $text = trim($text);
            if ('' === $text) {
                return null;
            }

            $placeholders = array_replace($placeholders, $arguments);

            $val = new Message($text, ...$arguments);
        }

        return $val;
    }

    /**
     * @param string|array|mixed $message
     * @param mixed              ...$arguments
     *
     * @return Message
     */
    public function theMessageVal($message, ...$arguments) : Message
    {
        if (null === ( $val = $this->messageVal($message, ...$arguments) )) {
            throw new InvalidArgumentException(
                [ 'Invalid Message passed: %s', func_get_args() ]
            );
        }

        return $val;
    }


    /**
     * @param null|array|\Throwable|mixed $trace
     * @param null|int                    $limit
     * @param null|int                    $options
     *
     * @return null|array
     */
    public function traceVal($trace = null, int $limit = null, int $options = null) : ?array
    {
        $limit = max(0, $limit ?? 0);
        $options = $options ?? DEBUG_BACKTRACE_PROVIDE_OBJECT;

        if (is_null($trace)) {
            $trace = debug_backtrace($options, $limit);

        } elseif (is_a($trace, \Throwable::class)) {
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
                if (! isset(static::getTraceKeys()[ $key ])) {
                    return null;
                }
            }
        }

        return $trace;
    }

    /**
     * @param null|array|\Throwable|mixed $trace
     * @param null|int                    $limit
     * @param null|int                    $options
     *
     * @return array
     */
    public function theTraceVal($trace = null,
        int $limit = null,
        int $options = null
    ) : array
    {
        if (null === ( $traceVal = $this->traceVal($trace, $limit, $options) )) {
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
            ?? array_keys(static::getTraceKeys());

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
     * @return IDebug
     */
    public static function getInstance() : IDebug
    {
        return SupportFactory::getInstance()->getDebug();
    }


    /**
     * @return bool[]
     */
    protected static function getTraceKeys() : array
    {
        return [
            'function' => true,
            'line'     => true,
            'file'     => true,
            'class'    => true,
            'object'   => true,
            'type'     => true,
            'args'     => true,
        ];
    }
}
