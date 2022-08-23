<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 * @noinspection RedundantSuppression
 */

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Exceptions\Logic\OutOfRangeException;
use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Exceptions\Runtime\UnderflowException;
use Gzhegow\Support\Traits\Load\NumLoadTrait;
use Gzhegow\Support\Traits\Load\PhpLoadTrait;
use Gzhegow\Support\Traits\Load\StrLoadTrait;

interface IArr
{
    /**
     * @param string|array $path
     * @param array        $src
     * @param null|mixed   $default
     *
     * @return mixed
     */
    public function get($path, array &$src, $default = null);

    /**
     * @param string|array $path
     * @param array        $src
     *
     * @return bool
     */
    public function has($path, array &$src): bool;

    /**
     * @param null|array   $dst
     * @param string|array $path
     * @param mixed        $value
     *
     * @return XArr
     */
    public function set(?array &$dst, $path, $value);

    /**
     * @param int   $pos
     * @param array $src
     *
     * @return mixed
     */
    public function getByPos(int $pos, array &$src);

    /**
     * @param int   $pos
     * @param array $src
     *
     * @return bool
     */
    public function hasByPos(int $pos, array &$src): bool;

    /**
     * @param string|array $path
     * @param array        $src
     * @param null|mixed   $default
     *
     * @return mixed
     */
    public function &getRef($path, array &$src, $default = null);

    /**
     * @param int   $pos
     * @param array $src
     *
     * @return mixed
     */
    public function &getRefByPos(int $pos, array &$src);

    /**
     * @param null|array   $dst
     * @param string|array $path
     * @param mixed        $value
     *
     * @return mixed
     */
    public function &setRef(?array &$dst, $path, $value);

    /**
     * @param null|array $dst
     * @param int        $pos
     * @param mixed      $value
     *
     * @return mixed
     */
    public function &setRefByPos(?array &$dst, int $pos, $value);

    /**
     * @param array|mixed   $array
     * @param null|callable $of
     *
     * @return null|array
     */
    public function filterArray($array, callable $of = null): ?array;

    /**
     * @param array|mixed   $list
     * @param null|callable $of
     *
     * @return null|array
     */
    public function filterList($list, callable $of = null): ?array;

    /**
     * @param array|mixed   $dict
     * @param null|callable $of
     *
     * @return null|array
     */
    public function filterDict($dict, callable $of = null): ?array;

    /**
     * @param array|mixed   $assoc
     * @param null|callable $of
     *
     * @return null|array
     */
    public function filterAssoc($assoc, callable $of = null): ?array;

    /**
     * проверяет, содержит ли массив вложенные массивы
     *
     * @param array|mixed $array
     * @param null|int    $depth
     *
     * @return null|array
     */
    public function filterArrayDeep($array, int $depth = null): ?array;

    /**
     * проверяет, можно ли массив безопасно сериализовать
     *
     * @param array|mixed $array
     *
     * @return null|array
     */
    public function filterArrayPlain($array): ?array;

    /**
     * проверяет, может ли переменная быть приведена к массиву
     *
     * @param mixed $value
     *
     * @return null|mixed
     */
    public function filterArrval($value);

    /**
     * \Generator может передать любой объект в качестве ключа для foreach, пригодится
     *
     * @param int|string|mixed $value
     *
     * @return null|int|string
     */
    public function filterArrayKey($value);

    /**
     * @param array        $src
     * @param string|array $path
     *
     * @return array
     */
    public function del(array &$src, ...$path): ?array;

    /**
     * @param array $src
     * @param int   $pos
     *
     * @return array
     */
    public function delByPos(array &$src, int $pos): ?array;

    /**
     * @param array        $src
     * @param string|array $path
     *
     * @return bool
     */
    public function delRef(array &$src, ...$path): bool;

    /**
     * @param array $src
     * @param int   $pos
     *
     * @return bool
     */
    public function delRefByPos(array &$src, int $pos): bool;

    /**
     * @param mixed $value
     *
     * @return null|array
     */
    public function arrval($value): ?array;

    /**
     * @param mixed $value
     *
     * @return array
     */
    public function theArrval($value): array;

