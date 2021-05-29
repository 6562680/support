<?php

use Gzhegow\Support\Filter;

require_once __DIR__ . '/vendor/autoload.php';


$fnStarts = function (string $str, string $needle = null, bool $ignoreCase = true) : ?string {
    $needle = $needle ?? '';

    if ('' === $str) return null;
    if ('' === $needle) return $str;

    $pos = $ignoreCase
        ? mb_stripos($str, $needle)
        : mb_strpos($str, $needle);

    $result = 0 === $pos
        ? mb_substr($str, mb_strlen($needle))
        : null;

    return $result;
};


// file
$phpFile = new \Nette\PhpGenerator\PhpFile();

// namespace
$namespace = new \Nette\PhpGenerator\PhpNamespace('Gzhegow\\Support\\Generated');
$phpFile->addNamespace($namespace);
$namespace->addUse(\Gzhegow\Support\Filter::class, 'Filter');
$namespace->addUse(\Gzhegow\Support\Domain\Filter\CallableInfoVO::class, 'CallableInfoVO');

// class
$moduleAssert = new \Nette\PhpGenerator\ClassType('GeneratedAssert');

// add dependencies
$property = $moduleAssert->addProperty('filter')->setComment('@var Filter');
$method = new \Nette\PhpGenerator\Method('__construct');
$method->setComment(implode("\n", [
    '',
    '@param Filter $filter',
    '',
]));
$method->setBody('$this->filter = $filter;');
$method->setPublic();
$parameter = $method->addParameter('filter')->setType(Filter::class);
$moduleAssert->addMember($method);

// add methods
$method = new \Nette\PhpGenerator\Method('assert');
$method->setComment(implode("\n", [
    '',
    '@param string $filter',
    '@param mixed ...$arguments',
    '',
    '@return null|mixed',
]));
$method->setBody('return null !== $this->filter->filter($filter, ...$arguments);');
$method->setPublic();
$parameter = $method->addParameter('filter')->setType('string');
$parameter = $method->addParameter('arguments');
$method->setVariadic();
$moduleAssert->addMember($method);

// copy methods
$moduleCopy = \Nette\PhpGenerator\ClassType::from(Filter::class);
$moduleCopy->removeMethod('getCustomFilters');
$moduleCopy->removeMethod('filter');
$moduleCopy->removeMethod('bindFilter');
$moduleCopy->removeMethod('addCustomFilter');
$moduleCopy->removeMethod('replaceCustomFilter');
$moduleCopy->removeMethod('findCustomFilter');
foreach ( $moduleCopy->getMethods() as $method ) {
    $methodName = $method->getName();

    if ('__construct' === $methodName) {
        continue;
    }

    $methodParameters = $method->getParameters();
    $methodComment = $method->getComment();

    $methodNameNew = 'assert' . $fnStarts($methodName, 'filter');

    $lines = explode("\n", $methodComment);
    foreach ( $lines as $i => $line ) {
        $parts = explode('@return', $line);

        if (2 === count($parts)) {
            $lines[ $i ] = implode('@return', [ $parts[ 0 ], ' bool' ]);
        }
    }
    $methodCommentNew = implode("\n", $lines);

    $member = new \Nette\PhpGenerator\Method($methodNameNew);
    $member->setParameters($methodParameters);
    $member->setPublic();
    $member->setComment($methodCommentNew);
    $member->setReturnType('bool');
    $member->setBody('return null !== $this->filter->' . $methodName . '();');

    $moduleAssert->removeMethod($methodName);

    $moduleAssert->addMember($member);
}

$namespace->add($moduleAssert);

$printer = new \Nette\PhpGenerator\PsrPrinter();
file_put_contents('2.php', $printer->printFile($phpFile));
dd();

$moduleType = Nette\PhpGenerator\ClassType::from(Filter::class);
$moduleType->setName('GeneratedType');
$moduleType->removeMethod('getCustomFilters');
$moduleType->removeMethod('bindFilter');
$moduleType->removeMethod('addCustomFilter');
$moduleType->removeMethod('replaceCustomFilter');
$moduleType->removeMethod('findCustomFilter');

$namespace->add($moduleAssert);
$namespace->add($moduleType);

