<?php

namespace CWS\Encute\Providers;

use CWS\Encute\Styles;
use CWS\Encute\Scripts;
use CWS\Encute\Illuminate\Support\ServiceProvider;
use CWS\Encute\Contracts\Styles as StylesContract;
use CWS\Encute\Contracts\Scripts as ScriptContract;


class EnqueueablesProvider extends ServiceProvider {
	public function register() {
		$this->app->singleton(\WP_Scripts::class, fn () => $GLOBALS['wp_scripts']);
		$this->app->singleton(\WP_Styles::class, fn () => $GLOBALS['wp_styles']);
		$this->app->singleton(ScriptsContract::class, Scripts::class);
		$this->app->singleton(StylesContract::class, Styles::class);
	}
}
