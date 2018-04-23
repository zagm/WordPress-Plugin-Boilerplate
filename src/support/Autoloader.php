<?php

namespace RefineIt\Support;


class Autoloader {
	private $search_paths;

	private function get_paths($root) {
		if(!is_dir($root)) {
			return [];
		}

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
		echo "<pre>";
		print_r($roots);
		echo "</pre>";
		$this->search_paths = array();
		foreach ($roots as $root) {
			$this->search_paths = array_merge($this->search_paths, $this->get_paths($root));
		}

		spl_autoload_register(array($this, 'load_element'));
	}

	public function load_element($class_name) {
		$f = $class_name . '.php';
		echo "$f";
		$file_path = '';
		$i = 0;
		$path_count = count($this->search_paths);
		echo "$path_count";
		while ($i < $path_count && !file_exists($file_path)) {
			$file_path = $this->search_paths[$i] . '/' . $f;
			$i++;
		}

		if($i == $path_count) {
			return;
		}

		include $file_path;
	}

}