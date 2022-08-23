<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 * @noinspection RedundantSuppression
 */

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Exceptions\Logic\OutOfRangeException;
use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Exceptions\Runtime\UnderflowException;
use Gzhegow\Support\IArr;
use Gzhegow\Support\SupportFactory;
use Gzhegow\Support\Traits\Load\NumLoadTrait;
use Gzhegow\Support\Traits\Load\PhpLoadTrait;
use Gzhegow\Support\Traits\Load\StrLoadTrait;
use Gzhegow\Support\XArr;

class Arr
{
    /**
     * @param string|array $path
     * @param array        $src
     * @param null|mixed   $default
     *
     * @return mixed
     */
    public static function get($path, array &$src, $default = null)
    {
        return static::getInstance()->get($path, $src, $default);
    }

    /**
     * @param string|array $path
     * @param array        $src
     *
     * @return bool
     */
    public static function has($path, array &$src): bool
    {
        return static::getInstance()->has($path, $src);
    }

    /**
     * @param null|array   $dst
     * @param string|array $path
     * @param mixed        $value
     *
     * @return XArr
     */
    public static function set(?array &$dst, $path, $value)
    {
        return static::getInstance()->set($dst, $path, $value);
    }

    /**
     * @param int   $pos
     * @param array $src
     *
     * @return mixed
     */
    public static function getByPos(int $pos, array &$src)
    {
        return static::getInstance()->getByPos($pos, $src);
    }

    /**
     * @param int   $pos
     * @param array $src
     *
     * @return bool
     */
    public static function hasByPos(int $pos, array &$src): bool
    {
        return static::getInstance()->hasByPos($pos, $src);
    }

    /**
     * @param string|array $path
     * @param array        $src
     * @param null|mixed   $default
     *
     * @return mixed
     */
    public static function &getRef($path, array &$src, $default = null)
    {
        return static::getInstance()->getRef($path, $src, $default);
    }

    /**
     * @param int   $pos
     * @param array $src
     *
     * @return mixed
     */
    public static function &getRefByPos(int $pos, array &$src)
    {
        return static::getInstance()->getRefByPos($pos, $src);
    }

    /**
     * @param null|array   $dst
     * @param string|array $path
     * @param mixed        $value
     *
     * @return mixed
     */
    public static function &setRef(?array &$dst, $path, $value)
    {
        return static::getInstance()->setRef($dst, $path, $value);
    }

    /**
     * @param null|array $dst
     * @param int        $pos
     * @param mixed      $value
     *
     * @return mixed
     */
    public static function &setRefByPos(?array &$dst, int $pos, $value)
    {
        return static::getInstance()->setRefByPos($dst, $pos, $value);
    }

    /**
     * @param array|mixed   $array
     * @param null|callable $of
     *
     * @return null|array
     */
    public static function filterArray($array, callable $of = null): ?array
    {
        return static::getInstance()->filterArray($array, $of);
    }

    /**
     * @param array|mixed   $list
     * @param null|callable $of
     *
     * @return null|array
     */
    public static function filterList($list, callable $of = null): ?array
    {
        return static::getInstance()->filterList($list, $of);
    }

    /**
     * @param array|mixed   $dict
     * @param null|callable $of
     *
     * @return null|array
     */
    public static function filterDict($dict, callable $of = null): ?array
    {
        return static::getInstance()->filterDict($dict, $of);
    }

    /**
     * @param array|mixed   $assoc
     * @param null|callable $of
     *
     * @return null|array
     */
    public static function filterAssoc($assoc, callable $of = null): ?array
    {
        return static::getInstance()->filterAssoc($assoc, $of);
    }

    /**
     * проверяет, содержит ли массив вложенные массивы
     *
     * @param array|mixed $array
     * @param null|int    $depth
     *
     * @return null|array
     */
    public static function filterArrayDeep($array, int $depth = null): ?array
    {
        return static::getInstance()->filterArrayDeep($array, $depth);
    }

    /**
     * проверяет, можно ли массив безопасно сериализовать
     *
     * @param array|mixed $array
     *
     * @return null|array
     */
    public static function filterArrayPlain($array): ?array
    {
        return static::getInstance()->filterArrayPlain($array);
    }

    /**
     * проверяет, может ли переменная быть приведена к массиву
     *
     * @param mixed $value
     *
     * @return null|mixed
     */
    public static function filterArrval($value)
    {
        return static::getInstance()->filterArrval($value);
    }

    /**
     * \Generator может передать любой объект в качестве ключа для foreach, пригодится
     *
     * @param int|string|mixed $value
     *
     * @return null|int|string
     */
    public static function filterArrayKey($value)
    {
        return static::getInstance()->filterArrayKey($value);
    }

