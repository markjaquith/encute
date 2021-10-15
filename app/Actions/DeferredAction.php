<?php

namespace CWS\Encute\Actions;

use function CWS\Encute\app;
use CWS\Encute\Contracts\Actionable;
use CWS\Encute\Contracts\Enqueueable;
use CWS\Encute\Contracts\ActionQueue;

class DeferredAction extends Action {
	public $callback;

	public function __construct(Enqueueable $asset, callable $callback) {
		$this->asset= $asset;
		$this->callback = $callback;
	}

	public static function dispatch(...$args): void {
		$action = new static(...$args);
		add_action('wp_print_styles', $action->callback, PHP_INT_MAX - 1);
	}
}
