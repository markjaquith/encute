<?php

namespace CWS\Encute;

use CWS\Encute\Contracts\Enqueueable;

abstract class Enqueue implements Enqueueable {
	protected array $handles = [];

	public function __construct($handles = []) {
		if (is_string($handles)) {
			$handles = [$handles];
		}

		$this->handles = $handles;
	}

	public static function get($handles = []): Enqueueable {
		return new static($handles);
	}

	public function getHandles(): array {
		return $this->handles;
	}

	public function dispatch(string $actionClass, ...$args): Enqueueable {
		$actionClass::dispatch($this, ...$args);

		return $this;
	}
}
