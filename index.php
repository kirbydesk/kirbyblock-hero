<?php

// Ensure pwConfig is available when plugins are loaded in alphabetical order
// (manual installation has no composer autoloader — load order depends on filesystem)
if (!class_exists('pwConfig')) {
	$pagewizardConfig = __DIR__ . '/../kirby-pagewizard/src/helpers/blocks/config.php';
	if (file_exists($pagewizardConfig)) {
		require_once $pagewizardConfig;
	}
}

pwConfig::register('pwhero', __DIR__ . '/src/config');

Kirby::plugin('kirbydesk/kirbyblock-hero', [
	/* -------------- Extensions --------------*/
	'blueprints' => require_once 'src/extensions/blueprints.php',
	'snippets' => require_once 'src/extensions/snippets.php',
	'translations' => require_once 'src/extensions/translations.php'
]);