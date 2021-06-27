<?php

namespace Gzhegow\Support;


use Gzhegow\Support\Interfaces\EnvInterface;


/**
 * Env
 */
class Env implements EnvInterface
{
    /**
     * @param null      $option
     * @param bool|null $runtime
     *
     * @return null|array|false|string
     */
    public function getenv($option = null, bool $runtime = null) // : string|array
    {
        $varname = is_string($option)
            ? $option
            : null;

        $varname_lower = is_string($option)
            ? mb_strtolower($option)
            : null;

        $runtime = null
            ?? ( is_bool($runtime)
                ? $runtime
                : null )
            ?? ( is_bool($option)
                ? $option
                : null )
            ?? true;

        $env = getenv();
        if ($runtime) {
            $env = array_merge($env, static::$env ?? []);
        }

        // one value
        if ($varname) {
            $result = null
                ?? ( isset($env[ $varname ])
                    ? getenv($varname, $runtime)
                    : null )
                ?? ( isset($env[ $varname_lower ])
                    ? getenv($varname_lower, $runtime)
                    : null );

            return $result;
        }

        // all values
        $result = [];
        $registry = [];
        foreach ( $env as $key => $item ) {
            $prev = $registry[ $keyLower = mb_strtolower($key) ] ?? null;

            if (isset($prev)) unset($result[ $prev ]);

            $registry[ $keyLower ] = $key;
            $result[ $key ] = getenv($key, $runtime);
        }

        return $result;
    }

    /**
     * @param string $name
     * @param string $value
     *
     * @return bool
     */
    public function putenv(string $name, string $value) : bool
    {
        $status = putenv($name . '=' . $value);

        if ($status) {
            static::$env[ $name ] = $value;
        }

        return $status;
    }


    /**
     * @var
     */
    protected static $env;
}
