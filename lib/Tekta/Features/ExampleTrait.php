<?php

namespace CWS\Encute\Tekta\Features;

use CWS\Encute\Tekta\Admin\Notice;

trait ExampleTrait {
	public function prebootExampleTrait() {
		// This code gets run before the plugin boots.
	}

	public function bootExampleTrait() {
		Notice::info("<code>ExampleTrait</code> was automatically booted, because it has a method called <code>bootExampleTrait()</code>.")->hook();
	}
}
