<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support\Interfaces;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Exceptions\Runtime\UnexpectedValueException;
use Gzhegow\Support\Php;

interface PhpInterface
{
    /**
     * @param mixed &$value
     *
     * @return bool
     */
    public function isBlank(&$value): bool;

    /**
     * @param mixed &$value
     *
     * @return bool
     */
    public function isNotBlank(&$value): bool;

    /**
     * @param string|mixed $phpKeyword
     *
     * @return bool
     */
    public function isPhpKeyword($phpKeyword): bool;

    /**
     * @param \Closure $func
     * @param string   $returnType
     *
     * @return bool
     */
    public function isFactory(\Closure $func, string $returnType): bool;

    /**
     * @param string|mixed $phpKeyword
     *
     * @return null|string
     */
    public function filterPhpKeyword($phpKeyword): ?string;

    /**
     * проверяет возвращаемый тип у замыкания
     *
     * @param \Closure        $factory
     * @param string|callable $returnType
     *
     * @return null|\Closure
     */
    public function filterFactory(\Closure $factory, $returnType): ?\Closure;

    /**
     * @param mixed &$value
     *
     * @return mixed
     */
    public function assertBlank(&$value);

    /**
     * @param mixed &$value
     *
     * @return mixed
     */
    public function assertNotBlank(&$value);

    /**
     * @param mixed &$value
     *
     * @return mixed
     */
    public function assertIsset(&$value);

    /**
     * @param string $key
     * @param array  $array
     *
     * @return mixed
     */
    public function assertKeyExists(string $key, array $array);

    /**
     * @param string|mixed $phpKeyword
     *
     * @return string
     */
    public function assertPhpKeyword($phpKeyword): string;

    /**
     * @param \Closure $func
     * @param string   $returnType
     *
     * @return \Closure
     */
    public function assertFactory(\Closure $func, $returnType): \Closure;

    /**
     * @param mixed ...$values
     *
     * @return array
     */
    public function flatval(...$values): array;

    /**
     * @param mixed ...$items
     *
     * @return array
     */
    public function listval(...$items): array;

    /**
     * @param mixed ...$lists
     *
     * @return array
     */
    public function listvals(...$lists): array;

    /**
     * Превращает enum-список любой вложенности (значения могут быть в ключах или в полях) в список уникальных значений
     *
     * @param mixed ...$items
     *
     * @return array
     */
    public function enumval(...$items): array;

    /**
     * Превращает каждый аргумент с помощью enumval
     *
     * @param mixed ...$enums
     *
     * @return array
     */
    public function enumvals(...$enums): array;

    /**
     * @param mixed ...$values
     *
     * @return array
     */
    public function unique(...$values): array;

    /**
     * @param mixed ...$values
     *
     * @return array
     */
    public function uniqueFlatten(...$values): array;

    /**
     * @param mixed ...$values
     *
     * @return array
     */
    public function duplicates(...$values): array;

    /**
     * @param mixed ...$values
     *
     * @return array
     */
    public function duplicatesFlatten(...$values): array;

    /**
     * генерирует последовательность типа "каждый с каждым из каждого массива" (все возможные пересечения)
     *
     * @param mixed ...$arrays
     *
     * @return array
     */
    public function sequence(...$arrays): array;

    /**
     * генерирует последовательность типа "каждый с каждым"
     *
     * @param mixed ...$values
     *
     * @return array
     */
    public function sequenceFlatten(...$values): array;

    /**
     * генерирует последовательность типа "битовая маска" (каждое значение есть или нет, могут быть все или ни одного)
     *
     * @param array ...$values
     *
     * @return array
     */
    public function bitmask(...$values): array;

    /**
     * возвращает идентификатор значения любой переменной в виде строки для дальнейшего сравнения
     * идентификаторы могут быть позже использованы другими обьектами
     * поэтому его актуальность до тех пор, пока конкретный обьект существует в памяти
     *
     * @param mixed $value
     *
     * @return string
     */
    public function hash($value): string;

    /**
     * @param mixed ...$values
     *
     * @return array
     */
    public function distinct(array $values): array;

