<?php

namespace CWS\Encute;

class Plugin extends Tekta\Plugin {
	/*
	 * List of Provider class names that extend CWS\Encute\Illuminate\Support\ServiceProvider
	 */
	protected $providers = [
		Tekta\Providers\TranslationsProvider::class,
		Providers\EnqueueablesProvider::class,
	];
}
