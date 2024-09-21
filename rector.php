<?php

declare(strict_types=1);

return Rector\Config\RectorConfig::configure()
    ->withPaths([
        __DIR__.'/src/',
        __DIR__.'/tests/',
        __DIR__.'/bin/',
    ])
    ->withRootFiles()
    ->withSets([
        Rector\Set\ValueObject\SetList::PHP_82,
        Rector\PHPUnit\Set\PHPUnitSetList::PHPUNIT_110,
        Rector\PHPUnit\Set\PHPUnitSetList::ANNOTATIONS_TO_ATTRIBUTES,
        Rector\PHPUnit\Set\PHPUnitSetList::PHPUNIT_CODE_QUALITY,
    ])
    ->withRules([
        Spatie\Ray\Rector\RemoveRayCallRector::class,
    ]);
