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

interface IItertools
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
    public function range(int $start, int $end = null, int $step = null, bool $equal = null): \Generator;

    /**
     * reversed([ 'A', 'B', 'C' ]) --> C B A
     *
     * @param iterable $it
     *
     * @return \Generator
     */
    public function reversed(iterable $it): \Generator;

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
    public function walk(
        iterable $it,
        bool &$continue = null,
        bool $withChildren = null,
        bool $withParents = null,
        bool $withRoot = null
    ): \Generator;

    /**
     * product('ABCD', 'xy') --> Ax Ay Bx By Cx Cy Dx Dy
     *
     * @param iterable ...$iterables
     *
     * @return \Generator
     */
    public function product(iterable ...$iterables): \Generator;

    /**
     * productRepeat(3, range(2)) --> 000 001 010 011 100 101 110 111
     *
     * @param null|int $repeat
     * @param iterable ...$iterables
     *
     * @return \Generator
     */
    public function productRepeat(?int $repeat, iterable ...$iterables): \Generator;

    /**
     * permutations([ 'A', 'B', 'C', 'D' ], 2) --> AB AC AD BA BC BD CA CB CD DA DB DC
     * permutations(range(3)) --> 012 021 102 120 201 210
     *
     * @param iterable $it
     * @param null|int $len
     *
     * @return \Generator
     */
    public function permutations(iterable $it, int $len = null): \Generator;

    /**
     * combinations([ 'A', 'B', 'C', 'D' ], 2) --> AB AC AD BC BD CD
     * combinations(range(4), 3) --> 012 013 023 123
     *
     * @param iterable $it
     * @param int      $len
     *
     * @return \Generator
     */
    public function combinations(iterable $it, int $len): ?\Generator;

    /**
     * combinationsAll([ 'A', 'B', 'C' ], 2) --> AA AB AC BB BC CC
     *
     * @param iterable $it
     * @param int      $len
     *
     * @return \Generator
     */
    public function combinationsAll(iterable $it, int $len): ?\Generator;
}
