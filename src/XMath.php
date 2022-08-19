<?php
/**
 * @noinspection RedundantSuppression
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support;

use Gzhegow\Support\Traits\Load\NumLoadTrait;
use Gzhegow\Support\Traits\Load\StrLoadTrait;
use Gzhegow\Support\Domain\Math\ValueObject\MathBcval;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;
use Gzhegow\Support\Exceptions\Runtime\OutOfBoundsException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * XMath
 */
class XMath implements IMath
{
    use NumLoadTrait;
    use StrLoadTrait;


    /**
     * @var int
     */
    protected $scale;
    /**
     * @var int
     */
    protected $scaleMax = 20;


    /**
     * @param null|int $scale
     *
     * @return static
     */
    public function withScale(?int $scale)
    {
        if (isset($scale)) {
            $theNum = $this->getNum();

            $scale = $theNum->theIntval($scale);

            if (null === $theNum->filterNumGte0($scale)) {
                throw new InvalidArgumentException([
                    'The `scale` should be greater than or equal to 0: %s',
                    $scale,
                ]);
            }
        }

        $this->scale = $scale;

        return $this;
    }

    /**
     * @param null|int $scaleMax
     *
     * @return static
     */
    public function withScaleMax(?int $scaleMax)
    {
        if (isset($scaleMax)) {
            $theNum = $this->getNum();

            $scaleMax = $theNum->theIntval($scaleMax);

            if (null === $theNum->filterNumGte0($scaleMax)) {
                throw new InvalidArgumentException([
                    'The `scaleMax` should be greater than or equal to 0: %s',
                    $scaleMax,
                ]);
            }
        }

        $this->scaleMax = $scaleMax ?? $this->loadScaleMax();

        return $this;
    }


    /**
     * @return int
     */
    public function loadScaleMax() : int
    {
        return 20;
    }


    /**
     * @param string $validValue
     *
     * @return MathBcval
     */
    public function newBcval(string $validValue) : MathBcval
    {
        return SupportFactory::getInstance()->newMathBcval($validValue);
    }


    /**
     * @return null|int
     */
    public function getScale() : ?int
    {
        return $this->scale;
    }

    /**
     * @return int
     */
    public function getScaleMax() : int
    {
        return $this->scaleMax;
    }


    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function filterAlgorism($value) : ?string
    {
        $theStr = $this->getStr();

        if (! is_string($value)) {
            return null;
        }

        if ($theStr->mb('strlen')($value) < 2) {
            return null;
        }

        foreach ( array_count_values($theStr->mb('str_split')($value)) as $cnt ) {
            if ($cnt > 1) {
                return null;
            }
        }

        return null;
    }

    /**
     * @param string|mixed $value
     *
     * @return null|int|float|string|object
     */
    public function filterAlgorismval($value) // : ?null|int|float|string|object
    {
        $theStr = $this->getStr();

        if (null === $theStr->filterStrval($value)) {
            return null;
        }

        if ($theStr->mb('strlen')(strval($value)) < 2) {
            return null;
        }

        foreach ( array_count_values($theStr->mb('str_split')(strval($value))) as $cnt ) {
            if ($cnt > 1) {
                return null;
            }
        }

        return null;
    }


    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return null|int|float|string|MathBcval
     */
    public function filterBcGt0($value) // : ?int|float|string|MathBcval
    {
        if (null === ( $bcval = $this->bcval($value) )) {
            return null;
        }

        // scale will be calculated
        if (0 < $this->bccomp($bcval, 0)) {
            return $value;
        }

        return null;
    }

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return null|int|float|string|MathBcval
     */
    public function filterBcGte0($value) // : ?int|float|string|MathBcval
    {
        if (null === ( $bcval = $this->bcval($value) )) {
            return null;
        }

        // scale will be calculated
        if (0 <= $this->bccomp($bcval, 0)) {
            return $value;
        }

        return null;
    }

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return null|int|float|string|MathBcval
     */
    public function filterBcLt0($value) // : ?int|float|string|MathBcval
    {
        if (null === ( $bcval = $this->bcval($value) )) {
            return null;
        }

        // scale will be calculated
        if (0 > $this->bccomp($bcval, 0)) {
            return $value;
        }

        return null;
    }

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return null|int|float|string|MathBcval
     */
    public function filterBcLte0($value) // : ?int|float|string|MathBcval
    {
        if (null === ( $bcval = $this->bcval($value) )) {
            return null;
        }

        // scale will be calculated
        if (0 >= $this->bccomp($bcval, 0)) {
            return $value;
        }

        return null;
    }


    /**
     * @param int|mixed                        $scale
     * @param int|float|string|MathBcval|mixed ...$numbers
     *
     * @return null|int
     */
    public function scaleval($scale, ...$numbers) : ?int
    {
        $theNum = $this->getNum();

        if (null === ( $scaleVal = $theNum->intval($scale ?? $this->scale) )) {
            $scaleVal = $this->fraclen($numbers);
        }

        if (null === $theNum->filterNumGte0($scaleVal)) {
            return null;
        }

        return $scaleVal;
    }

    /**
     * @param int|float|string|MathBcval|mixed $number
     *
     * @return null|MathBcval
     */
    public function bcval($number) : ?MathBcval
    {
        if (is_a($number, MathBcval::class)) {
            return $number;
        }

        if (is_int($number)) {
            return $this->newBcval($number);
        }

        if ('' === $number) {
            return null;
        }

        if (! ( is_string($number) || is_float($number) )) {
            return null;
        }

        $bcval = null
            ?? $this->bcvalFromInt($number)
            ?? $this->bcvalFromNum($number);

        if (is_null($bcval)) {
            try {
                $number = $this->getNum()->numberParse($number);

                $bcval = null
                    ?? $this->bcvalFromInt($number)
                    ?? $this->bcvalFromNum($number);
            }
            catch ( InvalidArgumentException $e ) {
                return null;
            }
        }

        $numericval = $bcval->getValue();

        if (false !== strpos($numericval, '.')) {
            $numericval = rtrim($numericval, '0');
            $numericval = rtrim($numericval, '.');

            $bcval = $this->newBcval($numericval);
        }

        return $bcval;
    }

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function algorismval($value) : ?string
    {
        if (null === $this->filterAlgorismVal($value)) {
            return null;
        }

        $result = strval($value);

        return $result;
    }


