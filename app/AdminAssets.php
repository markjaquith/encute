<?php

namespace CWS\Encute;

use CWS\Encute\Tekta\Contracts\PluginData;

class AdminAssets {
	protected Plugin $plugin;
	protected PluginData $data;

	public function __construct(Plugin $plugin, PluginData $data) {
		$this->plugin = $plugin;
		$this->data = $data;
	}
	public function boot() {
		add_action('admin_enqueue_scripts', [$this, 'enqueueAssets']);
	}

	public function enqueueAssets(string $adminPageSlug): void {
		if ($adminPageSlug !== 'tools_page_encute') {
			return;
		}

		wp_enqueue_script(
			'encute-main',
			$this->plugin->getUrl('dist/main.js'),
			[],
			$this->data->get('version'),
			true
		);

		wp_enqueue_style(
			'encute-main',
			$this->plugin->getUrl('dist/styles.css'),
			[],
			$this->data->get('version')
		);
	}
}
