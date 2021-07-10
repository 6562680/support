<?php
/**
 * @noinspection RedundantSuppression
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support;


/**
 * Prof
 */
class Prof implements IProf
{
    /**
     * @var ICalendar
     */
    protected $calendar;


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
     * @param ICalendar $calendar
     */
    public function __construct(
        ICalendar $calendar
    )
    {
        $this->calendar = $calendar;
    }


    /**
     * @param null|string $comment
     *
     * @return float
     */
    public function tick(string $comment = null) : float
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

        $current = null;
        foreach ( $this->ticks as $idx => $float ) {
            $dt = $this->calendar->theDateVal($float);
            $comment = $this->tickComments[ $idx ];

            $time = $current
                ? '+ ' . round(abs($this->calendar->diff($current, $dt)), $decimals)
                : $dt->format(\DateTimeInterface::RFC3339_EXTENDED);

            $report[] = sprintf('%s | %s', $time, $comment);

            $current = $dt;
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
    public static function getInstance()
    {
        return SupportFactory::getInstance()->getProf();
    }
}
