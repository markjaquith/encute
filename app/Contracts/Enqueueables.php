<?php

namespace CWS\Encute\Contracts;

interface Enqueueables {
	public function get(string $name): Enqueueable;
}
