<?php

namespace RefineIt\Support;

require __DIR__ . '/../../vendor/autoload.php';

use splitbrain\phpcli\CLI;
use splitbrain\phpcli\Options;


class WordpressPluginBox extends CLI
{

	/**
	 * Name of base module.
	 * 
	 * @var string
	 * 
	 */
	private $base_module = 'RefineIt';

	/**
	 * Main plugin shell file for each module.
	 * 
	 * @var string
	 * 
	 */
	private $plugin_shell_file = 'PluginShell.php';

	/**
	 * Elements to be execlue during new module creation.
	 * 
	 * @var array
	 * 
	 */
	private $exclude_elements;

	/**
	 * Register options and arguments
	 * 
	 * @param  Options $options Object of class.
	 * @return void
	 * 
	 */
	protected function setup(Options $options) {
		// Module command.
		$options->registerCommand('module', "Main module command.");
		$options->registerArgument('create', "Creates new plugin module. Name needs to be specified after this argument.", true, 'module');

		// Model command.
		$options->registerCommand('model', "<module-name> <model-name> Craetes new model in specified module.");

		// Controller command.
		$options->registerCommand('controller', "<module-name> <contrller-name> Craetes new controller in specified module.");

		// Publish command.
		$options->registerCommand('publish', "<plugins-path> Creates production-ready copy of a plugin on specified location.");
	}

	/**
	 * Generate array of excluded elements based on configuration.
	 * 
	 * @return array Associative array with sub arrays 'files' & 'folders' which specifies elements to be ignored during the process.
	 * 
	 */
	private function get_excluded_elements() {
		$folders = array();

		// Exclude folders.
		$required_structure = Config::go()->get('structure');
		foreach ($required_structure as $folder => $folder_obj) {
			if(isset($folder_obj['required'], $folder_obj['name']) && $folder_obj['required'] === 0) {
				$folders[] = $folder_obj['name'];
			}
		}

		$this->exclude_elements = array(
			'folders' => $folders,

			// Exclude files.
			// Note: We can only do this for now because there is only one file we are ignoring but please make sure you find a better solution 
			// in the future.
			'files' => [
				$required_structure['config_folder']['sub_elements'][0]['name']
			]
		);

		return $this->exclude_elements;

	}

	/**
	 * Get real name of template variable used in code templates.
	 * 
	 * @param  string $raw_name Script variable name.
	 * @return string Template variable name.
	 * 
	 */
	private function template_variable($raw_name) {
		return ('{{ @' . $raw_name . ' }}');
	}

	/**
	 * Format new file based on code template.
	 * 
	 * @param  string $template Code template to use-
	 * @param  string $file Destination file.
	 * @param  array $vars Array with script-like template variable names as keys and values of these template variables as values.
	 * @return bool True if file has been successfully created, false otherwise.
	 * 
	 */
	private function format_file($template, $file, $vars) {
		$template = Config::go()->get('plugin.base_path') . '/' . $this->base_module . '/' . Config::go()->get('structure.code_folder.name') . '/' . $template;

		if(!file_exists($template)) {
			return false;
		}

		$content = file_get_contents($template);

		if($content === false) {
			return false;
		}

		foreach ($vars as $placeholder => $value) {
			$var = $this->template_variable($placeholder);
			$content = str_replace($var, $value, $content);
		}

		file_put_contents($file, $content);

		return true;
	}

	/**
	 * Copy module base into new (independent module).
	 *
	 * Note: After new module has been created we should still make adjustmnets on config files of the module.
	 * 
	 * @param  string $source Absolute path to module used as source - 'RefineIt'
	 * @param  string $destination Absolute path to root of new module location (folder should not exist)
	 * @return void
	 * 
	 */
	private function copy_base_module($source, $destination) {

		$dir = opendir($source); 
		@mkdir($destination); 
		while(false !== ( $file = readdir($dir)) ) { 
			if (( $file != '.' ) && ( $file != '..' )) { 
				if ( is_dir($source . '/' . $file) && !in_array($file, $this->exclude_elements['folders'])) {
					$this->copy_base_module($source . '/' . $file,  $destination . '/' . $file); 
				}
				else if (!is_dir($source . '/' . $file) && !in_array($file, $this->exclude_elements['files'])) {
					copy($source . '/' . $file, $destination . '/' . $file); 
				}
			}
		}
		closedir($dir); 
	}