    /**
     * @param int|mixed                        $scale
     * @param int|float|string|MathBcval|mixed ...$numbers
     *
     * @return int
     */
    public function theScaleval($scale, ...$numbers) : int
    {
        if (null === ( $scaleVal = $this->scaleval($scale, ...$numbers) )) {
            throw new InvalidArgumentException(
                [ 'Value should be convertable to scaleval: %s', $scale ],
            );
        }

        return $scaleVal;
    }

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return MathBcval
     */
    public function theBcval($value) : MathBcval
    {
        if (null === ( $bcval = $this->bcval($value) )) {
            throw new InvalidArgumentException(
                [ 'Value should be convertable to bcval: %s', $value ],
            );
        }

        return $bcval;
    }

    /**
     * @param string|mixed $value
     *
     * @return string
     */
    public function theAlgorismval($value) : string
    {
        if (null === ( $val = $this->algorismval($value) )) {
            throw new InvalidArgumentException(
                [ 'Value should be convertable to algorismval: %s', $value ],
            );
        }

        return $val;
    }


    /**
     * @param string|array $numerics
     * @param null|bool    $uniq
     * @param null|bool    $recursive
     *
     * @return MathBcval[]
     */
    public function bcvals($numerics, bool $uniq = null, bool $recursive = null) : array
    {
        $result = [];

        $numerics = is_array($numerics)
            ? $numerics
            : [ $numerics ];

        if ($recursive) {
            array_walk_recursive($numerics, function ($item) use (&$result) {
                if (null !== ( $val = $this->bcval($item) )) {
                    $result[] = $val;
                }
            });

        } else {
            foreach ( $numerics as $item ) {
                if (null !== ( $val = $this->bcval($item) )) {
                    $result[] = $val;
                }
            }
        }

        if ($uniq) {
            $arr = [];
            foreach ( $result as $i ) {
                $arr[ strval($i) ] = true;
            }
            $result = array_keys($arr);
        }

        return $result;
    }

    /**
     * @param string|array $algorisms
     * @param null|bool    $uniq
     * @param null|bool    $recursive
     *
     * @return string[]
     */
    public function algorismvals($algorisms, bool $uniq = null, bool $recursive = null) : array
    {
        $result = [];

        $algorisms = is_array($algorisms)
            ? $algorisms
            : [ $algorisms ];

        if ($recursive) {
            array_walk_recursive($algorisms, function ($item) use (&$result) {
                if (null !== ( $val = $this->algorismval($item) )) {
                    $result[] = $val;
                }
            });

        } else {
            foreach ( $algorisms as $item ) {
                if (null !== ( $val = $this->algorismval($item) )) {
                    $result[] = $val;
                }
            }
        }

        if ($uniq) {
            $arr = [];
            foreach ( $result as $i ) {
                $arr[ $i ] = true;
            }
            $result = array_keys($arr);
        }

        return $result;
    }


    /**
     * @param string|array $numerics
     * @param null|bool    $uniq
     * @param null|bool    $recursive
     *
     * @return MathBcval[]
     */
    public function theBcvals($numerics, bool $uniq = null, bool $recursive = null) : array
    {
        $result = [];

        $numerics = is_array($numerics)
            ? $numerics
            : [ $numerics ];

        if ($recursive) {
            array_walk_recursive($numerics, function ($item) use (&$result) {
                $result[] = $this->theBcval($item);
            });

        } else {
            foreach ( $numerics as $item ) {
                $result[] = $this->theBcval($item);
            }
        }

        if ($uniq) {
            $arr = [];
            foreach ( $result as $i ) {
                $arr[ strval($i) ] = true;
            }
            $result = array_keys($arr);
        }

        return $result;
    }

    /**
     * @param string|array $algorisms
     * @param null|bool    $uniq
     * @param null|bool    $recursive
     *
     * @return string[]
     */
    public function theAlgorismvals($algorisms, bool $uniq = null, bool $recursive = null) : array
    {
        $result = [];

        $algorisms = is_array($algorisms)
            ? $algorisms
            : [ $algorisms ];

        if ($recursive) {
            array_walk_recursive($algorisms, function ($item) use (&$result) {
                $result[] = $this->theAlgorismval($item);
            });

        } else {
            foreach ( $algorisms as $item ) {
                $result[] = $this->theAlgorismval($item);
            }
        }

        if ($uniq) {
            $arr = [];
            foreach ( $result as $i ) {
                $arr[ $i ] = true;
            }
            $result = array_keys($arr);
        }

        return $result;
    }


    /**
     * Возвращает дробную часть числа
     *
     * @param int|float|string|MathBcval|mixed $number
     *
     * @return string
     */
    public function frac($number) : string
    {
        $bcval = $this->theBcval($number);

        $result = '';

        if (false !== ( $pos = strrchr($bcval, '.') )) {
            $result = substr($pos, 1);
        }

        return $result;
    }

    /**
     * Определяет максимальное число знаков после запятой из переданных чисел
     *
     * @param int|float|string|MathBcval|array $numbers
     * @param null|int                         $scaleMax
     *
     * @return int
     */
    public function fraclen($numbers, int $scaleMax = null) : int
    {
        $scaleMax = $this->theScaleval($scaleMax ?? $this->scaleMax ?? 0);

        $bcvals = $this->theBcvals($numbers);

        $scales[] = 0;
        foreach ( $bcvals as $l ) {
            $scales[] = strlen($this->frac($l));
        }

        $max = max($scales);

        if ($max > $scaleMax) {
            trigger_error(sprintf(
                'Fractional length is bigger than allowed maximum: %s / %s',
                $max, $scaleMax,
            ), E_USER_WARNING);
        }

        return $max;
    }


    /**
     * Округление
     *
     * @param int|float|mixed $number
     * @param null|int        $scale
     *
     * @return int|float
     */
    public function round($number, int $scale = null) // : int|float
    {
        $scale = $this->theScaleval($scale);

        $numval = $this->getNum()->theNumval($number);

        $result = round($numval, $scale);

        return $result;
    }

