<?php

namespace CWS\Encute;

use CWS\Encute\Contracts\Enqueueable;

class StyleDependencies extends Style implements Contracts\EnqueueableStyle {
	public function dependencies(): Enqueueable {
		return $this;
	}

	public function getAllDependencyHandles(string $handle) {
		$dependencies = app()->make(\WP_Styles::class)->registered[$handle]->deps ?? [];

		return $dependencies ? array_merge($dependencies, ...array_map([$this, 'getAllDependencyHandles'], $dependencies)) : $dependencies;
	}

	public function getHandles(): array {
		return [];
		return [
			...$this->getAllDependencyHandles($this->handle),
		];
	}
}