    /**
     * @param mixed $value
     *
     * @return null|int|float
     */
    public function keyval($value);

    /**
     * @param mixed $value
     *
     * @return null|int|float
     */
    public function theKeyval($value);

    /**
     * @param array|mixed ...$values
     *
     * @return array
     */
    public function listval(...$values): array;

    /**
     * @param array|mixed ...$lists
     *
     * @return array
     */
    public function listvalEach(...$lists): array;

    /**
     * @param array|mixed ...$enums
     *
     * @return array
     */
    public function enumval(...$enums): array;

    /**
     * @param array|mixed ...$enums
     *
     * @return array
     */
    public function enumvalEach(...$enums): array;

    /**
     * @param string|string[]|array $path
     * @param string|string[]|array $separators
     *
     * @return array
     */
    public function path($path, $separators = '.'): array;

    /**
     * @param string|string[]|array $path
     * @param string|string[]|array $separators
     *
     * @return string
     */
    public function pathkey($path, $separators = '.'): string;

    /**
     * @param int|string|array $keys
     * @param null|bool        $uniq
     * @param null|bool        $recursive
     *
     * @return string[]
     */
    public function keyvals($keys, bool $uniq = null, bool $recursive = null): array;

    /**
     * @param int|string|array $keys
     * @param null|bool        $uniq
     * @param null|bool        $recursive
     *
     * @return string[]
     */
    public function theKeyvals($keys, bool $uniq = null, bool $recursive = null): array;

    /**
     * @param array                 $array
     * @param string|string[]|array ...$keys
     *
     * @return array
     */
    public function only(array $array, ...$keys): array;

    /**
     * @param array                 $array
     * @param string|string[]|array ...$keys
     *
     * @return array
     */
    public function except(array $array, ...$keys): array;

    /**
     * очищает указанные ключи в массиве и возвращает новый. если не передать ключи - очистит все
     *
     * @param array                 $array
     * @param string|string[]|array ...$keys
     *
     * @return array
     */
    public function drop(array $array, ...$keys): array;

    /**
     * возвращает срез массива по числовым порядковым номерам элементов $arr = [ 1, 2, 3, 4 ] -> $arr[-3:2] -> [ 1 ]
     *
     * @param array     $array
     * @param int       $start
     * @param null|int  $end
     * @param bool|null $preserveKeys
     *
     * @return array
     */
    public function slicePos(array $array, int $start, int $end = null, bool $preserveKeys = null): array;

    /**
     * возвращает срез массива по числовым порядковым номерам элементов (изменяя сам массив) $arr = [ 1, 2, 3, 4 ] -> $arr[-3:2] -> [ 1 ]
     *
     * @param array    $array
     * @param int      $start
     * @param null|int $end
     * @param mixed    $replacement
     *
     * @return array
     */
    public function splicePos(array &$array, int $start, int $end = null, $replacement = null): array;

    /**
     * array_combine позволяющий передать разное число ключей и значений
     *
     * @param string|array     $keys
     * @param null|mixed|array $values
     * @param null|bool        $drop
     *
     * @return array
     */
    public function combine(array $keys, $values = null, bool $drop = null): array;

    /**
     * array_combine + array_map
     *
     * @param string|array $keys
     * @param iterable     $it
     * @param null|bool    $drop
     *
     * @return array
     */
    public function combineMap(array $keys, iterable $it, bool $drop = null): array;

    /**
     * возвращает массив без повторов
     *
     * @param mixed ...$values
     *
     * @return array
     */
    public function unique(...$values): array;

    /**
     * возвращает массив без повторов, в каждом
     *
     * @param mixed ...$arrays
     *
     * @return array
     */
    public function uniqueEach(...$arrays): array;

    /**
     * возвращает дубликаты во входящем массиве
     *
     * @param array|mixed ...$values
     *
     * @return array
     */
    public function duplicates(...$values): array;

    /**
     * возвращает дубликаты во входящем массиве, в каждом
     *
     * @param array|mixed ...$arrays
     *
     * @return array
     */
    public function duplicatesEach(...$arrays): array;

