<?php

$rules = [
    // All of these presets inherit the preset listed prior. While it
    // is not necessary to include them all individually, I am doing so
    // for the sake of visibility into the global scope of rules being used.
    '@PSR1' => true,
    '@PSR2' => true,
    '@PSR12' => true,
    '@Symfony' => true,
    '@PhpCsFixer' => true,

    // Custom Overrides.
    'declare_equal_normalize' => [
        'space' => 'single',
    ],
    'ordered_class_elements' => [
        'order' => [
            'use_trait',
            'constant_public',
            'constant_protected',
            'constant_private',
            'property_public',
            'property_protected',
            'property_private',
            'construct',
            'destruct',
            'magic',
            'phpunit',
            'method_public',
            'method_protected',
            'method_private',
        ],
    ],
    'ordered_imports' => [
        'sort_algorithm' => 'alpha',
        'imports_order' => [
            'class',
            'function',
            'const',
        ],
    ],
    'blank_line_before_statement' => [
        'statements' => [
            'break',
            'case',
            'continue',
            'declare',
            'default',
            'exit',
            'goto',
            'include',
            'include_once',
            'require',
            'require_once',
            'return',
            'switch',
            'throw',
            'try',
        ],
    ],
    'multiline_whitespace_before_semicolons' => [
        'strategy' => 'no_multi_line',
    ],
    'explicit_string_variable' => true,
    'operator_linebreak' => [
        'only_booleans' => true,
        'position' => 'end',
    ],

    // Turn both of these off (turned on from preset).
    'php_unit_internal_class' => false,
    'php_unit_test_class_requires_covers' => false,
    'phpdoc_add_missing_param_annotation' => [
        'only_untyped' => false,
    ],

    // Turned on by preset. I prefer to be explicit.
    'phpdoc_no_empty_return' => false,

    // Also turned on by preset. I like to use these in certain scenarios.
    'single_line_comment_style' => false,
    'standardize_increment' => true,

    // This should be after anything that modifies the increment logic.
    'increment_style' => [
        'style' => 'post',
    ],

    // I like to keep my PHPDocs intact and explicit.
    'no_superfluous_phpdoc_tags' => false,
    'ordered_imports' => [
        'sort_algorithm' => 'alpha',
    ],
    'php_unit_method_casing' => [
        'case' => 'snake_case',
    ],
    'phpdoc_types_order' => [
        'null_adjustment' => 'always_last',
    ],
];

$excludes = [
    'resources',
    'vendor',
    'storage',
    'node_modules',
];

// We can also use "notPath()" to specify files alongside directories.
$finder = PhpCsFixer\Finder::create()->exclude($excludes)->in(__DIR__);
$config = new PhpCsFixer\Config();

return $config->setRules($rules)->setFinder($finder)->setLineEnding("\n");
