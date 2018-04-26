<?php

namespace RefineIt\Support\Plugin;

abstract class ResourceBase {
	protected $root;

	protected $url_accessible;

	public function __construct($root, $url_accessible) {
		$this->root = $root;
		$this->url_accessible = $url_accessible;
	};

	public function is_url_accessible() {
		return $this->url_accessible;
	}

	public function absolute_path($resource_identifier) {
		return $this->root . '/' . $resource_identifier;
	}

	abstract public function absolute_url($resource_identifier);

}