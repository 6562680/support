<?php
/**
 * @noinspection RedundantSuppression
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support;


/**
 * XFormat
 */
class XFormat implements IFormat
{
    /**
     * Форматирует размер в байтах в читаемый формат
     *
     * @param int $bytesize
     *
     * @return string
     */
    public function byteText(int $bytesize)
    {
        if ($bytesize == 0) {
            return "0.00 B";
        }

        $s = [ 'B', 'KB', 'MB', 'GB', 'TB', 'PB' ];
        $e = floor(log($bytesize, 1024));

        if (! isset($s[ $e ])) {
            throw new \RuntimeException('The `bytesize` should be number from function _bytesize():' . $bytesize);
        }

        return round($bytesize / pow(1024, $e), 2) . $s[ $e ];
    }

    /**
     * Форматирует читаемый формат в размер в байтах
     *
     * @param string $bytetext
     *
     * @return float|int
     */
    public function byteSize(string $bytetext)
    {
        $bytetext = trim($bytetext);

        $s = array_flip([ 'B', 'KB', 'MB', 'GB', 'TB', 'PB' ]);

        $regex = '/(' . implode('|', array_keys($s)) . ')$/i';

        if (false === preg_match($regex, $bytetext, $mathes)) {
            throw new \RuntimeException('The `bytetext` should be text from function _bytetext():' . $bytetext);
        }

        $int = $bytetext;
        $float = $bytetext;

        $value = null
            ?? ( ( false !== settype($int, 'integer') ) ? $int : null )
            ?? ( ( false !== settype($float, 'float') ) ? $float : null )
            ?? null;

        return $value * pow(1024, $s[ $mathes[ 1 ] ]);
    }


    /**
     * Вычищает из JSON комментарии и лишние пустые строки
     *
     * @param string $json
     *
     * @return string
     */
    public function jsonClear(string $json) : string
    {
        if ('' === $json) return '';

        $result = $json;

        $result = preg_replace('~/\*.*?\*/~s', '', $result); // Strip multi-line comments: '/* comment */'
        $result = preg_replace('~//.*~', '', $result);       // Strip single-line comments: '// comment'
        $result = preg_replace('~\n\s*\n~', "\n", $result);  // Remove empty-lines (as clean up for above)

        return $result;
    }


    /**
     * Экранирует специальные символы SQL
     *
     * @param string      $value
     * @param null|string $escape
     *
     * @return string
     */
    public function sqlEscape(string $value, string $escape = null) : string
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
     * Заменяет любое число пробелов в тексте на один, как делает браузер с версткой
     *
     * @param string $htmlContent
     *
     * @return string
     */
    protected function htmlDom(string $htmlContent) : string
    {
        return trim(preg_replace("/\s+/m", ' ', $htmlContent));
    }


    /**
     * @return IFormat
     */
    public static function getInstance() : IFormat
    {
        return SupportFactory::getInstance()->getFormat();
    }
}