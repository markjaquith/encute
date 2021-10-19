<?php
/**
 * Plugin Name: Encute
 * Description: Fluent management of scripts and styles.
 * Version: 0.6.1
 * Author: Mark Jaquith
 * Plugin URI:
 * Author URI:
 * Requires at least: 5.8
 * Requires PHP: 7.4
 * Text Domain: encute
 * Domain Path: /languages
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/*

Encute

Copyright 2021 Mark Jaquith

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <https://www.gnu.org/licenses/>.

This software incorporates work covered by the following copyright and permission notices:

———

Tekta
Copyright 2020–2021 Mark Jaquith
(MIT License)

———

Laravel Framework
Copyright (c) Taylor Otwell
(MIT License)

*/

// Immediately trigger an error for super-old PHP versions.
if (version_compare(phpversion(), '5.6', '<')) {
	trigger_error("This plugin requires PHP 7.4 or higher", E_USER_ERROR);
} else {
	require __DIR__ . '/load.php';
}
