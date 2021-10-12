<?php

namespace CWS\Encute\Actions;

class MakeScriptDefer extends ModifyScriptTag {
	public function modifyTag(string $tag): string {
		return str_replace(' src=', ' defer src=', $tag);
	}
}
