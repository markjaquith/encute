<?php

namespace CWS\Encute;

if (!class_exists(Tekta\RequirementsCheck::class)) {
	if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
		throw new \Exception('Please run composer install');
	}

	require __DIR__ . '/vendor/autoload.php';
}

if (Tekta\RequirementsCheck::passes(
	__DIR__ . '/index.php',
	"Encute",
	"7.4",
	"5.7"
)) {
	\add_action("plugins_loaded", [Plugin::class, 'load']);
	require __DIR__ . '/app/setup.php';
}
