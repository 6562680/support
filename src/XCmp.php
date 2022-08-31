<?php
/**
 * @noinspection RedundantSuppression
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support;

use Gzhegow\Support\Traits\Load\NumLoadTrait;
use Gzhegow\Support\Traits\Load\CalendarLoadTrait;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * XCmp
 */
class XCmp implements ICmp
{
    use CalendarLoadTrait;
    use NumLoadTrait;


    /**
     * @param mixed $a
     * @param mixed $b
     *
     * @return int
     */
    public function cmp($a, $b) : int
    {
        // @gzhegow > named function to use in callable type

        $result = $a <=> $b;

        return $result;
    }


    /**
     * @param null|int       $a
     * @param null|int|mixed $b
     * @param null|bool      $coalesce
     *
     * @return int
     */
    public function cmpint($a, $b, bool $coalesce = null) : int
    {
        $theNum = $this->getNum();

        if (( $a !== null )
            && ( null === $theNum->filterInt($a) )
        ) {
            throw new InvalidArgumentException([
                'The `a` should be int or null: %s',
                $a,
            ]);
        }

        $coalesce = $coalesce ?? false;

        $bInt = ( null !== $b )
            ? ( null
                ?? ( ( null !== $theNum->filterInt($b) ) ? $b : null )
                ?? ( $coalesce ? $theNum->intval($b) : null )
            )
            : null;

        $result = $a <=> $bInt;

        return $result;
    }

    /**
     * @param null|float       $a
     * @param null|float|mixed $b
     * @param null|bool        $coalesce
     *
     * @return int
     */
    public function cmpfloat($a, $b, bool $coalesce = null) : int
    {
        $theNum = $this->getNum();

        if (( $a !== null )
            && ( null === $theNum->filterFloat($a) )
        ) {
            throw new InvalidArgumentException([
                'The `a` should be float or null: %s',
                $a,
            ]);
        }

        $coalesce = $coalesce ?? false;

        $bFloat = ( null !== $b )
            ? ( null
                ?? ( ( null !== $theNum->filterFloat($b) ) ? $b : null )
                ?? ( $coalesce ? $theNum->floatval($b) : null )
            )
            : null;

        $result = $a <=> $bFloat;

        return $result;
    }

    /**
     * @param null|int|float       $a
     * @param null|int|float|mixed $b
     * @param null|bool            $coalesce
     *
     * @return int
     */
    public function cmpnum($a, $b, bool $coalesce = null) : int
    {
        $theNum = $this->getNum();

        if (( $a !== null )
            && ( null === $theNum->filterNum($a) )
        ) {
            throw new InvalidArgumentException([
                'The `a` should be num or null: %s',
                $a,
            ]);
        }

        $coalesce = $coalesce ?? false;

        $bNum = ( null !== $b )
            ? ( null
                ?? ( ( null !== $theNum->filterNum($b) ) ? $b : null )
                ?? ( $coalesce ? $theNum->numval($b) : null )
            )
            : null;

        $result = $a <=> $bNum;

        return $result;
    }

    /**
     * @param null|int|float|string       $a
     * @param null|int|float|string|mixed $b
     * @param null|bool                   $coalesce
     *
     * @return int
     */
    public function cmpnumeric($a, $b, bool $coalesce = null) : int
    {
        $theNum = $this->getNum();

        if ($a !== null) {
            // @gzhegow > string should be converted to int/float otherwise non-comparable
            if (null === ( $val = $theNum->numval($a) )) {
                throw new InvalidArgumentException([
                    'The `a` should be numeric or null: %s',
                    $a,
                ]);
            }

            $a = $val;
        }

        $coalesce = $coalesce ?? false;

        $bNumeric = ( null !== $b )
            ? ( null
                ?? ( ( null !== $theNum->filterNum($b) ) ? $b : null )
                ?? ( ( is_string($b) && is_numeric($b) ) ? $theNum->numval($b) : null )
                ?? ( $coalesce ? $theNum->numval($b) : null )
            )
            : null;

        $result = $a <=> $bNumeric;

        return $result;
    }


    /**
     * @param null|string       $a
     * @param null|string|mixed $b
     * @param null|bool         $natural
     * @param null|bool         $coalesce
     *
     * @return int
     */
    public function cmpstr($a, $b, bool $natural = null, bool $coalesce = null) : int
    {
        if (( $a !== null )
            && ! is_string($a)
        ) {
            throw new InvalidArgumentException([
                'The `a` should be string or null: %s',
                $a,
            ]);
        }

        $result = null;

        $natural = $natural ?? true;
        $coalesce = $coalesce ?? false;

        $bString = ( null !== $b )
            ? ( null
                ?? ( is_string($b) ? $b : null )
                ?? ( $coalesce ? strval($b) : null )
            )
            : null;

        $isA = is_string($a);
        $isB = is_string($bString);
        if ($isA && $isB) {
            $result = $natural
                ? strnatcmp($a, $bString)
                : strcmp($a, $bString);
        }

        $result = $result
            ?? $isA <=> $isB;

        return $result;
    }

    /**
     * @param null|string       $a
     * @param null|string|mixed $b
     * @param null|bool         $natural
     * @param null|bool         $coalesce
     *
     * @return int
     */
    public function cmpstrCase($a, $b, bool $natural = null, bool $coalesce = null) : int
    {
        if (( $a !== null )
            && ! is_string($a)
        ) {
            throw new InvalidArgumentException([
                'The `a` should be string or null: %s',
                $a,
            ]);
        }

        $result = null;

        $natural = $natural ?? true;
        $coalesce = $coalesce ?? false;

        $bString = ( null !== $b )
            ? ( null
                ?? ( is_string($b) ? $b : null )
                ?? ( $coalesce ? strval($b) : null )
            )
            : null;

        $isA = is_string($a);
        $isB = is_string($bString);
        if ($isA && $isB) {
            $result = $natural
                ? strnatcasecmp($a, $bString)
                : strcasecmp($a, $bString);
        }

        $result = $result
            ?? $isA <=> $isB;

        return $result;
    }


    /**
     * @param null|\DateTimeInterface       $a
     * @param null|\DateTimeInterface|mixed $b
     * @param null|bool                     $coalesce
     *
     * @return int
     */
    public function cmpdate(\DateTimeInterface $a = null, $b = null, bool $coalesce = null) : int
    {
        $theCalendar = $this->getCalendar();

        $coalesce = $coalesce ?? false;

        $bDate = ( null !== $b )
            ? ( null
                ?? ( $b instanceof \DateTimeInterface ? $b : null )
                ?? ( $coalesce ? $theCalendar->dateVal($b) : null )
            )
            : null;

        $result = $a <=> $bDate;

        return $result;
    }


    /**
     * @return ICmp
     */
    public static function getInstance() : ICmp
    {
        return SupportFactory::getInstance()->getCmp();
    }
}