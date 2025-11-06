<?php

return (new PhpCsFixer\Config())
->setRules([
    '@PSR12' => true,
    'array_syntax' => ['syntax' => 'short'],
    'single_quote' => true,
    'no_unused_imports' => true,
])
->setFinder(
    PhpCsFixer\Finder::create()
    ->in([
        __DIR__ . '/app',
        __DIR__ . '/routes',
    ])
    ->name('*.php')
);
