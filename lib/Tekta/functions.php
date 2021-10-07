<?php

$__tekta_files = [
	__DIR__ . '/../../app/functions.php',
	__DIR__ . '/../Mozart/packages/DI/functions.php',
];

foreach ($__tekta_files as $__tekta_file) {
	if (file_exists($__tekta_file)) {
		require $__tekta_file;
	}
}
