<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Domain\Str\Slugger;
use Gzhegow\Support\Domain\Str\Inflector;
use Gzhegow\Support\Domain\Curl\CurlBlueprint;
use Gzhegow\Support\Domain\Debug\DebugMessage;
use Gzhegow\Support\Domain\Curl\CurloptManager;
use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Domain\Str\SluggerInterface;
use Gzhegow\Support\Domain\Str\InflectorInterface;
use Gzhegow\Support\Domain\Math\ValueObject\MathBcval;
use Gzhegow\Support\Domain\Curl\CurloptManagerInterface;
use Gzhegow\Support\Domain\Php\ValueObject\PhpInvokableInfo;


/**
 * SupportFactory
 */
class SupportFactory implements SupportFactoryInterface
{
    const PSR_CONTAINER_INTERFACE = '\Psr\Container\ContainerInterface';


    /**
     * @var null|\Psr\Container\ContainerInterface
     *
     * @noinspection PhpFullyQualifiedNameUsageInspection
     */
    protected $container;


    /**
     * Constructor
     *
     * @param null|object|\Psr\Container\ContainerInterface $container
     *
     * @noinspection PhpFullyQualifiedNameUsageInspection
     */
    public function __construct(object $container = null)
    {
        if (null !== $container) {
            if (! is_a($container, $interface = static::PSR_CONTAINER_INTERFACE)) {
                throw new RuntimeException('The `container` should implements ' . $interface);
            }

            $this->container = $container;
        }
    }


    /**
     * @param null|SupportFactoryInterface $instance
     *
     * @return void
     */
    public static function withInstance(?SupportFactoryInterface $instance) : void
    {
        static::$instance[ static::class ] = $instance;
    }


    /**
     * @return XArr
     */
    public function newArr() : XArr
    {
        return new XArr();
    }

    /**
     * @return XCache
     */
    public function newCache() : XCache
    {
        return new XCache();
    }

    /**
     * @return XCalendar
     */
    public function newCalendar() : XCalendar
    {
        return new XCalendar();
    }

    /**
     * @return XCli
     */
    public function newCli() : XCli
    {
        return new XCli();
    }

    /**
     * @return XCmp
     */
    public function newCmp() : XCmp
    {
        return new XCmp();
    }

    /**
     * @return XCriteria
     */
    public function newCriteria() : XCriteria
    {
        return new XCriteria();
    }

    /**
     * @return XCurl
     */
    public function newCurl() : XCurl
    {
        return new XCurl();
    }

    /**
     * @return XDebug
     */
    public function newDebug() : XDebug
    {
        return new XDebug();
    }

    /**
     * @return XEnv
     */
    public function newEnv() : XEnv
    {
        return new XEnv();
    }

    /**
     * @return XFilter
     */
    public function newFilter() : XFilter
    {
        return new XFilter();
    }

    /**
     * @return XFormat
     */
    public function newFormat() : XFormat
    {
        return new XFormat();
    }

    /**
     * @return XFs
     */
    public function newFs() : XFs
    {
        return new XFs();
    }

    /**
     * @return XItertools
     */
    public function newItertools() : XItertools
    {
        return new XItertools();
    }

    /**
     * @return XLoader
     */
    public function newLoader() : XLoader
    {
        return new XLoader();
    }

    /**
     * @return XLogger
     */
    public function newLogger() : XLogger
    {
        return new XLogger();
    }

    /**
     * @return XMath
     */
    public function newMath() : XMath
    {
        return new XMath();
    }

    /**
     * @return XNet
     */
    public function newNet() : XNet
    {
        return new XNet();
    }

    /**
     * @return XNum
     */
    public function newNum() : XNum
    {
        return new XNum();
    }

    /**
     * @return XPath
     */
    public function newPath() : XPath
    {
        return new XPath();
    }

    /**
     * @return XPhp
     */
    public function newPhp() : XPhp
    {
        return new XPhp();
    }

    /**
     * @return XProf
     */
    public function newProf() : XProf
    {
        return new XProf();
    }

    /**
     * @return XStr
     */
    public function newStr() : XStr
    {
        return new XStr();
    }

    /**
     * @return XUri
     */
    public function newUri() : XUri
    {
        return new XUri();
    }


    /**
     * @return CurloptManager
     */
    public function newCurlCurloptManager() : CurloptManager
    {
        return new CurloptManager();
    }

    /**
     * @param null|array $curloptArray
     *
     * @return CurlBlueprint
     */
    public function newCurlCurlBlueprint(array $curloptArray = null) : CurlBlueprint
    {
        $curloptArray = $curloptArray ?? [];

        return new CurlBlueprint(
            $curloptArray
        );
    }


    /**
     * @param string|array $message
     * @param array        ...$arguments
     *
     * @return DebugMessage
     */
    public function newDebugDebugMessage($message, ...$arguments) : DebugMessage
    {
        return new DebugMessage($message, ...$arguments);
    }


    /**
     * @param string $validValue
     *
     * @return MathBcval
     */
    public function newMathBcval(string $validValue) : MathBcval
    {
        return MathBcval::fromValidValue($validValue);
    }


    /**
     * @return Slugger
     */
    public function newStrSlugger() : Slugger
    {
        return new Slugger();
    }

    /**
     * @return Inflector
     */
    public function newStrInflector() : Inflector
    {
        return new Inflector();
    }


    /**
     * @return PhpInvokableInfo
     */
    public function newPhpInvokableInfo() : PhpInvokableInfo
    {
        return new PhpInvokableInfo();
    }