    /**
     * @param object $object
     *
     * @return array
     */
    public function objKeys(object $object): array;

    /**
     * @param object $object
     *
     * @return array
     */
    public function objVars(object $object): array;

    /**
     * @param object $object
     *
     * @return array
     */
    public function objKeysPublic(object $object): array;

    /**
     * @param object $object
     *
     * @return array
     */
    public function objVarsPublic(object $object): array;

    /**
     * @param mixed ...$arguments
     *
     * @return array
     */
    public function kwargs(...$arguments): array;

    /**
     * @param mixed ...$arguments
     *
     * @return array
     */
    public function kwargsFlatten(...$arguments): array;

    /**
     * @param mixed ...$arguments
     *
     * @return array
     */
    public function kwparams(...$arguments): array;

    /**
     * @param mixed ...$arguments
     *
     * @return array
     */
    public function theKwparams(...$arguments): array;

    /**
     * @param mixed ...$arguments
     *
     * @return array
     */
    public function kwparamsFlatten(...$arguments): array;

    /**
     * @param mixed ...$arguments
     *
     * @return array
     */
    public function theKwparamsFlatten(...$arguments): array;

    /**
     * @param int|float|int[]|float[] $sleeps
     *
     * @return Php
     */
    public function sleep(...$sleeps);

    /**
     * выполняет функцию как шаг array_filter
     *
     * @param null|callable $func
     * @param               $arg
     * @param array         $arguments
     *
     * @return bool|array
     */
    public function filter(?callable $func, $arg, ...$arguments): bool;

    /**
     * выполняет функцию как шаг array_map
     *
     * @param null|callable $func
     * @param               $arg
     * @param array         $arguments
     *
     * @return mixed
     */
    public function map(?callable $func, $arg, ...$arguments);

    /**
     * выполняет функцию как шаг array_reduce
     *
     * @param null|callable $func
     * @param               $arg
     * @param null          $carry
     * @param array         $arguments
     *
     * @return mixed
     */
    public function reduce(?callable $func, $arg, $carry = null, ...$arguments);

    /**
     * bind
     * копирует тело функции и присваивает аргументы на их места в переданном порядке
     * bind('is_array', [], 1, 2) -> Closure of (function is_array($var = []))
     *
     * @param callable $func
     * @param mixed    ...$arguments
     *
     * @return \Closure
     */
    public function bind(callable $func, ...$arguments): \Closure;

    /**
     * call
     * шорткат для call_user_func с рефлексией, чтобы передать в функцию ожидаемое число аргументов
     * для \Closure не имеет смысла, а для string callable вполне
     *
     * @param callable $func
     * @param array    $arguments
     *
     * @return mixed
     */
    public function call(callable $func, ...$arguments);

    /**
     * apply
     * шорткат для call_user_func_array с рефлексией, чтобы передать в функцию ожидаемое число аргументов
     * для \Closure не имеет смысла, а для string callable вполне
     *
     * @param callable $func
     * @param array    $arguments
     *
     * @return mixed
     */
    public function apply(callable $func, array $arguments);

    /**
     * @param \ReflectionProperty $reflectionProperty
     *
     * @return null|\ReflectionType
     */
    public function reflectionPropertyGetType(\ReflectionProperty $reflectionProperty);

    /**
     * @param \ReflectionProperty $reflectionProperty
     *
     * @return null|bool
     */
    public function reflectionPropertyHasDefaultValue(\ReflectionProperty $reflectionProperty): ?bool;

    /**
     * Выполняет func_get_arg($num) позволяя задать вероятные позиции аргумента и отфильтровать их
     *
     * @param null|array    $args
     * @param int|int[]     $num
     * @param null|callable $coalesce
     *
     * @return null|mixed
     */
    public function overload(?array &$args, $num, callable $coalesce = null);

    /**
     * Выполняет func_get_arg($num) позволяя задать вероятные позиции аргумента и проверить их
     *
     * @param null|array    $args
     * @param int|int[]     $num
     * @param null|callable $if
     *
     * @return null|mixed
     */
    public function overloadIf(?array &$args, $num, callable $if = null);
}
