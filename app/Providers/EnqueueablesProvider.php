<?php

namespace CWS\Encute\Providers;

use CWS\Encute\Illuminate\Support\ServiceProvider;

class EnqueueablesProvider extends ServiceProvider {
	public function register() {
		$this->app->singleton(\WP_Scripts::class, fn () => wp_scripts());
		$this->app->singleton(\WP_Styles::class, fn () => wp_styles());
	}

	public function boot() {
		add_filter('style_loader_tag', fn ($tag, $handle) => "\n" . '<!--wp-style:' . $handle . '-->' . "\n\t" . $tag . '<!--/wp-style:' . $handle . '-->' . "\n\n", 10, 2);
		add_filter('script_loader_tag', fn ($tag, $handle) => "\n" . '<!--wp-script:' . $handle . '-->' . "\n\t" . $tag . '<!--/wp-script:' . $handle . '-->' . "\n\n", 10, 2);
	}
}
