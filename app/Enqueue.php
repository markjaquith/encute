<?php

namespace CWS\Encute;

use CWS\Encute\Contracts\Enqueueable;

abstract class Enqueue implements Enqueueable {
	protected string $handle = '';
	protected bool $defer = false;

	protected int $delayMs = 0;
	protected bool $removed = false;
	// protected ?Contracts\Groupable $group = null;
	/**
	 * @var callable
	 */
	protected $showCallback = null;
	/**
	 * @var callable
	 */
	protected $removeCallback = null;

	public function __construct(string $handle) {
		$this->handle = $handle;
	}

	public static function get(string $handle): Enqueueable {
		return new static($handle);
	}

	// TODO: remove and implement downstream.
	public function delay(int $milliseconds): self {
		return $this;
	}

	public function dispatch(string $actionClass, ...$args): Enqueueable {
		$actionClass::dispatch($this, ...$args);

		return $this;
	}
}
