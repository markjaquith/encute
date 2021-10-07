<?php

namespace CWS\Encute\Illuminate\Foundation;

use Closure;
use CWS\Encute\Illuminate\Contracts\Foundation\Application as ApplicationContract;
use CWS\Encute\Illuminate\Support\ServiceProvider;
use CWS\Encute\Illuminate\Container\Container;
use CWS\Encute\Illuminate\Support\Collection;
use CWS\Encute\Illuminate\Support\Arr;
use CWS\Encute\Illuminate\Support\Str;

use RuntimeException;

class Application extends Container implements ApplicationContract {
	/**
	 * The base path for the plugin installation.
	 *
	 * @var string
	 */
	protected $basePath;

	/**
	 * Indicates if the application has been bootstrapped before.
	 *
	 * @var bool
	 */
	protected $hasBeenBootstrapped = false;

	/**
	 * Indicates if the application has "booted".
	 *
	 * @var bool
	 */
	protected $booted = false;

	/**
	 * The array of booting callbacks.
	 *
	 * @var callable[]
	 */
	protected $bootingCallbacks = [];

	/**
	 * The array of booted callbacks.
	 *
	 * @var callable[]
	 */
	protected $bootedCallbacks = [];

	/**
	 * The array of terminating callbacks.
	 *
	 * @var callable[]
	 */
	protected $terminatingCallbacks = [];

	/**
	 * All of the registered service providers.
	 *
	 * @var ServiceProvider[]
	 */
	protected $serviceProviders = [];

	/**
	 * The names of the loaded service providers.
	 *
	 * @var array
	 */
	protected $loadedProviders = [];

	/**
	 * The deferred services and their providers.
	 *
	 * @var array
	 */
	protected $deferredServices = [];

	/**
	 * The custom application path defined by the developer.
	 *
	 * @var string
	 */
	protected $appPath;

	/**
	 * The custom database path defined by the developer.
	 *
	 * @var string
	 */
	protected $databasePath;

	/**
	 * The custom storage path defined by the developer.
	 *
	 * @var string
	 */
	protected $storagePath;

	/**
	 * The custom environment path defined by the developer.
	 *
	 * @var string
	 */
	protected $environmentPath;

	/**
	 * The environment file to load during bootstrapping.
	 *
	 * @var string
	 */
	protected $environmentFile = '.env';

	/**
	 * Indicates if the application is running in the console.
	 *
	 * @var bool|null
	 */
	protected $isRunningInConsole;

	/**
	 * The application namespace.
	 *
	 * @var string
	 */
	protected $namespace;

	/**
	 * The prefixes of absolute cache paths for use during normalization.
	 *
	 * @var array
	 */
	protected $absoluteCachePathPrefixes = ['/', '\\'];

	/**
	 * Create a new plugin application instance.
	 *
	 * @param  string|null  $basePath
	 * @return void
	 */
	public function __construct($basePath = null) {
		if ($basePath) {
			$this->setBasePath($basePath);
		}
	}

	/**
	 * Run the given array of bootstrap classes.
	 *
	 * @param  string[]  $bootstrappers
	 * @return void
	 */
	public function bootstrapWith(array $bootstrappers) {
		$this->hasBeenBootstrapped = true;

		foreach ($bootstrappers as $bootstrapper) {
			$this['events']->dispatch('bootstrapping: '.$bootstrapper, [$this]);

			$this->make($bootstrapper)->bootstrap($this);

			$this['events']->dispatch('bootstrapped: '.$bootstrapper, [$this]);
		}
	}

	/**
	 * Register a callback to run after loading the environment.
	 *
	 * @param  \Closure  $callback
	 * @return void
	 */
	public function afterLoadingEnvironment(Closure $callback) {
		return $this->afterBootstrapping(
			LoadEnvironmentVariables::class, $callback
		);
	}

	/**
	 * Register a callback to run before a bootstrapper.
	 *
	 * @param  string  $bootstrapper
	 * @param  \Closure  $callback
	 * @return void
	 */
	public function beforeBootstrapping($bootstrapper, Closure $callback) {
		$this['events']->listen('bootstrapping: '.$bootstrapper, $callback);
	}

