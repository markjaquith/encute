<?php

namespace CWS\Encute;

use CWS\Encute\Contracts\Enqueueable;

class Script extends Enqueue implements Contracts\EnqueueableScript {
	public function module(): self {
		return $this->dispatch(Actions\MakeScriptModule::class);
	}

	public function noModule(): self {
		return $this->dispatch(Actions\MakeScriptNoModule::class);
	}

	public function async(): self {
		return $this->dispatch(Actions\MakeScriptAsync::class);
	}

	public function defer(): self {
		return $this->dispatch(Actions\MakeScriptDefer::class);
	}

	public function footer(): self {
		$this->dispatch(Actions\DeferredAction::class, function () {
			$allRelatedNodes = new self(DependencyGrapher::forScripts()->allRelatedNodes($this->getHandles()));
			$allRelatedNodes->dispatch(Actions\MoveScriptToFooter::class);
		});

		return $this;
	}

	public function remove(): self {
		return $this->dispatch(Actions\RemoveScript::class);
	}

	public function keepIf(callable $condition): Enqueueable {
		$reverseCondition = fn () => !call_user_func($condition);

		return $this->dispatch(Actions\RemoveScriptIf::class, $reverseCondition);
	}

	public function removeIf(callable $condition): Enqueueable {
		return $this->dispatch(Actions\RemoveScriptIf::class, $condition);
	}
}
