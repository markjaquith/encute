=== Encute ===
Contributors: markjaquith
Tags: scripts, styles, performance
Requires at least: 5.8
Tested up to: 5.8.1
Requires PHP: 7.4
Stable tag: 0.8.8
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/old-licenses/gpl-2.0.html

Fluent API for site owners to manipulate the scripts and styles on the frontend of their site.

== Description ==
Encute provides a fluent, declarative API for site owners to manipulate the scripts and styles that WordPress, themes, and plugins shove onto their site. Move things into the footer, defer loading, remove assets entirely. Or load scripts async, or as modules, or as nomodule!

Here's an example of how you could use the plugin:

    <?php

    use CWS\Encute\{ Plugin, Script, Style };

    add_action(Plugin::class, function (Plugin $plugin) {
    	$isContactPage = fn () => is_page('contact');
    	Script::get('contact-form-7')->keepIf($isContactPage)->footer()->defer();
    	Style::get('contact-form-7')->keepIf($isContactPage)->footer()->defer();

    	Style::get(['mediaelement', 'wp-mediaelement'])->footer()->defer();
    	Style::get('material-icons')->defer();
    	Script::get('jquery')->remove();
    });

## Wrapper

Always run code in this wrapper:

    add_action(\CWS\Encute\Plugin::class, function (\CWS\Encute\Plugin $encute) {
    	// Your code here.
    });

This wrapper will be a no-op if Encute is not available, and it will both wait for Encute to be available to run, and pass you Encute's main class instance.

## Fluency

Both `Script::get()` and `Style::get()` return an instance of themselves, as do all calls to their methods, so you can just chain your calls.

## Script

* `static CWS\Encute\Script::get(string $handle): CWS\Encute\Script` — get a Script instance for that handle.
* `CWS\Encute\Script::module(): CWS\Encute\Script` — make the script a module.
* `CWS\Encute\Script::noModule(): CWS\Encute\Script` — make the script nomodule.
* `CWS\Encute\Script::footer(): CWS\Encute\Script` — send the script to the footer (along with its entire dependency family).
* `CWS\Encute\Script::async(): CWS\Encute\Script` — make the script async.
* `CWS\Encute\Script::defer(): CWS\Encute\Script` — make the script defer.
* `CWS\Encute\Script::remove(): CWS\Encute\Script` — remove the script.
* `CWS\Encute\Script::removeIf(callable $callback): CWS\Encute\Script` — remove the script if the callback resolves as true.
* `CWS\Encute\Script::keepIf(callable $callback): CWS\Encute\Script` — keep the script if the callback resolves as true (else remove it).

## Style

* `static CWS\Encute\Style::get(string $handle): CWS\Encute\Style` — get a Style instance for that handle.
* `CWS\Encute\Style::footer(): CWS\Encute\Style` — send the style to the footer (along with its entire dependency family).
* `CWS\Encute\Style::defer(): CWS\Encute\Style` — defer the style's loading.
* `CWS\Encute\Style::remove(): CWS\Encute\Style` — remove the style.
* `CWS\Encute\Style::removeIf(callable $callback): CWS\Encute\Style` — remove the style if the callback resolves as true.
* `CWS\Encute\Style::keepIf(callable $callback): CWS\Encute\Style` — keep the style if the callback resolves as true (else remove it).

== Frequently Asked Questions ==
= How do I use this? =

Go to Tools > Encute and you'll be guided through code generation.

= Can't I do this through a UI? =

Not currently. This is a pro-level tool. You need to know what you're doing. If writing code isn't for you, then this plugin probably isn't for you.

== Screenshots ==

1. Code generation inside the plugin.
