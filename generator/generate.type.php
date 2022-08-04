<?php


require_once __DIR__ . '/generator.php';


$supportFactory = \Gzhegow\Support\SupportFactory::getInstance();

$generator = new Gzhegow_Support_Generator(
    $supportFactory->getLoader(),
    $supportFactory->getStr()
);


// deps
$printer = new \Nette\PhpGenerator\PsrPrinter();

// vars
$filepath = __ROOT__ . '/src/Generated/GeneratedType.php';

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
$phpNamespace->addUse(\Gzhegow\Support\Domain\Filter\ValueObject\InvokableInfo::class);
$phpNamespace->addUse(\Gzhegow\Support\IFilter::class);

// class
$classTypeType = \Nette\PhpGenerator\ClassType::withBodiesFrom(Gzhegow_Support_Generator_TypeBlueprint::class);
$classTypeType->setName('GeneratedType');
$classTypeType->setAbstract();
$classTypeType->setImplements([ \Gzhegow\Support\IType::class ]);

// copy methods
$classTypeFilter = \Nette\PhpGenerator\ClassType::from(\Gzhegow\Support\ZFilter::class);
$classTypeFilter->removeMethod('assert');
$classTypeFilter->removeMethod('php');
$classTypeFilter->removeMethod('type');
//
$classTypeFilter->removeMethod('bind');
$classTypeFilter->removeMethod('call');
//
$classTypeFilter->removeMethod('filter');
$classTypeFilter->removeMethod('addCustomFilter');
$classTypeFilter->removeMethod('findCustomFilter');
$classTypeFilter->removeMethod('getCustomFilters');
$classTypeFilter->removeMethod('replaceCustomFilter');
//
$classTypeFilter->removeMethod('me');
foreach ( $classTypeFilter->getMethods() as $method ) {
    if ('__construct' === ( $methodName = $method->getName() )) {
        continue;
    }

    if (null === ( $filterName = $generator->getStr()->starts($methodName, 'filter') )) {
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

    $classTypeType->addMember($methodNew);
}

// add to interface to namespace
$phpNamespace->add($classTypeType);

// add namespace to php file
$phpFile->addNamespace($phpNamespace);

// print
$content = $printer->printFile($phpFile);

// store
echo 'Writing file: ' . $filepath . PHP_EOL;
file_put_contents($filepath, $content);