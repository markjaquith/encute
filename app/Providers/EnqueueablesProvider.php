<?php

namespace CWS\Encute\Providers;

use CWS\Encute\Illuminate\Support\ServiceProvider;

class EnqueueablesProvider extends ServiceProvider {
	public function register() {
		$this->app->singleton(\WP_Scripts::class, fn () => wp_scripts());
		$this->app->singleton(\WP_Styles::class, fn () => wp_styles());
	}
}