	/**
	 * Register a callback to run after a bootstrapper.
	 *
	 * @param  string  $bootstrapper
	 * @param  \Closure  $callback
	 * @return void
	 */
	public function afterBootstrapping($bootstrapper, Closure $callback) {
		$this['events']->listen('bootstrapped: '.$bootstrapper, $callback);
	}

	/**
	 * Determine if the application has been bootstrapped before.
	 *
	 * @return bool
	 */
	public function hasBeenBootstrapped() {
		return $this->hasBeenBootstrapped;
	}

	/**
	 * Set the base path for the application.
	 *
	 * @param  string  $basePath
	 * @return $this
	 */
	public function setBasePath($basePath) {
		$this->basePath = rtrim($basePath, '\/');

		$this->bindPathsInContainer();

		return $this;
	}

	/**
	 * Bind all of the application paths in the container.
	 *
	 * @return void
	 */
	protected function bindPathsInContainer() {
		$this->instance('path', $this->path());
		$this->instance('path.base', $this->basePath());
		$this->instance('path.lang', $this->langPath());
		$this->instance('path.config', $this->configPath());
		$this->instance('path.public', $this->publicPath());
		$this->instance('path.storage', $this->storagePath());
		$this->instance('path.database', $this->databasePath());
		$this->instance('path.resources', $this->resourcePath());
		$this->instance('path.bootstrap', $this->bootstrapPath());
	}

	/**
	 * Get the path to the application "app" directory.
	 *
	 * @param  string  $path
	 * @return string
	 */
	public function path($path = '') {
		$appPath = $this->appPath ?: $this->basePath.DIRECTORY_SEPARATOR.'app';

		return $appPath.($path ? DIRECTORY_SEPARATOR.$path : $path);
	}

	/**
	 * Set the application directory.
	 *
	 * @param  string  $path
	 * @return $this
	 */
	public function useAppPath($path) {
		$this->appPath = $path;

		$this->instance('path', $path);

		return $this;
	}

	/**
	 * Get the base path of the Laravel installation.
	 *
	 * @param  string  $path Optionally, a path to append to the base path
	 * @return string
	 */
	public function basePath($path = '') {
		return $this->basePath.($path ? DIRECTORY_SEPARATOR.$path : $path);
	}

	/**
	 * Get the path to the bootstrap directory.
	 *
	 * @param  string  $path Optionally, a path to append to the bootstrap path
	 * @return string
	 */
	public function bootstrapPath($path = '') {
		return $this->basePath.DIRECTORY_SEPARATOR.'bootstrap'.($path ? DIRECTORY_SEPARATOR.$path : $path);
	}

	/**
	 * Get the path to the application configuration files.
	 *
	 * @param  string  $path Optionally, a path to append to the config path
	 * @return string
	 */
	public function configPath($path = '') {
		return $this->basePath.DIRECTORY_SEPARATOR.'config'.($path ? DIRECTORY_SEPARATOR.$path : $path);
	}

	/**
	 * Get the path to the database directory.
	 *
	 * @param  string  $path Optionally, a path to append to the database path
	 * @return string
	 */
	public function databasePath($path = '') {
		return ($this->databasePath ?: $this->basePath.DIRECTORY_SEPARATOR.'database').($path ? DIRECTORY_SEPARATOR.$path : $path);
	}

	/**
	 * Set the database directory.
	 *
	 * @param  string  $path
	 * @return $this
	 */
	public function useDatabasePath($path) {
		$this->databasePath = $path;

		$this->instance('path.database', $path);

		return $this;
	}

	/**
	 * Get the path to the language files.
	 *
	 * @return string
	 */
	public function langPath() {
		return $this->resourcePath().DIRECTORY_SEPARATOR.'lang';
	}

	/**
	 * Get the path to the public / web directory.
	 *
	 * @return string
	 */
	public function publicPath() {
		return $this->basePath.DIRECTORY_SEPARATOR.'public';
	}

	/**
	 * Get the path to the storage directory.
	 *
	 * @return string
	 */
	public function storagePath() {
		return $this->storagePath ?: $this->basePath.DIRECTORY_SEPARATOR.'storage';
	}

	/**
	 * Set the storage directory.
	 *
	 * @param  string  $path
	 * @return $this
	 */
	public function useStoragePath($path) {
		$this->storagePath = $path;

		$this->instance('path.storage', $path);

		return $this;
	}

