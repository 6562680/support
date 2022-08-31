<?php
/**
 * @noinspection RedundantSuppression
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support;


/**
 * XEnv
 */
class XEnv implements IEnv
{
    /**
     * @var array
     */
    protected $envLocal = [];
    /**
     * @var array
     */
    protected $envRuntime = [];


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->envLocal = getenv();
    }


    /**
     * @return void
     */
    public function resetEnv() : void
    {
        foreach ( $this->envRuntime as $key => $value ) {
            if (! isset($this->envLocal[ $key ])) {
                putenv($key); // unset env

            } elseif ($this->envRuntime[ $key ] !== $this->envLocal[ $key ]) {
                putenv($key . '=' . $this->envLocal[ $key ]); // reset env
            }
        }

        $this->envRuntime = [];
    }


    /**
     * @return array
     */
    public function getEnvLocal() : array
    {
        return $this->envLocal;
    }

    /**
     * @return array
     */
    public function getEnvRuntime() : array
    {
        return $this->envRuntime;
    }


    /**
     * @param string    $option
     * @param mixed     $default
     * @param null|bool $ignoreCase
     * @param null|bool $localOnly
     *
     * @return null|string|array|mixed
     */
    public function env(string $option, $default = null, bool $ignoreCase = null, bool $localOnly = null) // : null|string|array|mixed
    {
        $result = null;

        $localOnly = $localOnly ?? false;
        $ignoreCase = $ignoreCase ?? true;

        if (! $ignoreCase) {
            $result = null
                ?? ( ( ! $localOnly ) ? $_ENV[ $option ] : null )
                ?? ( ( false !== ( $val = $this->getenv($option, false, $localOnly) ) ) ? $val : null )
                ?? null;

        } else {
            if (! $localOnly) {
                $envIgnoreCase = [];
                foreach ( $_ENV as $key => $val ) {
                    $envIgnoreCase[ strtoupper($key) ] = $val;
                }

                $result = null
                    ?? $_ENV[ $option ]
                    ?? $envIgnoreCase[ strtoupper($option) ]
                    ?? null;
            }

            $result = $result
                ?? ( ( false !== ( $val = $this->getenv($option, true, $localOnly) ) ) ? $val : null )
                ?? null;
        }

        return $result ?? $default;
    }


    /**
     * @param null|string $option
     * @param null|bool   $ignoreCase
     * @param null|bool   $localOnly
     *
     * @return string|array|false
     */
    public function getenv(string $option = null, bool $ignoreCase = null, bool $localOnly = null) // : string|array|false
    {
        $result = false;

        $ignoreCase = $ignoreCase ?? true;
        $localOnly = $localOnly ?? false;

        $env = $localOnly
            ? $this->envLocal
            : getenv();

        if (! $ignoreCase) {
            $result = ( null !== $option )
                ? ( $env[ $option ] ?? false )
                : $env;

        } else {
            $envIgnoreCase = [];
            foreach ( $env as $key => $val ) {
                $envIgnoreCase[ strtoupper($key) ] = $val;
            }

            if (null === $option) {
                $result = $envIgnoreCase;

            } else {
                $result = null
                    ?? $env[ $option ]
                    ?? $envIgnoreCase[ strtoupper($option) ]
                    ?? false;
            }
        }

        return $result;
    }


    /**
     * @param string    $name
     * @param string    $value
     * @param null|bool $ignoreCase
     *
     * @return void
     */
    public function setenv(string $name, string $value, bool $ignoreCase = null) : void
    {
        $ignoreCase = $ignoreCase ?? true;

        $env = $this->getenv(null, false, false);

        $nameParsed = $name;
        if ($ignoreCase) {
            foreach ( $env as $key => $val ) {
                if (strtoupper($name) === strtoupper($key)) {
                    $nameParsed = $key;

                    break;
                }
            }
        }

        $this->envRuntime[ $nameParsed ] = $value;

        $_ENV[ $nameParsed ] = $value;
    }

    /**
     * @param string    $name
     * @param string    $value
     * @param null|bool $ignoreCase
     *
     * @return bool
     */
    public function putenv(string $name, string $value, bool $ignoreCase = null) : bool
    {
        $ignoreCase = $ignoreCase ?? true;

        $env = $this->getenv(null, false, false);

        $nameParsed = $name;
        if ($ignoreCase) {
            foreach ( $env as $key => $val ) {
                if (strtoupper($name) === strtoupper($key)) {
                    $nameParsed = $key;

                    break;
                }
            }
        }

        $status = putenv($nameParsed . '=' . $value);

        if ($status) {
            $this->envRuntime[ $nameParsed ] = $value;

            $_ENV[ $nameParsed ] = $value;
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
}