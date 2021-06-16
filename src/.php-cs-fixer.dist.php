<?php

require __DIR__.'/vendor/autoload.php';

$finder = \PhpCsFixer\Finder::create()
    ->in([
        __DIR__ . '/app',
        __DIR__ . '/tests'
    ]);

return (new \PhpCsFixer\Config())
    ->setFinder($finder)
    ->setRules([
        '@PSR12' => true,
        'declare_strict_types' => true,
        'no_break_comment' => false
    ])
    ->setRiskyAllowed(true);
