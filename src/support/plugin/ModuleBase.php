<?php

namespace RefineIt\Support\Plugin;

use ModuleInterface;
use RefineIt\Support\Config;


abstract class ModuleBase implements ModuleInterface {
	protected $config;

	abstract protected function get_plugin_root();

	abstract protected function run_plugin();

	/**
	 * Construct and initialize object.
	 */
	public function __construct() {
		// Load plugin or module configuration.
		$this->config = new Config($this->get_plugin_root(), Config::go());
		$text_domain = $this->config->get('plugin.text_domain', '');
		$languages_path = $this->get_plugin_root() . '/' . $this->config->get('structure.languages_folder');

		load_plugin_textdomain($text_domain, false, $languages_path);

		add_action( 'admin_enqueue_scripts', array( $this, 'register_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_styles' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_styles' ) );

		// Every module is basically a plugin but we activate each component a bit different
		// to prevent altering 'active_plugins' option in database.
		if(!$this->config->get('plugin.module', false)) {
			$entry_file = $this->get_plugin_root() . '/' . $this->config->get('plugin.entry_point');

			register_activation_hook($entry_file, array( $this, 'activation' ) );
			register_deactivation_hook($entry_file, array( $this, 'deactivation' ) );
		}
		else {
			add_action('refine_it_module_activation', array($this, 'activation'), 10, 0);
			add_action('refine_it_module_deactivation', array($this, 'deactivation'), 10, 0);
		}

		$this->run_plugin();
	}

	abstract public function activation();

	abstract public function deactivation();

	abstract public function register_scripts();

	abstract public function register_styles();
}