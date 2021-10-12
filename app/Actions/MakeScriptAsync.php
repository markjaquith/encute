<?php

namespace CWS\Encute\Actions;

class MakeScriptAsync extends ModifyScriptTag {
	public function modifyTag(string $tag): string {
		return str_replace(' src=', ' async src=', $tag);
	}
}
