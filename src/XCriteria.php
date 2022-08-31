<?php
/**
 * @noinspection RedundantSuppression
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support;

use Gzhegow\Support\Traits\Load\CmpLoadTrait;
use Gzhegow\Support\Traits\Load\StrLoadTrait;
use Gzhegow\Support\Traits\Load\NumLoadTrait;
use Gzhegow\Support\Traits\Load\CalendarLoadTrait;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * XCriteria
 */
class XCriteria implements ICriteria
{
    use CalendarLoadTrait;
    use CmpLoadTrait;
    use NumLoadTrait;
    use StrLoadTrait;


    const OPERATOR_BTW     = 'btw';
    const OPERATOR_ENDS    = 'ends';
    const OPERATOR_EQ      = 'eq';
    const OPERATOR_GT      = 'gt';
    const OPERATOR_GTE     = 'gte';
    const OPERATOR_IN      = 'in';
    const OPERATOR_LT      = 'lt';
    const OPERATOR_LTE     = 'lte';
    const OPERATOR_NBTW    = 'nbtw';
    const OPERATOR_NENDS   = 'nends';
    const OPERATOR_NEQ     = 'neq';
    const OPERATOR_NIN     = 'nin';
    const OPERATOR_NSTARTS = 'nstarts';
    const OPERATOR_NSTRPOS = 'nstrpos';
    const OPERATOR_STARTS  = 'starts';
    const OPERATOR_STRPOS  = 'strpos';

    const ORDER_ASC      = 'asc';
    const ORDER_ASCNULL  = 'asc,null';
    const ORDER_DEC      = 'dec';
    const ORDER_DECNULL  = 'dec,null';
    const ORDER_DESC     = 'desc';
    const ORDER_DESCNULL = 'desc,null';
    const ORDER_INC      = 'inc';
    const ORDER_INCNULL  = 'inc,null';
    const ORDER_NULLASC  = 'null,asc';
    const ORDER_NULLDEC  = 'null,dec';
    const ORDER_NULLDESC = 'null,desc';
    const ORDER_NULLINC  = 'null,inc';


    const THE_OPERATOR_LIST = [
        self::OPERATOR_BTW     => true,
        self::OPERATOR_ENDS    => true,
        self::OPERATOR_EQ      => true,
        self::OPERATOR_GT      => true,
        self::OPERATOR_GTE     => true,
        self::OPERATOR_IN      => true,
        self::OPERATOR_LT      => true,
        self::OPERATOR_LTE     => true,
        self::OPERATOR_NBTW    => true,
        self::OPERATOR_NENDS   => true,
        self::OPERATOR_NEQ     => true,
        self::OPERATOR_NIN     => true,
        self::OPERATOR_NSTARTS => true,
        self::OPERATOR_NSTRPOS => true,
        self::OPERATOR_STARTS  => true,
        self::OPERATOR_STRPOS  => true,
    ];

    const THE_ORDER_LIST = [
        self::ORDER_ASC      => true,
        self::ORDER_ASCNULL  => true,
        self::ORDER_DEC      => true,
        self::ORDER_DECNULL  => true,
        self::ORDER_DESC     => true,
        self::ORDER_DESCNULL => true,
        self::ORDER_INC      => true,
        self::ORDER_INCNULL  => true,
        self::ORDER_NULLASC  => true,
        self::ORDER_NULLDEC  => true,
        self::ORDER_NULLDESC => true,
        self::ORDER_NULLINC  => true,
    ];


    /**
     * @param array            $src
     * @param int|float|string $needle
     * @param null|bool        $coalesce
     *
     * @return bool
     */
    public function isInNumeric(array $src, $needle, bool $coalesce = null) : bool
    {
        $theNum = $this->getNum();

        // @gzhegow > string should be converted to int/float otherwise non-comparable
        if (null !== ( $val = $theNum->numval($needle) )) {
            $needle = $val;

        } else {
            throw new InvalidArgumentException([
                'The `needle` should be numeric or null: %s',
                $needle,
            ]);
        }

        $coalesce = $coalesce ?? false;

        foreach ( $src as $val ) {
            if (null === $val) {
                continue;
            }

            $valNumeric = null
                ?? ( ( null !== $theNum->filterNum($val) ) ? $val : null )
                ?? ( ( is_string($val) && is_numeric($val) ) ? $theNum->numval($val) : null )
                ?? ( $coalesce ? $theNum->numval($val) : null );

            if ($valNumeric == $needle) {
                return true;
            }
        }

        return false;
    }


