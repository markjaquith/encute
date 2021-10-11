<?php

namespace CWS\Encute\Actions;

use function CWS\Encute\app;
use CWS\Encute\Contracts\Actionable;
use CWS\Encute\Contracts\ActionQueue;

abstract class Action implements Actionable {
	protected string $name;

	public function __construct(string $name) {
		$this->name = $name;
	}

	public static function dispatch(...$args): Actionable {
		$action = new static(...$args);
		app()->make(ActionQueue::class)->add($action);

		return $action;
	}
}
