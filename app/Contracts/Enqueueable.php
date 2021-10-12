<?php

namespace CWS\Encute\Contracts;

interface Enqueueable {
	public function header(): Enqueueable;
	public function footer(): Enqueueable;
	public function delay(int $milliseconds): Enqueueable;
	public function defer(): Enqueueable;
	public function showIf(callable $callback): Enqueueable;
	public function removeIf(callable $callback): Enqueueable;
	// public function group(Groupable $group): Enqueueable;
	public function remove(): Enqueueable;
	// public function getName(): string;
	// public function getGroup(): ?Groupable;
	public function getNames(): array;
	public function dependencies(): ?Enqueueable;
	public function dispatch(string $actionClass, ...$args): Enqueueable;
}