    /**
     * @param array     $src
     * @param string    $needle
     * @param null|bool $natural
     * @param null|bool $coalesce
     *
     * @return bool
     */
    public function isInString(array $src, $needle, bool $natural = null, bool $coalesce = null) : bool
    {
        if (! is_string($needle)) {
            throw new InvalidArgumentException([
                'The `needle` should be string or null: %s',
                $needle,
            ]);
        }

        $coalesce = $coalesce ?? false;

        foreach ( $src as $val ) {
            if (null === $val) {
                continue;
            }

            $valString = null
                ?? ( is_string($val) ? $val : null )
                ?? ( $coalesce ? strval($val) : null );

            $isVal = is_string($valString);
            if ($isVal) {
                $result = $natural
                    ? strnatcmp($needle, $valString)
                    : strcmp($needle, $valString);

                if ($result === 0) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @param array     $src
     * @param string    $needle
     * @param null|bool $natural
     * @param null|bool $coalesce
     *
     * @return bool
     */
    public function isInStringCase(array $src, $needle, bool $natural = null, bool $coalesce = null) : bool
    {
        if (! is_string($needle)) {
            throw new InvalidArgumentException([
                'The `needle` should be string or null: %s',
                $needle,
            ]);
        }

        $coalesce = $coalesce ?? false;

        foreach ( $src as $val ) {
            if (null === $val) {
                continue;
            }

            $valString = null
                ?? ( is_string($val) ? $val : null )
                ?? ( $coalesce ? strval($val) : null );

            $isVal = is_string($valString);
            if ($isVal) {
                $result = $natural
                    ? strnatcasecmp($needle, $valString)
                    : strcasecmp($needle, $valString);

                if ($result === 0) {
                    return true;
                }
            }
        }

        return false;
    }


    /**
     * @param array              $src
     * @param \DateTimeInterface $needle
     * @param null|bool          $coalesce
     *
     * @return bool
     */
    public function isInDate(array $src, \DateTimeInterface $needle, bool $coalesce = null) : bool
    {
        $theCalendar = $this->getCalendar();

        $coalesce = $coalesce ?? false;

        foreach ( $src as $val ) {
            if (null === $val) {
                continue;
            }

            $valDate = null
                ?? ( $val instanceof \DateTimeInterface ? $val : null )
                ?? ( $coalesce ? $theCalendar->dateVal($val) : null );

            if ($valDate instanceof \DateTimeInterface) {
                if (( $needle <=> $valDate ) === 0) {
                    return true;
                }
            }
        }

        return false;
    }


    /**
     * @param array            $src
     * @param int|float|string $needle
     * @param null|bool        $coalesce
     *
     * @return bool
     */
    public function isBetweenNumber(array $src, $needle, bool $coalesce = null) : bool
    {
        $theNum = $this->getNum();

        // @gzhegow > string should be converted to int/float otherwise non-comparable
        if (null !== ( $val = $theNum->numval($needle) )) {
            $needle = $val;

        } else {
            throw new InvalidArgumentException([
                'The `needle` should be numeric or null: %s',
                $needle,
            ]);
        }

        $coalesce = $coalesce ?? false;

        $srcNumbers = [];
        foreach ( $src as $i => $val ) {
            if (null === $val) {
                continue;
            }

            $valNumeric = null
                ?? ( ( null !== $theNum->filterNum($val) ) ? $val : null )
                ?? ( ( is_string($val) && is_numeric($val) ) ? $theNum->numval($val) : null )
                ?? ( $coalesce ? $theNum->numval($val) : null );

            if ($valNumeric !== null) {
                $srcNumbers[ $i ] = $valNumeric;
            }
        }

        if (! $srcNumbers) {
            throw new InvalidArgumentException([
                'The `src` should contain at least one number: %s',
                $src,
            ]);
        }

        $min = min($srcNumbers);
        $max = max($srcNumbers);

        $result = $min <= $needle && $needle <= $max;

        return $result;
    }

    /**
     * @param array              $src
     * @param \DateTimeInterface $needle
     * @param null|bool          $coalesce
     *
     * @return bool
     */
    public function isBetweenDate(array $src, \DateTimeInterface $needle, bool $coalesce = null) : bool
    {
        $theCalendar = $this->getCalendar();

        $coalesce = $coalesce ?? false;

        $srcDates = [];
        foreach ( $src as $i => $val ) {
            $valDate = null
                ?? ( $val instanceof \DateTimeInterface ? $val : null )
                ?? ( $coalesce ? $theCalendar->dateVal($val) : null );

            if ($valDate !== null) {
                $srcDates[ $i ] = $valDate;
            }
        }

        if (! $srcDates) {
            throw new InvalidArgumentException([
                'The `src` should contain at least one \DateTimeInterface: %s',
                $src,
            ]);
        }

        $result = $theCalendar->isBetween($needle, $srcDates);

        return $result;
    }


    /**
     * @param mixed       $needle
     * @param mixed       $src
     * @param null|string $operator
     * @param null|bool   $coalesce
     *
     * @return bool
     */
    public function satisfy($needle, $src, string $operator = null, bool $coalesce = null) : bool
    {
        $operator = $operator ?? static::OPERATOR_EQ;
        $coalesce = $coalesce ?? false;

        if (! isset(static::THE_OPERATOR_LIST[ $operator ])) {
            throw new InvalidArgumentException('Unknown operator: ' . $operator);
        }

        if (is_array($needle)) {
            return $this->satisfyArray($src, $needle, $operator);

        } elseif (null !== $this->getNum()->filterNumval($needle)) {
            $theCmp = $this->getCmp();

            if ($operator === static::OPERATOR_GT) return 1 === $theCmp->cmpnumeric($needle, $src, $coalesce);
            if ($operator === static::OPERATOR_LT) return -1 === $theCmp->cmpnumeric($needle, $src, $coalesce);
            if ($operator === static::OPERATOR_GTE) return -1 !== $theCmp->cmpnumeric($needle, $src, $coalesce);
            if ($operator === static::OPERATOR_LTE) return 1 !== $theCmp->cmpnumeric($needle, $src, $coalesce);

        } elseif (is_string($needle)) {
            $theCmp = $this->getCmp();

            if ($operator === static::OPERATOR_GT) return 1 === $theCmp->cmpstr($needle, $src, $coalesce);
            if ($operator === static::OPERATOR_LT) return -1 === $theCmp->cmpstr($needle, $src, $coalesce);
            if ($operator === static::OPERATOR_GTE) return -1 !== $theCmp->cmpstr($needle, $src, $coalesce);
            if ($operator === static::OPERATOR_LTE) return 1 !== $theCmp->cmpstr($needle, $src, $coalesce);

            $theStr = $this->getStr();

            if ($operator === static::OPERATOR_BTW) {
                return (bool) $theStr->contains($needle, $src, $coalesce);
            }
            if ($operator === static::OPERATOR_NBTW) {
                return ! $theStr->contains($needle, $src, $coalesce);
            }

            if ($operator === static::OPERATOR_STARTS) return null !== $theStr->starts($needle, $src, $coalesce);
            if ($operator === static::OPERATOR_ENDS) return null !== $theStr->ends($needle, $src, $coalesce);
            if ($operator === static::OPERATOR_NSTARTS) {
                return null === $theStr->starts($needle, $src, $coalesce);
            }
            if ($operator === static::OPERATOR_NENDS) {
                return null === $theStr->ends($needle, $src, $coalesce);
            }

        } elseif ($needle instanceof \DateTimeInterface) {
            $theCmp = $this->getCmp();

            if ($operator === static::OPERATOR_GT) return 1 === $theCmp->cmpDate($needle, $src);
            if ($operator === static::OPERATOR_LT) return -1 === $theCmp->cmpDate($needle, $src);
            if ($operator === static::OPERATOR_GTE) return -1 !== $theCmp->cmpDate($needle, $src);
            if ($operator === static::OPERATOR_LTE) return 1 !== $theCmp->cmpDate($needle, $src);
        }

        if ($operator === static::OPERATOR_EQ) return $src === $needle;
        if ($operator === static::OPERATOR_NEQ) return $src !== $needle;

        return false;
    }

    /**
     * @param mixed       $needle
     * @param array       $src
     * @param null|string $operator
     * @param null|bool   $coalesce
     *
     * @return bool
     */
    public function satisfyArray($needle, array $src, string $operator = null, bool $coalesce = null) : bool
    {
        $operator = $operator ?? static::OPERATOR_IN;
        $coalesce = $coalesce ?? false;

        if (! isset(static::THE_OPERATOR_LIST[ $operator ])) {
            throw new InvalidArgumentException('Unknown operator: ' . $operator);
        }

        if (null !== $this->getNum()->filterNumval($needle)) {
            if ($operator === static::OPERATOR_IN) return $this->isInNumeric($src, $needle, $coalesce);
            if ($operator === static::OPERATOR_NIN) return ! $this->isInNumeric($src, $needle, $coalesce);

            if ($operator === static::OPERATOR_BTW) return $this->isBetweenNumber($src, $needle, $coalesce);
            if ($operator === static::OPERATOR_NBTW) {
                return ! $this->isBetweenNumber($src, $needle, $coalesce);
            }

        } elseif (is_string($needle)) {
            if ($operator === static::OPERATOR_IN) return $this->isInString($src, $needle, $coalesce);
            if ($operator === static::OPERATOR_NIN) {
                return ! $this->isInString($src, $needle, $coalesce);
            }

        } elseif ($needle instanceof \DateTimeInterface) {
            if ($operator === static::OPERATOR_IN) return $this->isInDate($src, $needle, $coalesce);
            if ($operator === static::OPERATOR_NIN) {
                return ! $this->isInDate($src, $needle, $coalesce);
            }

            if ($operator === static::OPERATOR_BTW) return $this->isBetweenDate($src, $needle, $coalesce);
            if ($operator === static::OPERATOR_NBTW) {
                return ! $this->isBetweenDate($src, $needle, $coalesce);
            }
        }

        return false;
    }


    /**
     * @return ICriteria
     */
    public static function getInstance() : ICriteria
    {
        return SupportFactory::getInstance()->getCriteria();
    }
}