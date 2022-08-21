<?php

require_once __DIR__ . '/generator.php';


$supportFactory = \Gzhegow\Support\SupportFactory::getInstance();

$generator = new Gzhegow_Support_Generator();


// list
$interfaces = [
    'IArr'       => [ \Gzhegow\Support\XArr::class ],
    'ICache'     => [ \Gzhegow\Support\XCache::class ],
    'ICalendar'  => [ \Gzhegow\Support\XCalendar::class ],
    'ICli'       => [ \Gzhegow\Support\XCli::class ],
    'ICmp'       => [ \Gzhegow\Support\XCmp::class ],
    'ICriteria'  => [ \Gzhegow\Support\XCriteria::class ],
    'ICurl'      => [ \Gzhegow\Support\XCurl::class ],
    'IDebug'     => [ \Gzhegow\Support\XDebug::class ],
    'IEnv'       => [ \Gzhegow\Support\XEnv::class ],
    'IFilter'    => [ \Gzhegow\Support\XFilter::class ],
    'IFormat'    => [ \Gzhegow\Support\XFormat::class ],
    'IFs'        => [ \Gzhegow\Support\XFs::class ],
    'IItertools' => [ \Gzhegow\Support\XItertools::class ],
    'ILoader'    => [ \Gzhegow\Support\XLoader::class ],
    'ILogger'    => [ \Gzhegow\Support\XLogger::class ],
    'IMath'      => [ \Gzhegow\Support\XMath::class ],
    'INet'       => [ \Gzhegow\Support\XNet::class ],
    'INum'       => [ \Gzhegow\Support\XNum::class ],
    'IPath'      => [ \Gzhegow\Support\XPath::class ],
    'IPhp'       => [ \Gzhegow\Support\XPhp::class ],
    'IProf'      => [ \Gzhegow\Support\XProf::class ],
    'IStr'       => [ \Gzhegow\Support\XStr::class ],
    'IUri'       => [ \Gzhegow\Support\XUri::class ],
];

// deps
$printer = new \Nette\PhpGenerator\PsrPrinter();

foreach ( $interfaces as $interface => $sourceClasses ) {
    // vars
    $filepath = __ROOT__ . '/src/' . $interface . '.php';

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
    $phpNamespace = new \Nette\PhpGenerator\PhpNamespace('Gzhegow\\Support');

    // class
    $classTypeInterface = new \Nette\PhpGenerator\ClassType($interface);
    $classTypeInterface->setInterface();

    // add to interface to namespace
    $phpNamespace->add($classTypeInterface);

    // add namespace to php file
    $phpFile->addNamespace($phpNamespace);

    // print
    $content = $printer->printFile($phpFile);

    // store
    echo 'Clearing file: ' . $filepath . PHP_EOL;
    file_put_contents($filepath, $content);
}