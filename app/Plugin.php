<?php

namespace CWS\Encute;

class Plugin extends Tekta\Plugin {
	/*
	 * List of Provider class names that extend CWS\Encute\Illuminate\Support\ServiceProvider
	 */
	protected $providers = [
		Tekta\Providers\TranslationsProvider::class,
		Providers\EnqueueablesProvider::class,
		Providers\ActionsProvider::class,
		Providers\AdminProvider::class,
	];

	public function debug(): void {
		add_filter('style_loader_tag', fn ($tag, $handle) => "\n" . '<!--wp-style:' . $handle . '-->' . "\n\t" . $tag . '<!--/wp-style:' . $handle . '-->' . "\n\n", 999, 2);
		add_filter('script_loader_tag', fn ($tag, $handle) => "\n" . '<!--wp-script:' . $handle . '-->' . "\n\t" . $tag . '<!--/wp-script:' . $handle . '-->' . "\n\n", 999, 2);
	}
}