	/**
	 * Put elements in newly created module under desired nammespace.
	 * 
	 * @param  string $namespace Namespace to be used.
	 * @return void
	 * 
	 */
	private function create_namespace($namespace) {
		// Since it is required for plugins using this project to have folders named the same as namespaces we can use $namespace varaible to build path.
		$path = Config::go()->get('plugin.base_path') . '/' . $namespace . '/' . $this->plugin_shell_file;

		if(!file_exists($path)) {
			$this->error("FAIL: File: '" . $path . "' does not exist.");
			return;
		}

		// Read file.
		$content = array();
		$fp = fopen($path, 'r');
		while(($l = fgets($fp))) {
			if (strpos($l, '{{ @module_namespace }}') !== false) {
				$l = 'namespace ' . $namespace . ';  // {{ @module_namespace }}';
			}
			$content[] = $l;
		}
		fclose($fp);

		// Write content back.
		file_put_contents($path, implode('', $content));
	}

	/**
	 * Handle 'module create'
	 * 
	 * @return void
	 * 
	 */
	private function handle_module_create() {
		$args = $this->options->getArgs();

		if(count($args) != 2) {
			$this->error("FAIL: Not enough arguments.");
			return;
		}

		if($args[0] != 'create') {

			$this->error("FAIL: Expecting first argument to be 'create'.");
			return;
		}

		$path = Config::go()->get('plugin.base_path') . '/' . $args[1];

		if(file_exists($path)) {
			$this->error("FAIL: Module with name: " . $args[1] . " already exists.");
			return;
		}

		$source_path = Config::go()->get('plugin.base_path') . '/' . $this->base_module;

		$this->get_excluded_elements();
		$this->copy_base_module($source_path, $path);
		$this->create_namespace($args[1]);
	}

	/**
	 * Handle 'controller'
	 * 
	 * @return void
	 * 
	 */
	private function handle_controller() {
		$args = $this->options->getArgs();
		$base_path = Config::go()->get('plugin.base_path');

		if(count($args) != 2 || !file_exists(($base_path . '/' . $args[0]))) {
			$this->error("FAIL: Provide existing module name and name of new controller.");
			return;
		}

		$controller_path = $base_path . '/' . $args[0] . '/' .  Config::go()->get('structure.controllers_folder.name');
		$controller_file = $controller_path . '/' . $args[1] . '.php';
		if(file_exists($controller_file)) {
			$this->error("FAIL: Controller already exists: '" . $controller_file . "'.");
			return;
		}

		// Create frash controller.
		$vars = [
			'module_name' => $args[0],
			'controller_name' => $args[1]
		];

		if(!$this->format_file('Controller.php', $controller_file, $vars)) {
			$this->error('FAIL: Creation of new controller failed.');
			return;
		}
	}

	/**
	 * Handle 'model'
	 * 
	 * @return void
	 */
	private function handle_model() {
		$args = $this->options->getArgs();
		$base_path = Config::go()->get('plugin.base_path');

		if(count($args) != 2 || !file_exists(($base_path . '/' . $args[0]))) {
			$this->error("FAIL: Provide existing module name and name of new database model.");
			return;
		}

		$models_path = $base_path . '/' . $args[0] . '/' .  Config::go()->get('structure.models_folder.name');
		$model_file = $models_path . '/' . $args[1] . '.php';
		if(file_exists($model_file)) {
			$this->error("FAIL: Database model already exists: '" . $model_file . "'.");
			return;
		}

		// Create frash controller.
		$vars = [
			'module_name' => $args[0],
			'model_name' => $args[1]
		];

		if(!$this->format_file('Model.php', $model_file, $vars)) {
			$this->error('FAIL: Creation of new database model failed.');
			return;
		}
	}

	/**
	 * Handle 'publish'
	 * 
	 * @return void
	 */
	private function handle_publish() {
		// @todo
	}

	/**
	 * CLI app entry point.
	 * 
	 * @param  Options $options Object of class.
	 * @return void
	 * 
	 */
	protected function main(Options $options) {
		switch ($options->getCmd()) {
			case 'module':
				$this->handle_module_create();
				break;

			case 'model':
				$this->handle_model();
				break;

			case 'controller':
				$this->handle_controller();
				break;

			case 'publish':
				$this->handle_publish();
				break;
			
			default:
				echo $options->help();
		}
	}
}
