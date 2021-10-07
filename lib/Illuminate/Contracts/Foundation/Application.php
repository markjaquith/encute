<?php

namespace CWS\Encute\Illuminate\Contracts\Foundation;

use CWS\Encute\Illuminate\Support\ServiceProvider;
use CWS\Encute\Illuminate\Contracts\Container\Container;

interface Application extends Container {
	/**
	 * Get the base path of the plugin installation.
	 *
	 * @param  string  $path
	 * @return string
	 */
	public function basePath($path = '');

	/**
	 * Get the path to the bootstrap directory.
	 *
	 * @param  string  $path Optionally, a path to append to the bootstrap path
	 * @return string
	 */
	public function bootstrapPath($path = '');

	/**
	 * Get the path to the application configuration files.
	 *
	 * @param  string  $path Optionally, a path to append to the config path
	 * @return string
	 */
	public function configPath($path = '');

	/**
	 * Get the path to the database directory.
	 *
	 * @param  string  $path Optionally, a path to append to the database path
	 * @return string
	 */
	public function databasePath($path = '');

	/**
	 * Get the path to the resources directory.
	 *
	 * @param  string  $path
	 * @return string
	 */
	public function resourcePath($path = '');

	/**
	 * Get the path to the storage directory.
	 *
	 * @return string
	 */
	public function storagePath();

	/**
	 * Get or check the current application environment.
	 *
	 * @param  string|array  $environments
	 * @return string|bool
	 */
	public function environment(...$environments);

	/**
	 * Determine if the application is running in the console.
	 *
	 * @return bool
	 */
	public function runningInConsole();

	/**
	 * Load all of the configured providers.
	 *
	 * @return void
	 */
	public function loadProviders(array $providers);

	/**
	 * Register a service provider with the application.
	 *
	 * @param  ServiceProvider|string  $provider
	 * @param  bool  $force
	 * @return ServiceProvider
	 */
	public function register($provider, $force = false);

	/**
	 * Register a deferred provider and service.
	 *
	 * @param  string  $provider
	 * @param  string|null  $service
	 * @return void
	 */
	public function registerDeferredProvider($provider, $service = null);

	/**
	 * Resolve a service provider instance from the class name.
	 *
	 * @param  string  $provider
	 * @return ServiceProvider
	 */
	public function resolveProvider($provider);

	/**
	 * Boot the application's service providers.
	 *
	 * @return void
	 */
	public function boot();

	/**
	 * Register a new boot listener.
	 *
	 * @param  callable  $callback
	 * @return void
	 */
	public function booting($callback);

	/**
	 * Register a new "booted" listener.
	 *
	 * @param  callable  $callback
	 * @return void
	 */
	public function booted($callback);

	/**
	 * Run the given array of bootstrap classes.
	 *
	 * @param  array  $bootstrappers
	 * @return void
	 */
	public function bootstrapWith(array $bootstrappers);

	/**
	 * Get the registered service provider instances if any exist.
	 *
	 * @param  ServiceProvider|string  $provider
	 * @return array
	 */
	public function getProviders($provider);

	/**
	 * Determine if the application has been bootstrapped before.
	 *
	 * @return bool
	 */
	public function hasBeenBootstrapped();

	/**
	 * Load and boot all of the remaining deferred providers.
	 *
	 * @return void
	 */
	public function loadDeferredProviders();

	/**
	 * Terminate the application.
	 *
	 * @return void
	 */
	public function terminate();
}
