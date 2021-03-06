<?php
/*
 * This document has been generated with
 * https://mlocati.github.io/php-cs-fixer-configurator/#version:2.16.1|configurator
 * you can change this configuration by importing this file.
 */
$config = new PhpCsFixer\Config();

return $config
	->setIndent("\t")
	->setRules([
		// Each line of multi-line DocComments must have an asterisk [PSR-5] and must be aligned with the first one.
		'align_multiline_comment' => true,
		// PHP arrays should be declared using the configured syntax.
		'array_syntax' => ['syntax' => 'short'],
		// The PHP constants `true`, `false`, and `null` MUST be written using the correct casing.
		'constant_case' => true,
		// Ensure there is no code on the same line as the PHP open tag and it is followed by a blank line.
		'blank_line_after_opening_tag' => true,
		// An empty line feed must precede any configured statement.
		'blank_line_before_statement' => true,
		// A single space or none should be between cast and variable.
		'cast_spaces' => true,
		// The body of each structure MUST be enclosed by braces. Braces should be properly placed. Body of braces should be properly indented.
		'braces' => ['allow_single_line_closure'=>true, 'position_after_anonymous_constructs' => 'same', 'position_after_control_structures' => 'same', 'position_after_functions_and_oop_constructs' => 'same'],
		// Concatenation should be spaced according configuration.
		'concat_space' => ['spacing' => 'one'],
		// Equal sign in declare statement should be surrounded by spaces or not following configuration.
		'declare_equal_normalize' => ['space' => 'single'],
		// The keyword `elseif` should be used instead of `else if` so that all control keywords look like single words.
		'elseif' => true,
		// Code MUST use configured indentation type.
		'indentation_type' => true,
		// All PHP files must use same line ending.
		'line_ending' => true,
		// Ensure there is no code on the same line as the PHP open tag.
		'linebreak_after_opening_tag' => true,
		// Cast should be written in lower case.
		'lowercase_cast' => true,
		// PHP keywords MUST be in lower case.
		'lowercase_keywords' => true,
		// Class static references `self`, `static` and `parent` MUST be in lower case.
		'lowercase_static_reference' => true,
		// Magic constants should be referred to using the correct casing.
		'magic_constant_casing' => true,
		// Magic method definitions and calls must be using the correct casing.
		'magic_method_casing' => true,
		// In method arguments and method call, there MUST NOT be a space before each comma and there MUST be one space after each comma. Argument lists MAY be split across multiple lines, where each subsequent line is indented once. When doing so, the first item in the list MUST be on the next line, and there MUST be only one argument per line.
		'method_argument_space' => ['keep_multiple_spaces_after_comma'=>false, 'on_multiline' => 'ensure_fully_multiline'],
		// When making a method or function call, there MUST NOT be a space between the method or function name and the opening parenthesis.
		'no_spaces_after_function_name' => true,
		// There MUST NOT be spaces around offset braces.
		'no_spaces_around_offset' => true,
		// There MUST NOT be a space after the opening parenthesis. There MUST NOT be a space before the closing parenthesis.
		'no_spaces_inside_parenthesis' => true,
		// There MUST be no trailing spaces inside comment or PHPDoc.
		'no_trailing_whitespace_in_comment' => true,
		// Remove trailing whitespace at the end of non-blank lines.
		'no_trailing_whitespace' => true,
		// Remove trailing whitespace at the end of blank lines.
		'no_whitespace_in_blank_line' => true,
		// Ordering `use` statements.
		'ordered_imports' => ['sort_algorithm' => 'length'],
		// Visibility MUST be declared on all properties and methods; `abstract` and `final` MUST be declared before the visibility; `static` MUST be declared after the visibility.
		'visibility_required' => true,
		// In array declaration, there MUST be a whitespace after each comma.
		'whitespace_after_comma_in_array' => true,
		// PHP multi-line arrays should have a trailing comma.
		'trailing_comma_in_multiline' => ['elements' => ['arrays']],
		// Arrays should be formatted like function/method arguments, without leading or trailing single line space.
		'trim_array_spaces' => true,
		// There MUST be one blank line after the namespace declaration.
		'blank_line_after_namespace' => true,
		// Each element of an array must be indented exactly once.
		'array_indentation' => true,
		// Forbid multi-line whitespace before the closing semicolon or move the semicolon to the new line for chained calls.
		'multiline_whitespace_before_semicolons' => ['strategy' => 'no_multi_line'],
		// There should be no empty lines after class opening brace.
		'no_blank_lines_after_class_opening' => true,
		// There should not be blank lines between docblock and the documented element.
		'no_blank_lines_after_phpdoc' => true,
		// The closing `? >` tag MUST be omitted from files containing only PHP.
		'no_closing_tag' => true,
		// Removes extra blank lines and/or blank lines following configuration.
		'no_extra_blank_lines' => true,
		// Remove leading slashes in `use` clauses.
		'no_leading_import_slash' => true,
		// The namespace declaration line shouldn't contain leading whitespace.
		'no_leading_namespace_whitespace' => true,
		// Operator `=>` should not be surrounded by multi-line whitespaces.
		'no_multiline_whitespace_around_double_arrow' => true,
		// There should no spaces before the return type colon.
		'return_type_declaration' => ['space_before' => 'none'],
	])
	->setFinder(
		PhpCsFixer\Finder::create()
		->exclude(['vendor', 'resources', 'storage', 'lib'])
		->in(__DIR__)
	);
