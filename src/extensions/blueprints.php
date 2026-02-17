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
			'headlineContent' => ['extends' => 'pagewizard/headlines/blockcontent'],
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
			$contentFields['buttons'] = [
				'extends' => 'blocks/pwButtons',
			];
		}
		/* -------------- Position --------------*/
		$contentFields['headlinePosition'] = ['extends' => 'pagewizard/headlines/position'];
		$contentFields['positionHorizontal'] = ['extends' => 'pagewizard/fields/position-horizontal'];
		$contentFields['positionVertical'] = ['extends' => 'pagewizard/fields/position-vertical'];

		$tabs['content'] = [
			'label'  => 'pw.tab.content',
			'fields' => $contentFields,
		];

		/* -------------- Layout Tab --------------*/
		$tabs['layout'] = [
			'label'  => 'pw.tab.layout',
			'fields' => [
				'headlineLayout' => ['extends' => 'pagewizard/headlines/layout'],
				'backgroundType' => [
					'extends' => 'pagewizard/fields/background-type'
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
				]
			]
		];

		/* -------------- Common Tabs (grid, spacing, theme) --------------*/
		pwConfig::buildTabs('pwhero', $defaults, $settings, $tabs);

		/* -------------- Properties Tab --------------*/
		$tabs['properties'] = [
			'label'  => 'pw.tab.properties',
			'fields' => [
				'headlineProperties' => ['extends' => 'pagewizard/headlines/blockproperties'],
				'fragment' => [
					'extends' => 'pagewizard/fields/fragment'
				]
			]
		];

		/* -------------- Blueprint --------------*/
		return [
			'name'	=> 'kirbyblock-hero.name',
			'icon'  => 'star',
			'tabs'	=> $tabs
		];
	}
];
