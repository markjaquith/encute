<?php

namespace CWS\Encute\Contracts;

interface Enqueueable {
	public function get(string $handle): self;
	public function header(): self;
	public function footer(): self;
	public function delay(int $milliseconds): self;
	public function defer(): self;
	public function showIf(callable $callback): self;
	public function hideIf(callable $callback): self;
	public function group(Groupable $group): self;
}
