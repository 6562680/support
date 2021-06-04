<?php

namespace Gzhegow\Support;


/**
 * Debug
 */
class Debug
{
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
     * Извлекает определенные колонки из debug_backtrace()/$throwable->getTrace()
     * может соединить их через разделитель в строку
     *
     * @param array       $trace
     * @param array       $columns
     * @param null|string $implode
     *
     * @return array
     */
    public function trace(array $trace, array $columns = [], string $implode = null) : array
    {
        $result = [];

        $shouldBreak = false;
        foreach ( $trace as $idx => $line ) {
            if (! is_int($idx)) {
                $line = $trace;
                $shouldBreak = true;
            }

            $data = [];

            if (! $columns) {
                $data = $line;

            } else {
                if (count($columns) === 1) {
                    $data = $line[ reset($columns) ];

                } else {
                    foreach ( $columns as $column ) {
                        $data[ $column ] = $line[ $column ] ?? '<' . $column . '>';
                    }
                }
            }

            if (is_array($data)) {
                if ($implode) {
                    $result[ $idx ] = implode($implode, $data);

                } else {
                    $args = $this->args($line[ 'args' ]);

                    $result[ $idx ] = $data;
                    $result[ $idx ][ 'args' ] = $this->printR($args, 1);
                }
            } else {
                $result[ $idx ] = $data;
            }

            if ($shouldBreak) {
                break;
            }
        }

        return null
            ?? ( count($result) === 1 ? reset($result) : null )
            ?? $result;
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
}
