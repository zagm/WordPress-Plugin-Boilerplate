<?php

namespace RwfineIt\Modules;

use RefineIt\Support\Plugin\ModuleBase;

class Example extends ModuleBase {
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

	}

	public function deactivation() {

	}

	public function register_scripts() {

	}

	public function register_styles() {

	}
}