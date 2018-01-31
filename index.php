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
			/*'controller' => 'sgerli\\flick\\Controller\\FlickController',*/
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
            'url'    => '@flick',
            'active' => '@flick*',
            'access' => 'flick: manage settings',
        ]
    ],
    'permissions' => [
        'flick: manage settings' => [
            'title' => 'Manage settings'
        ]
    ],
    'settings' => '@flick',
	
   'resources' => [
        'sgerli/flick:' => '',
    ],

    'events' => [
        'view.scripts' => function ($event, $scripts) use ($app) {

			$scripts->register('uikit-grid', 'app/assets/uikit/js/components/grid.min.js', 'uikit');
			$scripts->register('uikit-lightbox', 'app/assets/uikit/js/components/lightbox.min.js', 'uikit');
		},
    ]
];
