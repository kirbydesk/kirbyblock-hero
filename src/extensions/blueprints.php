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
				'headlineContentspacing' => ['extends' => 'pagewizard/headlines/contentspacing'],
				'paddingTop' => [
					'extends' => 'pagewizard/fields/toggle-spacing',
					'default' => $defaults['padding-top'],
					'label' => 'pw.field.padding-top',
					'help' => 'pw.field.padding-top.help'
				],
				'paddingRight' => [
					'extends' => 'pagewizard/fields/toggle-spacing',
					'default' => $defaults['padding-right'],
					'label' => 'pw.field.padding-right',
					'help' => 'pw.field.padding-right.help'
				],
				'paddingBottom' => [
					'extends' => 'pagewizard/fields/toggle-spacing',
					'default' => $defaults['padding-bottom'],
					'label' => 'pw.field.padding-bottom',
					'help' => 'pw.field.padding-bottom.help'
				],
				'paddingLeft' => [
					'extends' => 'pagewizard/fields/toggle-spacing',
					'default' => $defaults['padding-left'],
					'label' => 'pw.field.padding-left',
					'help' => 'pw.field.padding-left.help'
				],
				'headlineContentposition' => ['extends' => 'pagewizard/headlines/contentposition'],
				'positionHorizontal' => [
					'extends' => 'pagewizard/fields/position-horizontal',
					'default' => $defaults['horizontal-content-position']
				],
				'positionVertical' => [
					'extends' => 'pagewizard/fields/position-vertical',
					'default' => $defaults['vertical-content-position']
				]

			]
		];

		/* -------------- Style Tab --------------*/
		$tabs['style'] = [
			'label'  => 'pw.tab.style',
			'fields' => [
				'headlineStyle' => ['extends' => 'pagewizard/headlines/style'],
				'style' => [
					'extends' => 'pagewizard/fields/style',
					'width' => '1/1',
					'label'	=> 'pw.headline.theme',
					'default' => $defaults['style']
				],
				'textcolor' => [
					'extends' => 'pagewizard/fields/text-color',
					'when' => [
						'style' => 'custom'
					]
				],
				'backgroundcolor' => [
					'extends' => 'pagewizard/fields/background-color',
					'when' => [
						'style' => 'custom'
					]
				],
				'buttonstyle' => [
					'extends' => 'pagewizard/fields/button-style',
					'when' => [
						'style' => 'custom'
					]
				],
				'headlineBackground' => ['extends' => 'pagewizard/headlines/background'],
				'backgroundType' => [
					'extends' => 'pagewizard/fields/background-type'
				],
				'backgroundSize' => [
					'extends' => 'pagewizard/fields/background-size',
					'default' => $defaults['background-size']
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

		/* -------------- Settings Tab --------------*/
		$tabs['settings'] = [
      'label'  => 'pw.tab.settings',
      'fields' => [
				'headlineProperties' => ['extends' => 'pagewizard/headlines/properties'],
				'fragment' => [
					'extends' => 'pagewizard/fields/fragment'
				],
				'headlineSettings' => ['extends' => 'pagewizard/headlines/settings'],
				'marginTop' => [
					'extends' => 'pagewizard/fields/toggle-spacing',
					'default' => $defaults['margin-top'],
					'width' => '1/2',
					'label' => 'pw.field.margin-top',
					'help' => 'pw.field.margin-top.help'
				],
				'marginBottom' => [
					'extends' => 'pagewizard/fields/toggle-spacing',
					'default' => $defaults['margin-bottom'],
					'width' => '1/2',
					'label' => 'pw.field.margin-bottom',
					'help' => 'pw.field.margin-bottom.help'
				],
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
