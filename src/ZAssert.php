<?php
/**
 * @noinspection RedundantSuppression
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support;

use Gzhegow\Support\Domain\Debug\Message;
use Gzhegow\Support\Generated\GeneratedAssert;


/**
 * ZAssert
 */
class ZAssert extends GeneratedAssert
{
    /**
     * @var IDebug
     */
    protected $debug;


    /**
     * @var Message
     */
    protected $message;
    /**
     * @var \RuntimeException
     */
    protected $throwable;


    /**
     * Constructor
     *
     * @param IDebug  $debug
     * @param IFilter $filter
     */
    public function __construct(
        IDebug $debug,
        IFilter $filter
    )
    {
        $this->debug = $debug;

        parent::__construct($filter);
    }


    /**
     * @return Message
     */
    public function getMessage() : Message
    {
        return $this->message;
    }


    /**
     * @param null|string|array $text
     * @param array             ...$arguments
     *
     * @return null|array
     */
    public function getError($text = null, ...$arguments) : ?array
    {
        $message = null;

        if (null !== $text) {
            $message = $this->debug->theMessageVal($text, ...$arguments)->toArray();

        } elseif (null !== $this->message) {
            $message = $this->message->toArray();
        }

        if ($arguments && ( 1 === count($message) )) {
            $message = array_merge($message, $arguments);
        }

        $this->message = null;

        return $message;
    }

    /**
     * @param null|string|array $text
     * @param array             ...$arguments
     *
     * @return null|array
     */
    public function getErrorOr($text = null, ...$arguments) : ?array
    {
        $message = null;

        if (null !== $this->message) {
            $message = $this->message->toArray();

        } elseif (null !== $text) {
            $message = $this->debug->theMessageVal($text, ...$arguments)->toArray();
        }

        if ($arguments && ( 1 === count($message) )) {
            $message = array_merge($message, $arguments);
        }

        $this->message = null;

        return $message;
    }


    /**
     * @param null|\Throwable $throwable
     *
     * @return null|\RuntimeException
     */
    public function getThrowable(\Throwable $throwable = null) // : ?\Throwable
    {
        $throwable = null
            ?? ( ( null !== $throwable ) ? $throwable : null ) // 1
            ?? $this->throwable // 2
        ;

        $this->throwable = null;

        return $throwable;
    }

    /**
     * @param null|\Throwable $throwable
     *
     * @return null|\RuntimeException
     */
    public function getThrowableOr(\Throwable $throwable = null) // : ?\Throwable
    {
        $throwable = null
            ?? $this->throwable // 1
            ?? ( ( null !== $throwable ) ? $throwable : null ) // 2
        ;

        $this->throwable = null;

        return $throwable;
    }


    /**
     * @param null|string|array|\Throwable $error
     * @param mixed                        ...$arguments
     *
     * @return \Gzhegow\Support\IAssert
     * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
     * @noinspection PhpFullyQualifiedNameUsageInspection
     */
    public function assert($error = null, ...$arguments) : \Gzhegow\Support\IAssert
    {
        $this->error($error, ...$arguments);

        return $this;
    }

    /**
     * @return \Gzhegow\Support\IFilter
     * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
     * @noinspection PhpFullyQualifiedNameUsageInspection
     */
    public function filter() : \Gzhegow\Support\IFilter
    {
        return $this->filter;
    }

    /**
     * @return \Gzhegow\Support\IType
     * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
     * @noinspection PhpFullyQualifiedNameUsageInspection
     */
    public function type() : \Gzhegow\Support\IType
    {
        if (! isset($this->type)) {
            $this->type = SupportFactory::getInstance()->getType();
        }

        return $this->type;
    }


    /**
     * @param null|string|array|\Throwable $error
     * @param mixed                        ...$arguments
     *
     * @return static
     */
    protected function error($error, ...$arguments)
    {
        if (null !== $error) {
            if (null !== $this->filter->filterThrowable($error)) {
                $this->throwable = $this->filter->filterThrowable($error);

            } else {
                $this->message = $this->debug->theMessageVal($error, ...$arguments);
            }
        }

        return $this;
    }


    /**
     * @return IAssert
     */
    public static function getInstance() : IAssert
    {
        return SupportFactory::getInstance()->getAssert();
    }
}
