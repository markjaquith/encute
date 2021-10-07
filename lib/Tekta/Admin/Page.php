<?php

namespace CWS\Encute\Tekta\Admin;

use CWS\Encute\Tekta\Style;
use CWS\Encute\Tekta\Script;
use CWS\Encute\Tekta\Features\AddHooks;
use CWS\Encute\Tekta\Contracts\AutoHook;

class Page implements AutoHook {
	use AddHooks;

	protected $scripts = [];
	protected $styles = [];
	protected $data = [];

	protected $template;

	public function __construct($template) {
		$this->template = $template;
	}

	public function output() {
		extract($this->getData());
		include($this->template);
	}

	public function addScript(Script $script) {
		$this->scripts[] = $script;

		return $this;
	}

	public function addStyle(Style $style) {
		$this->styles[] = $style;

		return $this;
	}

	public function addData($data = []) {
		foreach ($data as $key => $value) {
			$this->data[$key] = $value;
		}

		return $this;
	}

	public function getData() {
		return array_map(
			function ($value) {
				return is_callable($value) ? call_user_func($value) : $value;
			},
			$this->data
		);
	}

	public function enqueueAll($things) {
		foreach ($things as $thing) {
			$thing->enqueue();
		}
	}

	public function enqueueScripts() {
		return $this->enqueueAll($this->scripts);
	}

	public function enqueueStyles() {
		return $this->enqueueAll($this->styles);
	}

	public function load() {
	}
}
