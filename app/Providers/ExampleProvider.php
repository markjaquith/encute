<?php

namespace CWS\Encute\Providers;

use CWS\Encute\Illuminate\Support\ServiceProvider;

class ExampleProvider extends ServiceProvider {
	public function register($app) {
		// $app->singleton(SomeInterface::class, SomeImplementation::class);
	}

	public function boot($app) {
		// $this->app->make(SomeInterface::class)->hook();
	}
}
