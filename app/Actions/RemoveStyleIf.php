<?php

namespace CWS\Encute\Actions;

use CWS\Encute\Contracts\Enqueueable;

class RemoveStyleIf extends Action {
	protected $condition;

	public function __construct(Enqueueable $asset, $condition) {
		$this->asset= $asset;
		$this->condition = $condition;
	}

	public function handle(\WP_Styles $wpStyles): void {
		if (call_user_func($this->condition)) {
			foreach($this->asset->getHandles() as $handle) {
				$wpStyles->remove($handle);
			}
		}
	}
}
