<?php

namespace RefineIt\Support;


class Autoloader {
	private $search_paths;

	private function get_paths($root) {
		$this->search_paths[] = $root;
		$paths = scandir($root);


		foreach ($paths as $p) {
			if($p == '.' || $p == '..') {
				continue;
			}

			$real_path = $root . '/' . $p;
			if(!is_dir($real_path)) {
				continue;
			}

			$this->search_paths[] = $real_path;
			$this->get_paths($real_path);
		}

		return $this->search_paths;
	}

	private function is_autoload_required($folder) {
		$first_letter = $folder[0];
		if(!\IntlChar::isupper($first_letter)) {
			return false;
		}

		return true;
	}

	public function __construct($root_folder) {
		$this->search_paths = array();
		
		// Root path.
		$this->search_paths[] = Config::go()->get('plugin.base_path') . '/' . $root_folder;

		// Add required folders.
		$required_folders = Config::go()->get('structure');
		foreach ($required_folders as $folder_properties) {
			$path = $this->search_paths[0] . '/' . $folder_properties['name'];

			// @todo: Trigger some error if required folder is missing.
			if($this->is_autoload_required($folder_properties['name']) && is_dir($path)) {
				$this->get_paths($path);
			}
		}

		spl_autoload_register(array($this, 'load_element'));
	}

	public function load_element($class_name) {

		$resolution = explode('\\', $class_name);
		$real_class_name = $resolution[count($resolution) - 1];

		$file_path = '';
		$i = 0;
		$path_count = count($this->search_paths);

		while ($i < $path_count && !file_exists($file_path)) {
			$file_path = $this->search_paths[$i] . '/' . $real_class_name . '.php';
			// echo "next path to check $file_path<br>";
			$i++;
		}

		if($i == $path_count) {
			return;
		}

		include $file_path;
	}

	public function test($a) {
		echo "test<br>";
		echo "<pre>";
		print_r($this->get_paths($a));
		echo "</pre>";
	}
}