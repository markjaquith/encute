<?php

namespace CWS\Encute\Actions;

class MakeScriptModule extends ModifyScriptTag {
	public function modifyTag(string $tag): string {
		$tag = str_replace(' type="text/javascript" ', ' ', $tag);
		$tag = str_replace(" type='text/javascript' ", ' ', $tag);

		return str_replace(' src=', ' type="module" src=', $tag);
	}
}