	/**
	 * Get the path to the resources directory.
	 *
	 * @param  string  $path
	 * @return string
	 */
	public function resourcePath($path = '') {
		return $this->basePath.DIRECTORY_SEPARATOR.'resources'.($path ? DIRECTORY_SEPARATOR.$path : $path);
	}

	/**
	 * Get the path to the environment file directory.
	 *
	 * @return string
	 */
	public function environmentPath() {
		return $this->environmentPath ?: $this->basePath;
	}

	/**
	 * Set the directory for the environment file.
	 *
	 * @param  string  $path
	 * @return $this
	 */
	public function useEnvironmentPath($path) {
		$this->environmentPath = $path;

		return $this;
	}

	/**
	 * Set the environment file to be loaded during bootstrapping.
	 *
	 * @param  string  $file
	 * @return $this
	 */
	public function loadEnvironmentFrom($file) {
		$this->environmentFile = $file;

		return $this;
	}

	/**
	 * Get the environment file the application is using.
	 *
	 * @return string
	 */
	public function environmentFile() {
		return $this->environmentFile ?: '.env';
	}

	/**
	 * Get the fully qualified path to the environment file.
	 *
	 * @return string
	 */
	public function environmentFilePath() {
		return $this->environmentPath().DIRECTORY_SEPARATOR.$this->environmentFile();
	}

	/**
	 * Get or check the current application environment.
	 *
	 * @param  string|array  $environments
	 * @return string|bool
	 */
	public function environment(...$environments) {
		if (count($environments) > 0) {
			$patterns = is_array($environments[0]) ? $environments[0] : $environments;

			return Str::is($patterns, $this['env']);
		}

		return $this['env'];
	}

	/**
	 * Determine if application is in local environment.
	 *
	 * @return bool
	 */
	public function isLocal() {
		return $this['env'] === 'local';
	}

	/**
	 * Determine if application is in production environment.
	 *
	 * @return bool
	 */
	public function isProduction() {
		return $this['env'] === 'production';
	}

	/**
	 * Detect the application's current environment.
	 *
	 * @param  \Closure  $callback
	 * @return string
	 */
	public function detectEnvironment(Closure $callback) {
		$args = $_SERVER['argv'] ?? null;

		return $this['env'] = (new EnvironmentDetector)->detect($callback, $args);
	}

	/**
	 * Determine if the application is running in the console.
	 *
	 * @return bool
	 */
	public function runningInConsole() {
		if ($this->isRunningInConsole === null) {
			$this->isRunningInConsole = Env::get('APP_RUNNING_IN_CONSOLE') ?? (\PHP_SAPI === 'cli' || \PHP_SAPI === 'phpdbg');
		}

		return $this->isRunningInConsole;
	}

	public function loadProviders(array $providers) {
		(new ProviderRepository($this))->load($providers);
	}

	/**
	 * Register a service provider with the application.
	 *
	 * @param  ServiceProvider|string  $provider
	 * @param  bool  $force
	 * @return ServiceProvider
	 */
	public function register($provider, $force = false) {
		if (($registered = $this->getProvider($provider)) && ! $force) {
			return $registered;
		}

		// If the given "provider" is a string, we will resolve it, passing in the
		// application instance automatically for the developer. This is simply
		// a more convenient way of specifying your service provider classes.
		if (is_string($provider)) {
			$provider = $this->resolveProvider($provider);
		}

		$provider->register();

		// If there are bindings / singletons set as properties on the provider we
		// will spin through them and register them with the application, which
		// serves as a convenience layer while registering a lot of bindings.
		if (property_exists($provider, 'bindings')) {
			foreach ($provider->bindings as $key => $value) {
				$this->bind($key, $value);
			}
		}

		if (property_exists($provider, 'singletons')) {
			foreach ($provider->singletons as $key => $value) {
				$this->singleton($key, $value);
			}
		}

		$this->markAsRegistered($provider);

		// If the application has already booted, we will call this boot method on
		// the provider class so it has an opportunity to do its boot logic and
		// will be ready for any usage by this developer's application logic.
		if ($this->isBooted()) {
			$this->bootProvider($provider);
		}

		return $provider;
	}

