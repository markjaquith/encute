<?php
/*
 * This document has been generated with
 * https://mlocati.github.io/php-cs-fixer-configurator/#version:2.19.2|configurator
 * you can change this configuration by importing this file.
 */
$config = new PhpCsFixer\Config();
return $config
	->setIndent("\t")
	->setRules([
		'align_multiline_comment' => true,
		'array_indentation' => true,
		'array_syntax' => ['syntax'=>'short'],
		'blank_line_after_namespace' => true,
		'blank_line_after_opening_tag' => true,
		'blank_line_before_statement' => true,
		'braces' => ['allow_single_line_closure'=>true,'position_after_anonymous_constructs'=>'same','position_after_control_structures'=>'same','position_after_functions_and_oop_constructs'=>'same'],
		'cast_spaces' => true,
		'concat_space' => ['spacing'=>'one'],
		'constant_case' => true,
		'declare_equal_normalize' => ['space'=>'single'],
		'elseif' => true,
		'indentation_type' => true,
		'line_ending' => true,
		'linebreak_after_opening_tag' => true,
		'lowercase_cast' => true,
		'lowercase_keywords' => true,
		'lowercase_static_reference' => true,
		'magic_constant_casing' => true,
		'magic_method_casing' => true,
		'method_argument_space' => ['ensure_fully_multiline'=>true,'keep_multiple_spaces_after_comma'=>false,'on_multiline'=>'ensure_fully_multiline'],
		'multiline_whitespace_before_semicolons' => ['strategy'=>'no_multi_line'],
		'no_blank_lines_after_class_opening' => true,
		'no_blank_lines_after_phpdoc' => true,
		'no_closing_tag' => true,
		'no_extra_blank_lines' => true,
		'no_leading_import_slash' => true,
		'no_leading_namespace_whitespace' => true,
		'no_multiline_whitespace_around_double_arrow' => true,
		'no_spaces_after_function_name' => true,
		'no_spaces_around_offset' => true,
		'no_spaces_inside_parenthesis' => true,
		'no_trailing_whitespace' => true,
		'no_trailing_whitespace_in_comment' => true,
		'no_unused_imports' => true,
		'no_whitespace_in_blank_line' => true,
		'ordered_imports' => ['sort_algorithm'=>'length'],
		'return_type_declaration' => ['space_before'=>'none'],
		'trailing_comma_in_multiline_array' => true,
		'trim_array_spaces' => true,
		'visibility_required' => true,
		'whitespace_after_comma_in_array' => true,
	])
	->setFinder(PhpCsFixer\Finder::create()
		->exclude(['vendor', 'resources', 'storage', 'lib'])
		->in(__DIR__)
	);
