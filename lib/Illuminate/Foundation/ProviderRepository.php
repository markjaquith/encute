<?php

namespace CWS\Encute\Illuminate\Foundation;

use Exception;
use CWS\Encute\Illuminate\Contracts\Foundation\Application as ApplicationContract;

class ProviderRepository {
	/**
	 * The application implementation.
	 *
	 * @var \CWS\Encute\Illuminate\Contracts\Foundation\Application
	 */
	protected $app;

	/**
	 * Create a new service repository instance.
	 *
	 * @param  \CWS\Encute\Illuminate\Contracts\Foundation\Application  $app
	 * @param  \CWS\Encute\Illuminate\Filesystem\Filesystem  $files
	 * @param  string  $manifestPath
	 * @return void
	 */
	public function __construct(ApplicationContract $app) {
		$this->app = $app;
	}

	/**
	 * Register the application service providers.
	 *
	 * @param  array  $providers
	 * @return void
	 */
	public function load(array $providers) {
		$manifest = $this->compileManifest($providers);

		// We will go ahead and register all of the eagerly loaded providers with the
		// application so their services can be registered with the application as
		// a provided service. Then we will set the deferred service list on it.
		foreach ($manifest['eager'] as $provider) {
			$this->app->register($provider);
		}

		$this->app->addDeferredServices($manifest['deferred']);
	}

	/**
	 * Compile the application service manifest file.
	 *
	 * @param  array  $providers
	 * @return array
	 */
	protected function compileManifest($providers) {
		// The service manifest should contain a list of all of the providers for
		// the application so we can compare it on each request to the service
		// and determine if the manifest should be recompiled or is current.
		$manifest = $this->freshManifest($providers);

		foreach ($providers as $provider) {
			$instance = $this->createProvider($provider);

			// When recompiling the service manifest, we will spin through each of the
			// providers and check if it's a deferred provider or not. If so we'll
			// add it's provided services to the manifest and note the provider.
			if ($instance->isDeferred()) {
				foreach ($instance->provides() as $service) {
					$manifest['deferred'][$service] = $provider;
				}

				$manifest['when'][$provider] = $instance->when();
			}

			// If the service providers are not deferred, we will simply add it to an
			// array of eagerly loaded providers that will get registered on every
			// request to this application instead of "lazy" loading every time.
			else {
				$manifest['eager'][] = $provider;
			}
		}

		return array_merge(['when' => []], $manifest);
	}

	/**
	 * Create a fresh service manifest data structure.
	 *
	 * @param  array  $providers
	 * @return array
	 */
	protected function freshManifest(array $providers) {
		return ['providers' => $providers, 'eager' => [], 'deferred' => []];
	}

	/**
	 * Create a new provider instance.
	 *
	 * @param  string  $provider
	 * @return \CWS\Encute\Illuminate\Support\ServiceProvider
	 */
	public function createProvider($provider) {
		return new $provider($this->app);
	}
}