    /**
     * Округляет в меньшую сторону
     *
     * @param int|float|mixed $number
     * @param null|int        $scale
     *
     * @return int|float
     */
    public function floor($number, int $scale = null) // : int|float
    {
        $scale = $this->theScaleval($scale);

        $numval = $this->getNum()->theNumval($number);

        $pow = pow(10, $scale);

        $result = floor($numval * $pow) / $pow;

        return $result;
    }

    /**
     * Округляет в большую сторону
     *
     * @param int|float|mixed $number
     * @param null|int        $scale
     *
     * @return int|float
     */
    public function ceil($number, int $scale = null) // : int|float
    {
        $scale = $this->theScaleval($scale);

        $numval = $this->getNum()->theNumval($number);

        $pow = pow(10, $scale);

        $result = ceil($numval * $pow) / $pow;

        return $result;
    }


    /**
     * @param int|float ...$values
     *
     * @return null|int|float
     */
    public function max(...$values) // : ?int|float
    {
        $numvals = $this->getNum()->theNumvals($values, null, true);

        $result = $numvals
            ? max($numvals)
            : null;

        return $result;
    }

    /**
     * @param int|float ...$values
     *
     * @return null|int|float
     */
    public function min(...$values) // : int|float
    {
        $numvals = $this->getNum()->theNumvals($values, null, true);

        $result = $numvals
            ? min($numvals)
            : null;

        return $result;
    }


    /**
     * @param int|float ...$values
     *
     * @return int|float
     */
    public function sum(...$values) // : int|float
    {
        $numvals = $this->getNum()->theNumvals($values, null, true);

        $result = $numvals
            ? array_sum($numvals)
            : 0;

        return $result;
    }

    /**
     * @param int|float ...$values
     *
     * @return float
     */
    public function avg(...$values) : float
    {
        $numvals = $this->getNum()->theNumvals($values, null, true);

        $avg = null;

        if ($numvals) {
            $sum = array_sum($numvals);

            $avg = $sum / count($numvals);
        }

        return $avg;
    }

    /**
     * @param int|float ...$values
     *
     * @return null|int|float
     */
    public function median(...$values) // : ?int|float
    {
        $numvals = $this->getNum()->theNumvals($values, null, true);

        $median = null;

        if ($numvals) {
            sort($numvals);

            $numvals = array_values($numvals);

            $idx = count($numvals) / 2;

            $median = is_int($idx)
                ? ( ( $numvals[ $idx ] + $numvals[ $idx + 1 ] ) / 2 )
                : ( $numvals[ round($idx) - 1 ] );
        }

        return $median;
    }


    /**
     * @param int|float      $value
     * @param null|int|float $sum
     *
     * @return float
     */
    public function ratio($value, $sum = null) : float
    {
        $theNum = $this->getNum();

        $sum = $sum ?? 1;

        $value = $theNum->theNumval($value);
        $sum = $theNum->theNumval($sum);

        $valueNegative = $value < 0;
        $sumNegative = $sum < 0;

        if ($sum == 0) {
            throw new InvalidArgumentException(
                [ 'Sum should be not zero: %s', $sum ]
            );
        }

        if ($valueNegative !== $sumNegative) {
            throw new InvalidArgumentException(
                [ 'Both sum and value should be greater or less than zero: %s', $sum ]
            );
        }

        $result = $value / abs($sum);

        return $result;
    }

    /**
     * @param int|float      $value
     * @param null|int|float $sum
     *
     * @return float
     */
    public function percent($value, $sum = null) : float
    {
        $result = $this->ratio($value, $sum) * 100;

        return $result;
    }


    /**
     * @param int|float      $from
     * @param null|int|float $to
     *
     * @return float
     */
    public function rand($from, $to = null) : float
    {
        $theNum = $this->getNum();

        $to = $to ?? $from;

        $from = $theNum->theNumval($from);
        $to = $theNum->theNumval($to);

        $scaleMax = $this->fraclen([ $from, $to ]);

        $pow = pow(10, $scaleMax);

        $result = mt_rand(
            $from * $pow,
            $to * $pow
        );

        $result = $result / $pow;

        return $result;
    }


    /**
     * @param int|float|string|MathBcval|mixed $a
     * @param int|float|string|MathBcval|mixed $b
     * @param null|int                         $scale
     *
     * @return int
     */
    public function bccomp($a, $b, int $scale = null) : int
    {
        return bccomp(
            $this->theBcval($a),
            $this->theBcval($b),
            $this->theScaleval($scale, $a, $b)
        );
    }


    /**
     * @param int|float|string|MathBcval|mixed $a
     * @param int|float|string|MathBcval|mixed $b
     * @param null|int                         $scale
     *
     * @return MathBcval
     */
    public function bcadd($a, $b, int $scale = null) : MathBcval
    {
        return $this->newBcval(
            bcadd(
                $this->theBcval($a),
                $this->theBcval($b),
                $this->theScaleval($scale, $a, $b)
            )
        );
    }

    /**
     * @param int|float|string|MathBcval|mixed $a
     * @param int|float|string|MathBcval|mixed $b
     * @param null|int                         $scale
     *
     * @return MathBcval
     */
    public function bcsub($a, $b, int $scale = null) : MathBcval
    {
        return $this->newBcval(
            bcsub(
                $this->theBcval($a),
                $this->theBcval($b),
                $this->theScaleval($scale, $a, $b)
            )
        );
    }

    /**
     * @param int|float|string|MathBcval|mixed $a
     * @param int|float|string|MathBcval|mixed $b
     * @param null|int                         $scale
     *
     * @return MathBcval
     */
    public function bcmul($a, $b, int $scale = null) : MathBcval
    {
        $scale = $scale ?? $this->scale;

        if (is_null($scale)) {
            if ($scaleRequired = $this->fraclen($a) && $this->fraclen($b)) {
                throw new BadMethodCallException(
                    [ 'You should pass `scale` cause of you multiply both fractional numbers: [ %s, %s ]', $a, $b ]
                );
            }
        }

        return $this->newBcval(
            bcmul(
                $this->theBcval($a),
                $this->theBcval($b),
                $this->theScaleval($scale, $a, $b)
            )
        );
    }


