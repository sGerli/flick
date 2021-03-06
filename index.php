<?php
use Pagekit\Application as App;
return [
    'name' => 'sgerli/flick',
    'main' => function() {
    },
    'autoload' => [
        'sgerli\\flick\\' => 'src'
    ],
    'resources' => [
        'flick:' => ''
    ],
    'nodes' => [

		'flick' => [
			'name' => '@flick',
			'label' => 'Flick',
			'controller' => 'sgerli\\flick\\Controller\\SiteController',
			'protected' => true,
			'frontpage' => true
		]

	],
    'routes' => [
        '/flick' => [
            'name' => '@flick',
            'controller' => ['sgerli\\flick\\Controller\\FlickController']
        ]
    ],
    'config' => [
        'apiKey' => '',
        'uId' => '',
        'cId' => '',
        'flick_title' => '',
        'flick_text' => '',
        'markdown_enabled' => false
    ],
    'menu' => [
        'flick' => [
            'label' => 'Flick',
            'icon'   => 'app/system/assets/images/placeholder-icon.svg',
            'url'    => '@flick/settings',
            'active' => '@flick/settings*',
            'access' => 'flick: manage settings',
        ]
    ],
    'permissions' => [
        'flick: manage settings' => [
            'title' => 'Manage settings'
        ]
    ],
    'settings' => '@flick/settings',
	
   'resources' => [
        'sgerli/flick:' => '',
    ],

    'events' => [
        'view.scripts' => function ($event, $scripts) use ($app) {
			$scripts->register('uikit-grid', 'app/assets/uikit/js/components/grid.min.js', 'uikit');
            $scripts->register('fancybox', 'sgerli/flick:external/fancybox/jquery.fancybox.min.js');
		},
    ]
];
