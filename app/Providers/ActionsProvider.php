<?php

namespace CWS\Encute\Providers;

use CWS\Encute\ActionQueue;
use CWS\Encute\Illuminate\Support\ServiceProvider;
use CWS\Encute\Contracts\ActionQueue as ActionQueueContract;

class ActionsProvider extends ServiceProvider {
	public function register() {
		$this->app->singleton(ActionQueueContract::class, ActionQueue::class);
		$this->app->instance('config.queue_hook', 'wp_print_styles');
		$this->app->instance('config.queue_run_priority', PHP_INT_MAX);
		$this->app->singleton('config.queue_priority', fn () => $this->app->make('config.queue_run_priority') - 1);
	}

	public function boot(ActionQueueContract $actionQueue) {
		// TODO: Separate queues for scripts and styles,
		// using wp_print_styles and wp_print_scripts hooks.
		$hook = $this->app->make('config.queue_hook');
		$priority = $this->app->make('config.queue_run_priority');
		add_action($hook, fn () => $actionQueue->handle(), $priority);
	}
}
