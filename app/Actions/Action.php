<?php

namespace CWS\Encute\Actions;

use function CWS\Encute\app;
use CWS\Encute\Contracts\Actionable;
use CWS\Encute\Contracts\ActionQueue;
use CWS\Encute\Contracts\Enqueueable;

abstract class Action implements Actionable {
	protected Enqueueable $asset;

	public function __construct(Enqueueable $asset) {
		$this->asset= $asset;
	}

	public static function dispatch(...$args): void {
		$action = new static(...$args);
		app()->make(ActionQueue::class)->add($action);
	}
}