    /**
     * @param int|float|string|MathBcval|mixed $a
     * @param int|float|string|MathBcval|mixed $b
     * @param null|int                         $scale
     *
     * @return MathBcval
     */
    public function bcmod($a, $b, int $scale = null) : MathBcval
    {
        return $this->newBcval(
            bcmod(
                $this->theBcval($a),
                $this->theBcval($b),
                $this->theScaleval($scale, $a, $b)
            )
        );
    }

    /**
     * @param int|float|string|MathBcval|mixed $a
     * @param int|float|string|MathBcval|mixed $b
     * @param null|int                         $scale
     *
     * @return MathBcval
     */
    public function bcdiv($a, $b, int $scale = null) : MathBcval
    {
        $scale = $scale ?? $this->scale;

        if (is_null($scale)) {
            throw new BadMethodCallException(
                [ 'You should pass `scale` cause of you using division: [ %s, %s ]', $a, $b ]
            );
        }

        return $this->newBcval(
            bcdiv(
                $this->theBcval($a),
                $this->theBcval($b),
                $this->theScaleval($scale, $a, $b)
            )
        );
    }


    /**
     * @param int|float|string|MathBcval|mixed $val
     * @param int|float|string|MathBcval|mixed $exp
     * @param null|int                         $scale
     *
     * @return MathBcval
     */
    public function bcpow($val, $exp, int $scale = null) : MathBcval
    {
        $scale = $scale ?? $this->scale;

        if (is_null($scale)) {
            if ($scaleRequired = $this->fraclen($val) || $this->fraclen($exp)) {
                throw new BadMethodCallException(
                    [ 'You should pass `scale` cause of you exponentiate fractionals: [ %s, %s ]', $val, $exp ]
                );
            }
        }

        return $this->newBcval(
            bcpow(
                $this->theBcval($val),
                $this->theBcval($exp),
                $this->theScaleval($scale, $val, $exp)
            )
        );
    }

    /**
     * @param int|float|string|MathBcval|mixed $val
     * @param null|int                         $scale
     *
     * @return MathBcval
     */
    public function bcsqrt($val, int $scale = null) : MathBcval
    {
        $scale = $scale ?? $this->scale;

        if (is_null($scale)) {
            throw new BadMethodCallException(
                [ 'You should pass `scale` cause of you making square root: [ %s ]', $val ]
            );
        }

        return $this->newBcval(
            bcsqrt(
                $this->theBcval($val),
                $this->scaleval($scale, $val)
            )
        );
    }


    /**
     * Получает значение по модулю от числа
     *
     * @param int|float|string|MathBcval|mixed $number
     *
     * @return string
     */
    public function bcabs($number) : string
    {
        $bcval = $this->theBcval($number);

        $bcabs = $this->theBcval($bcval->getAbs());

        return $bcabs;
    }


    /**
     * Округление
     *
     * @param int|float|string|MathBcval|mixed $number
     * @param null|int                         $scale
     *
     * @return MathBcval
     */
    public function bcround($number, int $scale = null) : MathBcval
    {
        $scale = $this->theScaleval($scale);

        $bcval = $this->theBcval($number);

        if (! $hasDecimals = false !== strpos($bcval, '.')) {
            $bcround = $bcval;

        } else {
            $bcround = $bcval->getMinus()
                ? $this->bcsub($bcval, '0.' . str_repeat('0', $scale) . '5', $scale)
                : $this->bcadd($bcval, '0.' . str_repeat('0', $scale) . '5', $scale);
        }

        return $bcround;
    }

    /**
     * Округляет в меньшую сторону
     *
     * @param int|float|string|MathBcval|mixed $number
     * @param null|int                         $scale
     *
     * @return MathBcval
     */
    public function bcfloor($number, int $scale = null) : MathBcval
    {
        $scale = $this->theScaleval($scale);

        $bcval = $this->theBcval($number);

        if (! $hasDecimals = false !== strpos($bcval, '.')) {
            $bcfloor = $bcval;

        } else {
            $bcfloor = ( $minus = $bcval->getMinus() )
                ? $this->bcsub($bcval, '0.' . str_repeat('0', $scale) . '5', $scale)
                : $this->bcadd($bcval, '0', $scale);

            $bonus = 0 === $this->bccomp($bcval, $bcfloor)
                ? 0
                : 1 / pow(10, $scale);

            $bcfloor = $minus
                ? $this->bcsub($bcval, $bonus, $scale)
                : $bcfloor;
        }

        return $bcfloor;
    }

    /**
     * Округляет в большую сторону
     *
     * @param int|float|string|MathBcval|mixed $number
     * @param null|int                         $scale
     *
     * @return MathBcval
     */
    public function bcceil($number, int $scale = null) : MathBcval
    {
        $scale = $this->theScaleval($scale);

        $bcval = $this->theBcval($number);

        if (! $hasDecimals = false !== strpos($bcval, '.')) {
            $bcceil = $bcval;

        } else {
            $bcceil = ( $minus = $bcval->getMinus() )
                ? $this->bcsub($bcval, '0', $scale)
                : $this->bcadd($bcval, '0.' . str_repeat('0', $scale) . '5', $scale);

            $bonus = 0 === $this->bccomp($bcval, $bcceil)
                ? 0
                : 1 / pow(10, $scale);

            $bcceil = $minus
                ? $bcceil
                : $this->bcadd($bcval, $bonus, $scale);
        }

        return $bcceil;
    }


    /**
     * @param int|float|string|MathBcval|array $numbers
     * @param null|int                         $scale
     *
     * @return null|MathBcval
     */
    public function bcmax($numbers, int $scale = null) : ?MathBcval
    {
        $bcvals = $this->theBcvals($numbers);

        $bcmax = null;

        if ($bcvals) {
            natsort($bcvals);

            $bcmax = end($bcvals);

            $bcmax = $this->bcadd($bcmax, 0, $scale);
        }

        return $bcmax;
    }

