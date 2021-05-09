<?php

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;
use Symplify\EasyCodingStandard\ValueObject\Option;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();

    $parameters->set(Option::PATHS, [
        __DIR__ . '/src'
    ]);

    $parameters->set(Option::SKIP, [
        PhpCsFixer\Fixer\ClassNotation\VisibilityRequiredFixer::class,
        PhpCsFixer\Fixer\ControlStructure\YodaStyleFixer::class,
        PhpCsFixer\Fixer\Whitespace\MethodChainingIndentationFixer::class,
        PhpCsFixer\Fixer\Operator\NotOperatorWithSuccessorSpaceFixer::class,
        Symplify\CodingStandard\Fixer\Spacing\MethodChainingNewlineFixer::class,
    ]);

    $containerConfigurator->import(SetList::ARRAY);
    $containerConfigurator->import(SetList::CLEAN_CODE);
    $containerConfigurator->import(SetList::COMMENTS);
    $containerConfigurator->import(SetList::COMMON);
    $containerConfigurator->import(SetList::CONTROL_STRUCTURES);
    $containerConfigurator->import(SetList::DOCBLOCK);
    $containerConfigurator->import(SetList::NAMESPACES);
    $containerConfigurator->import(SetList::PSR_12);
    $containerConfigurator->import(SetList::SPACES);
    $containerConfigurator->import(SetList::STRICT);
    $containerConfigurator->import(SetList::SYMPLIFY);

    $services = $containerConfigurator->services();
    $services->set(PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer::class)
        ->call('configure', [[
            'syntax' => 'long',
        ]]);
};