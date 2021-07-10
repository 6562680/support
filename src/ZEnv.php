<?php
/**
 * @noinspection RedundantSuppression
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support;


/**
 * ZEnv
 */
class ZEnv implements IEnv
{
    /**
     * @param null|string $option
     * @param null|bool   $runtime
     *
     * @return null|array|false|string
     */
    public function getenv($option = null, bool $runtime = null) // : string|array
    {
        $varname = is_string($option)
            ? $option
            : null;

        $varname_lower = is_string($option)
            ? strtolower($option)
            : null;

        $runtime = null
            ?? ( is_bool($runtime) ? $runtime : null )
            ?? ( is_bool($option) ? $option : null )
            ?? true;

        $env = getenv();
        if ($runtime) {
            $env = array_merge($env, static::$env ?? []);
        }

        // one value
        if ($varname) {
            $result = null
                ?? ( isset($env[ $varname ]) ? getenv($varname, $runtime) : null )
                ?? ( isset($env[ $varname_lower ]) ? getenv($varname_lower, $runtime) : null );

            return $result;
        }

        // all values
        $result = [];
        $registry = [];
        foreach ( $env as $key => $item ) {
            $prev = $registry[ $keyLower = strtolower($key) ] ?? null;

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
     * @return IEnv
     */
    public static function getInstance() : IEnv
    {
        return SupportFactory::getInstance()->getEnv();
    }


    /**
     * @var array
     */
    protected static $env;
}
