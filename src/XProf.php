<?php
/**
 * @noinspection RedundantSuppression
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support;


use Gzhegow\Support\Exceptions\RuntimeException;


/**
 * XProf
 */
class XProf implements IProf
{
    /**
     * @var float[]
     */
    protected $ticks = [];
    /**
     * @var string[]
     */
    protected $tickComments = [];


    /**
     * @param null|int $decimals
     *
     * @return array
     */
    public function report(int $decimals = null) : array
    {
        $decimals = $decimals ?? 6;

        $report = [];

        $prev = null;
        reset($this->ticks);
        while ( null !== ( $k = key($this->ticks) ) ) {
            $comment = $this->tickComments[ $k ];

            if ($prev) {
                $dec = $decimals ? ( 1 / pow(10, $decimals) ) : 1;
                $time = '+ ' . ( round($this->ticks[ $k ] - $prev, $decimals) + $dec );

            } else {
                $micro = sprintf("%06d", ( $this->ticks[ $k ] - floor($this->ticks[ $k ]) ) * 1000000);

                try {
                    $dt = new \DateTime(date('Y-m-d H:i:s.' . $micro, $this->ticks[ $k ]));
                }
                catch ( \Exception $e ) {
                    throw new RuntimeException($e->getMessage(), null, $e);
                }

                $time = $dt->format(\DateTimeInterface::RFC3339_EXTENDED);
            }

            $report[] = $time . ' | ' . $comment;

            $prev = $this->ticks[ $k ];
            next($this->ticks);
        }

        return $report;
    }


    /**
     * @return static
     */
    public function reset()
    {
        $this->ticks = [];
        $this->tickComments = [];

        return $this;
    }

    /**
     * @param null|int $decimals
     *
     * @return array
     */
    public function flush(int $decimals = null) : array
    {
        $report = $this->report($decimals);

        $this->reset();

        return $report;
    }


    /**
     * @param null|string $comment
     *
     * @return float
     */
    public function tick(?string $comment = '') : float
    {
        if (null === $comment) {
            [ 1 => $prev ] = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);

            $comment = vsprintf('%s::%s - %s (%s)', [
                $prev[ 'class' ] ?? '<class>',
                $prev[ 'function' ] ?? '<func>',
                $prev[ 'file' ] ?? '<file>',
                $prev[ 'line' ] ?? '<line>',
            ]);
        }

        $microtime = microtime(true);

        $this->ticks[] = $microtime;
        $this->tickComments[] = $comment;

        return $microtime;
    }


    /**
     * @return IProf
     */
    public static function getInstance() : IProf
    {
        return SupportFactory::getInstance()->getProf();
    }
}