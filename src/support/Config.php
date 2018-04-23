<?php

namespace RefineIt\Support


class Config {
	protected $plugin_base_path;

	protected $config;

	protected $hystack;

	protected static $instance = NULL;

	protected static $temp = NULL;

	const FILE_CONFIG_FOLDER = 'config';

	public static function go($plugin_base_path=NULL) {
		if(self::$instance == NULL && $plugin_base_path != NULL) {
			self::$instance = new self($plugin_base_path);

			$files = self::$instance->get_config_files();
			foreach ($files as $file) {
				$new_config = self::$instance->load_from_file($file);
				self::$instance->config = array_merge(self::$instance->config, $new_config);
			}

		}

		return self::$instance;

	}

	public static function go_to($key='temp', $plugin_base_path==NULL) {
		if($plugin_base_path !== NULL) {
			self::$temp = new self($plugin_base_path);
		}
		else {
			self::$temp = NULL;
		}

		return self::$temp:
	}

	private function get_config_files() {
		$path = $this->plugin_base_path . '/' . self::FILE_CONFIG_FOLDER;
		$all_files = scandir($path);
		$files = array();

		foreach ($all_files as $file) {
			// We are only interested in PHP files here.
			$i = strpos($file, '.php');

			if($i === false) {
				continue;
			}

			$real_file = $path . '/' $file;
			$files[] = $real_file;
		}

		return $files;
	}

	public function __construct($plugin_base_path, $config_instance=NULL) {
		$this->plugin_base_path = $plugin_base_path;
		$this->config = array();
		$this->hystack = NULL;

		if($config_instance) {
			$this->load_from_object($config_instance);
		}
	}

	public function load_from_object($object) {
		$this->config = array_merge($this->config, $object->config);
		return $this->config;
	}

	public function load_from_file($path) {
		$c = include $path;
		$parent_key = basename($path, '.php');
		if(!isset($this->config[$parent_key])) {
			$this->config[$parent_key] = array();
		}

		$this->config = array_merge($this->config, $c);
		return $this->config;
	}

	public function load_from_database() {
		// @todo
	}

	public function get($key, $default=NULL) {
		$components = explode('.', $key);
		if($this->hystack === NULL) {
			$this->hystack = $this->config;
		}

		$value = $default;
		foreach ($components as $sub_field) {
			if(is_array($this->hystack[$sub_field])) {
				$this->hystack = $this->hystack[$sub_field];
			}
			else if(isset($this->hystack[$sub_field])) {
				$value = $this->hystack[$sub_field];
			}
			else {
				return $default;
			}
		}

		return $value;

	}

}