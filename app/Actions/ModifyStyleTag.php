<?php

namespace CWS\Encute\Actions;

abstract class ModifyStyleTag extends Action {
	abstract public function modifyTag(string $tag): string;

	public function handle(\WP_Styles $wpStyles): void {
		foreach ($this->asset->getHandles() as $handle) {
			add_filter('style_loader_tag', function ($tag, $currentHandle) use ($handle, $wpStyles) {
				if ($currentHandle !== $handle) {
					return $tag;
				}

				return $this->modifyTag($tag);
			}, 10, 2);
		}
	}
}
