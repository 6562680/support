<?php

require_once __DIR__ . '/generator.php';


$supportFactory = \Gzhegow\Support\SupportFactory::getInstance();

$generator = new Gzhegow_Support_Generator(
    $supportFactory->getLoader(),
    $supportFactory->getStr()
);


// list
$facades = [
    'Arr'      => [ \Gzhegow\Support\IArr::class, \Gzhegow\Support\ZArr::class ],
    'Assert'   => [ \Gzhegow\Support\IAssert::class, \Gzhegow\Support\ZAssert::class, \Gzhegow\Support\Generated\GeneratedAssert::class ],
    'Calendar' => [ \Gzhegow\Support\ICalendar::class, \Gzhegow\Support\ZCalendar::class ],
    'Cli'      => [ \Gzhegow\Support\ICli::class, \Gzhegow\Support\ZCli::class ],
    'Cmp'      => [ \Gzhegow\Support\ICmp::class, \Gzhegow\Support\ZCmp::class ],
    'Criteria' => [ \Gzhegow\Support\ICriteria::class, \Gzhegow\Support\ZCriteria::class ],
    'Curl'     => [ \Gzhegow\Support\ICurl::class, \Gzhegow\Support\ZCurl::class ],
    'Debug'    => [ \Gzhegow\Support\IDebug::class, \Gzhegow\Support\ZDebug::class ],
    'Env'      => [ \Gzhegow\Support\IEnv::class, \Gzhegow\Support\ZEnv::class ],
    'Filter'   => [ \Gzhegow\Support\IFilter::class, \Gzhegow\Support\ZFilter::class ],
    'Format'   => [ \Gzhegow\Support\IFormat::class, \Gzhegow\Support\ZFormat::class ],
    'Fs'       => [ \Gzhegow\Support\IFs::class, \Gzhegow\Support\ZFs::class ],
    'Loader'   => [ \Gzhegow\Support\ILoader::class, \Gzhegow\Support\ZLoader::class ],
    'Math'     => [ \Gzhegow\Support\IMath::class, \Gzhegow\Support\ZMath::class ],
    'Net'      => [ \Gzhegow\Support\INet::class, \Gzhegow\Support\ZNet::class ],
    'Num'      => [ \Gzhegow\Support\INum::class, \Gzhegow\Support\ZNum::class ],
    'Path'     => [ \Gzhegow\Support\IPath::class, \Gzhegow\Support\ZPath::class ],
    'Php'      => [ \Gzhegow\Support\IPhp::class, \Gzhegow\Support\ZPhp::class ],
    'Preg'     => [ \Gzhegow\Support\IPreg::class, \Gzhegow\Support\ZPreg::class ],
    'Prof'     => [ \Gzhegow\Support\IProf::class, \Gzhegow\Support\ZProf::class ],
    'Str'      => [ \Gzhegow\Support\IStr::class, \Gzhegow\Support\ZStr::class ],
    'Type'     => [ \Gzhegow\Support\IType::class, \Gzhegow\Support\ZType::class, \Gzhegow\Support\Generated\GeneratedType::class ],
    'Uri'      => [ \Gzhegow\Support\IUri::class, \Gzhegow\Support\ZUri::class ],
];

// deps
$printer = new \Nette\PhpGenerator\PsrPrinter();

foreach ( $facades as $facade => $sourceClasses ) {
    // vars
    $filepath = __ROOT__ . '/src/Facades/' . $facade . '.php';

    // interface
    $interface = array_shift($sourceClasses);

    // original
    $originalClass = reset($sourceClasses);
    $originalClassName = substr($originalClass, strrpos($originalClass, '\\') + 1);

    // file
    $phpFile = new \Nette\PhpGenerator\PhpFile();
    $phpFile->setComment(implode("\n", [
        'This file is auto-generated.',
        '',
        '@noinspection PhpDocMissingThrowsInspection',
        '@noinspection PhpUnhandledExceptionInspection',
        '@noinspection PhpUnusedAliasInspection',
        '@noinspection RedundantSuppression',
    ]));

    // namespace
    $phpNamespace = new \Nette\PhpGenerator\PhpNamespace('Gzhegow\\Support\\Facades');

    // class
    $classTypeFacade = new \Nette\PhpGenerator\ClassType($facade);

    // add to interface to namespace
    $phpNamespace->add($classTypeFacade);

    // add namespace to php file
    $phpFile->addNamespace($phpNamespace);

    // print
    $content = $printer->printFile($phpFile);

    // store
    echo 'Clearing file: ' . $filepath . PHP_EOL;
    file_put_contents($filepath, $content);
}