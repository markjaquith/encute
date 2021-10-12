<?php

namespace CWS\Encute;

class Styles extends Enqueues implements Contracts\Styles {
	public function get(string $handle): Style {
		$style = new Style($handle);
		$this->add($style);

		return $style;
	}
}
