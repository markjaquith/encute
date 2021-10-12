<?php

namespace CWS\Encute;

use CWS\Encute\Contracts\Enqueueable;

class ScriptDependencies extends Script implements Contracts\EnqueueableScript {
	public function dependencies(): ?Enqueueable {
		return new ScriptDependencies($this->name);
	}

	public function getNames(): array {
		return app()->make(\WP_Scripts::class)->registered[$this->name]->deps ?? [];
	}
}
