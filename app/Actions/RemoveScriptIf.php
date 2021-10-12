<?php

namespace CWS\Encute\Actions;

use CWS\Encute\Contracts\Enqueueable;

class RemoveScriptIf extends Action {
	protected $condition;

	public function __construct(Enqueueable $asset, $condition) {
		$this->asset= $asset;
		$this->condition = $condition;
	}

	public function handle(\WP_Scripts $wpScripts): void {
		if (call_user_func($this->condition)) {
			foreach($this->asset->getHandles() as $handle) {
				$wpScripts->remove($handle);
			}
		}
	}
}
