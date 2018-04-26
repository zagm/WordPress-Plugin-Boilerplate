<?php

namespace RefineIt\Support;


class AssetsResource extends ResourceBase {
	public function __construct($root, $url_accessible) {
		parent::__construct($root, $url_accessible);
	}

	public function absolute_url($resource_identifier) {
		return false;
	}
}