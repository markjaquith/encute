# Encute

WordPress plugin for fluent management of scripts and styles.

Managing scripts and styles on the front of your site can be tricky. This makes it trivial to do stuff like:

- Shove a script (and its entire connecte family) into the footer
- Defer a script or a style until page load
- Load a script `async`
- Mark a script as `type="module"`
- Mark a script as `nomodule`
- Remove some plugin script or style you don't need

## Installation

If you're using composer you can `composer require markjaquith/encute`. Else, install via Git.

## Usage

Put this in an `mu-plugins` drop-in:

```php
<?php

use CWS\Encute\Plugin;
use CWS\Encute\Script;
use CWS\Encute\Style;

add_action(Plugin::class, function (Plugin $encute) {
	$encute->debug(); // Optional: Adds HTML comments to scripts and styles, making it easier to see the handle.

	if (!is_admin()) {
    // Move jQuery to footer and defer its loading.
		Script::get('jquery')->footer()->defer();

    // Move 'some-handle' to the footer.
    Script::get('some-handle')->footer();

    // Defer 'wp-embed'.
    Script::get('wp-embed')->defer();
    
    // Make 'some-module' load as a module.
    Script::get('some-module')->module();
    
    // Make 'nomodule-fallback' load as nomodule.
    Script::get('nomodule-fallback')->noModule();
    
    // Move 'admin-bar' styles to the footer and defer their loading.
		Style::get('admin-bar')->footer()->defer();

    // Move 'wp-block-library' styles to the footer.
		Style::get('wp-block-library')->footer();
	}
});
```

## API

### Initialization

Always run code in this wrapper:

```php
add_action(\CWS\Encute\Plugin::class, function (\CWS\Encute\Plugin $encute) {
  // Your code here.
});
```

This wrapper will be a no-op if Encute is not available, and it will both wait for Encute to be available to run, and pass you Encute's main class instance.

### Script

- `static CWS\Encute\Script::get(string $handle): CWS\Encute\Script` — get a Script instance for that handle.
- `CWS\Encute\Script::module(): CWS\Encute\Script` — make the script a module.
- `CWS\Encute\Script::noModule(): CWS\Encute\Script` — make the script nomodule.
- `CWS\Encute\Script::footer(): CWS\Encute\Script` — send the script to the footer (along with its entire dependency family).
- `CWS\Encute\Script::async(): CWS\Encute\Script` — make the script async.
- `CWS\Encute\Script::defer(): CWS\Encute\Script` — make the script defer.

### Style

- `static CWS\Encute\Style::get(string $handle): CWS\Encute\Style` — get a Style instance for that handle.
- `CWS\Encute\Style::footer(): CWS\Encute\Style` — send the style to the footer (along with its entire dependency family).
- `CWS\Encute\Style::defer(): CWS\Encute\Style` — defer the style's loading.