	/**
	 * Get the registered service provider instance if it exists.
	 *
	 * @param  ServiceProvider|string  $provider
	 * @return ServiceProvider|null
	 */
	public function getProvider($provider) {
		return array_values($this->getProviders($provider))[0] ?? null;
	}

	/**
	 * Get the registered service provider instances if any exist.
	 *
	 * @param  ServiceProvider|string  $provider
	 * @return array
	 */
	public function getProviders($provider) {
		$name = is_string($provider) ? $provider : get_class($provider);

		return Arr::where($this->serviceProviders, function ($value) use ($name) {
			return $value instanceof $name;
		});
	}

	/**
	 * Resolve a service provider instance from the class name.
	 *
	 * @param  string  $provider
	 * @return ServiceProvider
	 */
	public function resolveProvider($provider) {
		return new $provider($this);
	}

	/**
	 * Mark the given provider as registered.
	 *
	 * @param  ServiceProvider  $provider
	 * @return void
	 */
	protected function markAsRegistered($provider) {
		$this->serviceProviders[] = $provider;

		$this->loadedProviders[get_class($provider)] = true;
	}

	/**
	 * Load and boot all of the remaining deferred providers.
	 *
	 * @return void
	 */
	public function loadDeferredProviders() {
		// We will simply spin through each of the deferred providers and register each
		// one and boot them if the application has booted. This should make each of
		// the remaining services available to this application for immediate use.
		foreach ($this->deferredServices as $service => $provider) {
			$this->loadDeferredProvider($service);
		}

		$this->deferredServices = [];
	}

	/**
	 * Load the provider for a deferred service.
	 *
	 * @param  string  $service
	 * @return void
	 */
	public function loadDeferredProvider($service) {
		if (! $this->isDeferredService($service)) {
			return;
		}

		$provider = $this->deferredServices[$service];

		// If the service provider has not already been loaded and registered we can
		// register it with the application and remove the service from this list
		// of deferred services, since it will already be loaded on subsequent.
		if (! isset($this->loadedProviders[$provider])) {
			$this->registerDeferredProvider($provider, $service);
		}
	}

	/**
	 * Register a deferred provider and service.
	 *
	 * @param  string  $provider
	 * @param  string|null  $service
	 * @return void
	 */
	public function registerDeferredProvider($provider, $service = null) {
		// Once the provider that provides the deferred service has been registered we
		// will remove it from our local list of the deferred services with related
		// providers so that this container does not try to resolve it out again.
		if ($service) {
			unset($this->deferredServices[$service]);
		}

		$this->register($instance = new $provider($this));

		if (! $this->isBooted()) {
			$this->booting(function () use ($instance) {
				$this->bootProvider($instance);
			});
		}
	}

	/**
	 * Resolve the given type from the container.
	 *
	 * @param  string  $abstract
	 * @param  array  $parameters
	 * @return mixed
	 */
	public function make($abstract, array $parameters = []) {
		$this->loadDeferredProviderIfNeeded($abstract = $this->getAlias($abstract));

		return parent::make($abstract, $parameters);
	}

	/**
	 * Resolve the given type from the container.
	 *
	 * @param  string  $abstract
	 * @param  array  $parameters
	 * @param  bool  $raiseEvents
	 * @return mixed
	 */
	protected function resolve($abstract, $parameters = [], $raiseEvents = true) {
		$this->loadDeferredProviderIfNeeded($abstract = $this->getAlias($abstract));

		return parent::resolve($abstract, $parameters, $raiseEvents);
	}

	/**
	 * Load the deferred provider if the given type is a deferred service and the instance has not been loaded.
	 *
	 * @param  string  $abstract
	 * @return void
	 */
	protected function loadDeferredProviderIfNeeded($abstract) {
		if ($this->isDeferredService($abstract) && ! isset($this->instances[$abstract])) {
			$this->loadDeferredProvider($abstract);
		}
	}

	/**
	 * Determine if the given abstract type has been bound.
	 *
	 * @param  string  $abstract
	 * @return bool
	 */
	public function bound($abstract) {
		return $this->isDeferredService($abstract) || parent::bound($abstract);
	}

	/**
	 * Determine if the application has booted.
	 *
	 * @return bool
	 */
	public function isBooted() {
		return $this->booted;
	}

