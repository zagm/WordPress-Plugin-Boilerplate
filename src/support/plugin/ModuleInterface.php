<?php

namespace RefineIt\Support\Plugin;


interface ModuleInterface {

	/**
	 * Register plugin functionality.
	 * @return void
	 */
	private function run_plugin();

	/**
	 * Plugin activation method.
	 * @return void
	 */
	public function activation();

	/**
	 * Plugin deactivation method.
	 * @return void
	 */
	public function deactivation();

	/**
	 * Enqueue and register JavaScript files here.
	 * @return void
	 */
	public function register_scripts();

	/**
	 * Enqueue and register CSS files here.
	 * @return void
	 */
	public function register_styles();
}