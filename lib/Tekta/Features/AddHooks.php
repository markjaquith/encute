<?php

namespace CWS\Encute\Tekta\Features;

use CWS\Encute\Tekta\Contracts\AutoHook;
use CWS\Encute\Illuminate\Support\Str;

trait AddHooks {
	public function getHookArgType($arg) {
		if (is_int($arg)) {
			return 'int';
		} elseif ($arg instanceof AutoHook) {
			return 'interface';
		} elseif ($arg instanceof Closure) {
			return 'closure';
		} elseif (is_callable($arg)) {
			return 'basicCallable';
		} elseif (is_string($arg)) {
			return 'method';
		}

		return 'unknown';
	}

	/**
	 * Adds a WordPress hook (action/filter).
	 *
	 * @param mixed $hook,... First parameter is the name of the hook.
	 *                        If second or third parameters are included,
	 *                        they will be used as a priority (if an integer)
	 *                        or as a class method callback name (if a string).
	 */
	public function hook($hook = null) {
		$priority = 10;
		$args = func_get_args();

		if (is_null($hook) || !is_string($hook)) {
			if ($this instanceof AutoHook && isset($this->hook)) {
				$hook = $this->hook;
				$method = 'output';
			} else {
				trigger_error("You called hook() on a non-AutoHook object, without passing a hook", E_USER_WARNING);

				return;
			}
		} else {
			// Seems like $hook is a string, so don't consider it when iterating the args.
			array_shift($args);

			// Some WordPress hooks have dot or dash characters, which are invalid in method names.
			// It is assumed that in theses cases, the user will provide a cleaner method name, but
			// we make sure the default is a
			$method = Str::camel(str_replace(['.', '-'], ['_', '_'], $hook));
		}

		$callback = [$this, $method];

		foreach ($args as $arg) {
			$type = $this->getHookArgType($arg);

			switch ($type) {
				case 'int':
					$priority = $arg;

					break;

				case 'interface':
					$callback = [$arg, 'output'];

					break;

				case 'basicCallable':
					$callback = $arg;

					break;

				case 'closure':
					$callback = function (...$fnArgs) use ($arg) {
						$result = call_user_func($arg, ...$fnArgs);

						if ($result instanceof AutoHook) {
							// The callable yielded an object that implements the hook interface.
							return call_user_func([$result, 'output'], ...$fnArgs);
						} else {
							return $result;
						}
					};

					break;

				case 'method':
					$callback = [$this, $arg];

					break;

				default:
					trigger_error("You tried to hook an object which does not implement AutoHook", E_USER_WARNING);

					return;
			}
		}

		return \add_action($hook, $callback, $priority, 999);
	}
}
