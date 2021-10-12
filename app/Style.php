<?php

namespace CWS\Encute;

use CWS\Encute\Contracts\Enqueueable;

class Style extends Enqueue implements Contracts\EnqueueableStyle {
	public function header(): self {
		// No-op. Styles are already in the header.
		return $this;
	}

	public function footer(): self {
		return $this->dispatch(Actions\MoveStyleToFooter::class);
	}

	public function getHandles(): array {
		return [$this->handle];
	}

	public function dependencies(): Enqueueable {
		return new StyleDependencies($this->handle);
	}

	public function withDependencies(): Enqueueable {
		return new StyleWithDependencies($this->handle);
	}
}
