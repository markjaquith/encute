<?php

namespace CWS\Encute\Tekta\Features;

use CWS\Encute\Tekta\Script;
use CWS\Encute\Tekta\Style;

trait ScriptsAndStyles {
	protected function makeScript($path, $dependencies = []) {
		return new Script($this->getUrl($path), $this->getData('version'), $dependencies);
	}

	protected function makeStyle($path, $dependencies = []) {
		return new Style($this->getUrl($path), $this->getData('version'), $dependencies);
	}
}
