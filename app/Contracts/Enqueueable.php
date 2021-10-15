<?php

namespace CWS\Encute\Contracts;

interface Enqueueable {
	public function footer(): Enqueueable;
	// public function delay(int $milliseconds): Enqueueable;
	public function defer(): Enqueueable;
	// public function keepIf(callable $callback): Enqueueable;
	// public function removeIf(callable $callback): Enqueueable;
	public function remove(): Enqueueable;
	public function getHandles(): array;
	public function dispatch(string $actionClass, ...$args): Enqueueable;
	public static function get(string $handle): Enqueueable;
}
