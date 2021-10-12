<?php

namespace CWS\Encute;

class Scripts extends Enqueues implements Contracts\Scripts {
	public function get(string $handle): Script {
		$script = new Script($handle);
		$this->add($script);

		return $script;
	}
}
