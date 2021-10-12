<?php

namespace CWS\Encute\Actions;

class MoveStyleToFooter extends Action {
	protected function move(\WP_Styles $wpStyles, string $handle) {
		if (wp_style_is($handle, 'registered')) {
			$dependencies = $wpStyles->registered[$handle]->deps;
			$style = $wpStyles->registered[$handle];
			wp_deregister_style($handle);
			add_action('wp_head', fn() => $wpStyles->registered[$handle] = $style, PHP_INT_MAX);

			foreach ((array) $dependencies as $dependency) {
				$this->move($wpStyles, $dependency);
			}
		}
	}

	public function handle(\WP_Styles $wpStyles): void {
		foreach ($this->asset->getHandles() as $handle) {
			$this->move($wpStyles, $handle);
		}
	}
}
