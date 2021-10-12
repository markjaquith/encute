<?php

namespace CWS\Encute\Actions;

abstract class ModifyScriptTag extends Action {
	abstract public function modifyTag(string $tag): string;

	public function handle(\WP_Scripts $wpScripts): void {
		foreach($this->asset->getHandles() as $handle) {
			add_filter('script_loader_tag', function ($tag, $currentHandle) use ($handle, $wpScripts) {
				if ($currentHandle !== $handle) {
					return $tag;
				}

				return $this->modifyTag($tag);
			}, 10, 2);
		}
	}
}
