<?php

namespace CWS\Encute\Tekta;

use CWS\Encute\Illuminate\Foundation\Application;
use CWS\Encute\Tekta\Contracts\PluginData as PluginDataContract;
use CWS\Encute\Tekta\PluginData;

abstract class Plugin {
	use Features\FilesAndUrls;

	public static $instance;
	protected $file;
	public $app;
	protected $providers = [];

	private function __construct() {
		$basedir = dirname(dirname(__DIR__));
		$this->file = $basedir . '/index.php';

		$this->app = new Application($basedir);

		// Assign the singleton;
		static::$instance = $this;

		// Assign core things to the service container.
		$this->app->instance(get_called_class(), $this);
		$this->app->singleton(PluginDataContract::class, function () {
			$file = $this->getPath('tekta.json');
			$json = file_get_contents($file);

			return new PluginData($json ? json_decode($json, true) : []);
		});
		$this->app->instance(\WPDB::class, $GLOBALS['wpdb']);

		$this->app->loadProviders($this->providers);
		$this->app->boot();

		// Announce that the plugin is booted.
		do_action(get_called_class(), $this);
	}

	public static function load() {
		if (!static::$instance) {
			new static();
		}
	}

	public static function getInstance() {
		if (!static::$instance) {
			trigger_error("You tried to access " . get_called_class() . " before it was ready. Use add_action(\\" . get_called_class() . "::class, function() { /" . "* CODE *" . "/ }) to properly defer your code.", E_USER_ERROR);
		}

		return static::$instance;
	}

	public function getFile() {
		return $this->file;
	}
}
