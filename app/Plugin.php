<?php

namespace CWS\Encute;

use CWS\Encute\Mozart\DI\ContainerBuilder;
use function CWS\Encute\Mozart\DI\object;

class Plugin extends Tekta\Plugin {
	// Enable Tekta features here, like translations and scripts and styles:
	// use Tekta\Features\Translations;
	// use Tekta\Features\ScriptsAndStyles;

	// For things that add functionality to the plugin container itself:
	// use Traits\YourBootableTrait;

	public function boot(ContainerBuilder $containerBuilder) {
		// Everything else should go here.
		//
		// 1. Register into the container with $containerBuilder->addDefinitions();
		// 2. Queue post-boot code with $this->afterBoot(callable $callback);
	}
}
