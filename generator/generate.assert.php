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
$filepath = __ROOT__ . '/src/Generated/GeneratedAssert.php';

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
$classTypeAssert = \Nette\PhpGenerator\ClassType::withBodiesFrom(Gzhegow_Support_Generator_AssertBlueprint::class);
$classTypeAssert->setName('GeneratedAssert');
$classTypeAssert->setAbstract();
$classTypeAssert->setImplements([ \Gzhegow\Support\IAssert::class ]);

// copy uses
$phpNamespace->addUse(\Gzhegow\Support\IFilter::class);
$phpNamespace->addUse(\Gzhegow\Support\Domain\Filter\ValueObject\InvokableInfo::class);
$phpNamespace->addUse(\Gzhegow\Support\Exceptions\Logic\InvalidArgumentException::class);

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

    $methodNameNew = 'assert' . $filterName;

    $lines = explode("\n", $methodComment);
    foreach ( $lines as $i => $line ) {
        if (false !== mb_strpos($line, $separator = '@return')) {
            $parts = explode($separator, $line);

            $type = ltrim($parts[ 1 ]);

            $lines[ $i ] = implode($separator, [
                $parts[ 0 ],
                ' ' . ( $generator->getStr()->starts($type, 'null|') ?? $type ),
            ]);
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

    $arguments = implode(',', $arguments);

    $methodNew = new \Nette\PhpGenerator\Method($methodNameNew);
    $methodNew->setVariadic($method->isVariadic());
    $methodNew->setReturnNullable($method->isReturnNullable());
    $methodNew->setParameters($methodParameters);
    $methodNew->setPublic();
    $methodNew->setComment($methodCommentNew);
    $methodNew->setReturnType($method->getReturnType());
    $methodNew->setBody(
        implode("\n", [
            '' . sprintf('if (null === ( $filtered = $this->filter->%s(%s) )) {', $methodName, $arguments),
            '    throw $this->getThrowableOr(',
            '        new InvalidArgumentException($this->getErrorOr(',
            '            \'Invalid ' . $filterName . ' passed: %s\', ...func_get_args()',
            '        ))',
            '    );',
            '}',
            '',
            'return $filtered;',
        ])
    );

    $classTypeAssert->addMember($methodNew);
}

// add to interface to namespace
$phpNamespace->add($classTypeAssert);

// add namespace to php file
$phpFile->addNamespace($phpNamespace);

// print
$content = $printer->printFile($phpFile);

// store
echo 'Writing file: ' . $filepath . PHP_EOL;
file_put_contents($filepath, $content);