    /**
     * @param int|float|string|MathBcval|array $numbers
     * @param null|int                         $scale
     *
     * @return null|MathBcval
     */
    public function bcmin($numbers, int $scale = null) : ?MathBcval
    {
        $bcvals = $this->theBcvals($numbers);

        $bcmin = null;

        if ($bcvals) {
            natsort($bcvals);

            $bcmin = reset($bcvals);

            $bcmin = $this->bcadd($bcmin, 0, $scale);
        }

        return $bcmin;
    }


    /**
     * @param int|float|string|MathBcval|array $numbers
     * @param null|int                         $scale
     *
     * @return MathBcval
     */
    public function bcsum($numbers, int $scale = null) : MathBcval
    {
        $bcvals = $this->theBcvals($numbers);

        $bcsum = '0';

        if ($bcvals) {
            foreach ( $bcvals as $l ) {
                $bcsum = $this->bcadd($bcsum, $l); // scale will be calculated
            }

            $bcsum = $this->bcadd($bcsum, 0, $scale);
        }

        $bcsum = $this->theBcval($bcsum);

        return $bcsum;
    }

    /**
     * @param int|float|string|MathBcval|array $numbers
     * @param null|int                         $scale
     *
     * @return MathBcval
     */
    public function bcavg($numbers, int $scale = null) : MathBcval
    {
        $bcvals = $this->theBcvals($numbers);

        $bcavg = '0.0';

        if ($bcvals) {
            $sum = $this->bcsum($bcvals); // scale will be calculated

            $bcavg = $this->bcdiv($sum, count($bcvals), $scale);
        }

        $bcavg = $this->theBcval($bcavg);

        return $bcavg;
    }

    /**
     * @param int|float|string|MathBcval|array $numbers
     * @param null|int                         $scale
     *
     * @return null|MathBcval
     */
    public function bcmedian($numbers, int $scale = null) : ?MathBcval
    {
        $bcvals = $this->theBcvals($numbers);

        $bcmedian = null;

        if ($bcvals) {
            natsort($bcvals);

            $bcvals = array_values($bcvals);

            $medianIndex = count($bcvals) / 2;

            if (is_float($medianIndex)) {
                $bcmedian = $bcvals[ round($medianIndex) - 1 ];

            } else {
                $bcmedian = $this->bcadd($bcvals[ $medianIndex ], $bcvals[ $medianIndex + 1 ]); // scale will be calculated

                $bcmedian = $this->bcdiv($bcmedian, 2, $scale);
            }
        }

        return $bcmedian;
    }


    /**
     * @param int|float      $value
     * @param null|int|float $sum
     * @param null|int       $scale
     *
     * @return MathBcval
     */
    public function bcratio($value, $sum = null, int $scale = null) : MathBcval
    {
        $sum = $sum ?? '1';

        $value = $this->theBcval($value);
        $sum = $this->theBcval($sum);

        $sumZero = 0 === $this->bccomp($sum, 0); // scale will be calculated

        if ($sumZero) {
            throw new InvalidArgumentException(
                [ 'Sum should be non-zero: %s', $sum ]
            );
        }

        $valueNegative = ( -1 === $this->bccomp($value, 0) );
        $sumNegative = ( -1 === $this->bccomp($sum, 0) );

        if ($valueNegative !== $sumNegative) {
            throw new InvalidArgumentException(
                [ 'Both sum and value should be greater or less than zero: %s', $sum ]
            );
        }

        $result = $this->bcdiv($value, $this->bcabs($sum), $scale);

        return $result;
    }

    /**
     * @param int|float|string|MathBcval|mixed      $value
     * @param null|int|float|string|MathBcval|mixed $sum
     * @param null|int                              $scale
     *
     * @return MathBcval
     */
    public function bcpercent($value, $sum = null, int $scale = null) : MathBcval
    {
        $ratio = $this->bcratio($value, $sum, $scale);

        $result = $this->bcmul($ratio, '100', $scale);

        return $result;
    }


    /**
     * @param int|float|string|MathBcval|mixed      $from
     * @param null|int|float|string|MathBcval|mixed $to
     * @param null|int                              $scale
     *
     * @return MathBcval
     */
    public function bcrand($from, $to = null, int $scale = null) : MathBcval
    {
        $to = $to ?? $from;

        $from = $this->theBcval($from);
        $to = $this->theBcval($to);

        if ($from === $to) {
            return $from;
        }

        $pow = pow(10, $this->fraclen([ $from, $to ]));

        $bcFrom = $this->bcmul($from, $pow);
        $bcTo = $this->bcmul($to, $pow);

        $bcFromTo = [ $bcFrom->getValue(), $bcTo->getValue() ];

        natsort($bcFromTo);

        $result = mt_rand(...$bcFromTo);

        $result = $this->bcdiv($result, $pow, $scale);

        return $result;
    }


    /**
     * Рассчитывает соотношение долей между собой
     *
     * @param int|float|array $rates
     *
     * @return float[]
     */
    public function rates(...$rates) : array
    {
        $theNum = $this->getNum();

        $ratesNum = $theNum->theNumvals($rates, null, true);

        if (! $ratesNum) {
            throw new InvalidArgumentException(
                [ 'At least one rate should be passed: %s', $rates ]
            );
        }

        foreach ( $ratesNum as $rateNum ) {
            if (null === $theNum->filterNumGte0($rateNum)) {
                throw new InvalidArgumentException([
                    'The `rateNum` should be greater than or equal to 0: %s',
                    $rateNum,
                ]);
            }
        }

        $ratesIndexes = array_keys($ratesNum);
        $ratesSum = array_sum($ratesNum);

        $result = [];

        foreach ( $ratesIndexes as $i => $bool ) {
            $result[ $i ] = $ratesNum[ $i ] / $ratesSum;
        }

        return $result;
    }

