<?php

namespace CWS\Encute;

use CWS\Encute\Contracts\Enqueueable;

class StyleWithDependencies extends Style implements Contracts\EnqueueableStyle {
	public function dependencies(): Enqueueable {
		return $this;
	}

	public function getHandles(): array {
		return [
			$this->handle,
			...(app()->make(\WP_Styles::class)->registered[$this->handle]->deps ?? []),
		];
	}
}
