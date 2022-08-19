<?php

require_once __DIR__ . '/generator.php';


$supportFactory = \Gzhegow\Support\SupportFactory::getInstance();

$generator = new Gzhegow_Support_Generator_FilterGenerator(
    $supportFactory->getLoader(),
    $supportFactory->getStr()
);


// list
$methodSources = [
    'Arr'       => [ \Gzhegow\Support\IArr::class, \Gzhegow\Support\XArr::class ],
    'Cache'     => [ \Gzhegow\Support\ICache::class, \Gzhegow\Support\XCache::class ],
    'Calendar'  => [ \Gzhegow\Support\ICalendar::class, \Gzhegow\Support\XCalendar::class ],
    'Cli'       => [ \Gzhegow\Support\ICli::class, \Gzhegow\Support\XCli::class ],
    'Cmp'       => [ \Gzhegow\Support\ICmp::class, \Gzhegow\Support\XCmp::class ],
    'Criteria'  => [ \Gzhegow\Support\ICriteria::class, \Gzhegow\Support\XCriteria::class ],
    'Curl'      => [ \Gzhegow\Support\ICurl::class, \Gzhegow\Support\XCurl::class ],
    'Debug'     => [ \Gzhegow\Support\IDebug::class, \Gzhegow\Support\XDebug::class ],
    'Env'       => [ \Gzhegow\Support\IEnv::class, \Gzhegow\Support\XEnv::class ],
    'Format'    => [ \Gzhegow\Support\IFormat::class, \Gzhegow\Support\XFormat::class ],
    'Fs'        => [ \Gzhegow\Support\IFs::class, \Gzhegow\Support\XFs::class ],
    'Itertools' => [ \Gzhegow\Support\IItertools::class, \Gzhegow\Support\XItertools::class ],
    'Loader'    => [ \Gzhegow\Support\ILoader::class, \Gzhegow\Support\XLoader::class ],
    'Math'      => [ \Gzhegow\Support\IMath::class, \Gzhegow\Support\XMath::class ],
    'Net'       => [ \Gzhegow\Support\INet::class, \Gzhegow\Support\XNet::class ],
    'Num'       => [ \Gzhegow\Support\INum::class, \Gzhegow\Support\XNum::class ],
    'Path'      => [ \Gzhegow\Support\IPath::class, \Gzhegow\Support\XPath::class ],
    'Php'       => [ \Gzhegow\Support\IPhp::class, \Gzhegow\Support\XPhp::class ],
    'Prof'      => [ \Gzhegow\Support\IProf::class, \Gzhegow\Support\XProf::class ],
    'Str'       => [ \Gzhegow\Support\IStr::class, \Gzhegow\Support\XStr::class ],
    'Uri'       => [ \Gzhegow\Support\IUri::class, \Gzhegow\Support\XUri::class ],
];


// deps
$printer = new \Nette\PhpGenerator\PsrPrinter();

// vars
$class = 'GeneratedFilter';
$filepath = __ROOT__ . '/src/Generated/' . $class . '.php';

// file
$phpFile = new \Nette\PhpGenerator\PhpFile();
$phpFile->setComment(implode("\n", [
    'This file is auto-generated.',
    '',
    '@noinspection PhpDocMissingThrowsInspection',
    '@noinspection PhpUnhandledExceptionInspection',
    '@noinspection PhpUnusedAliasInspection',
]));

// namespace
$phpNamespace = new \Nette\PhpGenerator\PhpNamespace('Gzhegow\\Support\\Generated');

// class
$classTypeFilter = new \Nette\PhpGenerator\ClassType();
$classTypeFilter->setName($class);
$classTypeFilter->setAbstract();
$phpNamespace->addUse(\Gzhegow\Support\IFilter::class);
$classTypeFilter->setImplements([ \Gzhegow\Support\IFilter::class ]);

// add traits
$phpNamespace->addUse(\Gzhegow\Support\Traits\Load\DebugLoadTrait::class);
$classTypeFilter->addTrait(\Gzhegow\Support\Traits\Load\DebugLoadTrait::class);

// add uses
$phpNamespace->addUse(\Gzhegow\Support\Domain\Math\ValueObject\MathBcval::class);
$phpNamespace->addUse(\Gzhegow\Support\Domain\Php\ValueObject\PhpInvokableInfo::class);
$phpNamespace->addUse(\Gzhegow\Support\Exceptions\Logic\InvalidArgumentException::class);

// copy methods
$methodsByType = [];
$methodsBySource = [];
foreach ( $methodSources as $sourceName => [ $interface, $class ] ) {
    $classTypeSource = \Nette\PhpGenerator\ClassType::from($class, false, false);

    foreach ( $classTypeSource->getTraits() as $trait ) {
        $classTypeSource->removeTrait($trait);
    }

    foreach ( $classTypeSource->getMethods() as $method ) {
        if ('__construct' === ( $methodName = $method->getName() )) {
            continue;
        }

        if (null === ( $filterName = $generator->getStr()->starts($methodName, 'filter') )) {
            continue;
        }

        $arguments = [];
        $parameters = $method->getParameters();
        $last = array_pop($parameters);
        foreach ( $parameters as $parameter ) {
            $arguments[] = '$' . $parameter->getName();
        }
        if ($last) {
            $arguments[] = $method->isVariadic()
                ? '...$' . $last->getName()
                : '$' . $last->getName();
        }

        $methodsByTypeCurrent = [];
        foreach ( $generator->mapGenerate() as $type => $fn ) {
            $methodsByType[ $type ][] =
            $methodsByTypeCurrent[ $type ][] =
                $fn(
                    $sourceName, $method,
                    $filterName, $arguments
                );
        }

        $methodsBySource[ $sourceName ] = $methodsByTypeCurrent;
    }
}

// add source traits
foreach ( $methodsBySource as $sourceName => $list ) {
    $phpNamespace->addUse($trait = "\Gzhegow\Support\Traits\Load\\${sourceName}LoadTrait");
    $classTypeFilter->addTrait($trait);
}

// add source methods
foreach ( $methodsByType as $type => $methods ) {
    foreach ( $methods as $method ) {
        $classTypeFilter->addMember($method);
    }
}

// add to interface to namespace
$phpNamespace->add($classTypeFilter);

// add namespace to php file
$phpFile->addNamespace($phpNamespace);

// print
$content = $printer->printFile($phpFile);

// store
echo 'Writing file: ' . $filepath . PHP_EOL;
file_put_contents($filepath, $content);