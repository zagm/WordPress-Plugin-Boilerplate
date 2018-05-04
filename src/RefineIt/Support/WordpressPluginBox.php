<?php

namespace RefineIt\Support;

require __DIR__ . '/../../vendor/autoload.php';

use splitbrain\phpcli\CLI;
use splitbrain\phpcli\Options;


class WordpressPluginBox extends CLI
{
	// register options and arguments
	protected function setup(Options $options) {
		$options->registerCommand('module', 'Module sub command');
		$options->registerCommand('publish', 'Publish plugin');
	}

	// implement your code
	protected function main(Options $options) {
		if ($options->getOpt('version')) {
			$this->info('1.0.0');
		}
		else {
			echo $options->help();
		}
	}
}
