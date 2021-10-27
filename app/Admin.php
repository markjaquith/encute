<?php

namespace CWS\Encute;

class Admin {
	protected Menu $menu;
	protected AdminAssets $assets;
	protected $hideUi = false;

	public function __construct(Menu $menu, AdminAssets $assets) {
		$this->menu = $menu;
		$this->assets = $assets;
	}

	public function hideUi(): void {
		$this->hideUi = true;
	}

	public function boot() {
		add_action(Plugin::class, function () {
			if (!$this->hideUi) {
				$this->menu->boot();
				$this->assets->boot();
			}
		}, PHP_INT_MAX);
	}
}
