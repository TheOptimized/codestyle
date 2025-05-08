<?php

require 'vendor/autoload.php';

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . '/src/');

return TheOptimized\Codestyle\PHP84::create($finder);
