<?php

namespace CWS\Encute\Contracts;

interface EnqueueableScript extends Enqueueable {
	public function module(): self;
	public function noModule(): self;
	public function async(): self;
}
