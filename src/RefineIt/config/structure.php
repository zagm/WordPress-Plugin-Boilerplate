<?php

/**
 * Required structure for this plugin.
 *
 * Note: 'required' key in array below is not yet used but it will be used by Autoloader in the future.
 * 
 */
return [
	/**
	 * Images, CSS and JS resources.
	 * 
	 */
	'assets_folder' 		=> [
		'name' 		=> 'assets',
		'required'	=> 1
	],

	/**
	 * Cpde templates used for fast generation of individual buiilding blocks.
	 * 
	 */
	'code_folder'			=> [
		'name'		=> 'code',
		'required'	=> 0
	],

	/**
	 * General plugin configuration (not related to specific WP installation).
	 * 
	 */
	'config_folder'			=> [
		'name'		=> 'config',
		'required'	=> 1,

		/**
		 * Elements inside config_folder that should be removed when creating new module.
		 * 
		 */
		'sub_elements' => [
			/**
			 * Since the structure of all modules should be the same there is no need to keep
			 * same structure configuration in every module.
			 * 
			 */
			[
				'name' => 'structure.php',
				'required' => 0
			]
		]
	],

	/**
	 * This folder should contain most of plugin logic.
	 *
	 * Note: Its expected that this folder contains elements that could be autoloaded (classes, interfaces, traits,...)
	 * thats why it begins with a capital letter.
	 * 
	 */
	'controllers_folder'	=> [
		'name'		=> 'Controllers',
		'required'	=> 1
	],

	/**
	 * Contains translations for specific part of a plugin (module).
	 * 
	 */
	'languages_folder'		=> [
		'name'		=> 'languages',
		'required'	=> 1
	],

	/**
	 * Folder contains higher-level interfacce for interaction with database.
	 * 
	 */
	'models_folder'			=> [
		'name'		=> 'Models',
		'required'	=> 1
	],

	/**
	 * This folder represents root of a core that powers up this plugin.
	 * 
	 */
	'support_folder'		=> [
		'name'		=> 'Support',
		'required'	=> 0
	],

	/**
	 * It should contain all templates required by specific module.
	 * 
	 */
	'templates_folder'		=> [
		'name'		=> 'templates',
		'required'	=> 1
	]
];