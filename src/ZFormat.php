<?php
/**
 * @noinspection RedundantSuppression
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support;


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
    public function textFilesize($filesize) : string
    {
        $filesize = $this->num->theNumericval($filesize);

        $pow = 0;
        while ( ( $result = ( $filesize / 1024 ) ) > 1 ) {
            $filesize = $result;
            $pow++;
        }

        $result = round($filesize) . static::getUnits()[ $pow ];

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
    public static function getInstance() : IFormat
    {
        return SupportFactory::getInstance()->getFormat();
    }


    /**
     * @return array
     */
    protected static function getUnits() : array
    {
        return [
            'b',
            'Kb',
            'Mb',
            'Gb',
            'Tb',
            'Pb',
            'Eb',
            'Zb',
            'Yb',
        ];
    }
}
