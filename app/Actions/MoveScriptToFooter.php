<?php

namespace CWS\Encute\Actions;

class MoveScriptToFooter extends Action {
	public function handle(\WP_Scripts $wpScripts): void {
		foreach ($this->asset->getHandles() as $handle) {
			if (wp_script_is($handle, 'registered')) {
				$script = $wpScripts->registered[$handle];
				wp_deregister_script($handle);
				add_action('wp_head', fn() => $wpScripts->registered[$handle] = $script, PHP_INT_MAX);
			}
		}
	}
}
