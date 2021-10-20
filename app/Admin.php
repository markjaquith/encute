<?php

namespace CWS\Encute;

class Admin {
	protected Menu $menu;

	public function __construct(Menu $menu) {
		$this->menu = $menu;
	}

	public function boot() {
		$this->menu->boot();
	}
}
