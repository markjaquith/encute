<?php

namespace CWS\Encute\Providers;

use CWS\Encute\Illuminate\Support\ServiceProvider;

class ExampleProvider extends ServiceProvider {
	// In register, all you should do is bind things to the container.
	public function register() {
		// Singleton (only one instance).
		// $this->app->singleton(SomeInterface::class, SomeImplementation::class);

		// A different instance each time.
		// $this->app->bind(SomeInterface::class, SomeImplementation::class);

		// Custom initialization.
		// $this->app->bind(SomeInterface::class, function ($app) {
		//     return new SomeImplementation($app->make(SomeOtherInterface::class));
		// });
	}

	// In boot, everything is bound, so you can type hint things in boot() that will
	// automatically be resolved.
	//
	// Or you can use $this->app->make(SomeInterface::class) to resolve them.
	public function boot() {
		// $this->app->make(SomeInterface::class)->hook();
	}
}
