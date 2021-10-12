<?php

namespace CWS\Encute;

use CWS\Encute\Contracts\Enqueueable;

class ScriptDependencies extends Script implements Contracts\EnqueueableScript {
	public function dependencies(): Enqueueable {
		return $this;
	}

	public function getAllDependencyHandles(string $handle) {
		$dependencies = app()->make(\WP_Scripts::class)->registered[$handle]->deps ?? [];

		return $dependencies ? array_merge($dependencies, ...array_map([$this, 'getAllDependencyHandles'], $dependencies)) : $dependencies;
	}

	public function getHandles(): array {
		return [
			...$this->getAllDependencyHandles($this->handle),
		];
	}
}
