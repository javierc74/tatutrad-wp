<?php

namespace Memsource\Tests\Controller;

$wp_rest_server = new \WP_REST_Server();


class WebHookControllerTest extends \WP_UnitTestCase
{


    public function test_registerRestRoutes()
    {
        $option = new \Memsource\Service\OptionsService();
        $database = new \Memsource\Service\DatabaseService($option);
        $post = new \Memsource\Service\Content\PostService($option, $database);
        $api = new \Memsource\Service\MemsourceApiService($option);
        $webHookController = new \Memsource\Controller\WebHookController($option, $api, $post);
        $webHookController->registerRestRoutes();

        global $wp_rest_server;
        $routes = $wp_rest_server->get_routes();

        $routeKey = sprintf('/%s/webhook/job', $option->getRestNamespace());
        $expectedOptions = [[
            'methods' => [
                $wp_rest_server::CREATABLE => true
            ],
            'callback' => [$webHookController, 'refreshWork'],
            'accept_json' => false,
            'accept_raw' => false,
            'show_in_index' => true,
            'args' => Array()
        ]];

        $this->assertTrue(array_key_exists($routeKey, $routes));
        $this->assertEquals($expectedOptions, $routes[$routeKey]);
    }
}