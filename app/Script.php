<?php

namespace CWS\Encute;

use CWS\Encute\Contracts\Enqueueable;

class Script extends Enqueue implements Contracts\EnqueueableScript {
	public function module(): self {
		Actions\MakeScriptModule::dispatch($this->name);

		return $this;
	}

	public function noModule(): self {
		return $this;
	}

	public function async(): self {
		return $this;
	}

	public function header(): self {
		return $this->dispatch(Actions\MoveScriptToHeader::class);
	}

	public function footer(): self {
		return $this->dispatch(Actions\MoveScriptToFooter::class);
	}

	public function getNames(): array {
		return [$this->name];
	}

	public function dependencies(): ?Enqueueable {
		return new ScriptDependencies($this->name);
	}
}