    /**
     * @return IArr
     */
    public function getArr() : IArr
    {
        return null
            ?? $this->containerGet(IArr::class)
            ?? $this->newArr();
    }

    /**
     * @return ICache
     */
    public function getCache() : ICache
    {
        return null
            ?? $this->containerGet(ICache::class)
            ?? $this->newCache();
    }

    /**
     * @return ICalendar
     */
    public function getCalendar() : ICalendar
    {
        return null
            ?? $this->containerGet(ICalendar::class)
            ?? $this->newCalendar();
    }

    /**
     * @return ICli
     */
    public function getCli() : ICli
    {
        return null
            ?? $this->containerGet(ICli::class)
            ?? $this->newCli();
    }

    /**
     * @return ICmp
     */
    public function getCmp() : ICmp
    {
        return null
            ?? $this->containerGet(ICmp::class)
            ?? $this->newCmp();
    }

    /**
     * @return ICriteria
     */
    public function getCriteria() : ICriteria
    {
        return null
            ?? $this->containerGet(ICriteria::class)
            ?? $this->newCriteria();
    }

    /**
     * @return ICurl
     */
    public function getCurl() : ICurl
    {
        return null
            ?? $this->containerGet(ICurl::class)
            ?? $this->newCurl();
    }

    /**
     * @return IDebug
     */
    public function getDebug() : IDebug
    {
        return null
            ?? $this->containerGet(IDebug::class)
            ?? $this->newDebug();
    }

    /**
     * @return IEnv
     */
    public function getEnv() : IEnv
    {
        return null
            ?? $this->containerGet(IEnv::class)
            ?? $this->newEnv();
    }

    /**
     * @return IFilter
     */
    public function getFilter() : IFilter
    {
        return null
            ?? $this->containerGet(IFilter::class)
            ?? $this->newFilter();
    }

    /**
     * @return IFormat
     */
    public function getFormat() : IFormat
    {
        return null
            ?? $this->containerGet(IFormat::class)
            ?? $this->newFormat();
    }

    /**
     * @return IFs
     */
    public function getFs() : IFs
    {
        return null
            ?? $this->containerGet(IFs::class)
            ?? $this->newFs();
    }

    /**
     * @return IItertools
     */
    public function getItertools() : IItertools
    {
        return null
            ?? $this->containerGet(IItertools::class)
            ?? $this->newItertools();
    }

    /**
     * @return ILoader
     */
    public function getLoader() : ILoader
    {
        return null
            ?? $this->containerGet(ILoader::class)
            ?? $this->newLoader();
    }

    /**
     * @return ILogger
     */
    public function getLogger() : ILogger
    {
        return null
            ?? $this->containerGet(ILogger::class)
            ?? $this->newLogger();
    }

    /**
     * @return IMath
     */
    public function getMath() : IMath
    {
        return null
            ?? $this->containerGet(IMath::class)
            ?? $this->newMath();
    }

    /**
     * @return INet
     */
    public function getNet() : INet
    {
        return null
            ?? $this->containerGet(INet::class)
            ?? $this->newNet();
    }

    /**
     * @return INum
     */
    public function getNum() : INum
    {
        return null
            ?? $this->containerGet(INum::class)
            ?? $this->newNum();
    }

    /**
     * @return IPath
     */
    public function getPath() : IPath
    {
        return null
            ?? $this->containerGet(IPath::class)
            ?? $this->newPath();
    }

    /**
     * @return IPhp
     */
    public function getPhp() : IPhp
    {
        return null
            ?? $this->containerGet(IPhp::class)
            ?? $this->newPhp();
    }

    /**
     * @return IProf
     */
    public function getProf() : IProf
    {
        return null
            ?? $this->containerGet(IProf::class)
            ?? $this->newProf();
    }

    /**
     * @return IStr
     */
    public function getStr() : IStr
    {
        return null
            ?? $this->containerGet(IStr::class)
            ?? $this->newStr();
    }

    /**
     * @return IUri
     */
    public function getUri() : IUri
    {
        return null
            ?? $this->containerGet(IUri::class)
            ?? $this->newUri();
    }


    /**
     * @return CurloptManagerInterface
     */
    public function getCurlCurloptManager() : CurloptManagerInterface
    {
        return null
            ?? $this->containerGet(CurloptManagerInterface::class)
            ?? $this->newCurlCurloptManager();
    }


    /**
     * @return SluggerInterface
     */
    public function getStrSlugger() : SluggerInterface
    {
        return null
            ?? $this->containerGet(SluggerInterface::class)
            ?? $this->newStrSlugger();
    }

    /**
     * @return InflectorInterface
     */
    public function getStrInflector() : InflectorInterface
    {
        return null
            ?? $this->containerGet(InflectorInterface::class)
            ?? $this->newStrInflector();
    }


    /**
     * @param string $id
     *
     * @return null|mixed
     */
    protected function containerGet(string $id)
    {
        return $this->containerHas($id)
            ? $this->container->get($id)
            : null;
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    protected function containerHas(string $id)
    {
        return $this->container
            && $this->container->has($id);
    }


    /**
     * @return static
     */
    public static function getInstance() : SupportFactory
    {
        return static::$instance[ static::class ] = null
            ?? static::$instance[ static::class ]
            ?? new SupportFactory(null);
    }


    /**
     * @var SupportFactoryInterface[]
     */
    protected static $instance = [];
}