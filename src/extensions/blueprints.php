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
