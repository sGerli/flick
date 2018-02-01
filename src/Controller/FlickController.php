<?php

namespace sgerli\flick\Controller;

use Pagekit\Application as App;

class FlickController
{
    /**
     * @Access(admin=true)
     */
    public function indexAction()
    {
        $module = App::module('sgerli/flick');
        return [
            '$view' => [
                'title' => __("Flick"),
                'name' => 'sgerli/flick:views/admin/index.php'
            ],
            '$data' => [
                'config' => $module->config()
            ],
        ];
    }
    /**
     * @Request({"config": "array"}, csrf=true)
     * @Access(admin=true)
     */
    public function saveAction($config = [])
    {
        App::config('sgerli/flick')->merge($config, true);
        return ['message' => 'success'];
    }
    /**
     * @Route("/")
     */
    public function siteAction()
    {
        if (!App::node()->hasAccess(App::user())) {
            App::abort(403, __('Insufficient User Rights.'));
        }

        $module = App::module('sgerli/flick');

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
