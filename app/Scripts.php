<?php

namespace CWS\Encute;

class Scripts extends Enqueues implements Contracts\Scripts {
	public function get(string $name): Script {
		$script = new Script($name);
		$this->add($script);

		return $script;
	}
}
