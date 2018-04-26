<?php

namespace RefineIt\Support;


class TemplatesResource extends ResourceBase {
	
	public function __construct($root, $url_accessible) {
		parent::__construct($root, $url_accessible);
	}

	public function absolute_url($resource_identifier) {
		return false;
	}

	public function render($template_file, $data) {}
}