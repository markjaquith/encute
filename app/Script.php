<?php

namespace CWS\Encute;

use CWS\Encute\Contracts\Enqueueable;

class Script extends Enqueue implements Contracts\EnqueueableScript {
	public function module(): self {
		return $this->dispatch(Actions\MakeScriptModule::class);
	}

	public function noModule(): self {
		return $this->dispatch(Actions\MakeScriptNoModule::class);
	}

	public function async(): self {
		return $this->dispatch(Actions\MakeScriptAsync::class);
	}

	public function defer(): self {
		return $this->dispatch(Actions\MakeScriptDefer::class);
	}

	public function header(): self {
		return $this->dispatch(Actions\MoveScriptToHeader::class);
	}

	public function footer(): self {
		return $this->dispatch(Actions\MoveScriptToFooter::class);
	}

	public function getHandles(): array {
		return [$this->handle];
	}

	public function dependencies(): Enqueueable {
		return new ScriptDependencies($this->handle);
	}

	public function withDependencies(): Enqueueable {
		return new ScriptWithDependencies($this->handle);
	}
}
