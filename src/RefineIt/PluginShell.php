<?php

namespace RefineIt;  // {{ @module_namespace }}

use RefineIt\Support\Plugin\ModuleBase;


class PluginShell extends ModuleBase {
	public function __construct() {
		parent::__construct();
	}

	protected function get_plugin_root() {
		return __DIR__;
	}

	public function activation() {
	
	}

	public function deactivation() {
	
	}

	public function register_scripts() {
	
	}

	public function register_styles() {

	}

	public function run_plugin() {
		return;
	}

}
