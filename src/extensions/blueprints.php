<?php return [ 'blocks/pwhero' => function () {

    /* -------------- Config --------------*/
    $config   = pwConfig::load('pwhero');
    $settings = $config['settings'];
    $defaults = $config['defaults'];

		/* -------------- Allowed Fields --------------*/
    $defaultHeading = !empty($settings['heading']);
		$defaultText = !empty($settings['text']);
		$defaultButtons = !empty($settings['buttons']);

		/* -------------- Tabs --------------*/
    $tabs = [];

		/* -------------- Content Tab --------------*/
		$contentFields = [
			'headlineContent' => ['extends' => 'pagewizard/headlines/content'],
		];

		/* -------------- Heading --------------*/
		if ($defaultHeading) {
			$contentFields['heading'] = [
				'extends' => 'pagewizard/fields/heading',
			];
		}
		/* -------------- Text --------------*/
		if ($defaultText) {
			$contentFields['text'] = [
				'extends' => 'pagewizard/fields/text-textarea',
			];
		}
		/* -------------- Buttons --------------*/
		if ($defaultButtons) {
			$contentFields['buttonsAlignment'] = [
				'type' => 'pwalign',
				'default' => $defaults['buttons-alignment'] ?? 'left',
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
		]);

		/* -------------- Common Tabs (grid, spacing, theme) --------------*/
		pwConfig::buildTabs('pwhero', $defaults, $settings, $tabs);

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
