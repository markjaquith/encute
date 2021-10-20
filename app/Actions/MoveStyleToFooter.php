<?php

namespace CWS\Encute\Actions;

class MoveStyleToFooter extends Action {
	public function handle(\WP_Styles $wpStyles): void {
		foreach ($this->asset->getHandles() as $handle) {
			if (wp_style_is($handle, 'registered')) {
				$style = $wpStyles->registered[$handle];
				wp_deregister_style($handle);
				add_action('wp_head', fn() => $wpStyles->registered[$handle] = $style, PHP_INT_MAX);
			}
		}
	}
}
