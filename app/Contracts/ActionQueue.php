<?php

namespace CWS\Encute\Contracts;

interface ActionQueue {
	public function add(Actionable $action): void;
	public function handle(): void;
}
