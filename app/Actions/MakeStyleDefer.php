<?php

namespace CWS\Encute\Actions;

class MakeStyleDefer extends ModifyStyleTag {
	public function modifyTag(string $tag): string {
		$originalTag = $tag;
		$tag = preg_replace('# rel=([\'"])[^\\1]+?\\1 #', ' ', $tag);
		$tag = str_replace(' href=', ' rel="preload" as="style" onload="this.onload=null;this.rel=\'stylesheet\'" href=', $tag);

		return $tag . "\n\t" . '<noscript>' . "\n\t\t" . $originalTag . "\t" . '</noscript>' . "\n";
	}
}
