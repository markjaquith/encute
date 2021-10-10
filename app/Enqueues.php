<?php

namespace CWS\Encute;

use CWS\Encute\Contracts\Enqueueable;
use CWS\Encute\Contracts\Enqueueables;
use CWS\Encute\Illuminate\Support\Collection;

abstract class Enqueues implements Enqueueables {
	private Collection $enqueues;

	public function __construct() {
		$this->enqueues = new Collection();
	}

	public function add(Enqueueable $enqueueable) {
		$this->enqueues->push($enqueueable);
	}

	abstract public function get(string $name): Enqueueable;

	public function all(): Collection {
		return $this->enqueues;
	}
}
