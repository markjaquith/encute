<?php

namespace CWS\Encute;

use CWS\Encute\Contracts\Enqueueable;

class ScriptWithDependencies extends Script implements Contracts\EnqueueableScript {
	public function dependencies(): Enqueueable {
		return $this;
	}

	public function getHandles(): array {
		return [
			$this->handle,
			...(app()->make(\WP_Scripts::class)->registered[$this->handle]->deps ?? []),
		];
	}
}
