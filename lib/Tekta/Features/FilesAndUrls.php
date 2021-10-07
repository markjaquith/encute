<?php

namespace CWS\Encute\Tekta\Features;

trait FilesAndUrls {
	/**
	 * Includes a file (relative to the plugin base path)
	 * and optionally globalizes a named array passed in.
	 *
	 * @param  string $file the file to include
	 * @param  array  $data a named array of data to globalize
	 */
	public function includeFile($file, $data = []) {
		extract($data, EXTR_SKIP);

		return include $this->getPath() . $file;
	}

	/**
	 * Includes a file (relative to the plugin base path)
	 * and returns its output, and optionally globalizes
	 * a named array passed in.
	 *
	 * @param [type] $file
	 * @param array $data
	 * @return void
	 */
	public function getFileOutput($file, $data = []) {
		ob_start();
		$this->includeFile($file, $data);

		return ob_get_clean();
	}

	/**
	 * Returns the URL to the plugin's directory.
	 *
	 * @param  string $relativePath The relative path to append to the plugin URL.
	 * @return string The URL to the plugin's directory.
	 */
	public function getUrl($relativePath = '') {
		return \plugin_dir_url($this->file) . $relativePath;
	}

	/**
	 * Returns the path to the plugin's directory (with trailing slash).
	 *
	 * @param  string $relativePath The relative path to append to the plugin path.
	 * @return string The absolute path to the plugin directory.
	 */
	public function getPath($relativePath = '') {
		return \plugin_dir_path($this->file) . $relativePath;
	}
}
