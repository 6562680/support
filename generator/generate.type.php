<?php


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
$namespace = new \Nette\PhpGenerator\PhpNamespace('Gzhegow\\Support\\Generated');
$phpFile->addNamespace($namespace);
$namespace->addUse(\Gzhegow\Support\Domain\Filter\ValueObject\InvokableInfo::class);
$namespace->addUse(\Gzhegow\Support\IFilter::class);
// class
$moduleType = \Nette\PhpGenerator\ClassType::withBodiesFrom(Gzhegow_Support_Generator_TypeBlueprint::class);
$moduleType->setName('GeneratedType');
$moduleType->setAbstract();
$moduleType->setImplements([ \Gzhegow\Support\IType::class ]);

// copy methods
$moduleCopy = \Nette\PhpGenerator\ClassType::from(\Gzhegow\Support\Filter::class);
$moduleCopy->removeMethod('assert');
$moduleCopy->removeMethod('php');
$moduleCopy->removeMethod('type');
//
$moduleCopy->removeMethod('bind');
$moduleCopy->removeMethod('call');
//
$moduleCopy->removeMethod('filter');
$moduleCopy->removeMethod('addCustomFilter');
$moduleCopy->removeMethod('findCustomFilter');
$moduleCopy->removeMethod('getCustomFilters');
$moduleCopy->removeMethod('replaceCustomFilter');
//
$moduleCopy->removeMethod('me');
foreach ( $moduleCopy->getMethods() as $method ) {
    if ('__construct' === ( $methodName = $method->getName() )) {
        continue;
    }

    if (null === ( $filterName = $generator->strStarts($methodName, 'filter') )) {
        continue;
    }

    $methodParameters = $method->getParameters();
    $methodComment = $method->getComment();

    $methodNameNew = 'is' . $filterName;

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
$filepath = __ROOT__ . '/src/Generated/GeneratedType.php';

echo 'Writing file: ' . $filepath . PHP_EOL;
file_put_contents($filepath, $content);
