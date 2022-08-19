<?php
/**
 * @noinspection RedundantSuppression
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support;

use Gzhegow\Support\Generated\GeneratedFilter;
use Gzhegow\Support\Domain\Debug\DebugMessage;
use Gzhegow\Support\Traits\Load\DebugLoadTrait;


/**
 * XFilter
 */
class XFilter extends GeneratedFilter
{
    use DebugLoadTrait;


    /**
     * @var \RuntimeException
     * @ var \Throwable
     */
    protected $throwable;

    /**
     * @var DebugMessage
     */
    protected $message;


    /**
     * @param null|string|array $text
     * @param array             ...$placeholders
     *
     * @return null|array
     */
    public function getMessageOr($text = null, ...$placeholders) : ?array
    {
        $text = $this->message
            ? $this->message->getMessage()
            : $text;

        $placeholders = $this->message
            ? [ $this->message->getPlaceholders(), $placeholders ]
            : $placeholders;

        $result = $this->getDebug()->theMessageVal($text, ...$placeholders)->toArray();

        $this->message = null;

        return $result;
    }

    /**
     * @param null|\Throwable $throwable
     *
     * @return null|\RuntimeException
     */
    public function getThrowableOr(\Throwable $throwable = null) // : ?\Throwable
    {
        /**
         * @var \RuntimeException $result
         */

        $result = $this->throwable
            ?? ( ( null !== $throwable ) ? $throwable : null );

        $this->throwable = null;

        return $result;
    }


    /**
     * @param null|string|array|\Throwable $assert
     * @param mixed                        ...$placeholders
     *
     * @return static
     */
    public function assert($assert, ...$placeholders)
    {
        if (null !== $assert) {
            ( $assert instanceof \Throwable )
                ? ( $this->throwable = $assert )
                : ( $this->message = $this->getDebug()->theMessageVal($assert, ...$placeholders) );
        }

        return $this;
    }


    /**
     * @return IFilter
     */
    public static function getInstance() : IFilter
    {
        return SupportFactory::getInstance()->getFilter();
    }
}