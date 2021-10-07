<?php

namespace CWS\Encute\Illuminate\Contracts\Support;

interface Jsonable {
	/**
	 * Convert the object to its JSON representation.
	 *
	 * @param  int  $options
	 * @return string
	 */
	public function toJson($options = 0);
}