	/**
	 * Boot the application's service providers.
	 *
	 * @return void
	 */
	public function boot() {
		if ($this->isBooted()) {
			return;
		}

		// Once the application has booted we will also fire some "booted" callbacks
		// for any listeners that need to do work after this initial booting gets
		// finished. This is useful when ordering the boot-up processes we run.
		$this->fireAppCallbacks($this->bootingCallbacks);

		array_walk($this->serviceProviders, function ($p) {
			$this->bootProvider($p);
		});

		$this->booted = true;

		$this->fireAppCallbacks($this->bootedCallbacks);
	}

	/**
	 * Boot the given service provider.
	 *
	 * @param  ServiceProvider  $provider
	 * @return mixed
	 */
	protected function bootProvider(ServiceProvider $provider) {
		if (method_exists($provider, 'boot')) {
			return $this->call([$provider, 'boot']);
		}
	}

	/**
	 * Register a new boot listener.
	 *
	 * @param  callable  $callback
	 * @return void
	 */
	public function booting($callback) {
		$this->bootingCallbacks[] = $callback;
	}

	/**
	 * Register a new "booted" listener.
	 *
	 * @param  callable  $callback
	 * @return void
	 */
	public function booted($callback) {
		$this->bootedCallbacks[] = $callback;

		if ($this->isBooted()) {
			$this->fireAppCallbacks([$callback]);
		}
	}

	/**
	 * Call the booting callbacks for the application.
	 *
	 * @param  callable[]  $callbacks
	 * @return void
	 */
	protected function fireAppCallbacks(array $callbacks) {
		foreach ($callbacks as $callback) {
			$callback($this);
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function handle(SymfonyRequest $request, int $type = self::MASTER_REQUEST, bool $catch = true) {
		return $this[HttpKernelContract::class]->handle(Request::createFromBase($request));
	}

	/**
	 * Determine if middleware has been disabled for the application.
	 *
	 * @return bool
	 */
	public function shouldSkipMiddleware() {
		return $this->bound('middleware.disable') &&
			   $this->make('middleware.disable') === true;
	}

	/**
	 * Register a terminating callback with the application.
	 *
	 * @param  callable|string  $callback
	 * @return $this
	 */
	public function terminating($callback) {
		$this->terminatingCallbacks[] = $callback;

		return $this;
	}

	/**
	 * Terminate the application.
	 *
	 * @return void
	 */
	public function terminate() {
		foreach ($this->terminatingCallbacks as $terminating) {
			$this->call($terminating);
		}
	}

	/**
	 * Get the service providers that have been loaded.
	 *
	 * @return array
	 */
	public function getLoadedProviders() {
		return $this->loadedProviders;
	}

	/**
	 * Determine if the given service provider is loaded.
	 *
	 * @param  string  $provider
	 * @return bool
	 */
	public function providerIsLoaded(string $provider) {
		return isset($this->loadedProviders[$provider]);
	}

	/**
	 * Get the application's deferred services.
	 *
	 * @return array
	 */
	public function getDeferredServices() {
		return $this->deferredServices;
	}

	/**
	 * Set the application's deferred services.
	 *
	 * @param  array  $services
	 * @return void
	 */
	public function setDeferredServices(array $services) {
		$this->deferredServices = $services;
	}

	/**
	 * Add an array of services to the application's deferred services.
	 *
	 * @param  array  $services
	 * @return void
	 */
	public function addDeferredServices(array $services) {
		$this->deferredServices = array_merge($this->deferredServices, $services);
	}

	/**
	 * Determine if the given service is a deferred service.
	 *
	 * @param  string  $service
	 * @return bool
	 */
	public function isDeferredService($service) {
		return isset($this->deferredServices[$service]);
	}

	/**
	 * Flush the container of all bindings and resolved instances.
	 *
	 * @return void
	 */
	public function flush() {
		parent::flush();

		$this->buildStack = [];
		$this->loadedProviders = [];
		$this->bootedCallbacks = [];
		$this->bootingCallbacks = [];
		$this->deferredServices = [];
		$this->reboundCallbacks = [];
		$this->serviceProviders = [];
		$this->resolvingCallbacks = [];
		$this->terminatingCallbacks = [];
		$this->afterResolvingCallbacks = [];
		$this->globalResolvingCallbacks = [];
	}
}
