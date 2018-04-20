<?php

/*
  Plugin Name: WordPress Refineit plugin
  Plugin URI: https://github.com/zagm/WordPress-Plugin-Boilerplate.git
  Description: Clean and healthy starting point to build a Wordpress plugin.
  Version: 0.0.1
  Author: Matic Zagmajster
  Author URI: http://maticzagmajster.ddns.net/
  License: GPL V3
 */

require_once './support/Autoloader.php';

return [
	/**
	 * Initialize core elements.
	 *
	 * Note: All elements under this section are required for plugin to function - do not change anything
	 * unless you really know what you are doing.
	 * 
	 */
	new \RefineIt\Support\Autoloader(),
	\RefineIt\Support\Config::go(__DIR__),

	/**
	 * Load modules.
	 *
	 * Create object for each module you are planning to use.
	 * 
	 */
	//
	// ...
	//
	
	/**
	 * Load plugin shell.
	 *
	 * Note: Do not touch this seaction - if in need cerate your own plugin shell.
	 * 
	 */
	new \RefineIt\PluginShell()
];