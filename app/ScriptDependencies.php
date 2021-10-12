<?php

namespace CWS\Encute;

use CWS\Encute\Contracts\Enqueueable;

class ScriptDependencies extends Script implements Contracts\EnqueueableScript {
	public function dependencies(): ?Enqueueable {
		return new ScriptDependencies($this->handle);
	}

	public function getHandles(): array {
		return app()->make(\WP_Scripts::class)->registered[$this->handle]->deps ?? [];
	}
}
