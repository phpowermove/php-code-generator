<?php
require_once __DIR__ . '/vendor/autoload.php';

use Sami\Sami;
use Symfony\Component\Finder\Finder;

$iterator = Finder::create()->files()->name('*.php')->in(__DIR__ . '/src');

return new Sami($iterator, [
	'title' => 'PHP Code Generator API',
	'theme' => 'default',
	'build_dir' => __DIR__ . '/api',
	'default_opened_level' => 2
]);