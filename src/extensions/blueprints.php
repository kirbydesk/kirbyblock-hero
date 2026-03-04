<?php return [ 'blocks/pwhero' => function () {

    /* -------------- Config --------------*/
    $config       = pwConfig::load('pwhero');
    $settings     = $config['content'];
    $tabSettings  = $config['tabs'];
		$defaults     = $config['defaults'];
		$fields       = $config['fields'];
		$editor       = $config['editor'];
		$fieldOptions = $config['field-options'];
		$effectsVis   = $config['effects'];


		/* -------------- Tabs --------------*/
    $tabs = [];

		/* -------------- Content Tab --------------*/
		$contentFields = [
			'headlineContent' => ['extends' => 'pagewizard/headlines/content'],
		];

		/* -------------- Tagline --------------*/
		if (!empty($settings['tagline'])) {
			$contentFields['tagline'] = [
				'extends'      => 'pagewizard/fields/tagline',
				'align'        => $fields['align-tagline'],
				'alignOptions' => $fieldOptions['tagline']['align'] ?? null,
			];
		}
		/* -------------- Heading --------------*/
		if (!empty($settings['heading'])) {
			$contentFields['heading'] = [
				'extends'      => 'pagewizard/fields/heading',
				'align'        => $fields['align-heading'],
				'level'        => $fields['level-heading'] ?? null,
				'size'         => $fields['size-heading'] ?? null,
				'sizeOptions'  => $fieldOptions['heading']['sizes'] ?? null,
				'alignOptions' => $fieldOptions['heading']['align'] ?? null,
				'levelOptions' => $fieldOptions['heading']['level'] ?? null,
			];
		}
		/* -------------- Editor --------------*/
		if (!empty($settings['editor'])) {
			$contentFields['editor'] = pwEditor::contentField($editor, $settings);
			$contentFields['editor']['align']        = $fields['align-editor'] ?? null;
			$contentFields['editor']['size']         = $fields['size-editor'] ?? null;
			$contentFields['editor']['alignOptions'] = $fieldOptions['editor']['align'] ?? null;
			$contentFields['editor']['sizeOptions']  = $fieldOptions['editor']['sizes'] ?? null;
			$contentFields['editor']['defaultMode'] = $fields['mode-editor'] ?? null;
		}
		/* -------------- Buttons --------------*/
		if (!empty($settings['buttons'])) {
			$contentFields['buttonsAlignment'] = [
				'type'         => 'pwalign',
				'align'        => $fields['align-buttons'],
				'default'      => $fields['align-buttons'],
				'alignOptions' => $fieldOptions['buttons']['align'] ?? null,
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
		$effectsFields = ['headlineEffects' => ['extends' => 'pagewizard/headlines/effects']];
		if (!empty($effectsVis['blur'])) {
			$effectsFields['blurImage'] = ['extends' => 'pagewizard/fields/blur', 'when' => ['backgroundType' => 'image']];
			$effectsFields['blurVideo'] = ['extends' => 'pagewizard/fields/blur', 'when' => ['backgroundType' => 'video']];
		}
		if (!empty($effectsVis['overlay'])) {
			$effectsFields['overlayType']              = ['extends' => 'pagewizard/fields/overlay-type'];
			$effectsFields['overlayIntensity']         = ['extends' => 'pagewizard/fields/overlay-intensity',  'when' => ['overlayType' => 'solid']];
			$effectsFields['overlayGradientIntensity'] = ['extends' => 'pagewizard/fields/overlay-intensity',  'when' => ['overlayType' => 'gradient']];
			$effectsFields['overlaySize']              = ['extends' => 'pagewizard/fields/overlay-size',       'when' => ['overlayType' => 'gradient']];
			$effectsFields['overlayPosition']          = ['extends' => 'pagewizard/fields/overlay-position',   'when' => ['overlayType' => 'gradient']];
		}
		pwConfig::addTab($tabs, 'effects', $tabSettings['effects'] ?? true, [
			'label'  => 'pw.tab.effects',
			'fields' => $effectsFields,
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
