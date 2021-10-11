<?php

namespace CWS\Encute;

class Script extends Enqueue implements Contracts\EnqueueableScript {
	public function module(): self {
		return $this;
	}

	public function noModule(): self {
		return $this;
	}

	public function async(): self {
		return $this;
	}

	public function header(): self {
		Actions\MoveScriptToHeader::dispatch($this->name);

		return $this;
	}

	public function footer(): self {
		Actions\MoveScriptToFooter::dispatch($this->name);

		return $this;
	}
}
