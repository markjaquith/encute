<?php

namespace CWS\Encute\Tekta\Providers;

use CWS\Encute\Plugin;
use CWS\Encute\Tekta\Contracts\PluginData;
use CWS\Encute\Illuminate\Support\ServiceProvider;

class TranslationsProvider extends ServiceProvider {
	public function register() {}

	public function boot(Plugin $plugin, PluginData $data) {
		\add_action('plugins_loaded', function () {
			\load_plugin_textdomain($this->data->get('translationsDomain'), false, $this->plugin->getPath() . 'languages');
		});
	}
}
