<?php

namespace sgerli\flick\Controller;

use Pagekit\Application as App;

/**
 * @Access(admin=true)
 */
class FlickController
{

    /**
     * @Access(admin=true)
     */
    public function settingsAction()
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
}

?>
