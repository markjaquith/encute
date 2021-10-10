<?php

namespace CWS\Encute;

abstract class Enqueue implements Contracts\Enqueueable {
	public function header(): self {
		return $this;
	}

	public function footer(): self {
		return $this;
	}

	public function delay(int $milliseconds): self {
		return $this;
	}

	public function defer(): self {
		return $this;
	}

	public function showIf(callable $callback): self {
		return $this;
	}

	public function hideIf(callable $callback): self {
		return $this;
	}

	public function group(Contracts\Groupable $group): self {
		return $this;
	}
}