    /**
     * @param array        $src
     * @param string|array $path
     *
     * @return array
     */
    public static function del(array &$src, ...$path): ?array
    {
        return static::getInstance()->del($src, ...$path);
    }

    /**
     * @param array $src
     * @param int   $pos
     *
     * @return array
     */
    public static function delByPos(array &$src, int $pos): ?array
    {
        return static::getInstance()->delByPos($src, $pos);
    }

    /**
     * @param array        $src
     * @param string|array $path
     *
     * @return bool
     */
    public static function delRef(array &$src, ...$path): bool
    {
        return static::getInstance()->delRef($src, ...$path);
    }

    /**
     * @param array $src
     * @param int   $pos
     *
     * @return bool
     */
    public static function delRefByPos(array &$src, int $pos): bool
    {
        return static::getInstance()->delRefByPos($src, $pos);
    }

    /**
     * @param mixed $value
     *
     * @return null|array
     */
    public static function arrval($value): ?array
    {
        return static::getInstance()->arrval($value);
    }

    /**
     * @param mixed $value
     *
     * @return array
     */
    public static function theArrval($value): array
    {
        return static::getInstance()->theArrval($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|int|float
     */
    public static function keyval($value)
    {
        return static::getInstance()->keyval($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|int|float
     */
    public static function theKeyval($value)
    {
        return static::getInstance()->theKeyval($value);
    }

    /**
     * @param array|mixed ...$values
     *
     * @return array
     */
    public static function listval(...$values): array
    {
        return static::getInstance()->listval(...$values);
    }

    /**
     * @param array|mixed ...$lists
     *
     * @return array
     */
    public static function listvalEach(...$lists): array
    {
        return static::getInstance()->listvalEach(...$lists);
    }

    /**
     * @param array|mixed ...$enums
     *
     * @return array
     */
    public static function enumval(...$enums): array
    {
        return static::getInstance()->enumval(...$enums);
    }

    /**
     * @param array|mixed ...$enums
     *
     * @return array
     */
    public static function enumvalEach(...$enums): array
    {
        return static::getInstance()->enumvalEach(...$enums);
    }

    /**
     * @param string|string[]|array $path
     * @param string|string[]|array $separators
     *
     * @return array
     */
    public static function path($path, $separators = '.'): array
    {
        return static::getInstance()->path($path, $separators);
    }

    /**
     * @param string|string[]|array $path
     * @param string|string[]|array $separators
     *
     * @return string
     */
    public static function pathkey($path, $separators = '.'): string
    {
        return static::getInstance()->pathkey($path, $separators);
    }

    /**
     * @param int|string|array $keys
     * @param null|bool        $uniq
     * @param null|bool        $recursive
     *
     * @return string[]
     */
    public static function keyvals($keys, bool $uniq = null, bool $recursive = null): array
    {
        return static::getInstance()->keyvals($keys, $uniq, $recursive);
    }

    /**
     * @param int|string|array $keys
     * @param null|bool        $uniq
     * @param null|bool        $recursive
     *
     * @return string[]
     */
    public static function theKeyvals($keys, bool $uniq = null, bool $recursive = null): array
    {
        return static::getInstance()->theKeyvals($keys, $uniq, $recursive);
    }

    /**
     * @param array                 $array
     * @param string|string[]|array ...$keys
     *
     * @return array
     */
    public static function only(array $array, ...$keys): array
    {
        return static::getInstance()->only($array, ...$keys);
    }

    /**
     * @param array                 $array
     * @param string|string[]|array ...$keys
     *
     * @return array
     */
    public static function except(array $array, ...$keys): array
    {
        return static::getInstance()->except($array, ...$keys);
    }

    /**
     * очищает указанные ключи в массиве и возвращает новый. если не передать ключи - очистит все
     *
     * @param array                 $array
     * @param string|string[]|array ...$keys
     *
     * @return array
     */
    public static function drop(array $array, ...$keys): array
    {
        return static::getInstance()->drop($array, ...$keys);
    }

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
    public static function slicePos(array $array, int $start, int $end = null, bool $preserveKeys = null): array
    {
        return static::getInstance()->slicePos($array, $start, $end, $preserveKeys);
    }

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
    public static function splicePos(array &$array, int $start, int $end = null, $replacement = null): array
    {
        return static::getInstance()->splicePos($array, $start, $end, $replacement);
    }

    /**
     * array_combine позволяющий передать разное число ключей и значений
     *
     * @param string|array     $keys
     * @param null|mixed|array $values
     * @param null|bool        $drop
     *
     * @return array
     */
    public static function combine(array $keys, $values = null, bool $drop = null): array
    {
        return static::getInstance()->combine($keys, $values, $drop);
    }

    /**
     * array_combine + array_map
     *
     * @param string|array $keys
     * @param iterable     $it
     * @param null|bool    $drop
     *
     * @return array
     */
    public static function combineMap(array $keys, iterable $it, bool $drop = null): array
    {
        return static::getInstance()->combineMap($keys, $it, $drop);
    }

    /**
     * возвращает массив без повторов
     *
     * @param mixed ...$values
     *
     * @return array
     */
    public static function unique(...$values): array
    {
        return static::getInstance()->unique(...$values);
    }

    /**
     * возвращает массив без повторов, в каждом
     *
     * @param mixed ...$arrays
     *
     * @return array
     */
    public static function uniqueEach(...$arrays): array
    {
        return static::getInstance()->uniqueEach(...$arrays);
    }

    /**
     * возвращает дубликаты во входящем массиве
     *
     * @param array|mixed ...$values
     *
     * @return array
     */
    public static function duplicates(...$values): array
    {
        return static::getInstance()->duplicates(...$values);
    }

    /**
     * возвращает дубликаты во входящем массиве, в каждом
     *
     * @param array|mixed ...$arrays
     *
     * @return array
     */
    public static function duplicatesEach(...$arrays): array
    {
        return static::getInstance()->duplicatesEach(...$arrays);
    }

    /**
     * distinct это unique() с сохранением ключей
     *
     * @param array|mixed ...$values
     *
     * @return array
     */
    public static function distinct(...$values): array
    {
        return static::getInstance()->distinct(...$values);
    }

    /**
     * distinct это unique() с сохранением ключей, в каждом
     *
     * @param array|mixed ...$arrays
     *
     * @return array
     */
    public static function distinctEach(...$arrays): array
    {
        return static::getInstance()->distinctEach(...$arrays);
    }

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
    public static function &walk(
        array &$array,
        bool $childrenFirst = null,
        bool $withParents = null,
        bool $withRoot = null
    ): \Generator {
        foreach (static::getInstance()->walk($array, $childrenFirst, $withParents, $withRoot) as $ref) {
            yield $ref;
        }
    }

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
    public static function &walkeach(
        array &$array,
        bool &$continue = null,
        bool $withChildren = null,
        bool $withParents = null,
        bool $withRoot = null
    ): \Generator {
        foreach (static::getInstance()->walkeach($array, $continue, $withChildren, $withParents, $withRoot) as $ref) {
            yield $ref;
        }
    }

    /**
     * обменивает местами номер элемента массива и номер ключа в массиве
     * [ [$a1, $a2], [$b1, $b2]... ] => [ [$a1, $b1], [$a2, $b2]... ]
     *
     * @param array $array
     * @param array ...$arrays
     *
     * @return array
     */
    public static function zip(array $array, array ...$arrays): array
    {
        return static::getInstance()->zip($array, ...$arrays);
    }

    /**
     * разбивает на два по указанному критерию
     *
     * @param array         $array
     * @param callable|null $condition
     *
     * @return array
     */
    public static function two(array $array, callable $condition = null): array
    {
        return static::getInstance()->two($array, $condition);
    }

    /**
     * разбивает на группированный список и остаток, замыкание должно возвращать имя группы
     *
     * @param array         $array
     * @param \Closure|null $fnGroupName
     *
     * @return array
     */
    public static function group(array $array, \Closure $fnGroupName = null): array
    {
        return static::getInstance()->group($array, $fnGroupName);
    }

    /**
     * рекурсивно собирает массив в одноуровневый соединяя ключи через разделитель
     *
     * @param array                 $array
     * @param string|string[]|array $separators
     *
     * @return array
     */
    public static function dot(array $array, $separators = '.'): array
    {
        return static::getInstance()->dot($array, $separators);
    }

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
    public static function dotarr(array $array, $separators = '.'): array
    {
        return static::getInstance()->dotarr($array, $separators);
    }

    /**
     * превращает массив из dot-нотации во вложенный
     *
     * @param array                 $data
     * @param string|string[]|array $separators
     *
     * @return array
     */
    public static function undot(array $data, $separators = '.'): array
    {
        return static::getInstance()->undot($data, $separators);
    }

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
    public static function expand(array $array, int $pos, $value, string $key = null): array
    {
        return static::getInstance()->expand($array, $pos, $value, $key);
    }

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
    public static function expandAfter(array $array, $after, $val, string $key = null, bool $strict = null): array
    {
        return static::getInstance()->expandAfter($array, $after, $val, $key, $strict);
    }

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
    public static function expandMany(array $array, array ...$expands): array
    {
        return static::getInstance()->expandMany($array, ...$expands);
    }

    /**
     * @return IArr
     */
    public static function getInstance(): IArr
    {
        return SupportFactory::getInstance()->getArr();
    }
}
