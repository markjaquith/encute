<?php

namespace CWS\Encute;

use CWS\Encute\Tekta\Contracts\PluginData;

class Menu {
	protected Plugin $plugin;
	protected PluginData $data;

	public function __construct(Plugin $plugin, PluginData $data) {
		$this->plugin = $plugin;
		$this->data = $data;
	}
	public function boot() {
		add_action('admin_menu', [$this, 'addMenu']);
	}

	public function addMenu() {
		add_submenu_page('tools.php', 'Encute', 'Encute', 'manage_options', 'encute', [$this, 'render']);
	}

	public function render() {
		$this->plugin->includeFile('templates/index.php', [
			'title' => 'Encute Code Generation',
			'scriptSrc' => $this->plugin->getUrl('dist/main.js?v=' . $this->data->get('version')),
			'styleSrc' => $this->plugin->getUrl('dist/styles.css?v=' . $this->data->get('version')),
		]);
	}
}
