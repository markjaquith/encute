<?php

namespace CWS\Encute\Tekta\Features;

use CWS\Encute\Tekta\Contracts\PluginDataInterface;

trait Data {
	protected $tektaData;

	public function getAllData() {
		return $this->app->make(PluginDataInterface::class);
	}

	public function getData($key = null) {
		$data = $this->getAllData();

		return $key ? $data[$key] : $data;
	}
}
