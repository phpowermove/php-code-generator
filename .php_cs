<?php

$config = new phootwork\fixer\Config();
$config->getFinder()
    ->exclude(['fixture', 'generated'])
    ->in(__DIR__ . '/src')
    ->in(__DIR__ . '/tests');

$cacheDir = getenv('TRAVIS') ? getenv('HOME') . '/.php-cs-fixer' : __DIR__;

$config->setCacheFile($cacheDir . '/.php_cs.cache');

return $config;