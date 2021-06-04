<?php /** @noinspection PhpUnusedAliasInspection */

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * Format
 */
class Format
{
    /**
     * @var Num
     */
    protected $num;


    /**
     * Constructor
     *
     * @param Num $num
     */
    public function __construct(
        Num $num
    )
    {
        $this->num = $num;
    }


    /**
     * конвертирует цифру размера в читабельный формат (1024 => 1Mb)
     *
     * @param int|float|string $size
     *
     * @return string
     */
    public function fileSize($size) : string
    {
        if (null === ( $numval = $this->num->numval($size) )) {
            throw new InvalidArgumentException(
                [ 'Filesize should be int or float: %s', $size ]
            );
        }

        $multiplier = 0;
        while ( $numval / 1024 > 0.9 ) {
            $numval = $numval / 1024;

            $multiplier++;
        }

        $result = round($numval) . array_search($multiplier, static::$units);

        return $result;
    }


    /**
     * Формирует условие для SQL LIKE %val% запроса, экранируя проценты и подчеркивания
     *
     * @param string      $value
     * @param null|string $escape
     *
     * @return string
     */
    public function sqlLike(string $value, string $escape = null) : string
    {
        $escape = $escape ?? '\\';

        $result = str_replace(
            [ $escape, '%', '_' ],
            [ $escape . $escape, $escape . '%', $escape . '_' ],
            $value
        );

        return $result;
    }


    /**
     * @var array
     */
    protected static $units = [
        'B' => 0,

        'Kb' => 1,
        'Mb' => 2,
        'Gb' => 3,
        'Tb' => 4,
        'Pb' => 5,
        'Eb' => 6,
        'Zb' => 7,
        'Yb' => 8,

        'K' => 1,
        'M' => 2,
        'G' => 3,
        'T' => 4,
        'P' => 5,
        'E' => 6,
        'Z' => 7,
        'Y' => 8,
    ];
}
