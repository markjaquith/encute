<?php

namespace CWS\Encute;

use CWS\Encute\Contracts\Enqueueable;

abstract class Enqueue implements Enqueueable {
	protected string $handle = '';

	public function __construct(string $handle) {
		$this->handle = $handle;
	}

	public static function get(string $handle): Enqueueable {
		return new static($handle);
	}

	public function getHandles(): array {
		return [$this->handle];
	}

	public function dispatch(string $actionClass, ...$args): Enqueueable {
		$actionClass::dispatch($this, ...$args);

		return $this;
	}
}
