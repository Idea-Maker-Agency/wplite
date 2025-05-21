<?php
use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
  ->in(__DIR__);

return (new Config())
  ->setRules([
    '@PSR12' => true,
    'phpdoc_align' => ['align' => 'vertical'],
    'phpdoc_indent' => true,
    'array_syntax' => ['syntax' => 'short'],
    'binary_operator_spaces' => ['default' => 'align_single_space_minimal'],
  ])
  ->setIndent('  ')
  ->setFinder($finder);
