<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__);

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR12' => true,
        '@PHP71Migration' => true,
        '@Symfony' => true,
        'declare_strict_types' => true,
        'trailing_comma_in_multiline' => ['elements' => ['arrays', 'match', 'parameters']],
    ])
    ->setFinder($finder);
