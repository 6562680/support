<?php
/**
 * @noinspection RedundantSuppression
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support;


/**
 * XArr
 */
class XItertools implements IItertools
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
    public function range(int $start, int $end = null, int $step = null, bool $equal = null) : \Generator
    {
        $step = $step ?? 1;
        $equal = $equal ?? false;

        if (0 === $step) {
            return;
        }

        $isReverse = $step < 0;

        if ($isReverse) {
            $end = $end ?? 0;

        } else {
            if (! isset($end)) {
                [ $end, $start ] = [ $start, $end ];
            }

            $start = $start ?? 0;
        }

        // dd($start, $end, $isForward, $equal);

        for ( $i = $start;
              null
              ?? ( ( $equal && $isReverse ) ? $i >= $end : null )
              ?? ( $equal ? $i <= $end : null )
              ?? ( $isReverse ? $i > $end : null )
              ?? ( $i < $end );
            //
              $i += $step
        ) {
            yield $i;
        }
    }


    /**
     * reversed([ 'A', 'B', 'C' ]) --> C B A
     *
     * @param iterable $it
     *
     * @return \Generator
     */
    public function reversed(iterable $it) : \Generator
    {
        $array = [];
        foreach ( $it as $key => $item ) {
            $array[] = [ $key, $item ];
        }

        for ( end($array); key($array) !== null; prev($array) ) {
            [ $key, $item ] = current($array);

            yield $key => $item;
        }
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
    public function walk(iterable $it,
        bool &$continue = null,
        bool $withChildren = null,
        bool $withParents = null,
        bool $withRoot = null
    ) : \Generator
    {
        $continue = $continue ?? false;
        $withChildren = $withChildren ?? true;
        $withParents = $withParents ?? false;
        $withRoot = $withRoot ?? false;

        $stack = [
            [ $it, [] ],
        ];

        $isRoot = true;
        while ( null !== key($stack) ) {
            $cur = array_pop($stack);

            if (! ( is_iterable($cur[ 0 ])
                && ( false
                    || ( is_object($cur[ 0 ]) && $cur[ 0 ]->valid() )
                    || ( is_array($cur[ 0 ]) && ( null !== key($cur[ 0 ]) ) )
                )
            )) {
                if ($withChildren) {
                    yield $cur[ 1 ] => $cur[ 0 ];
                }

            } else {
                if (( $withParents && ! $isRoot )
                    || ( $withRoot && $isRoot )
                ) {
                    yield $cur[ 1 ] => $cur[ 0 ];
                }

                if ($continue) continue;

                foreach ( $this->reversed($cur[ 0 ]) as $kk => $child ) {
                    $fullpath = $cur[ 1 ];
                    $fullpath[] = $kk;

                    $stack[] = [ $cur[ 0 ][ $kk ], $fullpath ];
                }
            }

            $isRoot = false;
        }
    }


    /**
     * product('ABCD', 'xy') --> Ax Ay Bx By Cx Cy Dx Dy
     *
     * @param iterable ...$iterables
     *
     * @return \Generator
     */
    public function product(iterable ...$iterables) : \Generator
    {
        $pools = [];
        foreach ( $iterables as $i => $iterable ) {
            foreach ( $iterable as $ii => $v ) {
                $pools[ $i ][ $ii ] = $v;
            }
        }

        $result = [ [] ];
        foreach ( $pools as $pool ) {
            $resultCurrent = [];
            foreach ( $result as $x ) {
                foreach ( $pool as $y ) {
                    $resultCurrent[] = array_merge($x, [ $y ]);
                }
            }

            $result = $resultCurrent;
        }

        foreach ( $result as $item ) {
            yield $item;
        }
    }

    /**
     * productRepeat(3, range(2)) --> 000 001 010 011 100 101 110 111
     *
     * @param null|int $repeat
     * @param iterable ...$iterables
     *
     * @return \Generator
     */
    public function productRepeat(?int $repeat, iterable ...$iterables) : \Generator
    {
        $repeat = $repeat ?? 1;
        $repeat = max(0, $repeat);

        $pools = [];
        foreach ( $iterables as $i => $iterable ) {
            foreach ( $iterable as $ii => $v ) {
                $pools[ $i ][ $ii ] = $v;
            }
        }

        $list = [];
        for ( $i = 0; $i < $repeat; $i++ ) {
            $list[] = $pools;
        }

        $pools = array_merge(...$list);

        yield from $this->product(...$pools);
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
    public function permutations(iterable $it, int $len = null) : \Generator
    {
        $pool = [];
        foreach ( $it as $v ) {
            $pool[] = $v;
        }

        $size = count($pool);

        $len = $len ?? $size;

        if ($len > $size) {
            return;
        }

        $indices = [];
        foreach ( $this->range($size) as $i ) {
            $indices[] = $i;
        }

        $row = [];
        foreach ( array_slice($indices, 0, $len) as $i ) {
            $row[] = $pool[ $i ];
        }
        yield $row;

        $cycles = iterator_to_array($this->range($size, $size - $len, -1));

        while ( $size ) {
            $found = null;
            foreach ( $this->range($len - 1, 0, -1, true) as $i ) {
                $cycles[ $i ] -= 1;

                if ($cycles[ $i ] === 0) {
                    array_splice($indices, $i, count($indices), array_merge(
                        array_slice($indices, $i + 1),
                        array_slice($indices, $i, 1),
                    ));

                    $cycles[ $i ] = $size - $i;

                } else {
                    $j = $cycles[ $i ];

                    [
                        $indices[ $i ],
                        $indices[ count($indices) - $j ],
                    ] = [
                        $indices[ count($indices) - $j ],
                        $indices[ $i ],
                    ];

                    $row = [];
                    foreach ( array_slice($indices, 0, $len) as $ii ) {
                        $row[] = $pool[ $ii ];
                    }
                    yield $row;

                    $found = $i;
                    break;
                }
            }

            if (null === $found) {
                return;
            }
        }
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
    public function combinations(iterable $it, int $len) : ?\Generator
    {
        $pool = [];
        foreach ( $it as $v ) {
            $pool[] = $v;
        }

        $size = count($pool);

        if ($len > $size) {
            return;
        }

        $row = [];
        $indexes = [];
        foreach ( $this->range($len) as $i ) {
            $row[] = $pool[ $i ];
            $indexes[] = $i;
        }
        yield $row;

        while ( true ) {
            $found = null;
            foreach ( $this->range($len - 1, 0, -1, true) as $i ) {
                if ($indexes[ $i ] !== $i + $size - $len) {
                    $found = $i;
                    break;
                }
            }

            if (null === $found) {
                return;
            }

            $i = $found;

            $indexes[ $i ] += 1;

            foreach ( $this->range($i + 1, $len) as $j ) {
                $indexes[ $j ] = $indexes[ $j - 1 ] + 1;
            }

            $row = [];
            foreach ( $indexes as $i ) {
                $row[] = $pool[ $i ];
            }
            yield $row;
        }
    }

    /**
     * combinationsAll([ 'A', 'B', 'C' ], 2) --> AA AB AC BB BC CC
     *
     * @param iterable $it
     * @param int      $len
     *
     * @return \Generator
     */
    public function combinationsAll(iterable $it, int $len) : ?\Generator
    {
        $pool = [];
        foreach ( $it as $v ) {
            $pool[] = $v;
        }

        $size = count($pool);

        if (! $size && $len) {
            return;
        }

        $row = [];
        $indices = [];
        foreach ( $this->range($len) as $i ) {
            $indices[] = 0;
            $row[] = $pool[ 0 ];
        }
        yield $row;

        while ( true ) {
            $found = null;
            foreach ( $this->range($len - 1, 0, -1, true) as $i ) {
                if ($indices[ $i ] !== ( $size - 1 )) {
                    $found = $i;
                    break;
                }
            }

            if (null === $found) {
                return;
            }

            $i = $found;

            $replace = [];
            foreach ( $this->range($len - $i) as $ii ) {
                $replace[] = $indices[ $i ] + 1;
            }

            array_splice($indices, $i, count($indices), $replace);

            $row = [];
            foreach ( $indices as $i ) {
                $row[] = $pool[ $i ];
            }
            yield $row;
        }
    }


    /**
     * @return IItertools
     */
    public static function getInstance() : IItertools
    {
        return SupportFactory::getInstance()->getItertools();
    }
}