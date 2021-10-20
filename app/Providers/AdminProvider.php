<?php

namespace CWS\Encute\Providers;

use CWS\Encute\Menu;
use CWS\Encute\Admin;
use CWS\Encute\Illuminate\Support\ServiceProvider;

class AdminProvider extends ServiceProvider {
	public function register() {
		$this->app->singleton(Admin::class);
		$this->app->singleton(Menu::class);
	}

	public function boot(Admin $admin) {
		$admin->boot();
	}
}
