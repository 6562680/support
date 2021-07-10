<?php

namespace Gzhegow\Support;

use Psr\Container\ContainerInterface;


/**
 * SupportFactory
 */
class SupportFactory implements SupportFactoryInterface
{
    /**
     * @var null|ContainerInterface
     */
    protected $container;


    /**
     * Constructor
     *
     * @param null|ContainerInterface $container
     */
    public function __construct(?ContainerInterface $container)
    {
        $this->container = $container;
    }


    /**
     * @param SupportFactoryInterface $instance
     *
     * @return void
     */
    public static function withInstance(SupportFactoryInterface $instance) : void
    {
        static::$instance[ static::class ] = $instance;
    }


    /**
     * @return IArr
     */
    public function newArr() : IArr
    {
        return new Arr(
            $this->getFilter(),
            $this->getPhp(),
            $this->getStr()
        );
    }

    /**
     * @return IAssert
     */
    public function newAssert() : IAssert
    {
        return new Assert(
            $this->getDebug(),
            $this->getFilter(),
        );
    }

    /**
     * @return ICalendar
     */
    public function newCalendar() : ICalendar
    {
        return new Calendar(
            $this->getFilter(),
            $this->getNum(),
            $this->getPhp(),
            $this->getStr()
        );
    }

    /**
     * @return ICli
     */
    public function newCli() : ICli
    {
        return new Cli(
            $this->getEnv(),
            $this->getFs(),
            $this->getPhp()
        );
    }

    /**
     * @return ICmp
     */
    public function newCmp() : ICmp
    {
        return new Cmp(
            $this->getCalendar(),
            $this->getFilter()
        );
    }

    /**
     * @return ICriteria
     */
    public function newCriteria() : ICriteria
    {
        return new Criteria(
            $this->getCalendar(),
            $this->getCmp(),
            $this->getFilter(),
            $this->getStr()
        );
    }

    /**
     * @return ICurl
     */
    public function newCurl() : ICurl
    {
        return new Curl(
            $this->getArr(),
            $this->getFilter(),
            $this->getNet(),
            $this->getPhp()
        );
    }

    /**
     * @return IDebug
     */
    public function newDebug() : IDebug
    {
        return new Debug();
    }

    /**
     * @return IEnv
     */
    public function newEnv() : IEnv
    {
        return new Env();
    }

    /**
     * @return IFilter
     */
    public function newFilter() : IFilter
    {
        return new Filter();
    }

    /**
     * @return IFormat
     */
    public function newFormat() : IFormat
    {
        return new Format(
            $this->getNum()
        );
    }

    /**
     * @return IFs
     */
    public function newFs() : IFs
    {
        return new Fs(
            $this->getFilter(),
            $this->getPhp()
        );
    }

    /**
     * @return ILoader
     */
    public function newLoader() : ILoader
    {
        return new Loader(
            $this->getFilter(),
            $this->getStr()
        );
    }

    /**
     * @return IMath
     */
    public function newMath() : IMath
    {
        return new Math(
            $this->getFilter(),
            $this->getNum(),
            $this->getStr()
        );
    }

    /**
     * @return INet
     */
    public function newNet() : INet
    {
        return new Net(
            $this->getStr()
        );
    }

    /**
     * @return INum
     */
    public function newNum() : INum
    {
        return new Num(
            $this->getFilter()
        );
    }

    /**
     * @return IPath
     */
    public function newPath() : IPath
    {
        return new Path(
            $this->getFilter(),
            $this->getPhp(),
            $this->getStr()
        );
    }

    /**
     * @return IPhp
     */
    public function newPhp() : IPhp
    {
        return new Php(
            $this->getFilter()
        );
    }

    /**
     * @return IPreg
     */
    public function newPreg() : IPreg
    {
        return new Preg(
            $this->getStr()
        );
    }

    /**
     * @return IProf
     */
    public function newProf() : IProf
    {
        return new Prof(
            $this->getCalendar()
        );
    }

    /**
     * @return IStr
     */
    public function newStr() : IStr
    {
        return new Str(
            $this->getFilter()
        );
    }

    /**
     * @return IType
     */
    public function newType() : IType
    {
        return new Type(
            $this->getFilter()
        );
    }

    /**
     * @return IUri
     */
    public function newUri() : IUri
    {
        return new Uri(
            $this->getArr(),
            $this->getFilter(),
            $this->getPhp(),
            $this->getStr()
        );
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
     * @return IAssert
     */
    public function getAssert() : IAssert
    {
        return null
            ?? $this->containerGet(IAssert::class)
            ?? $this->newAssert();
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
     * @return ILoader
     */
    public function getLoader() : ILoader
    {
        return null
            ?? $this->containerGet(ILoader::class)
            ?? $this->newLoader();
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
     * @return IPreg
     */
    public function getPreg() : IPreg
    {
        return null
            ?? $this->containerGet(IPreg::class)
            ?? $this->newPreg();
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
     * @return IType
     */
    public function getType() : IType
    {
        return null
            ?? $this->containerGet(IType::class)
            ?? $this->newType();
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
     * @return null|mixed
     */
    protected function containerHas(string $id)
    {
        return $this->container
            ? $this->container->has($id)
            : null;
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
