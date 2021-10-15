<?php

namespace CWS\Encute;

use CWS\Encute\Contracts\Enqueueable;

class Style extends Enqueue implements Contracts\EnqueueableStyle {
	public function footer(): self {
		$this->dispatch(Actions\DeferredAction::class, function () {
			$allRelatedNodes = new self(DependencyGrapher::forStyles()->allRelatedNodes($this->getHandles()));
			$allRelatedNodes->dispatch(Actions\MoveStyleToFooter::class);
		});

		return $this;
	}

	public function remove(): self {
		return $this->dispatch(Actions\RemoveStyle::class);
	}

	public function defer(): self {
		return $this->dispatch(Actions\MakeStyleDefer::class);
	}

	public function keepIf(callable $condition): Enqueueable {
		$reverseCondition = fn () => !call_user_func($condition);

		return $this->dispatch(Actions\RemoveStyleIf::class, $reverseCondition);
	}

	public function removeIf(callable $condition): Enqueueable {
		return $this->dispatch(Actions\RemoveStyleIf::class, $condition);
	}
}
