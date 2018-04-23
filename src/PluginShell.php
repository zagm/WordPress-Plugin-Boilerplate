<?php

namespace RefineIt;

use RefineIt\Support\Plugin\ModuleBase;


class PluginShell extends ModuleBase {
	public function __construct() {
		self::parent();
	}

	private function get_plugin_root() {
		return $this->config->get('plugin.base_path');
	}

	private function run_plugin() {
		return;
	}

	public function activation() {
		do_action('refine_it_module_activation');
	}

	public function deactivation() {
		do_action('refine_it_module_deactivation');
	}

	public function register_scripts() {

	}

	public function register_styles() {

	}
}