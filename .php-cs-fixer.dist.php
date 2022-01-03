<?php

use PhpCsFixer\Config;

$finder = PhpCsFixer\Finder::create()
    ->in('src')
    ->in('tests');
;

$c = new Config();
$c->setRules([
    '@PSR2' => true,
    'no_unused_imports' => true,
    'array_syntax' => ['syntax' => 'short'],
])
    ->setFinder($finder)
;
return $c;

