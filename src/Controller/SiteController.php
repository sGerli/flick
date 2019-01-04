<?php

namespace sgerli\flick\Controller;

use Pagekit\Application as App;

class SiteController
{

    /**
     * @var Module
     */
    protected $flick;
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->flick = App::module('sgerli/flick');
    }

    /**
     * @Route("/")
     */
    public function indexAction()
    {
        if (!App::node()->hasAccess(App::user())) {
            App::abort(403, __('Insufficient User Rights.'));
        }

        $module = $this->flick;

        $flick_text = '';
		if ($module->config('flick_text')) {
			$flick_text = App::content()->applyPlugins($module->config('flick_text'), ['markdown' => $module->config('markdown_enabled')]);;
        }
        
        return [
            '$view' => [
                'title' => __($module->config()['flick_title'] ?: App::node()->title),
                'name' => 'sgerli/flick:views/index.php'
            ],
            'config' => $module->config(),
            'flick_text' => $flick_text,
            'node' => App::node()
        ];
    }
}

?>