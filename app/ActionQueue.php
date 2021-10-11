<?php

namespace CWS\Encute;

use CWS\Encute\Illuminate\Support\Collection;
use CWS\Encute\Contracts\Actionable;

class ActionQueue implements Contracts\ActionQueue {
	protected Collection $actions;

	public function __construct() {
		$this->actions = new Collection();
	}

	public function add(Actionable $action): void {
		$this->actions->push($action);
	}

	public function handle(): void {
		$this->actions->each(function (Actionable $action) {
			app()->call([$action, 'handle']);
		});
	}
}
