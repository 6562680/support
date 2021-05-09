<?php

namespace Gzhegow\Support\Domain\Curl;

use Gzhegow\Support\Php;
use Gzhegow\Support\Filter;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * Formatter
 */
class Formatter
{
    const METHOD_CONNECT = 'CONNECT';
    const METHOD_DELETE  = 'DELETE';
    const METHOD_GET     = 'GET';
    const METHOD_HEAD    = 'HEAD';
    const METHOD_OPTIONS = 'OPTIONS';
    const METHOD_PATCH   = 'PATCH';
    const METHOD_POST    = 'POST';
    const METHOD_PURGE   = 'PURGE';
    const METHOD_PUT     = 'PUT';
    const METHOD_TRACE   = 'TRACE';

    const THE_METHOD_LIST = [
        self::METHOD_HEAD    => true,
        self::METHOD_OPTIONS => true,
        self::METHOD_GET     => true,
        self::METHOD_POST    => true,
        self::METHOD_PATCH   => true,
        self::METHOD_PUT     => true,
        self::METHOD_DELETE  => true,
        self::METHOD_PURGE   => true,
        self::METHOD_CONNECT => true,
        self::METHOD_TRACE   => true,
    ];


    /**
     * @var Filter
     */
    protected $filter;
    /**
     * @var Php
     */
    protected $php;


    /**
     * Constructor
     *
     * @param Php    $php
     * @param Filter $filter
     */
    public function __construct(
        Filter $filter,
        Php $php
    )
    {
        $this->filter = $filter;
        $this->php = $php;

        static::$infoCodes = static::$infoCodes ?? array_flip(static::$info);
        static::$curloptCodes = static::$curloptCodes ?? array_flip(static::$curlopt);
    }


    /**
     * @param $method
     *
     * @return null|string
     */
    public function detectHttpMethod($method) : ?string
    {
        if (! is_string($method)) {
            return null;
        }

        return isset(static::THE_METHOD_LIST[ $httpMethod = strtoupper($method) ])
            ? $httpMethod
            : null;
    }

    /**
     * @param mixed $info
     *
     * @return null|int
     */
    public function detectInfoCode($info) : ?int
    {
        $infoCode = null
            ?? ( ( ( null !== $this->filter->filterInt($info) )
                && isset(static::$infoCodes[ $info ]) )
                ? $info
                : false
            )
            ?? ( is_string($info) ? static::$info[ $info ] : false );

        return false !== $infoCode
            ? $infoCode
            : null;
    }

    /**
     * @param mixed $opt
     *
     * @return null|int
     */
    public function detectOptCode($opt) : ?int
    {
        $optCode = null
            ?? ( ( ( null !== $this->filter->filterInt($opt) )
                && isset(static::$curloptCodes[ $opt ]) )
                ? $opt
                : false
            )
            ?? ( is_string($opt) ? static::$curlopt[ $opt ] : false );

        return false !== $optCode
            ? $optCode
            : null;
    }


    /**
     * @param array $curlOptArray
     *
     * @return array
     */
    public function formatOptions(array $curlOptArray) : array
    {
        $keys = array_intersect_key(static::$curloptCodes, $curlOptArray);

        $result = [];

        foreach ( $keys as $id => $name ) {
            $result[ $name ] = $curlOptArray[ $id ];
        }

        return $result;
    }

    /**
     * @param array ...$curlOptArrays
     *
     * @return array
     */
    public function mergeOptions(array ...$curlOptArrays) : array
    {
        $result = [];
        $resultHeaders = [];

        [ $kwargs, $args ] = $this->php->kwargsDistinct(...$curlOptArrays);

        foreach ( $kwargs as $opt => $val ) {
            if (null === ( $optCode = $this->detectOptCode($opt) )) {
                throw new InvalidArgumentException('Invalid CURL option: ' . $opt, func_get_args());
            }

            ( $optCode === CURLOPT_HTTPHEADER )
                ? ( $resultHeaders = array_merge($resultHeaders, $val) )
                : ( $result[ $opt ] = $val );
        }

        foreach ( $args as $opt => $val ) {
            if (null === ( $optCode = $this->detectOptCode($opt) )) {
                throw new InvalidArgumentException('Invalid CURL option: ' . $opt, func_get_args());
            }

            ( $optCode === CURLOPT_HTTPHEADER )
                ? ( $resultHeaders = array_merge($resultHeaders, $val) )
                : ( $result[ $opt ] = $val );
        }

        $headers = [];
        foreach ( $resultHeaders as $name => $header ) {
            $parts = explode(':', $header, 2) + [ null, null ];
            $val = reset($parts);

            $contentName = ( null !== $parts[ 1 ] ) ? $parts[ 0 ] : null;
            $arrayName = is_string($name) ? $name : null;

            $key = $contentName ?? $arrayName;
            $key = trim(strtolower($key));

            if ($key) {
                $headers[ $key ] = trim($val);
            }
        }
        foreach ( $headers as $key => $val ) {
            $result[ CURLOPT_HTTPHEADER ][] = $key . ': ' . $val;
        }

        return $result;
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
    /**
     * @var array
     */
    protected static $infoCodes;
}
