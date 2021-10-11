<?php

namespace CWS\Encute;

abstract class Enqueue implements Contracts\Enqueueable {
	protected string $name = '';
	protected bool $defer = false;
	protected bool $header = false;
	protected bool $footer = false;
	protected int $delayMs = 0;
	protected bool $removed = false;
	protected ?Contracts\Groupable $group = null;
	/**
	 * @var callable
	 */
	protected $showCallback = null;
	/**
	 * @var callable
	 */
	protected $removeCallback = null;

	public function getName(): string {
		return $this->name;
	}

	public function header(): self {
		$this->header = true;
		$this->footer = false;

		return $this;
	}

	public function footer(): self {
		$this->footer = true;
		$this->header = false;

		return $this;
	}

	public function delay(int $milliseconds): self {
		$this->delayMs = $milliseconds;

		return $this;
	}

	public function defer(): self {
		$this->defer = true;

		return $this;
	}

	public function showIf(callable $callback): self {
		$this->showCallback = $callback;
		$this->hideCallback = null;

		return $this;
	}

	public function removeIf(callable $callback): self {
		$this->hideCallback = $callback;
		$this->showCallback = null;

		return $this;
	}

	public function group(Contracts\Groupable $group): self {
		return $this;
	}

	public function getGroup(): ?Contracts\Groupable {
		return $this->group;
	}

	public function remove(): self {
		$this->removed = true;

		return $this;
	}
}
