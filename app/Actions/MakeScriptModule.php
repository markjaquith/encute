<?php

namespace CWS\Encute\Actions;

class MakeScriptModule extends Action {
	public function handle(\WP_Scripts $wpScripts): void {
		foreach($this->asset->getHandles() as $handle) {
			add_filter('script_loader_tag', function ($tag, $currentHandle) use ($handle, $wpScripts) {
				if ($currentHandle !== $handle) {
					return $tag;
				}
				$tag = str_replace(' type="text/javascript" ', ' ', $tag);
				$tag = str_replace(" type='text/javascript' ", ' ', $tag);
				return str_replace(' src=', ' type="module" src=', $tag);
			}, 10, 2);
		}
	}
}
