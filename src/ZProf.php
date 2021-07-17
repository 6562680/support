<?php
/**
 * @noinspection RedundantSuppression
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support;


use Gzhegow\Support\Exceptions\RuntimeException;


/**
 * ZProf
 */
class ZProf implements IProf
{
    /**
     * @var ICalendar
     */
    protected $calendar;
    /**
     * @var IMath
     */
    protected $math;


    /**
     * @var float[]
     */
    protected $ticks = [];
    /**
     * @var string[]
     */
    protected $tickComments = [];


    /**
     * Constructor
     *
     * @param IMath $math
     */
    public function __construct(
        IMath $math
    )
    {
        $this->math = $math;
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
        while ( null !== ( $idx = key($this->ticks) ) ) {
            $float = current($this->ticks);

            $comment = $this->tickComments[ $idx ];

            if ($prev) {
                $dec = $decimals ? ( 1 / pow(10, $decimals) ) : 1;
                $time = '+ ' . ( round($float - $prev, $decimals) + $dec );

            } else {
                $micro = sprintf("%06d", ( $float - floor($float) ) * 1000000);

                try {
                    $dt = new \DateTime(date('Y-m-d H:i:s.' . $micro, $float));
                }
                catch ( \Exception $e ) {
                    throw new RuntimeException($e->getMessage(), null, $e);
                }

                $time = $dt->format(\DateTimeInterface::RFC3339_EXTENDED);
            }

            $report[] = $time . ' | ' . $comment;

            next($this->ticks);

            $prev = $float;
        }

        return $report;
    }


    /**
     * @return static
     */
    public function flush()
    {
        $this->ticks[] = [];
        $this->tickComments[] = [];

        return $this;
    }


    /**
     * @return IProf
     */
    public static function getInstance() : IProf
    {
        return SupportFactory::getInstance()->getProf();
    }
}
