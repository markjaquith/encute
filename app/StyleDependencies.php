<?php

namespace CWS\Encute;

use CWS\Encute\Contracts\Enqueueable;

class StyleDependencies extends Style implements Contracts\EnqueueableStyle {
	public function dependencies(): Enqueueable {
		return new StyleDependencies($this->handle);
	}

	public function getHandles(): array {
		return app()->make(\WP_Styles::class)->registered[$this->handle]->deps ?? [];
	}
}
