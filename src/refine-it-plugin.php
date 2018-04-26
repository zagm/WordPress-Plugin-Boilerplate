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

require_once __DIR__ . '/RefineIt/Support/Config.php';
require_once __DIR__ . '/RefineIt/Support/Autoloader.php';


return [
	/**
	 * Initialize core elements.
	 *
	 * Note: All elements under this section are required for plugin to function - do not change anything
	 * unless you really know what you are doing.
	 * 
	 */
	\RefineIt\Support\Config::go(__DIR__ . '/RefineIt'),
	new \RefineIt\Support\Autoloader('RefineIt'),

	/**
	 * Load modules.
	 *
	 * Create object for each module you are planning to use.
	 *
	 * Note: For each module you have to extend directory search array in order for module to be able to load.
	 * 
	 */
	/*new \RefineIt\Support\Autoloader([
		\RefineIt\Support\Config::go_to('temp', __DIR__ . '/' . \RefineIt\Support\Config::go()->get('structure.required_shell_elements.modules_folder')  . '/example')->get('plugin.base_path'),
		\RefineIt\Support\Config::go_to('temp')->get('plugin.base_path') . '/' . \RefineIt\Support\Config::go_to('temp')->get('structure.required_module_elements.models_folder'),
		\RefineIt\Support\Config::go_to('temp')->get('plugin.base_path') . '/' . \RefineIt\Support\Config::go_to('temp')->get('structure.required_module_elements.controllers_folder'),
	]),
	new RefineIt\Modules\Example(),*/

	
	/**
	 * Load plugin shell.
	 *
	 * Note: Do not touch this seaction - if in need cerate your own plugin shell.
	 * 
	 */
	new \RefineIt\PluginShell()
];
