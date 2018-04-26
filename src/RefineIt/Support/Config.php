<?php

namespace RefineIt\Support;


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

	public static function go_to($key='temp', $plugin_base_path=NULL) {
		if($plugin_base_path !== NULL) {
			self::$temp = new self($plugin_base_path);
		}
		else {
			self::$temp = NULL;
		}

		return self::$temp;
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

			$real_file = $path . '/' . $file;
			$files[] = $real_file;
		}

		return $files;
	}

	public function __construct($plugin_base_path, $config_instance=NULL) {
		$this->plugin_base_path = $plugin_base_path;
		$this->config = array();
		$this->hystack = NULL;

		if($config_instance) {
			$this->config = $this->config_instance->config;
		}

		// Ovewrite any existing properties and add a new one if they exist to new object.
		$files = $this->get_config_files();
		foreach ($files as $file) {
			$this->load_from_file($file);
		}
	}

	public function load_from_file($path) {
		$c = include $path;
		$parent_key = basename($path, '.php');
		if(!isset($this->config[$parent_key])) {
			$this->config[$parent_key] = array();
		}

		$this->config[$parent_key] = $c;
		return $this->config;
	}

	public function load_from_database() {
		// @todo
	}

	public function get($key, $default=NULL) {
		$components = explode('.', $key);
		$this->hystack = $this->config;

		$i = 0;
		while ($i < count($components)) {
			if(isset($this->hystack[$components[$i]])) {
				$this->hystack = $this->hystack[$components[$i]];
			}
			else {
				return $default;
			}
			$i++;
		}
		return $this->hystack;
	}

}