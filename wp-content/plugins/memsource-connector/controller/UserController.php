<?php

namespace Memsource\Controller;


use Memsource\Service\AuthService;
use Memsource\Service\LanguageService;
use Memsource\Service\MemsourceApiService;
use Memsource\Service\OptionsService;
use WP_REST_Server;

class UserController {

    private $optionsService;
    private $authService;
    private $languageService;
    private $memsourceApiService;

    function __construct(OptionsService &$optionsService,
                         AuthService &$authService,
                         LanguageService &$languageService,
                         MemsourceApiService &$memsourceApiService) {
        $this->optionsService = &$optionsService;
        $this->authService = &$authService;
        $this->languageService = &$languageService;
        $this->memsourceApiService = &$memsourceApiService;
    }

    public function registerRestRoutes() {
        $namespace = $this->optionsService->getRestNamespace();
        register_rest_route($namespace, '/wpml', array(
            'methods' => WP_REST_Server::READABLE,
            'callback' => array($this, 'memsource_get_wpml_data')
        ));
        register_rest_route($namespace, '/user', array(
            'methods' => WP_REST_Server::READABLE,
            'callback' => array($this, 'memsource_get_admin_user')
        ));
        register_rest_route($namespace, '/oauth/code', array(
            'methods' => WP_REST_Server::READABLE,
            'callback' => array($this, 'memsource_oauth_receive_code')
        ));
    }

    function memsource_get_wpml_data() {
        $check_response = $this->authService->checkAuth();
        if (array_key_exists('error', $check_response)) {
            return $check_response;
        }
        return rest_ensure_response(array('languages' => $this->languageService->getActiveLanguages(TRUE)));
    }

    function memsource_get_admin_user() {
        $check_response = $this->authService->checkAuth();
        if (array_key_exists('error', $check_response)) {
            return $check_response;
        }
        $admin = get_user_by('ID', get_option('memsource_admin_user'));
        return array(
            'ID' => $admin->ID,
            'display_name' => $admin->display_name,
            'user_login' => $admin->user_login,
            'user_email' => $admin->user_email
        );
    }

    function memsource_oauth_receive_code() {
        header('Content-Type: text/html');
        ?>
        <script>
            function closeAndReloadParent() {
                window.opener.location.reload();
                window.close();
            }
        </script>
        <?php
        if (isset($_GET['code'])) {
            // obtain the permanent auth token
            $body = array(
                'code' => $_GET['code'],
                'grant_type' => 'authorization_code'
            );
            $args = array('body' => $body);
            $response = wp_remote_post($this->memsourceApiService->getApiUrlPrefix() . '/oauth/token', $args);
            if (is_wp_error($response)) {
                _e('Error receiving authentication token. Please try again later.', 'memsource');
            } else {
                $params = json_decode(wp_remote_retrieve_body($response));
                $this->optionsService->updateOAuthToken($params->access_token);
                _e('Authentication successful. Click <a href="#" onclick="closeAndReloadParent()">here</a> to close this window and reload the Memsource Connector page.', 'memsource');
            }

        } else {
            // "Cancel" clicked, close the popup window
            _e('Authentication cancelled. You can close this window now.', 'memsource');
        }
        wp_die();
    }

}