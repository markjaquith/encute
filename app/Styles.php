<?php

namespace CWS\Encute;

class Styles extends Enqueues implements Contracts\Styles {
	public function get(string $name): Style {
		$style = new Style($name);
		$this->add($style);

		return $style;
	}
}
