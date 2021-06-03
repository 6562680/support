<?php

defined('__ROOT__') or define('__ROOT__', __DIR__ . '/..');

require_once __DIR__ . '/../vendor/autoload.php';

class Gzhegow_Support_Generator
{
    /**
     * @param string      $str
     * @param null|string $needle
     * @param bool        $ignoreCase
     *
     * @return null|string
     */
    public function str_starts(string $str, string $needle = null, bool $ignoreCase = true) : ?string
    {
        $needle = $needle ?? '';

        if ('' === $str) return null;
        if ('' === $needle) return $str;

        $pos = $ignoreCase
            ? mb_stripos($str, $needle)
            : mb_strpos($str, $needle);

        $result = 0 === $pos
            ? mb_substr($str, mb_strlen($needle))
            : null;

        return $result;
    }

    /**
     * @param string $class
     *
     * @return array
     */
    public function classUses(string $class) : array
    {
        $uses = [];

        try {
            $rc = new \ReflectionClass($class);
        }
        catch ( ReflectionException $e ) {
            throw new \RuntimeException('Unable to reflect: ' . $class, null, $e);
        }

        $filepath = $rc->getFileName();

        $h = fopen($filepath, 'r');
        while ( ! feof($h) ) {
            $line = trim(fgets($h));

            if (null !== ( $cut = $this->str_starts($line, 'use ') )) {
                $uses[] = rtrim($cut, ';');
            }

            if (null !== $this->str_starts($line, 'class ')) {
                break;
            }
        }
        fclose($h);

        return $uses;
    }
}
