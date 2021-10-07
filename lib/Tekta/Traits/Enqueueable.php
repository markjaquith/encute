<?php

namespace CWS\Encute\Tekta\Traits;

trait Enqueueable {
	protected $url;
	protected $version;
	protected $dependencies = [];

	public function __construct($url, $version, array $dependencies = []) {
		$this->url = $url;
		$this->version = $version;
		$this->dependencies = $dependencies;
	}

	public function enqueue() {
		$func = "\wp_enqueue_" . $this->type;
		$func(
			$this->getHandle(),
			$this->url,
			$this->dependencies,
			$this->version,
			$this->lastParam
		);
	}

	public function getHandle() {
		return md5($this->url . ':' . $this->version);
	}
}
