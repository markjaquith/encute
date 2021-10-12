<?php

namespace CWS\Encute\Actions;

class MakeScriptNoModule extends ModifyScriptTag {
	public function modifyTag(string $tag): string {
		return str_replace(' src=', ' nomodule src=', $tag);
	}
}
