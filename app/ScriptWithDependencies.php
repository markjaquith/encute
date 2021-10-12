<?php

namespace CWS\Encute;

use CWS\Encute\Contracts\Enqueueable;

class ScriptWithDependencies extends ScriptDependencies implements Contracts\EnqueueableScript {
	public function dependencies(): Enqueueable {
		return $this;
	}

	public function getHandles(): array {
		return [
			$this->handle,
			...$this->getAllDependencyHandles($this->handle),
		];
	}
}
