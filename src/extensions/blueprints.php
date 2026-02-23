<?php return [ 'blocks/pwhero' => function () {

    /* -------------- Config --------------*/
    $config   = pwConfig::load('pwhero');
    $settings = $config['settings'];
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
			];
		}
		/* -------------- Editor --------------*/
		if ($defaultEditor) {
			$contentFields['editor'] = pwEditor::contentField($defaults, $editor, $settings, $fields);
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
		$tabs['layout'] = pwLayout::options('pwhero', $defaults, [
			'headlineContentposition' => ['extends' => 'pagewizard/headlines/contentposition'],
			'positionHorizontal' => [
				'extends' => 'pagewizard/fields/position-horizontal',
				'default' => $defaults['horizontal-content-position']
			],
			'positionVertical' => [
				'extends' => 'pagewizard/fields/position-vertical',
				'default' => $defaults['vertical-content-position']
			],
		]);

		/* -------------- Style Tab --------------*/
		$tabs['style'] = pwStyle::options('pwhero', $defaults, [
			'height' => [
				'extends' => 'pagewizard/fields/height',
				'default' => $defaults['height']
			],
			'backgroundType' => [
				'extends' => 'pagewizard/fields/background-type',
				'default' => $defaults['background-type']
			],
			'image' => [
				'extends' => 'pagewizard/fields/image',
				'uploads' => 'pwHero',
				'query' => 'page.images.template("pwHero")',
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
			],
			'headlineEffects' => ['extends' => 'pagewizard/headlines/effects'],
			'fade' => [
				'extends' => 'pagewizard/fields/fade',
				'default' => $defaults['fade']
			],
			'fadeSize' => [
				'extends' => 'pagewizard/fields/fade-size',
				'default' => $defaults['fade-size'],
				'when'    => [
					'fade' => true
				]
			],
			'fadePosition' => [
				'extends' => 'pagewizard/fields/fade-position',
				'default' => $defaults['fade-position'],
				'when'    => [
					'fade' => true
				]
			]
		]);

		/* -------------- Common Tabs (grid, spacing, theme) --------------*/
		pwConfig::buildTabs('pwhero', $defaults, $tabSettings, $tabs);

		/* -------------- Settings Tab --------------*/
		$tabs['settings'] = pwSettings::options('pwhero', $defaults);

		/* -------------- Blueprint --------------*/
		return [
			'name'	=> 'kirbyblock-hero.name',
			'icon'  => 'star',
			'tabs'	=> $tabs
		];
	}
];
