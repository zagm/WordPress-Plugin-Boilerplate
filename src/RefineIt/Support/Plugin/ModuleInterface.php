<?php

namespace RefineIt\Support\Plugin;


interface ModuleInterface {

	/**
	 * Register plugin functionality.
	 * @return void
	 */
	function run_plugin();

	/**
	 * Plugin activation method.
	 * @return void
	 */
	function activation();

	/**
	 * Plugin deactivation method.
	 * @return void
	 */
	function deactivation();

	/**
	 * Enqueue and register JavaScript files here.
	 * @return void
	 */
	function register_scripts();

	/**
	 * Enqueue and register CSS files here.
	 * @return void
	 */
	function register_styles();
}