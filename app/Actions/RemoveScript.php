<?php

namespace CWS\Encute\Actions;

class RemoveScript extends Action {
	public function handle(\WP_Scripts $wpScripts): void {
		foreach($this->asset->getHandles() as $handle) {
			$wpScripts->remove($handle);
		}
	}
}
