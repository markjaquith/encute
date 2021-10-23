<?php

namespace CWS\Encute;

class Admin {
	protected Menu $menu;
	protected AdminAssets $assets;

	public function __construct(Menu $menu, AdminAssets $assets) {
		$this->menu = $menu;
		$this->assets = $assets;
	}

	public function boot() {
		$this->menu->boot();
		$this->assets->boot();
	}
}
