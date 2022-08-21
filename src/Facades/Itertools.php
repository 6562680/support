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

use Gzhegow\Support\IItertools;
use Gzhegow\Support\SupportFactory;
use Gzhegow\Support\XItertools;

class Itertools
{
    /**
     * range(2) -> 0 1
     * range(0,2) -> 0 1
     * range(2,0,-1) -> 2 1
     * range(2,0,-1,true) -> 2 1 0
     *
     * @param int       $start
     * @param int|null  $end
     * @param int|null  $step
     * @param null|bool $equal
     *
     * @return \Generator
     */
    public static function range(int $start, int $end = null, int $step = null, bool $equal = null): \Generator
    {
        yield from static::getInstance()->range($start, $end, $step, $equal);
    }

    /**
     * reversed([ 'A', 'B', 'C' ]) --> C B A
     *
     * @param iterable $it
     *
     * @return \Generator
     */
    public static function reversed(iterable $it): \Generator
    {
        yield from static::getInstance()->reversed($it);
    }

    /**
     * array_walk_recursive (для итераторов) реализованный через стек и позволяющий получить путь до элемента
     * в итераторах нельзя изменить значение по ссылке, если вам это требуется используйте Arr::walk
     *
     * @param iterable  $it
     * @param null|bool $continue
     * @param null|bool $withChildren
     * @param null|bool $withParents
     * @param null|bool $withRoot
     *
     * @return \Generator
     */
    public static function walkeach(
        iterable $it,
        bool &$continue = null,
        bool $withChildren = null,
        bool $withParents = null,
        bool $withRoot = null
    ): \Generator {
        yield from static::getInstance()->walkeach($it, $continue, $withChildren, $withParents, $withRoot);
    }

    /**
     * product('ABCD', 'xy') --> Ax Ay Bx By Cx Cy Dx Dy
     *
     * @param iterable ...$iterables
     *
     * @return \Generator
     */
    public static function product(iterable ...$iterables): \Generator
    {
        yield from static::getInstance()->product(...$iterables);
    }

    /**
     * productRepeat(3, range(2)) --> 000 001 010 011 100 101 110 111
     *
     * @param null|int $repeat
     * @param iterable ...$iterables
     *
     * @return \Generator
     */
    public static function productRepeat(?int $repeat, iterable ...$iterables): \Generator
    {
        yield from static::getInstance()->productRepeat($repeat, ...$iterables);
    }

    /**
     * permutations([ 'A', 'B', 'C', 'D' ], 2) --> AB AC AD BA BC BD CA CB CD DA DB DC
     * permutations(range(3)) --> 012 021 102 120 201 210
     *
     * @param iterable $it
     * @param null|int $len
     *
     * @return \Generator
     */
    public static function permutations(iterable $it, int $len = null): \Generator
    {
        yield from static::getInstance()->permutations($it, $len);
    }

    /**
     * combinations([ 'A', 'B', 'C', 'D' ], 2) --> AB AC AD BC BD CD
     * combinations(range(4), 3) --> 012 013 023 123
     *
     * @param iterable $it
     * @param int      $len
     *
     * @return \Generator
     */
    public static function combinations(iterable $it, int $len): ?\Generator
    {
        yield from static::getInstance()->combinations($it, $len);
    }

    /**
     * combinationsAll([ 'A', 'B', 'C' ], 2) --> AA AB AC BB BC CC
     *
     * @param iterable $it
     * @param int      $len
     *
     * @return \Generator
     */
    public static function combinationsAll(iterable $it, int $len): ?\Generator
    {
        yield from static::getInstance()->combinationsAll($it, $len);
    }

    /**
     * @return IItertools
     */
    public static function getInstance(): IItertools
    {
        return SupportFactory::getInstance()->getItertools();
    }
}
