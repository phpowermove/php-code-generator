<?php

use Symfony\CS\FixerInterface;

$finder = PhpCsFixer\Finder::create()
	->exclude(['fixture', 'generated'])
    ->in(__DIR__ . '/src')
    ->in(__DIR__ . '/tests')
;

return PhpCsFixer\Config::create()
	//->level(FixerInterface::NONE_LEVEL)
	->setFinder($finder)
	//->setUsingLinter(true)
	->setUsingCache(false)
	->setRules([
		'array_syntax' => [
			'syntax' => 'short'
		],
		'blank_line_after_namespace' => true,
		'concat_space' => true,
		'encoding' => true,
		'full_opening_tag' => true,
		'function_declaration' => [
			'closure_function_spacing' => 'one'
		],
		'function_typehint_space' => true,
		'lowercase_constants' => true,
		'lowercase_keywords' => true,
		'method_argument_space' => true,
		'no_blank_lines_after_phpdoc' => true,
		'no_closing_tag' => true,
		'no_empty_statement' => true,
		'no_extra_blank_lines' => [
			'tokens' => ['use', 'extra']
		],
		'no_leading_import_slash' => true,
		'no_leading_namespace_whitespace' => true,
		'no_multiline_whitespace_around_double_arrow' => true,
		'no_spaces_after_function_name' => true,
		'no_spaces_inside_parenthesis' => true,
		'no_trailing_comma_in_singleline_array' => true,
		'no_trailing_whitespace' => true,
		'no_unused_imports' => true,
		'no_whitespace_before_comma_in_array' => true,
		'no_whitespace_in_blank_line' => true,
		'ordered_imports' => true,
		'phpdoc_scalar' => true,
		'phpdoc_types' => true,
		'self_accessor' => true,
		'single_blank_line_at_eof' => true,
		'single_import_per_statement' => true,
		'single_line_after_imports' => true,
		'single_quote' => true,
		'visibility_required' => true,
		'whitespace_after_comma_in_array' => true,
	])
;
