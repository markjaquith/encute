<?php

namespace CWS\Encute;

class Style extends Enqueue implements Contracts\EnqueueableStyle {
	public function header(): self {
		Actions\MoveStyleToHeader::dispatch($this->name);

		return $this;
	}

	public function footer(): self {
		Actions\MoveStyleToFooter::dispatch($this->name);

		return $this;
	}

}
