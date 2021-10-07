<?php

namespace CWS\Encute\Tekta;

/**
 * Provides a plugin activation gate based on PHP and WordPress versions.
 */
class RequirementsCheck {
	/**
	 * The main plugin file.
	 *
	 * @var string
	 */
	protected $file;

	/**
	 * The name of the plugin.
	 *
	 * @var string.
	 */
	protected $name;

	/**
	 * The minimum PHP version.
	 *
	 * @var string
	 */
	protected $phpVersion;

	/**
	 * The minimum WordPress version.
	 *
	 * @var string
	 */
	protected $wpVersion;

	/**
	 * Contructs a new RequirementsCheck object.
	 *
	 * @param string $file
	 * @param string $name
	 * @param string $phpVersion
	 * @param string $wpVersion
	 */
	public function __construct($file, $name, $phpVersion, $wpVersion) {
		$this->file = $file;
		$this->name = $name;
		$this->phpVersion = $phpVersion;
		$this->wpVersion = $wpVersion;
	}

	/**
	 * Constructs a new RequirementsCheck object and immediately performs the checks.
	 *
	 * Note: this has side effects if the checks fail — one or two notices will be
	 * added to the `admin_notices` hook (priority 1), and the plugin will then be
	 * deactivated  (priority 11).
	 *
	 * @param string $file
	 * @param string $name
	 * @param string $phpVersion
	 * @param string $wpVersion
	 * @return bool Whether the PHP and WordPress versions meet the requirements.
	 */
	public static function passes($file, $name, $phpVersion, $wpVersion) {
		$instance = new static($file, $name, $phpVersion, $wpVersion);

		return $instance->_passes();
	}

	/**
	 * Whether the PHP and WordPress versions meet the requirements.
	 *
	 * Note: this has side effects if the checks fail — one or two notices will be
	 * added to the `admin_notices` hook (priority 1), and the plugin will then be
	 * deactivated  (priority 11).
	 *
	 * @return bool
	 */
	protected function _passes() {
		$passesPhp  = \version_compare(\phpversion(), $this->phpVersion, '>=');
		$passesWp   = \version_compare(\get_bloginfo('version'), $this->wpVersion, '>=');
		$passesBoth = $passesPhp && $passesWp;

		$passesPhp  || \add_action('admin_notices', [$this, 'phpVersionNotice'], 10);
		$passesWp   || \add_action('admin_notices', [$this, 'wpVersionNotice'],  10);
		$passesBoth || \add_action('admin_notices', [$this, 'deactivate'],       11);

		return $passesBoth;
	}

	/**
	 * Deactivates the checked plugin.
	 *
	 * @return void
	 */
	public function deactivate() {
		\deactivate_plugins(
			\plugin_basename($this->file)
		);
	}

	/**
	 * Prints a notice about the PHP version being too low.
	 *
	 * @return void
	 */
	public function phpVersionNotice() {
		echo '<div class="error">';
		echo '<p>The &#8220;' . \esc_html($this->name) . '&#8221; plugin cannot run on PHP versions older than ' . \esc_html($this->phpVersion) . '. Please contact your host and ask them to upgrade.</p>';
		echo '</div>';
	}

	/**
	 * Prints a notice about the WordPress version being too low.
	 *
	 * @return void
	 */
	public function wpVersionNotice() {
		echo '<div class="error">';
		echo '<p>The &#8220;' . \esc_html($this->name) . '&#8221; plugin cannot run on WordPress versions older than ' . \esc_html($this->wpVersion) . '. Please update WordPress.</p>';
		echo '</div>';
	}
}