    /**
     * Рассчитывает соотношение долей между собой
     * Нули получают пропорционально их количества - чем нулей больше, тем меньше каждому не-нулю
     * Нули получают тем больше, чем ближе минимальное и максимальное без учета самих нулей
     *
     * @param int|float|array $rates
     *
     * @return float[]
     */
    public function ratesZero(...$rates) : array
    {
        $theNum = $this->getNum();

        $ratesNum = $theNum->theNumvals($rates, null, true);

        if (! $ratesNum) {
            throw new InvalidArgumentException(
                [ 'At least one rate should be passed: %s', $rates ]
            );
        }

        foreach ( $ratesNum as $rateNum ) {
            if (null === $theNum->filterNumGte0($rateNum)) {
                throw new InvalidArgumentException([
                    'The `rateNum` should be greater than or equal to 0: %s',
                    $rateNum,
                ]);
            }
        }

        $ratesIndexes = array_keys($ratesNum);
        $ratesSum = array_sum($ratesNum);

        $zeros = [];
        $values = [];
        foreach ( $ratesIndexes as $i ) {
            ( 0 == $ratesNum[ $i ] )
                ? ( $zeros[ $i ] = $ratesNum[ $i ] )
                : ( $values[ $i ] = $ratesNum[ $i ] );
        }

        $countValues = count($values);

        $zeroRatio = 0;
        if (count($zeros)) {
            $minRate = min($values);
            $maxRate = max($values);

            if ($maxRate) {
                $zeroRatio = $minRate / $maxRate;
            }
        }

        $result = [];
        foreach ( $values as $i => $bool ) {
            $result[ $i ] = 1
                * ( $ratesNum[ $i ] / $ratesSum )
                * ( 1 - ( $zeroRatio / $countValues ) );
        }

        $zeroSum = 1 - array_sum($result);

        foreach ( $zeros as $i => $bool ) {
            $result[ $i ] = $zeroSum / count($zeros);
        }

        return $result;
    }


    /**
     * Балансирует общую сумму между получателями учитывая заранее известные ("замороженные") значения
     * Создавалась для взаимозависимого эквалайзера - двигаешь один ползунок - остальные равномерно меняются
     * Заберет у тех, у кого много, раздаст тем, кому мало, недостающее выдаст из суммы
     *
     * 65; [ 5,10,50 ]; [ ,,20 ]
     * 5x + 10x + 50x = 65
     * ((5 + 10 + 50) - 20) = 45
     * [ 3, 7, 35 ] + [ , , 20 ]
     * 3x + 7x = 35
     * [ 13.5, 31.5, 20 ] -> round...
     * [ 14, 31, 20 ]
     *
     * @param int|float            $sum
     * @param int|float|array      $ratesNeedle
     * @param null|int|float|array $ratesFreezes
     *
     * @return array
     */
    public function balance($sum, $ratesNeedle, $ratesFreezes = null) : array
    {
        $theNum = $this->getNum();

        $sum = $theNum->theNumval($sum);

        $ratesNeedleNum = is_array($ratesNeedle)
            ? $ratesNeedle
            : ( $ratesNeedle ? [ $ratesNeedle ] : [] );

        $ratesFreezesNum = is_array($ratesFreezes)
            ? $ratesFreezes
            : ( $ratesFreezes ? [ $ratesFreezes ] : [] );

        $ratesNeedleNum = array_filter($ratesNeedleNum, 'strlen');
        $ratesFreezesNum = array_filter($ratesFreezesNum, 'strlen');

        if (null === $theNum->filterNumGte0($sum)) {
            throw new InvalidArgumentException([
                'The `sum` should be greater than or equal to 0: %s',
                $sum,
            ]);
        }

        if (! $ratesNeedleNum) {
            throw new InvalidArgumentException(
                [ 'At least one rate should be passed: %s', $ratesNeedle ]
            );
        }

        foreach ( $ratesNeedleNum as $rateNeedleNum ) {
            if (null === $theNum->filterNumGte0($rateNeedleNum)) {
                throw new InvalidArgumentException([
                    'The `rateNeedleNum` should be greater than or equal to 0: %s',
                    $rateNeedleNum,
                ]);
            }
        }

        $sumRates = array_sum($ratesNeedleNum);
        $sumFreezes = array_sum($ratesFreezesNum);

        if ($sumFreezes > $sum) {
            throw new OutOfBoundsException(
                [ 'SumFreezes should be less than or equal to sum: [%s, %s]', [ $sumFreezes, $sum ] ]
            );
        }

        $keysRates = array_keys($ratesNeedleNum);
        $keysFreezes = array_keys($ratesFreezesNum);
        $keysAll = array_values(
            array_unique(array_merge(
                $keysRates,
                $keysFreezes
            ))
        );
        $keysShare = array_diff($keysAll, $keysFreezes);

        $result = array_fill(0, max($keysAll) + 1, 0);

        $src = [];
        $diff = [];
        foreach ( $keysAll as $k ) {
            $rate = $ratesNeedleNum[ $k ] ?? 0;
            $freeze = $ratesFreezesNum[ $k ] ?? 0;

            $src[ $k ] = ( $rate / $sumRates ) * $sum;
            $diff[ $k ] = $src[ $k ] - $freeze;
        }

        foreach ( $keysFreezes as $i ) {
            if ($diff[ $i ] > 0) {
                $ratesShare = [];
                foreach ( $keysShare as $k ) {
                    $ratesShare[ $k ] = $src[ $k ];
                }

                $ratesShare = $this->ratesZero($ratesShare);

                foreach ( $keysShare as $ii ) {
                    $value = $ratesShare[ $ii ] * $diff[ $i ];

                    $src[ $i ] -= $value;
                    $src[ $ii ] += $value;
                }

                $src[ $i ] = $ratesFreezesNum[ $i ];
            }
        }

        $ratesShare = [];
        foreach ( $keysShare as $k ) {
            $ratesShare[ $k ] = $src[ $k ];
        }

        $sumShare = array_sum($ratesShare);

        foreach ( $keysFreezes as $i ) {
            if ($diff[ $i ] < 0) {
                foreach ( $keysShare as $ii ) {
                    $ratio = ( $sumShare + $diff[ $i ] ) / $sumShare;
                    $val = $src[ $ii ] - ( $ratio * $src[ $ii ] );

                    $src[ $ii ] -= $val;
                    $src[ $i ] += $val;
                }

                $sumShare += $diff[ $i ];
            }
        }

        foreach ( $keysAll as $i ) {
            $result[ $i ] = $src[ $i ];
        }

        return $result;
    }


