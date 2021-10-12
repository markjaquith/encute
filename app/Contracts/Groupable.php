<?php

namespace CWS\Encute\Contracts;

interface Groupable {
	public static function make(string $handle): self;
	public function getHandle(): string;
};
