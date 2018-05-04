<?php

/**
 * 
 * This file should never be inside plugin root folder when we are in production environment but lets prevent the script 
 * to run anyway with an extra condition.
 * 
 */

if(php_sapi_name() != 'cli') {
	exit;
}

require_once __DIR__ . '/RefineIt/Support/Config.php';
require_once __DIR__ . '/RefineIt/Support/Autoloader.php';

\RefineIt\Support\Config::go(__DIR__ . '/RefineIt');
new \RefineIt\Support\Autoloader('RefineIt');

use RefineIt\Support\WordpressPluginBox;

$cli = new WordpressPluginBox();
$cli->run();