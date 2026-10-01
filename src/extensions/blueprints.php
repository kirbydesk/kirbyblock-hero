<?php return [
	'blocks/pwhero' => pwBlueprint::main('pwhero', function ($cfg) {
		$defaults   = $cfg['defaults'];
		$effectsVis = $cfg['effects'];

		// Effects Tab (conditional fields for blur + overlay)
		$effectsFields = ['headlineEffects' => ['extends' => 'pagewizard/headlines/effects']];
		if (!empty($effectsVis['blur'])) {
			$effectsFields['blurImage'] = ['extends' => 'pagewizard/fields/blur', 'when' => ['backgroundType' => 'image']];
			$effectsFields['blurVideo'] = ['extends' => 'pagewizard/fields/blur', 'when' => ['backgroundType' => 'video']];
		}
		if (!empty($effectsVis['overlay'])) {
			$effectsFields['overlayType']              = ['extends' => 'pagewizard/fields/overlay-type'];
			// the strength: a range with a square in the variant's overlay colour
			$strength = ['type' => 'pwoverlay', 'block' => 'pwhero', 'swatch' => 'overlay'];
			$effectsFields['overlayIntensity']         = ['extends' => 'pagewizard/fields/overlay-intensity',  'when' => ['overlayType' => 'solid']] + $strength;
			$effectsFields['overlayGradientIntensity'] = ['extends' => 'pagewizard/fields/overlay-intensity',  'when' => ['overlayType' => 'gradient']] + $strength;
			// the gradient's width (left/right) or height (top/bottom), 10–100 %
			$effectsFields['overlayWidth']             = ['extends' => 'pagewizard/fields/overlay-width',      'when' => ['overlayType' => 'gradient']];
			// (the former steps – small, medium … –, kept for heroes from before
			// without a width: the frontend reads them as 25, 50, 75, 100 %)
			$effectsFields['overlaySize']              = ['type' => 'hidden'];
			$effectsFields['overlayPosition']          = ['extends' => 'pagewizard/fields/overlay-position',   'when' => ['overlayType' => 'gradient']];
		}

		return [
			'name'          => 'kirbyblock-hero.name',
			'icon'          => 'star',
			'contentFields' => pwBlueprint::stdContent($cfg, ['tagline', 'heading', 'editor', 'buttons']),
			'layoutExtras'  => [
				'headlineContentposition' => ['extends' => 'pagewizard/headlines/contentposition'],
				'positionHorizontal' => [
					'extends' => 'pagewizard/fields/position-horizontal',
					'default' => $defaults['position-horizontal']
				],
				'positionVertical' => [
					'extends' => 'pagewizard/fields/position-vertical',
					'default' => $defaults['position-vertical']
				],
			],
			'styleExtras' => [
				'backgroundType' => [
					'extends' => 'pagewizard/fields/background-type',
					'default' => $defaults['background-type']
				],
				'height' => [
					'extends' => 'pagewizard/fields/height',
					'default' => $defaults['height']
				],
				'image' => [
					'extends' => 'pagewizard/fields/image',
					'uploads' => 'pwBackgroundimage',
					'query'   => 'page.images.template("pwBackgroundimage")',
					'when'    => ['backgroundType' => 'image']
				],
				'video' => [
					'extends' => 'pagewizard/fields/video',
					'width'   => '1/1',
					'uploads' => 'pwVideo',
					'query'   => 'page.videos.template("pwVideo")',
					'when'    => ['backgroundType' => 'video']
				],
			],
			'extraTabs' => [
				'effects' => [
					'label'  => 'pw.tab.effects',
					'fields' => $effectsFields,
				],
			],
		];
	}),
];
