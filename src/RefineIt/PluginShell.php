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
		$root_module_prefix = Config::go()->get('prefix.module_prefix');
		do_action(($root_module_prefix . 'module_activation'));
	}

	public function deactivation() {
		$root_module_prefix = Config::go()->get('prefix.module_prefix');
		do_action(($root_module_prefix . 'module_deactivation'));
	}

	public function register_scripts() {

	}

	public function register_styles() {

	}

	public function run_plugin() {
		return;
	}
}