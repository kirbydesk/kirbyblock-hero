<?php return [ 'blocks/pwhero' => function () {

    /* -------------- Config --------------*/
    $config   = pwConfig::load('pwhero');
    $settings = $config['content'];
    $tabSettings = $config['tabs'];
		$defaults    = $config['defaults'];
		$fields      = $config['fields'];
		$editor      = $config['editor'];

		/* -------------- Allowed Fields --------------*/
		$defaultTagline = !empty($settings['tagline']);
		$defaultHeading = !empty($settings['heading']);
		$defaultEditor = !empty($settings['editor']);
		$defaultButtons = !empty($settings['buttons']);

		/* -------------- Tabs --------------*/
    $tabs = [];

		/* -------------- Content Tab --------------*/
		$contentFields = [
			'headlineContent' => ['extends' => 'pagewizard/headlines/content'],
		];

		/* -------------- Tagline --------------*/
		if ($defaultTagline) {
			$contentFields['tagline'] = [
				'extends' => 'pagewizard/fields/tagline',
				'align'   => $fields['align-tagline'],
			];
		}
		/* -------------- Heading --------------*/
		if ($defaultHeading) {
			$contentFields['heading'] = [
				'extends' => 'pagewizard/fields/heading',
				'align'   => $fields['align-heading'],
				'size'   => 'normal'
			];
		}
		/* -------------- Editor --------------*/
		if ($defaultEditor) {
			$contentFields['editor'] = pwEditor::contentField($defaults, $editor, $settings, $fields);
			$contentFields['editor']['size'] = 'normal';
		}
		/* -------------- Buttons --------------*/
		if ($defaultButtons) {
			$contentFields['buttonsAlignment'] = [
				'type'    => 'pwalign',
				'align'   => $fields['align-buttons'],
				'default' => $fields['align-buttons'],
			];
			$contentFields['buttons'] = [
				'extends' => 'blocks/pwButtons',
			];
		}

		$tabs['content'] = [
			'label'  => 'pw.tab.content',
			'fields' => $contentFields,
		];

		/* -------------- Layout Tab --------------*/
		pwConfig::addTab($tabs, 'layout', $tabSettings['layout'] ?? true, pwLayout::options('pwhero', $defaults, [
			'headlineContentposition' => ['extends' => 'pagewizard/headlines/contentposition'],
			'positionHorizontal' => [
				'extends' => 'pagewizard/fields/position-horizontal',
				'default' => $defaults['horizontal-content-position']
			],
			'positionVertical' => [
				'extends' => 'pagewizard/fields/position-vertical',
				'default' => $defaults['vertical-content-position']
			],
		], $config['layout'] ?? []));

		/* -------------- Style Tab --------------*/
		pwConfig::addTab($tabs, 'style', $tabSettings['style'] ?? true, pwStyle::options('pwhero', $defaults, [
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
				'query' => 'page.images.template("pwBackgroundimage")',
				'when'    => [
					'backgroundType' => 'image'
				]
			],
			'video' => [
				'extends' => 'pagewizard/fields/video',
				'width' => '1/1',
				'uploads' => 'pwVideo',
				'query' => 'page.videos.template("pwVideo")',
				'when'    => [
					'backgroundType' => 'video'
				]
			]
		], $config['style'] ?? []));

		/* -------------- Effects Tab --------------*/
		pwConfig::addTab($tabs, 'effects', $tabSettings['effects'] ?? true, [
			'label'  => 'pw.tab.effects',
			'fields' => [
				'headlineEffects' => ['extends' => 'pagewizard/headlines/effects'],
				'blurImage' => [
					'extends' => 'pagewizard/fields/blur',
					'when'    => [
						'backgroundType' => 'image'
					]
				],
				'blurVideo' => [
					'extends' => 'pagewizard/fields/blur',
					'when'    => [
						'backgroundType' => 'video'
					]
				],
				'overlayType' => [
					'extends' => 'pagewizard/fields/overlay-type',
				],
				'overlayIntensity' => [
					'extends' => 'pagewizard/fields/overlay-intensity',
					'when'    => [
						'overlayType' => 'solid'
					]
				],
				'overlayGradientIntensity' => [
					'extends' => 'pagewizard/fields/overlay-intensity',
					'when'    => [
						'overlayType' => 'gradient'
					]
				],
				'overlaySize' => [
					'extends' => 'pagewizard/fields/overlay-size',
					'when'    => [
						'overlayType' => 'gradient'
					]
				],
				'overlayPosition' => [
					'extends' => 'pagewizard/fields/overlay-position',
					'when'    => [
						'overlayType' => 'gradient'
					]
				]
			]
		]);

		/* -------------- Grid Tab --------------*/
		pwConfig::addTab($tabs, 'grid', $tabSettings['grid'] ?? false, pwGrid::layout('pwhero', $defaults));

		/* -------------- Settings Tab --------------*/
		pwConfig::addTab($tabs, 'settings', $tabSettings['settings'] ?? true, pwSettings::options('pwhero', $defaults, [], $config['settings'] ?? []));

		/* -------------- Blueprint --------------*/
		return [
			'name'	=> 'kirbyblock-hero.name',
			'icon'  => 'star',
			'tabs'	=> $tabs
		];
	}
];
