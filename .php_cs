<?php
use Symfony\CS\Config\Config;
use Symfony\CS\Finder\DefaultFinder;
use Symfony\CS\Fixer\Contrib\HeaderCommentFixer;
use Symfony\CS\FixerInterface;

$finder = DefaultFinder::create()
	->exclude(['fixture', 'generated'])
    ->in(__DIR__ . '/src')
    ->in(__DIR__ . '/tests')
;

return Config::create()
	->level(FixerInterface::NONE_LEVEL)
	->finder($finder)
	->setUsingLinter(true)
	->setUsingCache(false)
	->fixers([
		'encoding',
		'short_tag',
		'eof_ending',
		'function_call_space',
		'function_declaration',
		'line_after_namespace',
		'linefeed',
		'lowercase_constants',
		'lowercase_keywords',
		'method_argument_space',
		'multiple_use',
		'parenthesis',
		'php_closing_tag',
		'single_line_after_imports',
		'trailing_spaces',
		'visibility',
		'array_element_no_space_before_comma',
		'array_element_white_space_after_comma',
		'double_arrow_multiline_whitespaces',
		'duplicate_semicolon',
		'extra_empty_lines',
		'function_typehint_space',
		'namespace_no_leading_whitespace',
		'no_empty_lines_after_phpdocs',
		'phpdoc_scalar',
		'phpdoc_types',
		'remove_leading_slash_use',
		'remove_lines_between_uses',
		'self_accessor',
		'single_array_no_trailing_comma',
		'single_quote',
		'unused_use',
		'whitespacy_lines',
		'concat_with_spaces',
		'ordered_use',
		'short_array_syntax',
	])
;