    /**
     * @param int|string  $floor
     * @param string|null $baseCharsTo
     * @param string      $baseCharsFrom
     * @param int         $baseShiftTo
     * @param int         $baseShiftFrom
     *
     * @return string
     */
    function baseConvertFloor($floor,
        string $baseCharsTo = null, string $baseCharsFrom = '0123456789',
        int $baseShiftTo = 0, int $baseShiftFrom = 0
    ) : string
    {
        $theStr = $this->getStr();

        $floor = strval($floor);

        if (! $len = $theStr->mb('strlen')($floor)) {
            return '';
        }

        $baseCharsFrom = $this->theAlgorismval($baseCharsFrom);
        $baseCharsTo = $this->theAlgorismval($baseCharsTo);

        $baseTo = $theStr->mb('strlen')($baseCharsTo);
        $baseFrom = $theStr->mb('strlen')($baseCharsFrom);

        $baseCharsFromIndex = array_flip($theStr->mb('str_split')($baseCharsFrom));

        $baseChars10 = '0123456789';

        if ($baseCharsFrom === $baseCharsTo) {
            return $floor;

        } elseif ($baseCharsFrom === $baseChars10) {
            $result = [];

            $div = $floor;
            if (0 > $this->bccomp($this->bcadd($div, $baseShiftTo, 0), 0, 0)) {
                throw new \RuntimeException('Unable to convert cause of `baseShiftTo`: ' . $div);
            }

            do {
                $div = $this->bcadd($div, $baseShiftTo, 0);

                $mod = $this->bcmod($div, $baseTo, 0);
                $div = $this->bcdiv($div, $baseTo, 0);

                $result[] = $theStr->mb('substr')($baseCharsTo, (int) $mod, 1);
            } while ( $this->bccomp($div, 0, 1) );

            $result = implode('', array_reverse($result));

        } elseif ($baseCharsTo === $baseChars10) {
            $result = '0';

            for ( $i = 1; $i <= $len; $i++ ) {
                $idx = $baseCharsFromIndex[ $theStr->mb('substr')($floor, $i - 1, 1) ];
                $idx = $this->bcsub($idx, $baseShiftFrom, 0);

                $pow = $this->bcpow($baseFrom, $len - $i);
                $sum = $this->bcmul($idx, $pow, 0);

                $result = $this->bcadd($result, $sum, 0);
            }

        } else {
            $result = $floor;
            $result = $this->baseConvertFloor($result, $baseChars10, $baseCharsFrom, 0, $baseShiftFrom);
            $result = $this->baseConvertFloor($result, $baseCharsTo, $baseChars10, $baseShiftTo, 0);
        }

        return $result;
    }

    /**
     * @param int|string  $frac
     * @param string|null $baseCharsTo
     * @param string      $baseCharsFrom
     * @param int|null    $scale
     *
     * @return string
     */
    function baseConvertFrac($frac,
        string $baseCharsTo = null, string $baseCharsFrom = '0123456789',
        int $scale = null
    ) : string
    {
        $theStr = $this->getStr();

        $frac = ltrim($frac, '.');

        if (! $len = $theStr->mb('strlen')($frac)) {
            return '';
        }

        $baseCharsFrom = $this->theAlgorismval($baseCharsFrom);
        $baseCharsTo = $this->theAlgorismval($baseCharsTo);
        $scale = $this->theScaleval($scale, '0.' . $frac);

        $baseTo = $theStr->mb('strlen')($baseCharsTo);
        $baseFrom = $theStr->mb('strlen')($baseCharsFrom);

        $baseCharsFromIndex = array_flip($theStr->mb('str_split')($baseCharsFrom));

        for ( $i = 0; $i < $len; $i++ ) {
            if (! isset($baseCharsFromIndex[ $theStr->mb('substr')($frac, $i, 1) ])) {
                throw new \InvalidArgumentException('The `frac` contains char outside `baseCharsFrom`: ' . $frac[ $i ]);
            }
        }

        $baseChars10 = '0123456789';

        if ($baseCharsFrom === $baseCharsTo) {
            return $frac;

        } elseif ($baseCharsFrom === $baseChars10) {
            $result = [];

            $mul = $this->bcadd('0.' . $frac, 0, $scale);

            $limit = $scale;
            while ( $limit-- ) {
                $mul = $this->bcmul($mul, $baseTo, $scale);
                $floor = $this->bcadd($mul, 0, 0);

                $mul = $this->bcsub($mul, $floor, $scale);

                $result[] = $theStr->mb('substr')($baseCharsTo, (int) $floor, 1);

                if (0 === $this->bccomp($mul, 0, $scale)) break;
            }

            $result = implode('', $result);

        } elseif ($baseCharsTo === $baseChars10) {
            $result = '0';

            for ( $i = 1; $i <= $len; $i++ ) {
                $idx = $baseCharsFromIndex[ $theStr->mb('substr')($frac, $i - 1, 1) ];

                $pow = $this->bcpow($baseFrom, -$i, $scale);
                $sum = $this->bcmul($idx, $pow, $scale);

                $result = $this->bcadd($result, $sum, $scale);
            }

            $result = explode('.', $result, 2)[ 1 ] ?? '0';

        } else {
            $result = $frac;
            $result = $this->baseConvertFrac($result, $baseChars10, $baseCharsFrom);
            $result = $this->baseConvertFrac($result, $baseCharsTo, $baseChars10);
        }

        return '.' . $result;
    }

