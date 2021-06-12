<?php

use Gzhegow\Support\Filter;


require_once __DIR__ . '/generator.php';

$generator = new Gzhegow_Support_Generator();


// printer
$printer = new \Nette\PhpGenerator\PsrPrinter();

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
$namespace = new \Nette\PhpGenerator\PhpNamespace('Gzhegow\\Support\\Domain\\Filter\\Generated');
$phpFile->addNamespace($namespace);
$namespace->addUse(\Gzhegow\Support\Filter::class, 'Filter');
$namespace->addUse(\Gzhegow\Support\Domain\Filter\ValueObjects\InvokableInfo::class, 'InvokableInfo');

// class
$moduleType = \Nette\PhpGenerator\ClassType::withBodiesFrom(Gzhegow_Support_Generator_TypeBlueprint::class);
$moduleType->setName('GeneratedType');
$moduleType->setAbstract();

// copy methods
$moduleCopy = \Nette\PhpGenerator\ClassType::from(Filter::class);
$moduleCopy->removeMethod('getCustomFilters');
$moduleCopy->removeMethod('addCustomFilter');
$moduleCopy->removeMethod('assert');
$moduleCopy->removeMethod('filter');
$moduleCopy->removeMethod('php');
$moduleCopy->removeMethod('type');
$moduleCopy->removeMethod('call');
$moduleCopy->removeMethod('bind');
$moduleCopy->removeMethod('replaceCustomFilter');
$moduleCopy->removeMethod('findCustomFilter');
foreach ( $moduleCopy->getMethods() as $method ) {
    $methodName = $method->getName();

    if ('__construct' === $methodName) {
        continue;
    }

    $methodParameters = $method->getParameters();
    $methodComment = $method->getComment();

    $methodNameNew = 'is' . ( $filterName = $generator->strStarts($methodName, 'filter') );

    $lines = explode("\n", $methodComment);
    foreach ( $lines as $i => $line ) {
        if (false !== mb_strpos($line, $separator = '@return')) {
            $parts = explode($separator, $line);

            $lines[ $i ] = implode($separator, [ $parts[ 0 ], ' bool' ]);
        }
    }
    $methodCommentNew = implode("\n", $lines);

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

    $methodNew = new \Nette\PhpGenerator\Method($methodNameNew);
    $methodNew->setVariadic($method->isVariadic());
    $methodNew->setReturnNullable($method->isReturnNullable());
    $methodNew->setParameters($methodParameters);
    $methodNew->setPublic();
    // $methodNew->setComment($methodComment);
    $methodNew->setComment($methodCommentNew);
    $methodNew->setReturnType('bool');
    $methodNew->setBody(implode("\n", [
        sprintf(
            'return null !== $this->filter->' . $methodName . '(%s);',
            implode(', ', $arguments),
        ),
    ]));

    $moduleType->addMember($methodNew);
}

// add to namespace
$namespace->add($moduleType);

// print
$content = $printer->printFile($phpFile);

// store
$filepath = __ROOT__ . '/src/Domain/Filter/Generated/GeneratedType.php';

echo 'Writing file: ' . $filepath . PHP_EOL;
file_put_contents($filepath, $content);
