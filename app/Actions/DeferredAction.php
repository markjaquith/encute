<?php

namespace CWS\Encute\Actions;

use function CWS\Encute\app;
use CWS\Encute\Contracts\Enqueueable;

class DeferredAction extends Action {
	public $callback;

	public function __construct(Enqueueable $asset, callable $callback) {
		$this->asset= $asset;
		$this->callback = $callback;
	}

	public static function dispatch(...$args): void {
		$action = new static(...$args);
		$hook = app()->make('config.queue_hook');
		$priority = app()->make('config.queue_priority');
		add_action($hook, $action->callback, $priority);
	}
}
