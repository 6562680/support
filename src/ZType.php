<?php
/**
 * @noinspection RedundantSuppression
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support;

use Gzhegow\Support\Generated\GeneratedType;


/**
 * ZType
 */
class ZType extends GeneratedType
{
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
        if (! isset($this->assert)) {
            $this->assert = SupportFactory::getInstance()->getAssert();
        }

        $this->assert->assert($error, ...$arguments);

        return $this->assert;
    }

    /**
     * @return \Gzhegow\Support\IFilter
     * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
     * @noinspection PhpFullyQualifiedNameUsageInspection
     */
    public function filter() : \Gzhegow\Support\IFilter
    {
        if (! isset($this->filter)) {
            $this->filter = SupportFactory::getInstance()->getFilter();
        }

        return $this->filter;
    }

    /**
     * @return \Gzhegow\Support\IType
     * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
     * @noinspection PhpFullyQualifiedNameUsageInspection
     */
    public function type() : \Gzhegow\Support\IType
    {
        return $this;
    }


    /**
     * @return IType
     */
    public static function getInstance()
    {
        return SupportFactory::getInstance()->getType();
    }
}
