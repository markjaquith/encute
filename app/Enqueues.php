<?php

namespace CWS\Encute;

use CWS\Encute\Illuminate\Collections\Collection;

class Enqueues implements Contracts\Enqueueables {
	private Collection $enqueues;

	public function add(Enqueueable $enqueueable) {
		$this->enqueues->push($enqueueable);
	}

	public function all(): Collection {
		return $this->enqueues;
	}
}
