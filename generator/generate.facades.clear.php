<?php

require_once __DIR__ . '/generator.php';


$supportFactory = \Gzhegow\Support\SupportFactory::getInstance();

$generator = new Gzhegow_Support_Generator();


// list
$facades = [
    'Arr'       => [ \Gzhegow\Support\IArr::class, \Gzhegow\Support\XArr::class ],
    'Cache'     => [ \Gzhegow\Support\ICache::class, \Gzhegow\Support\XCache::class ],
    'Calendar'  => [ \Gzhegow\Support\ICalendar::class, \Gzhegow\Support\XCalendar::class ],
    'Cli'       => [ \Gzhegow\Support\ICli::class, \Gzhegow\Support\XCli::class ],
    'Cmp'       => [ \Gzhegow\Support\ICmp::class, \Gzhegow\Support\XCmp::class ],
    'Criteria'  => [ \Gzhegow\Support\ICriteria::class, \Gzhegow\Support\XCriteria::class ],
    'Curl'      => [ \Gzhegow\Support\ICurl::class, \Gzhegow\Support\XCurl::class ],
    'Debug'     => [ \Gzhegow\Support\IDebug::class, \Gzhegow\Support\XDebug::class ],
    'Env'       => [ \Gzhegow\Support\IEnv::class, \Gzhegow\Support\XEnv::class ],
    'Filter'    => [ \Gzhegow\Support\IFilter::class, \Gzhegow\Support\XFilter::class ],
    'Format'    => [ \Gzhegow\Support\IFormat::class, \Gzhegow\Support\XFormat::class ],
    'Fs'        => [ \Gzhegow\Support\IFs::class, \Gzhegow\Support\XFs::class ],
    'Itertools' => [ \Gzhegow\Support\IItertools::class, \Gzhegow\Support\XItertools::class ],
    'Loader'    => [ \Gzhegow\Support\ILoader::class, \Gzhegow\Support\XLoader::class ],
    'Logger'    => [ \Gzhegow\Support\ILogger::class, \Gzhegow\Support\XLogger::class ],
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