    /**
     * distinct это unique() с сохранением ключей
     *
     * @param array|mixed ...$values
     *
     * @return array
     */
    public function distinct(...$values): array;

    /**
     * distinct это unique() с сохранением ключей, в каждом
     *
     * @param array|mixed ...$arrays
     *
     * @return array
     */
    public function distinctEach(...$arrays): array;

    /**
     * array_walk_recursive реализованный через стек и позволяющий получить путь до элемента
     *
     * @param array     $array
     * @param null|bool $childrenFirst
     * @param null|bool $withParents
     * @param null|bool $withRoot
     *
     * @return \Generator
     */
    public function &walk(
        array &$array,
        bool $childrenFirst = null,
        bool $withParents = null,
        bool $withRoot = null
    ): \Generator;

    /**
     * array_walk_recursive реализованный через стек и позволяющий получить путь до элемента
     * позволяет остановить проход вглубь &$continue = true/false, если обработка уровня закончена, а также обходить "только родителей"
     *
     * @param array     $array
     * @param null|bool $withChildren
     * @param null|bool $withParents
     * @param null|bool $withRoot
     * @param null|bool $continue
     *
     * @return \Generator
     */
    public function &walkeach(
        array &$array,
        bool &$continue = null,
        bool $withChildren = null,
        bool $withParents = null,
        bool $withRoot = null
    ): \Generator;

    /**
     * обменивает местами номер элемента массива и номер ключа в массиве
     * [ [$a1, $a2], [$b1, $b2]... ] => [ [$a1, $b1], [$a2, $b2]... ]
     *
     * @param array $array
     * @param array ...$arrays
     *
     * @return array
     */
    public function zip(array $array, array ...$arrays): array;

    /**
     * разбивает на два по указанному критерию
     *
     * @param array         $array
     * @param callable|null $condition
     *
     * @return array
     */
    public function two(array $array, callable $condition = null): array;

    /**
     * разбивает на группированный список и остаток, замыкание должно возвращать имя группы
     *
     * @param array         $array
     * @param \Closure|null $fnGroupName
     *
     * @return array
     */
    public function group(array $array, \Closure $fnGroupName = null): array;

    /**
     * рекурсивно собирает массив в одноуровневый соединяя ключи через разделитель
     *
     * @param array                 $array
     * @param string|string[]|array $separators
     *
     * @return array
     */
    public function dot(array $array, $separators = '.'): array;

    /**
     * рекурсивно собирает массив в одноуровневый соединяя ключи через разделитель
     * если нет потомков - выводим
     * если потомок - пустой массив - выводим
     * если массив потомков содержит цифровой ключ - обработка ветки останавливается и выводим
     *
     * @param array                 $array
     * @param string|string[]|array $separators
     *
     * @return array
     */
    public function dotarr(array $array, $separators = '.'): array;

    /**
     * превращает массив из dot-нотации во вложенный
     *
     * @param array                 $data
     * @param string|string[]|array $separators
     *
     * @return array
     */
    public function undot(array $data, $separators = '.'): array;

    /**
     * Вставляет элемент в указанную позиции по номеру (начиная с 0), изменяя числовые индексы существующих элементов
     *
     * @param array       $array
     * @param int         $pos
     * @param mixed       $value
     * @param null|string $key
     *
     * @return array
     */
    public function expand(array $array, int $pos, $value, string $key = null): array;

    /**
     * Вставляет элементы в указанные позиции (начиная с 0), изменяя числовые индексы существующих элементов
     *
     * @param array           $array
     * @param null|int|string $after
     * @param mixed           $val
     * @param null|string     $key
     * @param null|bool       $strict
     *
     * @return array
     */
    public function expandAfter(array $array, $after, $val, string $key = null, bool $strict = null): array;

    /**
     * Вставляет элементы в указанные позиции (начиная с 0), изменяя числовые индексы существующих элементов
     *
     * Механизм применяется
     * - в dran-n-drop элементов списка при пользовательской сортировке
     * - в инжекторе зависимостей, чтобы между переданными параметрами воткнуть свой
     *
     * @param array   $array
     * @param array[] ...$expands
     *
     * @return array
     */
    public function expandMany(array $array, array ...$expands): array;
}
