<?php

namespace CWS\Encute\Actions;

class RemoveStyle extends Action {
	public function handle(\WP_Styles $wpStyles): void {
		foreach($this->asset->getHandles() as $handle) {
			$wpStyles->remove($handle);
		}
	}
}
