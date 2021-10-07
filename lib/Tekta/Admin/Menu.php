<?php

namespace CWS\Encute\Tekta\Admin;

use CWS\Encute\Tekta\Contracts\AutoHook;
use CWS\Encute\Tekta\Features\AddHooks;

class Menu implements AutoHook {
	use AddHooks;

	protected $title;
	protected $capability;
	protected $page;
	protected $icon;
	protected $hook = 'admin_menu';

	public function __construct(
		$title,
		$capability,
		Page $page,
		$icon = ''
	) {
		$this->title = $title;
		$this->capability = $capability;
		$this->page = $page;
		$this->icon = $icon;
	}

	public function output() {
		$this->page->addData(['title' => $this->title]);
		$hook = \add_menu_page(
			$this->title, // Page Title.
			$this->title, // Menu Title.
			$this->capability,
			\sanitize_title_with_dashes($this->title), // The slug, for the URL.
			[$this->page, 'output'],
			$this->icon,  // Icon.
			5 // Position.
		);

		$this->hook('load-' . $hook, [$this->page, 'enqueueScripts']);
		$this->hook('load-' . $hook, [$this->page, 'enqueueStyles']);
		$this->hook('load-' . $hook, [$this->page, 'load']);
	}
}
