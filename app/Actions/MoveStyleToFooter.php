<?php

namespace CWS\Encute\Actions;

class MoveStyleToFooter extends Action {
	protected function move(\WP_Styles $wpStyles, string $name) {
		if (wp_style_is($name, 'registered')) {
			$dependencies = $wpStyles->registered[$name]->deps;
			$style = $wpStyles->registered[$name];
			wp_deregister_style($name);
			add_action('wp_head', fn() => $wpStyles->registered[$name] = $style, PHP_INT_MAX);

			foreach ((array) $dependencies as $dependency) {
				$this->move($wpStyles, $dependency);
			}
		}
	}

	public function handle(\WP_Styles $wpStyles): void {
		$this->move($wpStyles, $this->name);
	}
}
