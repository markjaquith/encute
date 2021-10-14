<?php

namespace CWS\Encute;

use CWS\Encute\Contracts\Enqueueable;

class Style extends Enqueue implements Contracts\EnqueueableStyle {
	public function footer(): self {
		return $this->dispatch(Actions\MoveStyleToFooter::class);
	}

	public function remove(): self {
		return $this->dispatch(Actions\RemoveStyle::class);
	}

	public function defer(): self {
		return $this->dispatch(Actions\MakeStyleDefer::class);
	}

	public function dependencies(): Enqueueable {
		return new StyleDependencies($this->handle);
	}

	public function withDependencies(): Enqueueable {
		return new StyleWithDependencies($this->handle);
	}

	public function keepIf(callable $condition): Enqueueable {
		$reverseCondition = fn () => !call_user_func($condition);

		return $this->dispatch(Actions\RemoveStyleIf::class, $reverseCondition);
	}

	public function removeIf(callable $condition): Enqueueable {
		return $this->dispatch(Actions\RemoveStyleIf::class, $condition);
	}
}
