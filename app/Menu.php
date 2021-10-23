<?php

namespace CWS\Encute;

use CWS\Encute\Tekta\Contracts\PluginData;

class Menu {
	protected Plugin $plugin;

	public function __construct(Plugin $plugin) {
		$this->plugin = $plugin;
	}
	public function boot() {
		add_action('admin_menu', [$this, 'addMenu']);
	}

	public function getSlug(): string {
		return 'encute';
	}

	public function addMenu() {
		add_submenu_page('tools.php', 'Encute', 'Encute', 'manage_options', $this->getSlug(), [$this, 'render']);
	}

	public function render() {
		$this->plugin->includeFile('templates/index.php', [
			'title' => 'Encute Code Generation',
		]);
	}
}
