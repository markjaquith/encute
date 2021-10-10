<?php

namespace CWS\Encute\Contracts;

interface Groupable {
	public static function make(string $name): self;
	public function getName(): string;
};
