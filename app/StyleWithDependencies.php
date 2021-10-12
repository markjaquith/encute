<?php

namespace CWS\Encute;

use CWS\Encute\Contracts\Enqueueable;

class StyleWithDependencies extends StyleDependencies {
	public function getHandles(): array {
		return [
			$this->handle,
			...$this->getAllDependencyHandles($this->handle),
		];
	}
}
