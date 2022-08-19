<?php

namespace Gzhegow\Support\Domain\Exceptions;

use Gzhegow\Support\Traits\Load\DebugLoadTrait;


/**
 * ExceptionTrait
 */
trait ExceptionTrait
{
    use DebugLoadTrait;


    /**
     * @var mixed
     */
    protected $payload;

    /**
     * @var string
     */
    protected $text;

    /**
     * @var string
     */
    protected $textOriginal;
    /**
     * @var null|array
     */
    protected $textPlaceholders;

    /**
     * @var array
     */
    protected $report;
    /**
     * @var array
     */
    protected $reportTrace;


    /**
     * @return array
     */
    protected function loadReportTrace() : array
    {
        $theDebug = $this->getDebug();

        $trace = [];

        $index = [];
        foreach ( $this->{'getTrace'}() as $idx => $step ) {
            $key = implode(':', [
                $step[ 'file' ] ?? '<file>',
                $step[ 'line' ] ?? '<line>',
                $idx,
            ]);

            $trace[ $key ] = $theDebug->buildTraceReport($step);
        }

        return $trace;
    }


    /**
     * @return mixed
     */
    public function getPayload()
    {
        return $this->payload;
    }


    /**
     * @return string
     */
    public function getText() : string
    {
        return $this->text;
    }


    /**
     * @return string
     */
    public function getTextOriginal() : string
    {
        return $this->textOriginal;
    }

    /**
     * @return null|array
     */
    public function getTextPlaceholders() : ?array
    {
        return $this->textPlaceholders;
    }


    /**
     * @return array
     */
    public function getReport() : array
    {
        return [
            'class'   => static::class,
            'text'    => $this->text,
            'payload' => $this->payload,
            'trace'   => $this->getReportTrace(),
        ];
    }

    /**
     * @return array
     */
    public function getReportTrace() : array
    {
        return $this->reportTrace = $this->reportTrace
            ?? $this->loadReportTrace();
    }


    /**
     * @param string|array $message
     *
     * @return string
     */
    protected function parseMessage($message) : string
    {
        $theDebug = $this->getDebug();

        $this->payload = $message;

        $arguments = is_array($message)
            ? $message
            : ( $message ? [ $message ] : [] );

        $textOriginal = array_shift($arguments);

        $textOriginal = ! is_array($textOriginal)
            ? strval($textOriginal)
            : $theDebug->printR($textOriginal, 1);

        if ('' === $textOriginal) {
            throw new \InvalidArgumentException(
                'The `message` text should be non-empty string', null, $this
            );
        }

        $text = $textOriginal;

        $placeholders = null;
        if ($arguments) {
            $placeholders = array_slice($arguments, 0,
                substr_count(
                    str_replace('%%', "\0", $textOriginal),
                    '%'
                )
            );

            $placeholders = $theDebug->args($placeholders);

            foreach ( $placeholders as $idx => $placeholder ) {
                $placeholders[ $idx ] = $theDebug->printR($placeholder, 1);
            }

            $text = vsprintf($textOriginal, $placeholders);
        }

        $this->text = $text;
        $this->textOriginal = $textOriginal;
        $this->textPlaceholders = $placeholders;

        return $text;
    }
}