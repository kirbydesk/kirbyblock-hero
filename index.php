<?php

pwConfig::register('pwhero', __DIR__ . '/src/config');

Kirby::plugin('kirbydesk/kirbyblock-hero', [

	/* -------------- Extensions --------------*/
	'blueprints' => require_once 'src/extensions/blueprints.php',
	'snippets' => require_once 'src/extensions/snippets.php',
	'translations' => require_once 'src/extensions/translations.php'
]);