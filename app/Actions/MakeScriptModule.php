<?php

namespace CWS\Encute\Actions;

class MakeScriptModule extends Action {
	public function handle(\WP_Scripts $wpScripts): void {
		add_filter('script_loader_tag', function ($tag, $handle) use ($wpScripts) {
			if ($handle !== $this->name) {
				return $tag;
			}

			return str_replace(' src=', ' type="module" src=', $tag);
		}, 10, 2);
	}
}
