<?php
require_once __DIR__ . '/vendor/autoload.php';

use Sami\Sami;
use Sami\Version\GitVersionCollection;
use Symfony\Component\Finder\Finder;
use Sami\Parser\Filter\PublicFilter;

$dir = __DIR__ . '/src';
$iterator = Finder::create()
	->files()
	->name('*.php')
	->in($dir)
;

$versions = GitVersionCollection::create($dir)
	->addFromTags('v0.*')
	->add('master', 'master branch')
;

$sami = new Sami($iterator, [
	'title' => 'PHP Code Generator API',
	'theme' => 'default',
	'versions' => $versions,
	'build_dir' => __DIR__ . '/api/%version%',
	'cache_dir' => __DIR__ . '/cache/%version%',
	'default_opened_level' => 2,
	'sort_class_properties' => true,
	'sort_class_methods' => true,
	'sort_class_constants' => true,
	'sort_class_traits' => true,
	'sort_class_interfaces' => true
]);

$sami['filter'] = function () {
	return new PublicFilter();
};

return $sami;