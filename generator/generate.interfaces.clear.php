<?php

require_once __DIR__ . '/generator.php';


$supportFactory = \Gzhegow\Support\SupportFactory::getInstance();

$generator = new Gzhegow_Support_Generator(
    $supportFactory->getLoader(),
    $supportFactory->getStr()
);


// list
$interfaces = [
    'IArr'      => [ \Gzhegow\Support\ZArr::class ],
    'IAssert'   => [ \Gzhegow\Support\ZAssert::class, \Gzhegow\Support\Generated\GeneratedAssert::class ],
    'ICalendar' => [ \Gzhegow\Support\ZCalendar::class ],
    'ICli'      => [ \Gzhegow\Support\ZCli::class ],
    'ICmp'      => [ \Gzhegow\Support\ZCmp::class ],
    'ICriteria' => [ \Gzhegow\Support\ZCriteria::class ],
    'ICurl'     => [ \Gzhegow\Support\ZCurl::class ],
    'IDebug'    => [ \Gzhegow\Support\ZDebug::class ],
    'IEnv'      => [ \Gzhegow\Support\ZEnv::class ],
    'IFilter'   => [ \Gzhegow\Support\ZFilter::class ],
    'IFormat'   => [ \Gzhegow\Support\ZFormat::class ],
    'IFs'       => [ \Gzhegow\Support\ZFs::class ],
    'ILoader'   => [ \Gzhegow\Support\ZLoader::class ],
    'IMath'     => [ \Gzhegow\Support\ZMath::class ],
    'INet'      => [ \Gzhegow\Support\ZNet::class ],
    'INum'      => [ \Gzhegow\Support\ZNum::class ],
    'IPath'     => [ \Gzhegow\Support\ZPath::class ],
    'IPhp'      => [ \Gzhegow\Support\ZPhp::class ],
    'IPreg'     => [ \Gzhegow\Support\ZPreg::class ],
    'IProf'     => [ \Gzhegow\Support\ZProf::class ],
    'IStr'      => [ \Gzhegow\Support\ZStr::class ],
    'IType'     => [ \Gzhegow\Support\ZType::class, \Gzhegow\Support\Generated\GeneratedType::class ],
    'IUri'      => [ \Gzhegow\Support\ZUri::class ],
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