    /**
     * @param int|float|string $num
     * @param string|null      $baseCharsTo
     * @param string           $baseCharsFrom
     * @param int|null         $scale
     * @param int              $baseShiftTo
     * @param int              $baseShiftFrom
     *
     * @return string
     */
    public function baseConvert($num,
        string $baseCharsTo = null, string $baseCharsFrom = '0123456789',
        int $scale = null,
        int $baseShiftTo = 0, int $baseShiftFrom = 0
    )
    {
        $theStr = $this->getStr();

        $isNegative = 0 === $theStr->mb('strpos')($num, '-');

        $numAbs = ltrim($num, '-');
        [ $numFloor, $numFrac ] = explode('.', $numAbs, 2) + [ '0', '' ];

        $scale = $scale ?? $theStr->mb('strlen')($numFrac);

        $result = [];
        if ('' !== $numFloor) $result[] = $this->baseConvertFloor($numFloor, $baseCharsTo, $baseCharsFrom, $baseShiftTo, $baseShiftFrom);
        if ('' !== $numFrac) $result[] = $this->baseConvertFrac($numFrac, $baseCharsTo, $baseCharsFrom, $scale);

        $result = implode('', $result);

        if ($isNegative) {
            $result = '-' . $result;
        }

        return $result;
    }


    /**
     * Округление по "правилу денег"
     * Эта функция учитывает "потерянную копейку", 1.0005 будет округлено до 1.01 вместо 1.00 (по математическим правилам)
     *
     * @param int|float|string|MathBcval|mixed $number
     * @param null|int                         $scale
     *
     * @return MathBcval
     */
    public function bcmoneyround($number, int $scale = null) : MathBcval
    {
        $bcval = $this->theBcval($number);
        $scale = $this->theScaleval($scale);

        $numberAbs = $bcval->getAbs();
        $numberMinus = $bcval->getMinus();

        $bcvalNewAbs = $this->bcadd($numberAbs, 0, $scale);

        if (! $hasDecimals = false !== strpos($numberAbs, '.')) {
            $bcmoneyround = $bcvalNewAbs;

        } else {
            $bonus = $this->bccomp($numberAbs, $bcvalNewAbs)
                ? ( 1 / pow(10, $scale) )
                : 0;

            $bcmoneyround = $this->bcadd($bcvalNewAbs, $bonus, $scale);
        }

        if ($numberMinus) {
            $bcmoneyround = $this->bcmul($bcmoneyround, -1, $scale);
        }

        return $bcmoneyround;
    }

    /**
     * Разбивает сумму между получателями
     * Если разделить 100 на 3 получается 33.33, 33.33, и 33.33 и 0.01 в периоде
     * Функция позволяет разбить исходное число на три, дробная часть от каждого деления достанется первому
     *
     * @param int|float|string|MathBcval|mixed $sum
     * @param int|float|string|MathBcval|array $rates
     * @param null|int                         $scale
     *
     * @return MathBcval[]
     */
    public function bcmoneyshare($sum, $rates, int $scale = null) : array
    {
        $sum = $this->theBcval($sum);
        $rates = $this->theBcvals($rates);

        if (! $rates) {
            throw new InvalidArgumentException(
                [ 'At least one rate should be passed: %s', $rates ]
            );
        }

        if (null === $this->filterBcGte0($sum)) {
            throw new InvalidArgumentException([
                'The `sum` should be greater than or equal to 0: %s',
                $sum,
            ]);
        }

        foreach ( $rates as $rate ) {
            if (null === $this->filterBcGte0($rate)) {
                throw new InvalidArgumentException([
                    'The `rate` should be greater than or equal to 0: %s',
                    $rate,
                ]);
            }
        }

        $result = [];

        $ratesIndexes = array_keys($rates);
        $ratesSum = '0';
        foreach ( $rates as $r ) {
            $ratesSum = $this->bcadd($ratesSum, $r); // scale will be calculated
        }

        if (null === $this->filterBcGt0($ratesSum)) {
            throw new InvalidArgumentException([
                'The `ratesSum` should be greater than or equal to 0: %s',
                $ratesSum,
            ]);
        }

        foreach ( $ratesIndexes as $i ) {
            $val = $rates[ $i ];

            $val = $this->bcmul($val, $sum, $scale);
            $val = $this->bcdiv($val, $ratesSum, $scale);

            $floor = $this->bcmoneyround($val, $scale);

            $result[ $i ] = $floor;
        }

        $resultSum = $this->bcsum($result); // scale will be calculated

        $mod = $this->bcsub($sum, $resultSum); // scale will be calculated

        $result[ 0 ] = $this->bcadd($result[ 0 ], $mod); // scale will be calculated

        return $result;
    }


    /**
     * @param float|mixed $number
     *
     * @return null|MathBcval
     */
    protected function bcvalFromInt($number) : ?MathBcval
    {
        if (is_int($number)) {
            return $this->newBcval($number);
        }

        if (! is_string($number)) {
            return null;
        }

        $string = strval($number);

        if (( false !== stripos($string, 'e') )
            || ( false !== strpos($string, '.') )
        ) {
            return null;
        }

        $bcval = $this->newBcval($string);

        return $bcval;
    }

    /**
     * @param int|float|string|MathBcval|mixed $number
     *
     * @return null|MathBcval
     */
    protected function bcvalFromNum($number) : ?MathBcval
    {
        if (is_int($number)) {
            return $this->newBcval($number);
        }

        if (null === ( $numericval = $this->getNum()->numericval($number) )) {
            return null;
        }

        if (false === strripos($numericval, 'e')) {
            $trim = ltrim($numericval, '0');

            $numericval = null
                ?? ( ( '' === $trim ) ? '0' : null )
                ?? ( '.' === $trim[ 0 ] ? '0' . $trim : null )
                ?? $trim;

            $bcval = $this->newBcval($numericval);

            return $bcval;
        }

        [ $floatstr, $exponent ] = preg_split('/e/i', $numericval) + [ null, null ];

        $lenFrac = -1 * intval(ltrim($exponent, '+'));

        if (false !== strpos($floatstr, '.')) {
            [ 1 => $frac ] = explode('.', $floatstr);

            $add = strlen(rtrim($frac, '0'));

            $lenFrac = $lenFrac + $add;
        }

        $lenFrac = max(0, $lenFrac);

        $numericval = $lenFrac
            ? sprintf('%.' . $lenFrac . 'f', $number)
            : sprintf('%.0f', $number);

        $bcval = $this->newBcval($numericval);

        return $bcval;
    }


    /**
     * @return IMath
     */
    public static function getInstance() : IMath
    {
        return SupportFactory::getInstance()->getMath();
    }
}