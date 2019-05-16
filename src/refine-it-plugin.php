<?php

/*
  Plugin Name: RefineIt plugin
  Plugin URI: https://github.com/zagm/WordPress-Plugin-Boilerplate.git
  Description: Clean and healthy starting point to build a Wordpress plugin.
  Version: 0.0.1
  Author: Matic Zagmajster
  Author URI: http://maticzagmajster.ddns.net/
  License: GPL V3
 */

require_once 'vendor/autoload.php';

require_once __DIR__ . '/RefineIt/Support/boot.php';


return [
	/**
	 * Initialize core elements.
	 *
	 * Note: All elements under this section are required for plugin to function - do not change anything unless you 
	 * really know what you are doing.
	 * 
	 */
	\RefineIt\Support\Config::go(__DIR__ . '/RefineIt'),
	new \RefineIt\Support\Autoloader('RefineIt'),

	/**
	 * Load modules.
	 *
	 * Construct object for each module you are planning to use and place it under this section.
	 *
	 * Note: For each module you have to Autoloader´s include list to enable construction of module object.
	 *
	 * To fire up new module add lines below and change name of the module to correct one:
	 *
	 * \RefineIt\Support\Config::go(__DIR__ . '/Example'),
	 * new \RefineIt\Support\Autoloader('Example'),
	 * new \Example\PluginShell(),
	 * 
	 */
	
	//
	// ...
	// 

	/**
	 * Initialize last components.
	 *
	 * Note: All elements under this section are required for plugin to function - do not change anything unless you 
	 * really know what you are doing.
	 * 
	 */
	register_activation_hook(__FILE__, 'RefineIt\Support\activation'),
	register_deactivation_hook(__FILE__, 'RefineIt\Support\deactivation')
];

