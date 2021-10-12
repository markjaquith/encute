<?php

namespace CWS\Encute\Actions;

class MakeScriptNoModule extends Action {
	public function handle(\WP_Scripts $wpScripts): void {
		foreach($this->asset->getHandles() as $handle) {
			add_filter('script_loader_tag', function ($tag, $currentHandle) use ($handle, $wpScripts) {
				if ($currentHandle !== $handle) {
					return $tag;
				}

				return str_replace(' src=', ' nomodule src=', $tag);
			}, 10, 2);
		}
	}
}
