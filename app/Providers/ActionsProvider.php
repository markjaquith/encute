<?php

namespace CWS\Encute\Providers;

use CWS\Encute\ActionQueue;
use CWS\Encute\Illuminate\Support\ServiceProvider;
use CWS\Encute\Contracts\ActionQueue as ActionQueueContract;

class ActionsProvider extends ServiceProvider {
	public function register() {
		$this->app->singleton(ActionQueueContract::class, ActionQueue::class);
	}

	public function boot(ActionQueueContract $actionQueue) {
		// TODO: Separate queues for scripts and styles,
		// using wp_print_styles and wp_print_scripts hooks.
		add_action('wp_print_styles', fn () => $actionQueue->handle(), PHP_INT_MAX);
	}
}
