<?php

return [
	/**
	 * Plugin/module text-domain.
	 * 
	 */
	'text_domain'		=> '',

	/**
	 * Specifies if the current module is actually plugin or module (this info is required 
	 * during activation/deactivation process)
	 * 
	 */
	'module'			=> false,

	/**
	 * This should point to the folder where file with WP header is located.
	 * 
	 */
	'base_path' 		=> __DIR__ . '/../..',

	/**
	 * Points to file containing WP header.
	 * 
	 */
	'entry_point' 		=> 'refine-it-plugin.php'
];