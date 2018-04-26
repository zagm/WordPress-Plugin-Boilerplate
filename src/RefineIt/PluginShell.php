<?php

namespace RefineIt;

use RefineIt\Support\Plugin\ModuleBase;


class PluginShell extends ModuleBase {
	public function __construct() {
		parent::__construct();
	}

	protected function get_plugin_root() {
		return __DIR__;
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

	public function run_plugin() {
		return;
	}
}