<?php

namespace CWS\Encute\Actions;

class MoveScriptToFooter extends Action {
	protected string $name;

	public function __construct(string $name) {
		$this->name = $name;
	}

	public function moveToFooterRecursively(\WP_Scripts $wpScripts, string $name) {
		if (wp_script_is($name, 'registered')) {
			$src = $wpScripts->registered[$name]->src;
			$version = $wpScripts->registered[$name]->ver;
			$dependencies = $wpScripts->registered[$name]->deps;
			wp_deregister_script($name);
			wp_register_script($name, $src, $dependencies, $version, true);

			foreach ((array) $dependencies as $dependency) {
				$this->moveToFooterRecursively($wpScripts, $dependency);
			}
		}
	}

	public function handle(\WP_Scripts $wpScripts): void {
		$this->moveToFooterRecursively($wpScripts, $this->name);
	}
}
