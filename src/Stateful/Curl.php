<?php

namespace Gzhegow\Support\Stateful;

use Gzhegow\Support\Type;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * Curl
 */
class Curl implements CurlInterface
{
    /**
     * @var Type
     */
    protected $type;

    /**
     * @var array
     */
    protected $curls;
    /**
     * @var array
     */
    protected $matrix;


    /**
     * @var array
     */
    protected $optionsDefault = [
        CURLOPT_HEADER         => 0,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_FOLLOWLOCATION => 1,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
    ];


    /**
     * Constructor
     *
     * @param Type $type
     */
    public function __construct(
        Type $type
    )
    {
        $this->type = $type;

        static::$infoCodes = static::$infoCodes ?? array_flip(static::$info);
        static::$curloptCodes = static::$curloptCodes ?? array_flip(static::$curlopt);
    }

    /**
     * @return array
     */
    public function getOptionsDefault() : array
    {
        return $this->optionsDefault ?? [];
    }

    /**
     * @return array
     */
    protected function getCurls() : array
    {
        return $this->curls ?? [];
    }

    /**
     * @return array
     */
    protected function getMatrix() : array
    {
        return $this->matrix ?? [];
    }

    /**
     * @param int $id
     *
     * @return array
     */
    protected function getMatrixById(int $id) : array
    {
        return $this->matrix[ $id ];
    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    protected function getCurlById(int $id) // : resource
    {
        return $this->curls[ $id ];
    }

    /**
     * @param mixed $h
     *
     * @return boolean
     */
    public function isCurl($h) : bool
    {
        $isResource = is_resource($h);
        $isClosedResource = ! $isResource && $this->type->isResource($h);

        $isCurl = $isResource && @curl_getinfo($h);

        if ($isCurl) {
            return true;
        }

        if ($isClosedResource && $this->hasMatrixById((int) $h)) {
            return true;
        }

        return false;
    }

    /**
     * @param resource $h
     * @param int|null $opt
     * @param null     $getinfo
     *
     * @return boolean
     */
    public function isOpenedCurl($h, $opt = null, &$getinfo = null) : bool
    {
        if (! is_resource($h)) return false;

        if (isset(static::$infoCodes[ $opt ])) {
            $getinfo = @curl_getinfo($h, $opt);

        } else {
            $getinfo = @curl_getinfo($h);

            if ($opt) {
                $getinfo = $getinfo[ $opt ] ?? null;
            }
        }

        return (bool) $getinfo
            ?: false;
    }

    /**
     * @param mixed $matrix
     *
     * @return bool
     */
    protected function isMatrix($matrix) : bool
    {
        return is_array($matrix) && ! array_diff_key($matrix, static::$curloptCodes);
    }

    /**
     * @param int $id
     *
     * @return bool
     */
    protected function hasCurlById(int $id) : bool
    {
        return isset($this->curls[ $id ]);
    }

    /**
     * @param int $id
     *
     * @return bool
     */
    protected function hasMatrixById(int $id) : bool
    {
        return isset($this->matrix[ $id ]);
    }

    /**
     * готовит инструкцию для curl запоса и сохраняет матрицу для создания на основе
     * если передать готовый curl запрос заменит существующие опции
     * если создавали через эту же функцию, опции будут соединены с предыдущим экземпляром, иначе переписаны
     *
     * @param mixed $curl
     * @param null  $data
     * @param array $curl_options
     *
     * @return resource
     */
    public function createNew($curl, $data = null, array $curl_options = []) // : resource
    {
        return $this->create('new', $curl, $data, $curl_options);
    }

    /**
     * копирует или создает curl запрос и сохраняет матрицу для создания на основе
     * если передать готовый curl запрос заменит существующие опции и вернет новый curl
     * если создавали через эту же функцию, опции будут соединены с предыдущим экземпляром, иначе переписаны
     *
     * @param mixed $curl
     * @param mixed $data
     * @param array $curl_options
     *
     * @return resource
     */
    public function createCopy($curl, $data = null, array $curl_options = []) // : resource
    {
        return $this->create('copy', $curl, $data, $curl_options);
    }

    /**
     * @param string|int $option
     * @param mixed      $value
     *
     * @return Curl
     */
    public function setOptionDefault($option, $value)
    {
        $code = null;
        if (is_int($option)) {
            $code = isset(static::$curloptCodes[ $option ])
                ? $option
                : null;

        } elseif (is_string($option)) {
            $code = static::$curlopt[ $option ] ?? null;

        }

        if (! isset($code)) {
            throw new InvalidArgumentException('Unknown option: ' . $option, func_get_args());
        }

        $this->optionsDefault[ $code ] = $value;

        return $this;
    }

    /**
     * @param array $options
     *
     * @return Curl
     */
    public function setOptionsDefault(array $options)
    {
        $this->optionsDefault = [];

        $this->mergeOptionsDefault($options);

        return $this;
    }

    /**
     * @param array $options
     *
     * @return Curl
     */
    public function mergeOptionsDefault(array $options)
    {
        foreach ( $options as $int => $value ) {
            $this->setOptionDefault($int, $value);
        }

        return $this;
    }

    /**
     * возвращает результат curl_getinfo
     *
     * @param mixed $curl
     * @param mixed $opt
     *
     * @return mixed
     */
    public function info($curl, $opt = null) // : mixed
    {
        if (! $this->isOpenedCurl($curl, $opt, $result)) {
            throw new BadMethodCallException('Curl should opened curl resource', func_get_args());
        }

        return $result;
    }

    /**
     * возвращает результат curl_getinfo. работает с массивом ресурсов
     *
     * @param array $curls
     * @param null  $opt
     *
     * @return array
     */
    public function infos(array $curls, $opt = null) : array
    {
        $result = [];

        foreach ( $curls as $idx => $curl ) {
            if (! $this->isOpenedCurl($curl, $opt, $res)) {
                throw new BadMethodCallException('Curls should be array of opened curl resources', func_get_args());
            }

            $result[ $idx ] = $res;
        }

        return $result;
    }

    /**
     * выводит список сохраненных опций, по которым будет создаваться новый ресурс при копировании или обновлении
     *
     * @param mixed $curl
     * @param bool  $verbose
     *
     * @return array
     */
    public function opt($curl, bool $verbose = false) : array
    {
        if (! $this->isCurl($curl)) {
            throw new InvalidArgumentException('Curl should be curl resource or closed one (created using this library)',
                func_get_args());
        }

        $result = $this->opts([ $curl ], $verbose);

        return $result[ 0 ];
    }

    /**
     * выводит список сохраненных опций, по которым будет создаваться новый ресурс при копировании или обновлении. работает с массивом ресурсов
     *
     * @param array $curls
     * @param bool  $verbose
     *
     * @return array
     */
    public function opts(array $curls, bool $verbose = false) : array
    {
        if (! $curls) return $this->getMatrix();

        $result = [];

        foreach ( $curls as $idx => $curl ) {
            if (! $this->isCurl($curl)) {
                throw new InvalidArgumentException('Curls should be array of curl resources or closed ones (created using this library)',
                    func_get_args());
            }

            $result[ $idx ] = $this->getMatrixById((int) $curl);
        }

        if ($verbose) {
            foreach ( $result as $idx => $array ) {
                $keys = array_intersect_key(static::$curlopt, $array);

                foreach ( $keys as $id => $name ) {
                    $result[ $idx ][ $name ] = $result[ $idx ][ $id ];

                    unset($result[ $idx ][ $id ]);
                }
            }
        }

        return $result ?? [];
    }

    /**
     * делает запросы группами по $limit, с задержкой между группами в $sleep секунд
     * если параметр $urls передан как обьект, то обработка результатов должна быть генератором
     *
     * @param mixed $limit
     * @param mixed $sleep
     * @param mixed $curls
     * @param null  $post
     * @param array $options
     *
     * @return array
     */
    public function batch($limit, $sleep, $curls, $post = null, array $options = []) : array
    {
        $results = [];
        $urls = [];
        $hh = [];

        $limit = $limit
            ?: 1;

        foreach ( $this->walk($limit, $sleep, $curls, $post, $options) as $result ) {
            [ $resultsCurrent, $urlsCurrent, $hhCurrent ] = $result;

            $results += $resultsCurrent;
            $urls += $urlsCurrent;
            $hh += $hhCurrent;
        }

        return [ $results, $urls, $hh ];
    }

    /**
     * @param mixed $limit
     * @param mixed $sleep
     * @param mixed $curls
     * @param null  $post
     * @param array $options
     *
     * @return \Generator
     */
    public function walk($limit, $sleep, $curls, $post = null, array $options = []) : \Generator
    {
        [ $minLimit, $maxLimit ] = (array) $limit + [ 1, null ];
        [ $minSleep, $maxSleep ] = (array) $sleep + [ 0, null ];

        $curls = (array) $curls;

        if (! is_int($minLimit)) {
            throw new InvalidArgumentException('MinLimit should be numeric', func_get_args());
        }

        if (! is_numeric($minSleep)) {
            throw new InvalidArgumentException('MinLimit should be numeric', func_get_args());
        }

        if (0 > $minLimit) {
            throw new InvalidArgumentException('MinLimit should be positive');
        }

        if (0 > $minSleep) {
            throw new InvalidArgumentException('MinLimit should be positive');
        }

        $maxLimit = $maxLimit ?? $minLimit;
        $maxSleep = $maxSleep ?? $minSleep;

        if (! is_int($maxLimit)) {
            throw new InvalidArgumentException('MinLimit should be numeric', func_get_args());
        }

        if (! is_numeric($maxSleep)) {
            throw new InvalidArgumentException('MinLimit should be numeric', func_get_args());
        }

        if (0 > $maxLimit) {
            throw new InvalidArgumentException('MinLimit should be positive');
        }

        if (0 > $maxSleep) {
            throw new InvalidArgumentException('MinLimit should be positive');
        }

        do {
            $limitCurrent = rand($minLimit, $maxLimit) ?? null;

            // splice
            $i = 0;
            $curlsCurrent = [];
            while ( null !== ( $key = key($curls) ) ) {
                $curlsCurrent[ $key ] = $curls[ $key ];
                unset($curls[ $key ]);

                if (++$i === $limitCurrent) {
                    break;
                }
            }

            // multicurl
            [ $responsesCurrent, $urlsCurrent, $hhCurrent ] = $this->multi($curlsCurrent, $post, $options);

            // return generator to reduce memory usage
            yield [ $responsesCurrent, $urlsCurrent, $hhCurrent ];

            // await before next batch
            if ($curls) {
                $sleepCurrent = $minSleep;

                if ($sleepCurrent !== $maxSleep) {
                    $sleepCurrent = ( $minSleep + lcg_value() * ( abs($maxSleep - $minSleep) ) );

                    // wait microseconds
                    usleep($sleepCurrent * 1000 * 1000);

                } elseif (is_float($sleepCurrent)) {
                    // wait microseconds
                    usleep($sleepCurrent * 1000 * 1000);

                } else {
                    // wait seconds
                    sleep($sleepCurrent);

                }
            }
        } while ( $curls );
    }

    /**
     * делает параллельный (одновременный) запрос через curl
     *
     * @param mixed $curls
     * @param null  $post
     * @param array $options
     *
     * @return array
     */
    public function multi($curls, $post = null, array $options = []) : array
    {
        $curls = (array) $curls;

        $master = curl_multi_init();

        $hh = [];
        $urls = [];
        foreach ( $curls as $index => $url ) {
            $hh[ $index ] = $h = $this->createNew($url, $post, $options);
            $urls[ $index ] = $this->info($h, 'url');

            // add handler to multi
            curl_multi_add_handle($master, $h);

            // echo URL
            if (PHP_SAPI === 'cli') {
                $this->info($h, 'url');
            }
        }

        // start requests
        do {
            $mrc = curl_multi_exec($master, $running);

            if ($running) {
                curl_multi_select($master);
            }
        } while ( $running && $mrc == CURLM_OK );

        // parse responses
        $results = [];
        foreach ( $hh as $index => $h ) {
            $results[ $index ] = curl_multi_getcontent($h);

            curl_multi_remove_handle($master, $h);
        }

        // close loop
        curl_multi_close($master);

        // result
        return [ $results, $urls, $hh ];
    }

    /**
     * @param string     $type
     * @param mixed      $curl
     * @param null       $data
     * @param array|null $curl_options
     *
     * @return resource
     */
    protected function create(string $type, $curl, $data = null, array $curl_options = []) // : resource
    {
        $isUrl = is_string($curl) && (bool) filter_var($curl, FILTER_VALIDATE_URL);
        $isCurl = $this->isCurl($curl);

        if (! ( $isUrl || $isCurl )) {
            throw new InvalidArgumentException('Curl should be URL address or CURL resource', func_get_args());
        }

        if (isset($data)
            && ! is_string($data)
            && ! is_array($data)
        ) {
            throw new InvalidArgumentException('Data should be null, string or array');
        }

        // create resource
        $h = null;
        $id = null;
        $options = [];
        $optionsMatrix = [];
        if ($isUrl) {
            $h = curl_init();
            $options[ CURLOPT_URL ] = $curl;

            $id = intval($h);

            // add curl to registry
            $this->setCurlById($id, $h);

        } elseif ($isCurl) {
            if ($this->hasMatrixById($id = (int) $curl)) {
                $optionsMatrix = $this->getMatrixById($id);
            }

            if ('copy' === $type) {
                $h = curl_init();
            } elseif ('new' === $type) {
                $h = $curl;
            }

            $id = intval($h);
        }

        // default options
        $optionsDefault = $this->getOptionsDefault();

        // merge options
        $headers = [];
        foreach ( [ $optionsDefault, $optionsMatrix, $curl_options ] as $array ) {
            foreach ( $array as $key => $val ) {
                if ($key === CURLOPT_HTTPHEADER) {
                    $headers = array_merge($headers, $val);
                } else {
                    $options[ $key ] = $val;
                }
            }
        }

        // merge headers
        $array = $headers;
        $headers = [];
        foreach ( $array as $header ) {
            [ $key, $val ] = explode(':', $header);
            $key = trim(strtolower($key));
            $headers[ $key ] = trim($val);
        }
        foreach ( $headers as $key => $val ) {
            $options[ CURLOPT_HTTPHEADER ][] = $key . ': ' . $val;
        }

        // set data
        if (isset($data)) {
            if (! isset($options[ CURLOPT_CUSTOMREQUEST ])) {
                $options[ CURLOPT_POST ] = 1;
            }

            // set content
            if (is_array($data)) {
                $options[ CURLOPT_POSTFIELDS ] = http_build_query($data);
            } else {
                $options[ CURLOPT_POSTFIELDS ] = $data;
            }
        }

        // assign settings to curl
        if (isset($data) || isset($curl_options)) {
            curl_setopt_array($h, $options);

        } elseif ($isUrl) {
            curl_setopt_array($h, $options);

        }

        // update matrix
        $this->setMatrixById($id, $options);

        // result
        return $h;
    }

    /**
     * @param int   $id
     * @param mixed $curl
     *
     * @return Curl
     */
    protected function setCurlById(int $id, $curl)
    {
        if (! $this->isCurl($curl)) {
            throw new InvalidArgumentException('Curl should be curl resource', func_get_args());
        }

        $this->curls[ $id ] = $curl;

        return $this;
    }

    /**
     * @param int   $id
     * @param array $matrix
     *
     * @return Curl
     */
    protected function setMatrixById(int $id, array $matrix)
    {
        if (! $this->isMatrix($matrix)) {
            throw new InvalidArgumentException('Matrix should be valid curl matrix', func_get_args());
        }

        $this->matrix[ $id ] = $matrix;

        return $this;
    }

    /**
     * @var array
     */
    protected static $curlopt = [
        "CURLOPT_ACCEPTTIMEOUT_MS"        => CURLOPT_ACCEPTTIMEOUT_MS,         // 212
        "CURLOPT_ADDRESS_SCOPE"           => CURLOPT_ADDRESS_SCOPE,            // 171
        "CURLOPT_AUTOREFERER"             => CURLOPT_AUTOREFERER,              // 58
        "CURLOPT_BINARYTRANSFER"          => CURLOPT_BINARYTRANSFER,           // 19914
        "CURLOPT_BUFFERSIZE"              => CURLOPT_BUFFERSIZE,               // 98
        "CURLOPT_CAINFO"                  => CURLOPT_CAINFO,                   // 10065
        "CURLOPT_CAPATH"                  => CURLOPT_CAPATH,                   // 10097
        "CURLOPT_CERTINFO"                => CURLOPT_CERTINFO,                 // 172
        "CURLOPT_CONNECTTIMEOUT"          => CURLOPT_CONNECTTIMEOUT,           // 78
        "CURLOPT_CONNECTTIMEOUT_MS"       => CURLOPT_CONNECTTIMEOUT_MS,        // 156
        "CURLOPT_CONNECT_ONLY"            => CURLOPT_CONNECT_ONLY,             // 141
        "CURLOPT_CONNECT_TO"              => CURLOPT_CONNECT_TO,               // 10243
        "CURLOPT_COOKIE"                  => CURLOPT_COOKIE,                   // 10022
        "CURLOPT_COOKIEFILE"              => CURLOPT_COOKIEFILE,               // 10031
        "CURLOPT_COOKIEJAR"               => CURLOPT_COOKIEJAR,                // 10082
        "CURLOPT_COOKIELIST"              => CURLOPT_COOKIELIST,               // 10135
        "CURLOPT_COOKIESESSION"           => CURLOPT_COOKIESESSION,            // 96
        "CURLOPT_CRLF"                    => CURLOPT_CRLF,                     // 27
        "CURLOPT_CRLFILE"                 => CURLOPT_CRLFILE,                  // 10169
        "CURLOPT_CUSTOMREQUEST"           => CURLOPT_CUSTOMREQUEST,            // 10036
        "CURLOPT_DEFAULT_PROTOCOL"        => CURLOPT_DEFAULT_PROTOCOL,         // 10238
        "CURLOPT_DNS_CACHE_TIMEOUT"       => CURLOPT_DNS_CACHE_TIMEOUT,        // 92
        "CURLOPT_DNS_INTERFACE"           => CURLOPT_DNS_INTERFACE,            // 10221
        "CURLOPT_DNS_LOCAL_IP4"           => CURLOPT_DNS_LOCAL_IP4,            // 10222
        "CURLOPT_DNS_LOCAL_IP6"           => CURLOPT_DNS_LOCAL_IP6,            // 10223
        "CURLOPT_DNS_SERVERS"             => CURLOPT_DNS_SERVERS,              // 10211
        "CURLOPT_DNS_USE_GLOBAL_CACHE"    => CURLOPT_DNS_USE_GLOBAL_CACHE,     // 91
        "CURLOPT_EGDSOCKET"               => CURLOPT_EGDSOCKET,                // 10077
        "CURLOPT_EXPECT_100_TIMEOUT_MS"   => CURLOPT_EXPECT_100_TIMEOUT_MS,    // 227
        "CURLOPT_FAILONERROR"             => CURLOPT_FAILONERROR,              // 45
        "CURLOPT_FILE"                    => CURLOPT_FILE,                     // 10001
        "CURLOPT_FILETIME"                => CURLOPT_FILETIME,                 // 69
        "CURLOPT_FNMATCH_FUNCTION"        => CURLOPT_FNMATCH_FUNCTION,         // 20200
        "CURLOPT_FOLLOWLOCATION"          => CURLOPT_FOLLOWLOCATION,           // 52
        "CURLOPT_FORBID_REUSE"            => CURLOPT_FORBID_REUSE,             // 75
        "CURLOPT_FRESH_CONNECT"           => CURLOPT_FRESH_CONNECT,            // 74
        "CURLOPT_FTPPORT"                 => CURLOPT_FTPPORT,                  // 10017
        "CURLOPT_FTPSSLAUTH"              => CURLOPT_FTPSSLAUTH,               // 129
        "CURLOPT_FTP_ACCOUNT"             => CURLOPT_FTP_ACCOUNT,              // 10134
        "CURLOPT_FTP_ALTERNATIVE_TO_USER" => CURLOPT_FTP_ALTERNATIVE_TO_USER,  // 10147
        "CURLOPT_FTP_CREATE_MISSING_DIRS" => CURLOPT_FTP_CREATE_MISSING_DIRS,  // 110
        "CURLOPT_FTP_FILEMETHOD"          => CURLOPT_FTP_FILEMETHOD,           // 138
        "CURLOPT_FTP_RESPONSE_TIMEOUT"    => CURLOPT_FTP_RESPONSE_TIMEOUT,     // 112
        "CURLOPT_FTP_SKIP_PASV_IP"        => CURLOPT_FTP_SKIP_PASV_IP,         // 137
        "CURLOPT_FTP_SSL_CCC"             => CURLOPT_FTP_SSL_CCC,              // 154
        "CURLOPT_FTP_USE_EPRT"            => CURLOPT_FTP_USE_EPRT,             // 106
        "CURLOPT_FTP_USE_EPSV"            => CURLOPT_FTP_USE_EPSV,             // 85
        "CURLOPT_FTP_USE_PRET"            => CURLOPT_FTP_USE_PRET,             // 188
        "CURLOPT_GSSAPI_DELEGATION"       => CURLOPT_GSSAPI_DELEGATION,        // 210
        "CURLOPT_HEADER"                  => CURLOPT_HEADER,                   // 42
        "CURLOPT_HEADERFUNCTION"          => CURLOPT_HEADERFUNCTION,           // 20079
        "CURLOPT_HEADEROPT"               => CURLOPT_HEADEROPT,                // 229
        "CURLOPT_HTTP200ALIASES"          => CURLOPT_HTTP200ALIASES,           // 10104
        "CURLOPT_HTTPAUTH"                => CURLOPT_HTTPAUTH,                 // 107
        "CURLOPT_HTTPGET"                 => CURLOPT_HTTPGET,                  // 80
        "CURLOPT_HTTPHEADER"              => CURLOPT_HTTPHEADER,               // 10023
        "CURLOPT_HTTPPROXYTUNNEL"         => CURLOPT_HTTPPROXYTUNNEL,          // 61
        "CURLOPT_HTTP_CONTENT_DECODING"   => CURLOPT_HTTP_CONTENT_DECODING,    // 158
        "CURLOPT_HTTP_TRANSFER_DECODING"  => CURLOPT_HTTP_TRANSFER_DECODING,   // 157
        "CURLOPT_HTTP_VERSION"            => CURLOPT_HTTP_VERSION,             // 84
        "CURLOPT_IGNORE_CONTENT_LENGTH"   => CURLOPT_IGNORE_CONTENT_LENGTH,    // 136
        "CURLOPT_INFILESIZE"              => CURLOPT_INFILESIZE,               // 14
        "CURLOPT_INTERFACE"               => CURLOPT_INTERFACE,                // 10062
        "CURLOPT_IPRESOLVE"               => CURLOPT_IPRESOLVE,                // 113
        "CURLOPT_ISSUERCERT"              => CURLOPT_ISSUERCERT,               // 10170
        "CURLOPT_KEYPASSWD"               => CURLOPT_KEYPASSWD,                // 10026
        "CURLOPT_LOCALPORT"               => CURLOPT_LOCALPORT,                // 139
        "CURLOPT_LOCALPORTRANGE"          => CURLOPT_LOCALPORTRANGE,           // 140
        "CURLOPT_LOGIN_OPTIONS"           => CURLOPT_LOGIN_OPTIONS,            // 10224
        "CURLOPT_LOW_SPEED_LIMIT"         => CURLOPT_LOW_SPEED_LIMIT,          // 19
        "CURLOPT_LOW_SPEED_TIME"          => CURLOPT_LOW_SPEED_TIME,           // 20
        "CURLOPT_MAIL_AUTH"               => CURLOPT_MAIL_AUTH,                // 10217
        "CURLOPT_MAIL_FROM"               => CURLOPT_MAIL_FROM,                // 10186
        "CURLOPT_MAIL_RCPT"               => CURLOPT_MAIL_RCPT,                // 10187
        "CURLOPT_MAXCONNECTS"             => CURLOPT_MAXCONNECTS,              // 71
        "CURLOPT_MAXFILESIZE"             => CURLOPT_MAXFILESIZE,              // 114
        "CURLOPT_MAXREDIRS"               => CURLOPT_MAXREDIRS,                // 68
        "CURLOPT_NETRC"                   => CURLOPT_NETRC,                    // 51
        "CURLOPT_NETRC_FILE"              => CURLOPT_NETRC_FILE,               // 10118
        "CURLOPT_NEW_DIRECTORY_PERMS"     => CURLOPT_NEW_DIRECTORY_PERMS,      // 160
        "CURLOPT_NEW_FILE_PERMS"          => CURLOPT_NEW_FILE_PERMS,           // 159
        "CURLOPT_NOBODY"                  => CURLOPT_NOBODY,                   // 44
        "CURLOPT_NOPROGRESS"              => CURLOPT_NOPROGRESS,               // 43
        "CURLOPT_NOPROXY"                 => CURLOPT_NOPROXY,                  // 10177
        "CURLOPT_NOSIGNAL"                => CURLOPT_NOSIGNAL,                 // 99
        "CURLOPT_PASSWORD"                => CURLOPT_PASSWORD,                 // 10174
        "CURLOPT_PATH_AS_IS"              => CURLOPT_PATH_AS_IS,               // 234
        "CURLOPT_PINNEDPUBLICKEY"         => CURLOPT_PINNEDPUBLICKEY,          // 10230
        "CURLOPT_PIPEWAIT"                => CURLOPT_PIPEWAIT,                 // 237
        "CURLOPT_PORT"                    => CURLOPT_PORT,                     // 3
        "CURLOPT_POST"                    => CURLOPT_POST,                     // 47
        "CURLOPT_POSTFIELDS"              => CURLOPT_POSTFIELDS,               // 10015
        "CURLOPT_POSTQUOTE"               => CURLOPT_POSTQUOTE,                // 10039
        "CURLOPT_POSTREDIR"               => CURLOPT_POSTREDIR,                // 161
        "CURLOPT_PREQUOTE"                => CURLOPT_PREQUOTE,                 // 10093
        "CURLOPT_PRIVATE"                 => CURLOPT_PRIVATE,                  // 10103
        "CURLOPT_PROGRESSFUNCTION"        => CURLOPT_PROGRESSFUNCTION,         // 20056
        "CURLOPT_PROXY"                   => CURLOPT_PROXY,                    // 10004
        "CURLOPT_PROXYAUTH"               => CURLOPT_PROXYAUTH,                // 111
        "CURLOPT_PROXYHEADER"             => CURLOPT_PROXYHEADER,              // 10228
        "CURLOPT_PROXYPASSWORD"           => CURLOPT_PROXYPASSWORD,            // 10176
        "CURLOPT_PROXYPORT"               => CURLOPT_PROXYPORT,                // 59
        "CURLOPT_PROXYTYPE"               => CURLOPT_PROXYTYPE,                // 101
        "CURLOPT_PROXYUSERNAME"           => CURLOPT_PROXYUSERNAME,            // 10175
        "CURLOPT_PROXYUSERPWD"            => CURLOPT_PROXYUSERPWD,             // 10006
        "CURLOPT_PROXY_SERVICE_NAME"      => CURLOPT_PROXY_SERVICE_NAME,       // 10235
        "CURLOPT_PROXY_TRANSFER_MODE"     => CURLOPT_PROXY_TRANSFER_MODE,      // 166
        "CURLOPT_PUT"                     => CURLOPT_PUT,                      // 54
        "CURLOPT_QUOTE"                   => CURLOPT_QUOTE,                    // 10028
        "CURLOPT_RANDOM_FILE"             => CURLOPT_RANDOM_FILE,              // 10076
        "CURLOPT_RANGE"                   => CURLOPT_RANGE,                    // 10007
        "CURLOPT_READFUNCTION"            => CURLOPT_READFUNCTION,             // 20012
        "CURLOPT_REFERER"                 => CURLOPT_REFERER,                  // 10016
        "CURLOPT_RESOLVE"                 => CURLOPT_RESOLVE,                  // 10203
        "CURLOPT_RESUME_FROM"             => CURLOPT_RESUME_FROM,              // 21
        "CURLOPT_RETURNTRANSFER"          => CURLOPT_RETURNTRANSFER,           // 19913
        "CURLOPT_RTSP_CLIENT_CSEQ"        => CURLOPT_RTSP_CLIENT_CSEQ,         // 193
        "CURLOPT_RTSP_REQUEST"            => CURLOPT_RTSP_REQUEST,             // 189
        "CURLOPT_RTSP_SERVER_CSEQ"        => CURLOPT_RTSP_SERVER_CSEQ,         // 194
        "CURLOPT_RTSP_SESSION_ID"         => CURLOPT_RTSP_SESSION_ID,          // 10190
        "CURLOPT_RTSP_STREAM_URI"         => CURLOPT_RTSP_STREAM_URI,          // 10191
        "CURLOPT_RTSP_TRANSPORT"          => CURLOPT_RTSP_TRANSPORT,           // 10192
        "CURLOPT_SASL_IR"                 => CURLOPT_SASL_IR,                  // 218
        "CURLOPT_SERVICE_NAME"            => CURLOPT_SERVICE_NAME,             // 10236
        "CURLOPT_SHARE"                   => CURLOPT_SHARE,                    // 10100
        "CURLOPT_SOCKS5_GSSAPI_NEC"       => CURLOPT_SOCKS5_GSSAPI_NEC,        // 180
        "CURLOPT_SOCKS5_GSSAPI_SERVICE"   => CURLOPT_SOCKS5_GSSAPI_SERVICE,    // 10179
        "CURLOPT_SSH_AUTH_TYPES"          => CURLOPT_SSH_AUTH_TYPES,           // 151
        "CURLOPT_SSH_HOST_PUBLIC_KEY_MD5" => CURLOPT_SSH_HOST_PUBLIC_KEY_MD5,  // 10162
        "CURLOPT_SSH_KNOWNHOSTS"          => CURLOPT_SSH_KNOWNHOSTS,           // 10183
        "CURLOPT_SSH_PRIVATE_KEYFILE"     => CURLOPT_SSH_PRIVATE_KEYFILE,      // 10153
        "CURLOPT_SSH_PUBLIC_KEYFILE"      => CURLOPT_SSH_PUBLIC_KEYFILE,       // 10152
        "CURLOPT_SSLCERT"                 => CURLOPT_SSLCERT,                  // 10025
        "CURLOPT_SSLCERTTYPE"             => CURLOPT_SSLCERTTYPE,              // 10086
        "CURLOPT_SSLENGINE"               => CURLOPT_SSLENGINE,                // 10089
        "CURLOPT_SSLENGINE_DEFAULT"       => CURLOPT_SSLENGINE_DEFAULT,        // 90
        "CURLOPT_SSLKEY"                  => CURLOPT_SSLKEY,                   // 10087
        "CURLOPT_SSLKEYTYPE"              => CURLOPT_SSLKEYTYPE,               // 10088
        "CURLOPT_SSLVERSION"              => CURLOPT_SSLVERSION,               // 32
        "CURLOPT_SSL_CIPHER_LIST"         => CURLOPT_SSL_CIPHER_LIST,          // 10083
        "CURLOPT_SSL_ENABLE_ALPN"         => CURLOPT_SSL_ENABLE_ALPN,          // 226
        "CURLOPT_SSL_ENABLE_NPN"          => CURLOPT_SSL_ENABLE_NPN,           // 225
        "CURLOPT_SSL_FALSESTART"          => CURLOPT_SSL_FALSESTART,           // 233
        "CURLOPT_SSL_OPTIONS"             => CURLOPT_SSL_OPTIONS,              // 216
        "CURLOPT_SSL_SESSIONID_CACHE"     => CURLOPT_SSL_SESSIONID_CACHE,      // 150
        "CURLOPT_SSL_VERIFYHOST"          => CURLOPT_SSL_VERIFYHOST,           // 81
        "CURLOPT_SSL_VERIFYPEER"          => CURLOPT_SSL_VERIFYPEER,           // 64
        "CURLOPT_SSL_VERIFYSTATUS"        => CURLOPT_SSL_VERIFYSTATUS,         // 232
        "CURLOPT_STDERR"                  => CURLOPT_STDERR,                   // 10037
        "CURLOPT_STREAM_WEIGHT"           => CURLOPT_STREAM_WEIGHT,            // 239
        "CURLOPT_TCP_FASTOPEN"            => CURLOPT_TCP_FASTOPEN,             // 244
        "CURLOPT_TCP_KEEPALIVE"           => CURLOPT_TCP_KEEPALIVE,            // 213
        "CURLOPT_TCP_KEEPIDLE"            => CURLOPT_TCP_KEEPIDLE,             // 214
        "CURLOPT_TCP_KEEPINTVL"           => CURLOPT_TCP_KEEPINTVL,            // 215
        "CURLOPT_TCP_NODELAY"             => CURLOPT_TCP_NODELAY,              // 121
        "CURLOPT_TELNETOPTIONS"           => CURLOPT_TELNETOPTIONS,            // 10070
        "CURLOPT_TFTP_BLKSIZE"            => CURLOPT_TFTP_BLKSIZE,             // 178
        "CURLOPT_TFTP_NO_OPTIONS"         => CURLOPT_TFTP_NO_OPTIONS,          // 242
        "CURLOPT_TIMECONDITION"           => CURLOPT_TIMECONDITION,            // 33
        "CURLOPT_TIMEOUT"                 => CURLOPT_TIMEOUT,                  // 13
        "CURLOPT_TIMEOUT_MS"              => CURLOPT_TIMEOUT_MS,               // 155
        "CURLOPT_TIMEVALUE"               => CURLOPT_TIMEVALUE,                // 34
        "CURLOPT_TLSAUTH_PASSWORD"        => CURLOPT_TLSAUTH_PASSWORD,         // 10205
        "CURLOPT_TLSAUTH_TYPE"            => CURLOPT_TLSAUTH_TYPE,             // 10206
        "CURLOPT_TLSAUTH_USERNAME"        => CURLOPT_TLSAUTH_USERNAME,         // 10204
        "CURLOPT_TRANSFERTEXT"            => CURLOPT_TRANSFERTEXT,             // 53
        "CURLOPT_TRANSFER_ENCODING"       => CURLOPT_TRANSFER_ENCODING,        // 207
        "CURLOPT_UNIX_SOCKET_PATH"        => CURLOPT_UNIX_SOCKET_PATH,         // 10231
        "CURLOPT_UNRESTRICTED_AUTH"       => CURLOPT_UNRESTRICTED_AUTH,        // 105
        "CURLOPT_UPLOAD"                  => CURLOPT_UPLOAD,                   // 46
        "CURLOPT_URL"                     => CURLOPT_URL,                      // 10002
        "CURLOPT_USERAGENT"               => CURLOPT_USERAGENT,                // 10018
        "CURLOPT_USERNAME"                => CURLOPT_USERNAME,                 // 10173
        "CURLOPT_USERPWD"                 => CURLOPT_USERPWD,                  // 10005
        "CURLOPT_VERBOSE"                 => CURLOPT_VERBOSE,                  // 41
        "CURLOPT_WILDCARDMATCH"           => CURLOPT_WILDCARDMATCH,            // 197
        "CURLOPT_WRITEFUNCTION"           => CURLOPT_WRITEFUNCTION,            // 20011
        "CURLOPT_WRITEHEADER"             => CURLOPT_WRITEHEADER,              // 10029
        "CURLOPT_XOAUTH2_BEARER"          => CURLOPT_XOAUTH2_BEARER,           // 10220

        "CURLOPT_DIRLISTONLY" => CURLOPT_DIRLISTONLY,  // 48
        "CURLOPT_FTPLISTONLY" => CURLOPT_FTPLISTONLY,  // 48

        "CURLOPT_APPEND"    => CURLOPT_APPEND,     // 50
        "CURLOPT_FTPAPPEND" => CURLOPT_FTPAPPEND,  // 50

        "CURLOPT_USE_SSL" => CURLOPT_USE_SSL,  // 119
        "CURLOPT_FTP_SSL" => CURLOPT_FTP_SSL,  // 119

        "CURLOPT_READDATA" => CURLOPT_READDATA,  // 10009
        "CURLOPT_INFILE"   => CURLOPT_INFILE,    // 10009

        "CURLOPT_KRB4LEVEL" => CURLOPT_KRB4LEVEL,  // 10063
        "CURLOPT_KRBLEVEL"  => CURLOPT_KRBLEVEL,   // 10063

        "CURLOPT_SSLCERTPASSWD" => CURLOPT_SSLCERTPASSWD,  // 10026
        "CURLOPT_SSLKEYPASSWD"  => CURLOPT_SSLKEYPASSWD,   // 10026

        "CURLOPT_ACCEPT_ENCODING" => CURLOPT_ACCEPT_ENCODING,  // 10102
        "CURLOPT_ENCODING"        => CURLOPT_ENCODING,         // 10102

        "CURLOPT_MAX_SEND_SPEED_LARGE" => CURLOPT_MAX_SEND_SPEED_LARGE,  // 30145
        "CURLOPT_MAX_RECV_SPEED_LARGE" => CURLOPT_MAX_RECV_SPEED_LARGE,  // 30146 (?)

        "CURLOPT_PROTOCOLS"       => CURLOPT_PROTOCOLS,        // 181
        "CURLOPT_REDIR_PROTOCOLS" => CURLOPT_REDIR_PROTOCOLS,  // 182 (?)

        "CURLOPT_SAFE_UPLOAD" => CURLOPT_SAFE_UPLOAD,  // -1 (?)
    ];
    /**
     * @var array
     */
    protected static $curloptCodes;
    /**
     * @var array
     */
    protected static $info = [
        'CURLINFO_EFFECTIVE_URL'           => CURLINFO_EFFECTIVE_URL,
        'CURLINFO_FILETIME'                => CURLINFO_FILETIME,
        'CURLINFO_TOTAL_TIME'              => CURLINFO_TOTAL_TIME,
        'CURLINFO_NAMELOOKUP_TIME'         => CURLINFO_NAMELOOKUP_TIME,
        'CURLINFO_CONNECT_TIME'            => CURLINFO_CONNECT_TIME,
        'CURLINFO_PRETRANSFER_TIME'        => CURLINFO_PRETRANSFER_TIME,
        'CURLINFO_STARTTRANSFER_TIME'      => CURLINFO_STARTTRANSFER_TIME,
        'CURLINFO_REDIRECT_COUNT'          => CURLINFO_REDIRECT_COUNT,
        'CURLINFO_REDIRECT_TIME'           => CURLINFO_REDIRECT_TIME,
        'CURLINFO_REDIRECT_URL'            => CURLINFO_REDIRECT_URL,
        'CURLINFO_PRIMARY_IP'              => CURLINFO_PRIMARY_IP,
        'CURLINFO_PRIMARY_PORT'            => CURLINFO_PRIMARY_PORT,
        'CURLINFO_LOCAL_IP'                => CURLINFO_LOCAL_IP,
        'CURLINFO_LOCAL_PORT'              => CURLINFO_LOCAL_PORT,
        'CURLINFO_SIZE_UPLOAD'             => CURLINFO_SIZE_UPLOAD,
        'CURLINFO_SIZE_DOWNLOAD'           => CURLINFO_SIZE_DOWNLOAD,
        'CURLINFO_SPEED_DOWNLOAD'          => CURLINFO_SPEED_DOWNLOAD,
        'CURLINFO_SPEED_UPLOAD'            => CURLINFO_SPEED_UPLOAD,
        'CURLINFO_HEADER_SIZE'             => CURLINFO_HEADER_SIZE,
        'CURLINFO_HEADER_OUT'              => CURLINFO_HEADER_OUT,
        'CURLINFO_REQUEST_SIZE'            => CURLINFO_REQUEST_SIZE,
        'CURLINFO_SSL_VERIFYRESULT'        => CURLINFO_SSL_VERIFYRESULT,
        'CURLINFO_CONTENT_LENGTH_DOWNLOAD' => CURLINFO_CONTENT_LENGTH_DOWNLOAD,
        'CURLINFO_CONTENT_LENGTH_UPLOAD'   => CURLINFO_CONTENT_LENGTH_UPLOAD,
        'CURLINFO_CONTENT_TYPE'            => CURLINFO_CONTENT_TYPE,
        'CURLINFO_PRIVATE'                 => CURLINFO_PRIVATE,
        'CURLINFO_HTTP_CONNECTCODE'        => CURLINFO_HTTP_CONNECTCODE,
        'CURLINFO_HTTPAUTH_AVAIL'          => CURLINFO_HTTPAUTH_AVAIL,
        'CURLINFO_PROXYAUTH_AVAIL'         => CURLINFO_PROXYAUTH_AVAIL,
        'CURLINFO_OS_ERRNO'                => CURLINFO_OS_ERRNO,
        'CURLINFO_NUM_CONNECTS'            => CURLINFO_NUM_CONNECTS,
        'CURLINFO_SSL_ENGINES'             => CURLINFO_SSL_ENGINES,
        'CURLINFO_COOKIELIST'              => CURLINFO_COOKIELIST,
        'CURLINFO_FTP_ENTRY_PATH'          => CURLINFO_FTP_ENTRY_PATH,
        'CURLINFO_APPCONNECT_TIME'         => CURLINFO_APPCONNECT_TIME,
        'CURLINFO_CERTINFO'                => CURLINFO_CERTINFO,
        'CURLINFO_CONDITION_UNMET'         => CURLINFO_CONDITION_UNMET,
        'CURLINFO_RTSP_CLIENT_CSEQ'        => CURLINFO_RTSP_CLIENT_CSEQ,
        'CURLINFO_RTSP_CSEQ_RECV'          => CURLINFO_RTSP_CSEQ_RECV,
        'CURLINFO_RTSP_SERVER_CSEQ'        => CURLINFO_RTSP_SERVER_CSEQ,
        'CURLINFO_RTSP_SESSION_ID'         => CURLINFO_RTSP_SESSION_ID,
        'CURLINFO_HTTP_CODE'               => CURLINFO_HTTP_CODE,
        'CURLINFO_RESPONSE_CODE'           => CURLINFO_RESPONSE_CODE,
    ];
    protected static $infoCodes;
}
