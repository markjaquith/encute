<?php

namespace CWS\Encute\Contracts;

interface Enqueueable {
	public function header(): self;
	public function footer(): self;
	public function delay(int $milliseconds): self;
	public function defer(): self;
	public function showIf(callable $callback): self;
	public function removeIf(callable $callback): self;
	// public function group(Groupable $group): self;
	public function remove(): self;
	// public function getName(): string;
	// public function getGroup(): ?Groupable;
}
