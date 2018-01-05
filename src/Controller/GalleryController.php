<?php

namespace sgerli\flick\Controller;

use Pagekit\Application as App;

class GalleryController
{
    /**
     * @Access(admin=true)
     */
    public function indexAction()
    {
        $module = App::module('flick');
        return [
            '$view' => [
                'title' => __("Flick"),
                'name' => 'flick:views/admin/index.php'
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
        App::config('flick')->merge($config, true);
        return ['message' => 'success'];
    }
    /**
     * @Route("/")
     */
    public function siteAction()
    {
        $module = App::module('flick');

        $flick_text = '';
		if ($module->config('flick_text')) {
			$flick_text = App::content()->applyPlugins($module->config('flick_text'), ['markdown' => $module->config('markdown_enabled')]);;
        }
        
        return [
            '$view' => [
                'title' => __("Gallery"),
                'name' => 'flick:views/index.php'
            ],
            'config' => $module->config(),
            'flick_text' => $flick_text
        ];
    }
}