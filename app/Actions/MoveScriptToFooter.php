<?php

namespace CWS\Encute\Actions;

class MoveScriptToFooter extends Action {
	protected function move(\WP_Scripts $wpScripts, string $handle) {
		if (wp_script_is($handle, 'registered')) {
			$src = $wpScripts->registered[$handle]->src;
			$version = $wpScripts->registered[$handle]->ver;
			$dependencies = $wpScripts->registered[$handle]->deps;
			wp_deregister_script($handle);
			wp_register_script($handle, $src, $dependencies, $version, true);
		}
	}

	public function handle(\WP_Scripts $wpScripts): void {
		foreach ($this->asset->getHandles() as $handle) {
			$this->move($wpScripts, $handle);
		}
	}
}
