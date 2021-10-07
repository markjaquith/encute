<?php

namespace CWS\Encute\Tekta\Features;

trait Translations {
	public function bootTranslations() {
		$this->hook('plugins_loaded', function () {
			$this->loadTextDomain($this->getData('translationsDomain'));
		});
	}

	protected function loadTextdomain($domain) {
		return \load_plugin_textdomain($domain, false, $this->getPath() . 'languages');
	}
}
