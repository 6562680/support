<?php
/**
 * @noinspection RedundantSuppression
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * ZFormat
 */
class ZFormat implements IFormat
{
    /**
     * @var INum
     */
    protected $num;


    /**
     * Constructor
     *
     * @param INum $num
     */
    public function __construct(
        INum $num
    )
    {
        $this->num = $num;
    }


    /**
     * конвертирует цифру размера в читабельный формат (1024 => 1Mb)
     *
     * @param int|float|string $filesize
     *
     * @return string
     */
    public function niceSize($filesize) : string
    {
        $filesize = $this->num->theNumericval($filesize);

        $multiplier = 0;
        while ( $filesize / 1024 > 0.9 ) {
            $filesize = $filesize / 1024;

            $multiplier++;
        }

        $result = round($filesize) . array_search($multiplier, static::getUnits());

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
     * @return IFormat
     */
    public static function getInstance()
    {
        return SupportFactory::getInstance()->getFormat();
    }


    /**
     * @return array
     */
    protected static function getUnits() : array
    {
        return [
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
}
