<?php

namespace RefineIt\Support;


class Autoloader {
	private $search_paths;

	private function get_paths($root) {
		$paths = scandir($root);
		$dirs_only = array();

		foreach ($paths as $p) {
			if($p == '.' || $p == '..') {
				continue;
			}

			$real_path = $root . '/' . $p;
			if(!is_dir($real_path)) {
				continue;
			}

			$dirs_only[] = $real_path;
			return array_merge($dirs_only, $this->get_paths($real_path));
		}

		return $dirs_only;
	}

	public function __construct($roots) {

		$this->search_paths = array();
		foreach ($roots as $root) {
			$this->search_paths array_merge($this->search_paths, $this->get_paths($root));
		}

		spl_autoload_register(array($this, 'load_element'));
	}

	public function load_element($class_name) {
		$f = $class_name . '.php';
		$file_path = '';
		$i = 0;
		$path_count = count($this->search_paths);
		while ($i < $path_count && !file_exists($file_path)) {
			$file_path = $path . '/' . $f;
			$i++;
		}

		include $file_path;
	}

}