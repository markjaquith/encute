<?php

namespace CWS\Encute\Tekta\Admin;

use CWS\Encute\Tekta\Contracts\AutoHook;

class Notice implements AutoHook {
	use \CWS\Encute\Tekta\Features\AddHooks;

	public $text = '';
	public $type = 'info';
	public $isDismissible = true;
	public $wrap = true;
	public $hook = 'admin_notices';

	public function __construct($text = '') {
		$this->text = $text;
	}

	public static function __callStatic($method, $args) {
		switch($method) {
			case "error":
			case "warning":
			case "success":
			case "info":
				$instance = call_user_func_array([new \ReflectionClass(static::class), 'newInstance'], $args);
				$instance->type = $method;
				return $instance;
				break;
		}

		return false;
	}

	public function __get($name) {
		switch($name) {
			case 'persistent':
				$this->isDismissible = false;
				break;
			case 'noWrap':
				$this->wrap = false;
				break;
		}

		return $this;
	}

	public function noWrap() {
		$this->wrap = false;
	}

	public function output() {
		$classes = ['notice', 'notice-' . $this->type];

		if ($this->isDismissible) {
			$classes[] = 'is-dismissible';
		}

		echo '<div class="' . \esc_attr(implode(' ', $classes)) . '">';
		echo $this->wrap ? '<p>' : '';
		echo $this->text;
		echo $this->wrap ? '</p>' : '';
		echo '</div>';
	}
}
