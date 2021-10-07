<?php

namespace CWS\Encute\Tekta;

class PostType implements Contracts\AutoHook {
	use Features\AddHooks;

	protected $name;
	protected $args = [];
	protected $hook = 'init';

	public function __construct($name, array $args = []) {
		$this->name = $name;
		$this->args = $args;
	}

	public function output() {
		\register_post_type($this->name, $this->args);
	}
}
